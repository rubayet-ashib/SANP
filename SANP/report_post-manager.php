<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['post_id'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$report_id = bin2hex(random_bytes(16));
$reporter_id = $_SESSION['sid'];
$target_type = "post";
$target_id = $_POST['post_id'];
$des = $_POST['des'];

$redirectPage = $_POST['from'];

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query (for posts)
$sql = "INSERT INTO reports_feedbacks(report_id, reporter_id, target_type, target_id, report_description) VALUES(?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("sssss", $report_id, $reporter_id, $target_type, $target_id, $des);
$stmt->execute();

// Redirect
echo "<script>
    alert('Report submitted successfully!');
    window.location.href = '$redirectPage';
</script>";
exit;