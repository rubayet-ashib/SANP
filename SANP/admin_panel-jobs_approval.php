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
    <title>Admin Panel - Jobs Approval</title>

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
                        <li><a href="admin_panel-jobs_approval.php" class="active">Jobs Approval</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="admin_panel-publish_notice.php">Publish Notice</a></li>
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
                    <li><a href="admin_panel-events_approval.php">Events Approval</a></li>
                    <li><a href="admin_panel-jobs_approval.php" class="active">Jobs Approval</a></li>
                    <li><a href="admin_panel-publish_notice.php">Publish Notice</a></li>
                    <li><a href="admin_panel-manage_student.php">Manage Student</a></li>
                </ul>
            </div>
        </div>
        <!-- Post Container -->
        <div class="post-container">

            <div class="post-card">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <div class="profile-pic me-3">
                            <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=500"
                                alt="Profile Picture" />
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Rubayet Ashib Badhon</h6>
                            <small class="text-muted">22/09/2025</small>
                        </div>
                    </div>

                    <!-- Contact user -->
                    <div class="d-flex flex-column align-items-end">
                        <button class="download-btn">Contact</button>
                    </div>
                </div>

                <!-- Description -->
                <div class="text-wrapper pb-3">
                    <p class="notice-title mb-0">Company: Google</p>
                    <p class="notice-title mb-2">Vacancies: 5</p>
                    <p class="description mb-2">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rerum aperiam aut inventore
                        esse
                        enim
                        officia molestiae incidunt, totam vero qui labore dolore iure, voluptatem beatae eaque
                        nostrum
                        est.
                        Molestias odio praesentium nam recusandae atque inventore ad magnam iure quidem numquam
                        quibusdam
                        dolores illo odit error ullam totam fugiat quia deserunt voluptas natus mollitia
                        reprehenderit,
                        exercitationem sint optio. Sequi officiis dignissimos repellat perferendis eos odit
                        optio culpa
                        quod
                        consequuntur ullam incidunt accusamus, quaerat excepturi cupiditate aut necessitatibus
                        sit earum
                        facilis
                        inventore nihil in error fugit dolore? Laborum, esse delectus facilis eius laudantium
                        autem rem quia consectetur distinctio perferendis?
                    </p>
                </div>

                <!-- Post Footer -->
                <div class="post-footer d-flex align-items-center">
                    <!-- Approve Section -->
                    <div class="approve-container flex-fill d-flex justify-content-center align-items-center">
                        <div class="like d-flex align-items-center gap-3">
                            <img src="icons/approve.svg" alt="">
                            <span class="count">Approve</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="divider"></div>

                    <!-- Reject Section -->
                    <div class="reject-container flex-fill d-flex justify-content-center align-items-center">
                        <div class="comment d-flex align-items-center gap-3">
                            <img src="icons/reject.svg" alt="">
                            <span class="count">Reject</span>
                        </div>
                    </div>
                </div>

            </div>
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