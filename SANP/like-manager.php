<?php

session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

// Get info from POST
$sid = $_SESSION['sid'];
$post_id = $_POST['post_id'];
$source = $_POST['source'] ?? 'direct';

if ($source != 'ajax') {
    // User tried to access the file directly via URL
    die("Access denied!");
}

include('db_connect.php');
$db = connect();

// Check if the user already liked
$sql = "SELECT * FROM likes WHERE post_id = ? AND sid = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("ss", $post_id, $sid);
$stmt->execute();
$rel = $stmt->get_result();
$isLiked = 0;
if($rel->num_rows > 0) $isLiked = 1;

if ($isLiked) {
    // Unlike query
    $sql = "DELETE FROM likes WHERE post_id = ? AND sid = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $db->error);
    }
    $stmt->bind_param("ss", $post_id, $sid);
    $stmt->execute();
} else {
    // Like query
    $sql = "INSERT INTO likes (post_id, sid) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $db->error);
    }
    $stmt->bind_param("ss", $post_id, $sid);
    $stmt->execute();
}

// Return updated like count
$sql = "SELECT COUNT(sid) AS like_count FROM likes WHERE post_id = ? GROUP BY post_id";
$stmt2 = $db->prepare($sql);
if (!$stmt2) {
    die("Prepare failed: " . $db->error);
}
$stmt2->bind_param("s", $post_id);
$stmt2->execute();
$rel2 = $stmt2->get_result();
$data = $rel2->fetch_assoc();
$total_count = 0;
if($rel2->num_rows > 0) $total_count = $data['like_count'];

echo $total_count;