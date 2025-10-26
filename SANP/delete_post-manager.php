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
$post_id = $_POST['post_id'];

$redirectPage = $_POST['from'];

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query (for posts)
$sql = "DELETE FROM posts WHERE post_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("s", $post_id);
$stmt->execute();

// Prepare and execute query (for likes)
$sql = "DELETE FROM likes WHERE post_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("s", $post_id);
$stmt->execute();

// Prepare and execute query (for comments)
$sql = "DELETE FROM comments WHERE post_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("s", $post_id);
$stmt->execute();

// Redirect
echo "<script>
    alert('Post deleted successfully!');
    window.location.href = '$redirectPage';
</script>";
exit;