<?php
    if(!isset($_POST['login-btn']))
    {
        header("location: login.php");
        exit;
    }
    
    session_start();

    // Collect data from $_POST
    $sid = $_POST['sid'];
    $password = $_POST['password'];

    // Database connection
    include("db_connect.php");
    $db = connect();

    // Prepare and execute query
    $sql = "SELECT * FROM users WHERE sid = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt) { die("Prepare failed: " . $db->error); }
    $stmt->bind_param("s", $sid);
    $stmt->execute();
    $rel = $stmt->get_result();

    // Verify and access database
    if($data = $rel->fetch_assoc())
    {
        // Verify password
        if(!password_verify($password, $data['password']))
        {
            $_SESSION['invalid_status'] = 1;
            header("location: login.php");
            exit;
        }

        // Login successful
        $_SESSION['status'] = 1;
        $_SESSION['sid'] = $sid;
        $_SESSION['role'] = $data['role'];

        if($data['role'] == 'alumni')
        {
            header("location: alumni-news_feed.php");
            exit;
        }
        else
        {
            header("location: student-news_feed.php");
            exit;
        }
    }
    else
    {
        // User doesn't exist
        $_SESSION['invalid_status'] = 1;
        header("location: login.php");
        exit;
    }
?>