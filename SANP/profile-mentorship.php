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
    <title>Profile - Mentorship</title>

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

                                <li class="nav-item"><a class="nav-link"
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
                                <li class="nav-item"><a class="nav-link active" href="profile-my_profile.php">Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Sidebar -->
            <div class="sidebar-div">
                <div class="sidebar d-none d-md-flex justify-content-center">
                    <ul>
                        <li><a href="profile-my_profile.php">My Profile</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="profile-my_posts.php">My Posts</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="profile-mentorship.php" class="active">Mentorship</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="#">Edit Profile</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="logout-manager.php">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar Toggle div -->
        <div class="sidebar-toggle btn d-md-none" type="div" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
            <img src="icons/sidebar-expand.svg" alt="Sidebar Expand" style="height: 32px; width: 32px;">
        </div>

        <!-- Sidebar offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas"
            aria-labelledby="sidebarOffcanvasLabel">
            <div class="offcanvas-header">
                <div type="div" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></div>
            </div>
            <div class="offcanvas-body">
                <ul>
                    <li><a href="profile-my_profile.php">My Profile</a></li>
                    <li><a href="profile-my_posts.php">My Posts</a></li>
                    <li><a href="profile-mentorship.php" class="active">Mentorship</a></li>
                    <li><a href="#">Edit Profile</a></li>
                    <li><a href="logout-manager.php">Log Out</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mentorship-container">
            <!-- Proposal section -->
            <div class="section">
                <h5 class="mb-3">Proposals</h5>
                <div class="scroll-area">
                    <!-- Example Card -->
                    <div class="card-custom">
                        <div class="profile">
                            <div class="profile-pic">
                                <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=500"
                                    alt="Profile Picture" />
                            </div>
                            <div class="profile-info">
                                <span>Rubayet Ashib Badhon</span>
                                <small>22/09/2025</small>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-custom btn-accept me-2">Accept</button>
                            <button class="btn btn-custom btn-reject">Reject</button>
                        </div>
                    </div>

                    <!-- Duplicate for testing scroll -->
                    <div class="card-custom">
                        <div class="profile">
                            <div class="profile-pic">
                                <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=500"
                                    alt="Profile Picture" />
                            </div>
                            <div class="profile-info">
                                <span>John Doe</span>
                                <small>23/10/2025</small>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-custom btn-accept me-2">Accept</button>
                            <button class="btn btn-custom btn-reject">Reject</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Requests Section -->
            <div class="section">
                <h5 class="mb-3">Requests</h5>
                <div class="scroll-area">
                    <!-- Example Card -->
                    <div class="card-custom">
                        <div class="profile">
                            <div class="profile-pic">
                                <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=500"
                                    alt="Profile Picture" />
                            </div>
                            <div class="profile-info">
                                <span>Ashraful Haq</span>
                                <small>22/09/2025</small>
                            </div>
                        </div>
                        <div>
                            <span class="btn-custom btn-pending">Pending</span>
                        </div>
                    </div>

                    <!-- Duplicate for testing scroll -->
                    <div class="card-custom">
                        <div class="profile">
                            <div class="profile-pic">
                                <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=500"
                                    alt="Profile Picture" />
                            </div>
                            <div class="profile-info">
                                <span>William Smith</span>
                                <small>23/10/2025</small>
                            </div>
                        </div>
                        <div>
                            <span class="btn-custom btn-pending">Pending</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>