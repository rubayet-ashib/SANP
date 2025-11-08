<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    exit;
}

if (!isset($_GET['filepath'])) {
    die("Invalid request!");
}

$path = $_GET['filepath'];

// Check if file actually exists on the server
if (!file_exists($path)) {
    die("File missing on server!");
}

// Automatically generate filename from path
$filename = basename($path);

// Send the right headers
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . filesize($path));

// Output the file
readfile($path);
exit;
?>