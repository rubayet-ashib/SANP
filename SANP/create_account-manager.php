<?php
    if(!isset($_POST['create-btn']))
    {
        header("location: create_account.php");
        exit;
    }
    
    session_start();

    // Collect data from $_POST
    $sid = $_POST['sid'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Database connection
    include("db_connect.php");
    $db = connect();

    // Prepare and execute query
    $sql = "select * from users where sid = ?";
    $stmt = $db->prepare($sql);
    if (!$stmt) { die("Prepare failed: " . $db->error); }
    $stmt->bind_param("s", $sid);
    $stmt->execute();
    $rel = $stmt->get_result();

    // Verify and access database
    if($data = $rel->fetch_assoc())
    {
        if($data['password'] != NULL)
        {
            // Already have an account
            $_SESSION['invalid_user'] = 1;
            header("location: create_account.php");
            exit;
        }
        
        // Account creation successful
        // Prepare and execute query
        $sql = "UPDATE users SET email = ?, password = ?, name = ? WHERE sid = ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) { die("Prepare failed: " . $db->error); }
        $stmt->bind_param("ssss", $email, $hashedPassword, $name, $sid);
        $stmt->execute();

        $_SESSION['success_toast'] = 1;
        header("location: login.php");
        exit;
    }
    else
    {
        // Not a member
        $_SESSION['invalid_user'] = 1;
        header("location: create_account.php");
        exit;
    }
?>