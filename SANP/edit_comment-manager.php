<?php
include("db_connect.php");
$db = connect();

session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    return;
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
$comment_id = $_POST['comment_id'];
$post_id = substr($comment_id, 0, 32);
$sid = substr($comment_id, 32, 12);
$timestamp = substr($comment_id, 44, 10) . ' '. substr($comment_id, 54);
$comment_text = $_POST['comment_text'];

// Prepare and execute query
$sql = "UPDATE comments SET comment = ? WHERE post_id = ? AND  sid = ? AND timestamp = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("ssss", $comment_text, $post_id, $sid, $timestamp);
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