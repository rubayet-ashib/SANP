<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['update-btn'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$res_id = $_POST['res_id'];
$title = $_POST['title'];
$tags = $_POST['tags'];
$des = $_POST['des'];

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
if($filepath != NULL) $sql = "UPDATE resources SET title = ?, description = ?, filepath = ?, approve_status = 0 WHERE resource_id = ?";
else $sql = "UPDATE resources SET title = ?, description = ?, approve_status = 0 WHERE resource_id = ?";

$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}

if($filepath != NULL) $stmt->bind_param("sssi", $title, $des, $filepath, $res_id);
else $stmt->bind_param("ssi", $title, $des, $res_id);
$stmt->execute();

// Delete tags
$sql = "DELETE FROM resource_tags WHERE resource_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("i", $res_id);
$stmt->execute();

// Add tags
$sql = "INSERT INTO resource_tags (resource_id, value) VALUES (?, ?)";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}

foreach ($tags as $tag) {
    if ($tag == NULL) continue;
    $stmt->bind_param("ii", $res_id, $tag);
    $stmt->execute();
}

// Redirect
echo "<script>
    alert('Resource information updated successfully! Wait for admin approval.');
    window.location.href = '$redirectPage';
</script>";
exit;
