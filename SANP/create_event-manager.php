<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['create-btn'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$event_id = bin2hex(random_bytes(16));
$type = $_POST['type'];
$title = $_POST['title'];
$start_date = $_POST['start-date'];
$end_date = $_POST['end-date'];
$des = $_POST['des'];
$imageFile = NULL;
$posted_by = $_SESSION['sid'];

$redirectPage = $_POST['from'];

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageDir = "uploads/";
    $originalName = $_FILES['image']['name'];
    $fileType = pathinfo($originalName, PATHINFO_EXTENSION);
    $newFileName = uniqid("img_", true) . "." . $fileType;
    $imageFile = $imageDir . $newFileName;

    // Validate MIME type (safety check)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array(mime_content_type($_FILES['image']['tmp_name']), $allowedTypes)) {
        echo "<script>
            alert('Invalid file type. Only JPG, PNG, WEBP or GIF are allowed.');
            window.location.href = '$redirectPage';
            </script>";
        exit;
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $imageFile)) {
        echo "<script>
            alert('Error uploading image! Please try again.');
            window.location.href = '$redirectPage';
            </script>";
        exit;
    }
}

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query
$sql = "INSERT INTO events (event_id, type, title, start_date, end_date, description, image, posted_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("ssssssss", $event_id, $type, $title, $start_date, $end_date, $des, $imageFile, $posted_by);
$stmt->execute();

// Redirect
echo "<script>
    alert('Event created successfully! Wait for admin approval.');
    window.location.href = '$redirectPage';
</script>";
exit;