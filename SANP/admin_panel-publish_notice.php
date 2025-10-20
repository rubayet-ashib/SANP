<?php
    include("db_connect.php");
    $db = connect();

    session_start();
    if(!isset($_SESSION['status']))
    {
        header("location: login.php");
        return;
    }

    // Redirect if not admin
    if($_SESSION['role'] != "admin")
    {
        if($_SESSION['role'] == "student")
        {
            header("location: student-news_feed.php");
            exit;
        }
        else
        {
            header("location: alumni-news_feed.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="resources/favicon.svg" type="image/x-icon">
    <title>Admin Panel - Publish Notice</title>

    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row w-100 d-flex flex-column">

            <!-- Navbar -->
            <div class="navbar-div">
                <nav class="navbar navbar-expand-xl fixed-top">
                    <div class="container-fluid">
                        <!-- Logo -->
                        <a class="navbar-brand d-flex align-items-center" href="#">
                            <img src="resources/Logo.svg" alt="Logo" style="height: 80px;">
                            <div class="d-flex flex-column">
                                <span style="text-align: center;">Student & Alumni</span>
                                <span style="text-align: center;">Networking Portal</span>
                            </div>
                        </a>

                        <!-- Hamburger button -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Collapsible menu -->
                        <div class="collapse justify-content-end navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">

                                <li class="nav-item"><a class="nav-link" href="student-news_feed.php">Student</a></li>
                                <li class="nav-item"><a class="nav-link" href="alumni-news_feed.php">Alumni</a></li>
                                <li class="nav-item"><a class="nav-link" href="jobs_internships-posts.php">Jobs &
                                        Internships</a></li>
                                <li class="nav-item"><a class="nav-link" href="resources-resources.php">Resources</a>
                                </li>
                                <li class="nav-item"><a class="nav-link active"
                                        href="admin_panel-events_approval.php">Admin Panel</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="donate.php">Donate</a></li>
                                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Sidebar -->
            <div class="sidebar-div">
                <div class="sidebar d-none d-md-flex justify-content-center">
                    <ul>
                        <li><a href="admin_panel-events_approval.php">Events Approval</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-jobs_approval.php">Jobs Approval</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-publish_notice.php" class="active">Publish Notice</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-update-status.php">Update Status</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-manage_student.php">Manage Student</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar Toggle Button -->
        <button class="btn sidebar-toggle d-md-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
            <img src="icons/sidebar-expand.svg" alt="Sidebar Expand" style="height: 32px; width: 32px;">
        </button>

        <!-- Sidebar offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas"
            aria-labelledby="sidebarOffcanvasLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul>
                    <li><a href="admin_panel-events_approval.php">Events Approval</a></li>
                    <li><a href="admin_panel-jobs_approval.php">Jobs Approval</a></li>
                    <li><a href="admin_panel-publish_notice.php" class="active">Publish Notice</a></li>
                    <li><a href="admin_panel-update-status.php">Update Status</a></li>
                    <li><a href="admin_panel-manage_student.php">Manage Student</a></li>
                </ul>
            </div>
        </div>

    </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>