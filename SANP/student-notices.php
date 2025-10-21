<?php
include("db_connect.php");
$db = connect();

session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="resources/favicon.svg" type="image/x-icon">
    <title>Student - Notices</title>

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

                                <li class="nav-item"><a class="nav-link active"
                                        href="student-news_feed.php">Student</a></li>
                                <li class="nav-item"><a class="nav-link" href="alumni-news_feed.php">Alumni</a></li>
                                <li class="nav-item"><a class="nav-link" href="jobs_internships-posts.php">Jobs &
                                        Internships</a></li>
                                <li class="nav-item"><a class="nav-link" href="resources-resources.php">Resources</a>
                                </li>
                                <!-- Visible to admin only -->
                                <?php if ($_SESSION['role'] == "admin") { ?>
                                    <li class="nav-item"><a class="nav-link" href="admin_panel-events_approval.php">Admin
                                            Panel</a>
                                    </li>
                                <?php } ?>
                                <li class="nav-item"><a class="nav-link" href="donate.php">Donate</a></li>
                                <li class="nav-item"><a class="nav-link" href="profile-my_profile.php">Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Sidebar -->
            <div class="sidebar-div">
                <div class="sidebar d-none d-md-flex justify-content-center">
                    <ul>
                        <li><a href="student-news_feed.php">News Feed</a></li>
                        <li>
                            <hr>
                        </li>
                        <!-- Visible to students only -->
                        <?php if ($_SESSION['role'] != "alumni") { ?>
                            <li><a href="student-batch.php">Batch</a></li>
                            <li>
                                <hr>
                            </li>
                        <?php } ?>
                        <li><a href="student-notices.php" class="active">Notices</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="student-events.php">Events</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="student-search.php">Search</a></li>
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
                    <li><a href="student-news_feed.php">News Feed</a></li>
                    <!-- Visible to students only -->
                    <?php if ($_SESSION['role'] != "alumni") { ?>
                        <li><a href="student-batch.php">Batch</a></li>
                    <?php } ?>
                    <li><a href="student-notices.php" class="active">Notices</a></li>
                    <li><a href="student-events.php">Events</a></li>
                    <li><a href="student-search.php">Search</a></li>
                </ul>
            </div>
        </div>

        <!-- Notice section -->
        <div class="post-container" style="padding: 2.5rem;">
            <h3 class="mb-3">Notices</h3>

            <!-- Scrollable notice list -->
            <div class="notice-list">
                <div class="notice-card">
                    <div class="notice-text">
                        <p class="notice-title mb-0">Semester Final Exam Routine</p>
                        <p class="notice-date mb-0">Published on: October 12, 2025</p>
                    </div>
                    <button class="download-btn">Download</button>
                </div>

                <div class="notice-card">
                    <div class="notice-text">
                        <p class="notice-title mb-0">Class Suspension Notice</p>
                        <p class="notice-date mb-0">Published on: October 10, 2025</p>
                    </div>
                    <button class="download-btn">Download</button>
                </div>

                <div class="notice-card">
                    <div class="notice-text">
                        <p class="notice-title mb-0">Workshop on Research Methods</p>
                        <p class="notice-date mb-0">Published on: October 7, 2025</p>
                    </div>
                    <button class="download-btn">Download</button>
                </div>

                <div class="notice-card">
                    <div class="notice-text">
                        <p class="notice-title mb-0">Midterm Result Publication</p>
                        <p class="notice-date mb-0">Published on: October 3, 2025</p>
                    </div>
                    <button class="download-btn">Download</button>
                </div>

                <div class="notice-card">
                    <div class="notice-text">
                        <p class="notice-title mb-0">New Library Schedule</p>
                        <p class="notice-date mb-0">Published on: September 29, 2025</p>
                    </div>
                    <button class="download-btn">Download</button>
                </div>
            </div>
        </div>

    </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>