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
    <title>Admin Panel - Events Approval</title>

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
                        <li><a href="admin_panel-events_approval.php" class="active">Events Approval</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-jobs_approval.php">Jobs Approval</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-manage_notice.php">Manage Notice</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-manage_student.php">Manage Student</a></li>
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
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul>
                    <li><a href="admin_panel-events_approval.php" class="active">Events Approval</a></li>
                    <li><a href="admin_panel-jobs_approval.php">Jobs Approval</a></li>
                    <li><a href="admin_panel-manage_notice.php">Manage Notice</a></li>
                    <li><a href="admin_panel-manage_student.php">Manage Student</a></li>
                </ul>
            </div>
        </div>

        <!-- Post Container -->
        <div class="post-container">
            <?php
            // Prepare and execute query for event info
            $sql = "SELECT * FROM events WHERE approve_status = 0 ORDER BY timestamp";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $db->error);
            }
            $stmt->execute();
            $rel = $stmt->get_result();

            // Access database
            while ($row = $rel->fetch_assoc()) {
                // Get event info
                $event_id = $row['event_id'];
                $title = $row['title'];
                $start_date = date("M j, Y", strtotime($row['start_date']));
                $end_date = date("M j, Y", strtotime($row['end_date']));
                $event_des = $row['description'];
                $event_image = $row['image'];
                $approved_by = $row['approved_by'];
                $posted_by = $row['posted_by'];
            ?>
                <div class="post-card">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center row w-100">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <!-- Title -->
                                    <div>
                                        <h6 class="fw-bold" style="font-size: 2rem;"><?= $title ?></h6>
                                    </div>

                                    <!-- Verify Content -->
                                    <div class="d-flex flex-column align-items-end">
                                        <button class="download-btn">Verify</button>
                                    </div>
                                </div>

                                <div class="dates">
                                    <div class="date-box">
                                        <span class="date-label">Start</span>
                                        <span class="date-value"><?php echo $start_date ?></span>
                                    </div>
                                    <div class="date-box">
                                        <span class="date-label">End</span>
                                        <span class="date-value"><?php echo $end_date ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="text-wrapper">
                        <p class="description mb-2"><?php echo $event_des ?> </p>
                    </div>

                    <!-- Post Image -->
                    <div class="post-image mt-2" style="margin-bottom: -0.5rem;">
                        <img src="<?php echo $event_image ?>"
                            alt="" />
                    </div>

                    <!-- Post Footer -->
                    <div class="post-footer d-flex align-items-center">
                        <!-- Approve Section -->
                        <form action="content_approval.php" method="POST" class="approve-container flex-fill d-flex justify-content-center align-items-center">

                            <!-- Default parameters -->
                            <input type="hidden" value="<?= $event_id ?>" name="target_id">
                            <input type="hidden" value="event" name="target_type">
                            <input type="hidden" value="admin_panel-events_approval.php" name="from">
                            <input type="hidden" value="1" name="status">

                            <button type="submit" class="flex-fill d-flex justify-content-center align-items-center" style="all: unset;">
                                <div class="like d-flex align-items-center gap-3">
                                    <img src="icons/approve.svg" alt="">
                                    <span class="count">Approve</span>
                                </div>
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="divider"></div>

                        <!-- Reject Section -->
                        <form action="content_approval.php" method="POST" class="reject-container flex-fill d-flex justify-content-center align-items-center">

                            <!-- Default parameters -->
                            <input type="hidden" value="<?= $event_id ?>" name="target_id">
                            <input type="hidden" value="event" name="target_type">
                            <input type="hidden" value="admin_panel-events_approval.php" name="from">
                            <input type="hidden" value="0" name="status">

                            <button type="submit" class="flex-fill d-flex justify-content-center align-items-center" style="all: unset;">
                                <div class="like d-flex align-items-center gap-3">
                                    <img src="icons/reject.svg" alt="">
                                    <span class="count">Reject</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Collapsible Description Script -->
    <script>
        document.querySelectorAll(".text-wrapper").forEach(wrapper => {
            const textElement = wrapper.querySelector(".description");
            const fullText = textElement.textContent.trim();
            const charLimit = 500;

            if (fullText.length > charLimit) {
                const shortText = fullText.substring(0, charLimit).trim();

                // Initialize with short text
                textElement.innerHTML = `${shortText}<span class="show-more">... Show more</span>`;

                // Measure both heights
                wrapper.style.maxHeight = wrapper.scrollHeight + "px";
                const collapsedHeight = wrapper.scrollHeight;

                textElement.innerHTML = `${fullText}<span class="show-more"> Show less</span>`;
                wrapper.style.maxHeight = "none";
                const expandedHeight = wrapper.scrollHeight;

                // Revert to collapsed state
                textElement.innerHTML = `${shortText}<span class="show-more">... Show more</span>`;
                wrapper.style.maxHeight = collapsedHeight + "px";

                let expanded = false;

                textElement.addEventListener("click", e => {
                    if (!e.target.classList.contains("show-more")) return;
                    expanded = !expanded;

                    if (expanded) {
                        // EXPAND
                        textElement.innerHTML = `${fullText}<span class="show-more"> Show less</span>`;
                        wrapper.style.maxHeight = expandedHeight + "px";
                    } else {
                        // COLLAPSE (animate height first, then shorten text)
                        wrapper.style.maxHeight = collapsedHeight + "px";

                        // Wait for CSS transition to finish before replacing text
                        wrapper.addEventListener("transitionend", function handleTransition() {
                            textElement.innerHTML = `${shortText}<span class="show-more">... Show more</span>`;
                            wrapper.removeEventListener("transitionend", handleTransition);
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>