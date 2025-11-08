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
$report_id = bin2hex(random_bytes(16));
$reporter_id = $_SESSION['sid'];
$target_type = $_POST['type'];
$target_id = $_POST['target_id'];
$des = $_POST['des'];

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
if ($target_type == "comment") {
    $post_id = substr($target_id, 0, 32);

    echo '
    <form id="redirectForm" action="comments.php" method="POST">
      <input type="hidden" name="post_id" value="' . $post_id . '">
    </form>
    <script>
      document.getElementById("redirectForm").submit();
    </script>
    ';
    exit;
}

$redirectPage = $_POST['from'];

echo "<script>
    alert('Report submitted successfully!');
    window.location.href = '$redirectPage';
</script>";
exit;
?>