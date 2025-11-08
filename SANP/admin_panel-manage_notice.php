<?php
include("db_connect.php");
$db = connect();

session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    return;
}

// Redirect if not admin
if ($_SESSION['role'] != "admin") {
    if ($_SESSION['role'] == "student") {
        header("location: student-news_feed.php");
        exit;
    } else {
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
                        <a class="navbar-brand d-flex align-items-center" href="<?php echo ($_SESSION['role'] == "alumni") ? "alumni-news_feed.php" : "student-news_feed.php" ?>">
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
                        <li><a href="admin_panel-events_approval.php">Events Approval</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-jobs_approval.php">Jobs Approval</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-manage_notice.php" class="active">Manage Notice</a></li>
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
                    <li><a href="admin_panel-manage_notice.php" class="active">Manage Notice</a></li>
                    <li><a href="admin_panel-manage_student.php">Manage Student</a></li>
                </ul>
            </div>
        </div>

        <!-- Notice section -->
        <div class="post-container" style="padding: 2.5rem;">
            <div class="d-flex align-items-center justify-content-between ms-2 me-3 mb-3" style="cursor: pointer;">
                <!-- Title -->
                <h3 class="mb-3">Notices</h3>

                <!-- Publish Notice Button div -->
                <div class="download-btn" type="div" data-bs-toggle="modal" data-bs-target="#publishNoticeModal">
                    <img src="icons/add.svg" alt="Add" style="height: 24px;">
                    Add
                </div>
            </div>


            <!-- Scrollable notice list -->
            <div class="notice-list">
                <?php
                $sql = "SELECT * FROM notices ORDER BY timestamp DESC";
                $stmt = $db->prepare($sql);
                if (!$stmt) {
                    die("Prepare failed: " . $db->error);
                }
                $stmt->execute();
                $rel = $stmt->get_result();
                while ($row = $rel->fetch_assoc()) {
                    $notice_id = $row['notice_id'];
                    $title = $row['title'];
                    $publish_date = date("M j, Y", strtotime($row['timestamp']));
                    $filepath = $row['filepath'];
                ?>
                    <div class="notice-card">
                        <div class="notice-text">
                            <p class="notice-title mb-0"><?= $title ?></p>
                            <p class="notice-date mb-0">Published on: <?= $publish_date ?></p>
                        </div>

                        <form action="delete_notice-manager.php" method="POST" class="me-3">
                            <input type="hidden" name="notice_id" value="<?= $notice_id ?>">
                            <button type="submit" class="notice-delete-btn" name="delete-btn"><img src="icons/delete-hover.svg" alt="Delete" style="height: 28px; width: 28px;"></button>
                        </form>

                        <form action="download.php" method="get">
                            <input type="hidden" name="filepath" value="<?= $filepath ?>">
                            <button type="submit" class="download-btn">Download</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Publish Notice Section -->

        <!-- Publish Notice Modal -->
        <div class="modal fade p-3" id="publishNoticeModal" tabindex="-1" aria-labelledby="publishNoticeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-create-post modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="more-option-btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <img src="icons/close-btn.svg" alt="">
                        </div>
                    </div>

                    <!-- Modal body -->
                    <div class=" create-post-modal-body d-flex flex-column justify-content-center align-items-center w-100 p-4">
                        <h3 class="mb-3">Publish Notice</h3>
                        <form action="publish_notice-manager.php" method="POST" enctype="multipart/form-data" class="w-100 justify-content-center">
                            <!-- Notice Title -->
                            <div class="mb-4 d-flex flex-column align-items-start">
                                <label for="noticeTitle" class="form-label ms-2">Title</label>
                                <input type="text" class="form-control" id="noticeTitle" placeholder="Enter notice title" required name="title">
                            </div>

                            <!-- Upload File -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <label for="noticeFile" class="form-label ms-2">Attach File (Required)</label>
                                <input type="file" class="form-control" id="noticeFile" accept="application/pdf" name="pdf" required>
                                <small class="text-muted ms-1 mt-1">Max size: 2MB</small>
                            </div>

                            <!-- Default parameters -->
                            <input type="hidden" value="admin_panel-manage_notice.php" name="from">

                            <!-- Publish Button -->
                            <div class="d-flex justify-content-center mb-3">
                                <button type="submit" class="btn btn-primary" name="publish-btn">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>