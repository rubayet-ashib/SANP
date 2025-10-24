<?php
include("db_connect.php");
$db = connect();

session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    return;
}

if (!isset($_POST['comment-btn'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$sid = $_SESSION['sid'];
$post_id = $_POST['post_id'];
$comment_text = $_POST['comment-text'];

// Prepare and execute query
$sql = "INSERT INTO comments (post_id, sid, comment) VALUES (?, ?, ?)";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("sss", $post_id, $sid, $comment_text);
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