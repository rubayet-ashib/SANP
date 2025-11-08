<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['post-btn'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
        exit;
    }
}

// Collect data from $_POST
$job_id = bin2hex(random_bytes(16));
$title = $_POST['title'];
$des = $_POST['des'];
$company = $_POST['company'];
$vac = $_POST['vac'];
$posted_by = $_SESSION['sid'];

$redirectPage = $_POST['from'];

// Database connection
include("db_connect.php");
$db = connect();

// Prepare and execute query
$sql = "INSERT INTO job_posts (job_id, posted_by, title, description, company, vacancies) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("ssssss", $job_id, $posted_by, $title, $des, $company, $vac);
$stmt->execute();

// Redirect
echo "<script>
    alert('Job posted successfully! Wait for admin approval.');
    window.location.href = '$redirectPage';
</script>";
exit;