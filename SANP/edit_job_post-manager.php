<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
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
$job_id = $_POST['job_id'];
$title = $_POST['title'];
$des = $_POST['des'];
$company = $_POST['company'];
$vac = $_POST['vac'];

$redirectPage = $_POST['from'];

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query
$sql = "UPDATE job_posts SET title = ?, description = ?, company = ?, vacancies = ?, approve_status = 0 WHERE job_id = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("sssss", $title, $des, $company, $vac, $job_id);
$stmt->execute();

// Redirect
echo "<script>
    alert('Job post updated successfully!');
    window.location.href = '$redirectPage';
</script>";
exit;