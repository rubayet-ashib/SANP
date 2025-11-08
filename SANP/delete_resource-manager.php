<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['res_id'])) {
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

$redirectPage = $_POST['from'];

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query (for posts)
$sql = "DELETE FROM resources WHERE resource_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("i", $res_id);
$stmt->execute();

// Prepare and execute query (for likes)
$sql = "DELETE FROM resource_tags WHERE resource_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("i", $res_id);
$stmt->execute();

// Redirect
echo "<script>
    alert('Resource deleted successfully!');
    window.location.href = '$redirectPage';
</script>";
exit;