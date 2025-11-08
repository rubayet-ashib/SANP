<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['delete-btn'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$notice_id = $_POST['notice_id'];

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query (for posts)
$sql = "DELETE FROM notices WHERE notice_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("i", $notice_id);
$stmt->execute();

header("location: admin_panel-manage_notice.php");
exit;
?>