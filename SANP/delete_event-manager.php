<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['event_id'])) {
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

$redirectPage = $_POST['from'];

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query (for events)
$sql = "DELETE FROM events WHERE event_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("s", $event_id);
$stmt->execute();

// Redirect
echo "<script>
    alert('Event deleted successfully!');
    window.location.href = '$redirectPage';
</script>";
exit;