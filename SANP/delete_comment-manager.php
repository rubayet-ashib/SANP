<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['comment_id'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$comment_id = $_POST['comment_id'];
$post_id = substr($comment_id, 0, 32);
$sid = substr($comment_id, 32, 12);
$timestamp = substr($comment_id, 44, 10) . ' '. substr($comment_id, 54);

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query (for posts)
$sql = "DELETE FROM comments WHERE post_id = ? AND sid = ? AND timestamp = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("sss", $post_id, $sid, $timestamp);
$stmt->execute();

echo '
<form id="redirectForm" action="comments.php" method="POST">
  <input type="hidden" name="post_id" value="' . $post_id . '">
</form>
<script>
  document.getElementById("redirectForm").submit();
</script>
';
exit;
?>