<?php
include("db_connect.php");
$db = connect();

session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    return;
}

// Redirect if not student
if ($_SESSION['role'] == "alumni") {
    header("location: alumni-news_feed.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="resources/favicon.svg" type="image/x-icon">
    <title>Student - Batch</title>

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
                        <li><a href="student-batch.php" class="active">Batch</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="student-notices.php">Notices</a></li>
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
                    <li><a href="student-batch.php" class="active">Batch</a></li>
                    <li><a href="student-notices.php">Notices</a></li>
                    <li><a href="student-events.php">Events</a></li>
                    <li><a href="student-search.php">Search</a></li>
                </ul>
            </div>
        </div>
        <!-- Post Container -->
        <div class="post-container">

            <?php
            // Prepare and execute query
            $sql = "select * from batches where batch_id = ?";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $db->error);
            }
            $stmt->bind_param("i", $_SESSION['batch_id']);
            $stmt->execute();
            $rel = $stmt->get_result();
            $data = $rel->fetch_assoc();
            ?>
            <div class="batch-container d-flex align-items-center">
                <div class="batch-logo">
                    <img src="resources/batch-logo.png" alt="Batch Logo">
                </div>
                <div class="batch-title">
                    <h3><?php echo $data['batch_name'] ?></h3>
                    <p>Session: <?php echo $data['session'] ?></p>
                </div>
            </div>


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

                    <!-- More option trigger button -->
                    <div type="div" class="more-option" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <img src="icons/more-option.svg" alt="">
                    </div>

                    <!-- More option menu -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="more-option-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <img src="icons/close-btn.svg" alt="">
                                    </div>
                                </div>
                                <!-- Modal body -->
                                <div class="option-body d-flex flex-column justify-content-center align-items-center">
                                    <span class="w-100 ">Edit</span>
                                    <span class="w-100 ">Delete</span>
                                    <span class="w-100 ">Report</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="text-wrapper">
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

                <!-- Post Image -->
                <div class="post-image mt-2">
                    <img src="https://images.unsplash.com/photo-1421789665209-c9b2a435e3dc?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="" />
                </div>

                <!-- Post Footer -->
                <div class="post-footer d-flex align-items-center">
                    <!-- Like Section -->
                    <div class="like-container flex-fill d-flex justify-content-center align-items-center">
                        <div class="like d-flex align-items-center gap-3">
                            <img src="icons/like.svg" alt="">
                            <span class="count like-count">321</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="divider"></div>

                    <!-- Comment Section -->
                    <div class="comment-container flex-fill d-flex justify-content-center align-items-center">
                        <div class="comment d-flex align-items-center gap-3">
                            <img src="icons/comment.svg" alt="">
                            <span class="count comment-count">123</span>
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