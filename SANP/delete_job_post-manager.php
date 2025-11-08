<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['job_id'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$job_id = $_POST['job_id'];

$redirectPage = $_POST['from'];

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query (for posts)
$sql = "DELETE FROM job_posts WHERE job_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("s", $job_id);
$stmt->execute();

// Redirect
echo "<script>
    alert('Job post deleted successfully!');
    window.location.href = '$redirectPage';
</script>";
exit;