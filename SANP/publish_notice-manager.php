<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['publish-btn'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$title = $_POST['title'];
$admin_id = $_SESSION['sid'];

$redirectPage = $_POST['from'];

$filepath = NULL;

if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
    $pdfDir = "uploads/";
    $originalName = $_FILES['pdf']['name'];
    $fileType = pathinfo($originalName, PATHINFO_EXTENSION);
    $newFileName = uniqid("pdf_", true) . "." . $fileType;
    $filepath = $pdfDir . $newFileName;

    // Validate MIME type (only PDF)
    $allowedTypes = ['application/pdf'];
    if (!in_array(mime_content_type($_FILES['pdf']['tmp_name']), $allowedTypes)) {
        echo "<script>
            alert('Invalid file type. Only PDF is allowed.');
            window.location.href = '$redirectPage';
            </script>";
        exit;
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES['pdf']['tmp_name'], $filepath)) {
        echo "<script>
            alert('Error uploading PDF! Please try again.');
            window.location.href = '$redirectPage';
            </script>";
        exit;
    }
}

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query
$sql = "INSERT INTO notices (title, filepath, admin_id) VALUES (?, ?, ?)";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("sss", $title, $filepath, $admin_id);
$stmt->execute();

// Redirect
echo "<script>
    alert('Notice published successfully!');
    window.location.href = '$redirectPage';
</script>";
exit;
?>