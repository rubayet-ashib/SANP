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
$event_id = $_POST['event_id'];
$title = $_POST['title'];
$start_date = $_POST['start-date'];
$end_date = $_POST['end-date'];
$des = $_POST['des'];
$imageFile = NULL;

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
$sql = "";
if($imageFile != NULL) $sql = "UPDATE events SET approve_status = 0, title = ?, start_date = ?, end_date = ?, description = ?, image = ? WHERE event_id = ?";
else $sql = "UPDATE events SET approve_status = 0, title = ?, start_date = ?, end_date = ?, description = ? WHERE event_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
if($imageFile != NULL) $stmt->bind_param("ssssss", $title, $start_date, $end_date, $des, $imageFile, $event_id);
else $stmt->bind_param("sssss", $title, $start_date, $end_date, $des, $event_id);
$stmt->execute();

// Redirect
echo "<script>
    alert('Event updated successfully! Wait for admin approval.');
    window.location.href = '$redirectPage';
</script>";
exit;