<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['target_id'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$target_id = $_POST['target_id'];
$target_type = $_POST['target_type'];
$status = intval($_POST['status']);
$approved_by = $_SESSION['sid'];

$redirectPage = $_POST['from'];

// Database connection
include("db_connect.php");
$db = connect();

// Approved
if ($status == 1) {
    if($target_type == "event") $sql = "UPDATE events SET approve_status = ?, approved_by = ? WHERE event_id = ?";
    else if($target_type == "job post") $sql = "UPDATE job_posts SET approve_status = ?, approved_by = ? WHERE job_id = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $db->error);
    }
    $stmt->bind_param("iss", $status, $approved_by, $target_id);
    $stmt->execute();
} else {
    if($target_type == "event") $sql = "DELETE FROM events WHERE event_id = ?";
    else if($target_type == "job post") $sql = "DELETE FROM job_posts WHERE job_id = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $db->error);
    }
    $stmt->bind_param("s", $target_id);
    $stmt->execute();
}

// Redirect
if ($status == 1) {
    echo "<script>
    alert('Approved!');
    window.location.href = '$redirectPage';
</script>";
    exit;
} else {
    echo "<script>
    alert('Rejected!');
    window.location.href = '$redirectPage';
</script>";
    exit;
}
?>