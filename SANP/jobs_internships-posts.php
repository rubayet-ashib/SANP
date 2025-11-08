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
    <title>Jobs & Internships - Posts</title>

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

                        <!-- Hamburger div -->
                        <div class="navbar-toggler" type="div" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </div>

                        <!-- Collapsible menu -->
                        <div class="collapse justify-content-end navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">

                                <li class="nav-item"><a class="nav-link" href="student-news_feed.php">Student</a></li>
                                <li class="nav-item"><a class="nav-link" href="alumni-news_feed.php">Alumni</a></li>
                                <li class="nav-item"><a class="nav-link active" href="jobs_internships-posts.php">Jobs
                                        &
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
                        <li><a href="jobs_internships-posts.php" class="active">Posts</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="jobs_internships-search.php">Search</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Toggle div -->
    <div class="sidebar-toggle btn d-md-none" type="div" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas"
        aria-controls="sidebarOffcanvas">
        <img src="icons/sidebar-expand.svg" alt="Sidebar Expand" style="height: 32px; width: 32px;">
    </div>

    <!-- Sidebar offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul>
                <li><a href="jobs_internships-posts.php" class="active">Posts</a></li>
                <li><a href="jobs_internships-search.php">Search</a></li>
            </ul>
        </div>
    </div>

    <!-- Post Container -->
    <div class="post-container">
        <?php
        // Prepare and execute query for post info
        $sql = "SELECT * FROM job_posts WHERE approve_status = 1 ORDER BY timestamp DESC";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $db->error);
        }
        $stmt->execute();
        $rel = $stmt->get_result();

        // Access database
        while ($row = $rel->fetch_assoc()) {
            // Get job_id and user info who posted
            $job_id = $row['job_id'];
            $user = $row['posted_by'];

            // Prepare and execute query for user info
            $sql = "SELECT * FROM users WHERE sid = ?";
            $stmt1 = $db->prepare($sql);
            if (!$stmt1) {
                die("Prepare failed: " . $db->error);
            }
            $stmt1->bind_param("s", $user);
            $stmt1->execute();
            $user_data = $stmt1->get_result()->fetch_assoc();
            $user_name = $user_data['name'];
            $user_avatar = "resources/default-avatar.png";
            if ($user_data['avatar'] != NULL) $user_avatar = $user_data['avatar'];
            $job_des = $row['description'];
            $job_title = $row['title'];
            $job_date = date("M j, Y", strtotime($row['timestamp']));
            $company = $row['company'];
            $vacancies = $row['vacancies'];
        ?>
            <div class="post-card">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <div class="profile-pic me-3 <?php if ($user_avatar == "resources/default-avatar.png") echo "p-1" ?>">
                            <img src="<?php echo $user_avatar ?>"
                                alt="Profile Picture" />
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?php echo $user_name ?></h6>
                            <small class="text-muted"><?php echo $job_date ?></small>
                        </div>
                    </div>

                    <!-- More option trigger button -->
                    <div type="div" class="more-option" data-bs-toggle="modal" data-bs-target="#optionModal-<?php echo $job_id; ?>">
                        <img src="icons/more-option.svg" alt="">
                    </div>

                    <!-- More option menu -->
                    <div class="modal fade" id="optionModal-<?php echo $job_id; ?>" tabindex="-1" aria-labelledby="optionModalLabel"
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
                                    <?php if ($user == $_SESSION['sid']) { ?>
                                        <span class="w-100" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $job_id; ?>">Edit</span>
                                    <?php } ?>
                                    <?php if ($user == $_SESSION['sid'] || $_SESSION['role'] == "admin") { ?>
                                        <span class="delete-post w-100 " data-post-id="<?php echo $job_id ?>">Delete</span>
                                    <?php } ?>
                                    <?php if ($user != $_SESSION['sid']) { ?>
                                        <span class="w-100 " data-bs-toggle="modal" data-bs-target="#reportModal-<?php echo $job_id; ?>">Report</span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Post Modal  -->
                    <div class="modal fade p-3" id="editModal-<?php echo $job_id; ?>" tabindex="-1" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-create-post modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="more-option-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <img src="icons/close-btn.svg" alt="">
                                    </div>
                                </div>

                                <!-- Modal body -->
                                <div class=" create-post-modal-body d-flex flex-column justify-content-center align-items-center w-100 p-3">
                                    <h3 class="mb-3">Edit Job Post</h3>
                                    <form action="edit_job_post-manager.php" method="POST" class="w-100 justify-content-center">

                                        <!-- Job Title -->
                                        <div class="mb-4 d-flex flex-column align-items-start">
                                            <label for="jobTitle" class="form-label ms-2">Title</label>
                                            <input type="text" class="form-control" id="jobTitle" placeholder="Enter job title" required name="title" value="<?php echo $job_title ?>">
                                        </div>

                                        <div class="d-flex row mb-4">
                                            <!-- Company Name -->
                                            <div class="d-flex flex-column align-items-start col-8">
                                                <label for="companyName" class="form-label ms-2">Company name</label>
                                                <input type="text" class="form-control" id="companyName" placeholder="Enter company name" required name="company" value="<?php echo $company ?>">
                                            </div>

                                            <!-- Vacancies -->
                                            <div class="d-flex flex-column align-items-start col-4">
                                                <label for="vacancies" class="form-label ms-2">Vacancies</label>
                                                <input type="number" class="form-control" id="vacancies" placeholder="Enter number of vacancies" step="1" required name="vac" value="<?php echo $vacancies ?>">
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3 d-flex flex-column align-items-start">
                                            <label for="postDescription" class="form-label ms-2">Job description</label>
                                            <textarea class="form-control" id="postDescription" rows="5" placeholder="Write something..."
                                                required name="des"><?php echo $job_des ?></textarea>
                                        </div>

                                        <!-- Default Parameters  -->
                                        <input type="hidden" value="<?php echo $job_id ?>" name="job_id">

                                        <input type="hidden" value="jobs_internships-posts.php" name="from">

                                        <!-- Post Button -->
                                        <div class="d-flex justify-content-end mb-2">
                                            <button type="submit" class="btn btn-primary" name="update-btn">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Post Modal  -->
                    <div class="modal fade p-3" id="reportModal-<?php echo $job_id; ?>" tabindex="-1" aria-labelledby="reportModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-create-post modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="more-option-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <img src="icons/close-btn.svg" alt="">
                                    </div>
                                </div>

                                <!-- Modal body -->
                                <div class=" create-post-modal-body d-flex flex-column justify-content-center align-items-center w-100 p-3">
                                    <h3 class="mb-3">Report Job Post</h3>
                                    <form action="report-manager.php" method="POST" class="w-100">

                                        <!-- Description -->
                                        <div class="mb-3 d-flex flex-column align-items-start">
                                            <label for="postDescription" class="form-label ms-2">Description</label>
                                            <textarea class="form-control" id="postDescription" rows="7" placeholder="Type your report..."
                                                required name="des"></textarea>
                                        </div>

                                        <!-- Default Parameters  -->
                                        <input type="hidden" value="<?php echo $job_id ?>" name="target_id">

                                        <input type="hidden" value="job post" name="type">

                                        <input type="hidden" value="jobs_internships-posts.php" name="from">

                                        <!-- Report Button -->
                                        <div class="d-flex justify-content-end mb-2">
                                            <button type="submit" class="btn btn-primary" name="report-btn">Report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="text-wrapper pb-3">
                    <p class="notice-title mb-1" style="font-size: 1.5rem;"><?php echo $job_title ?></p>
                    <div class="d-flex justify-content-between mb-1">
                        <p class="notice-title" style="font-size: 1.20rem;">Company Name: <span style="background-color: #f6f1ff; border-radius: 6px; padding: 6px 12px; color: var(--primary-color);"><?php echo $company ?> </span></p>
                        <p class="notice-title muted-text" style="font-size: 1.20rem;">Available Vacancies: <span style="background-color: #f6f1ff; border-radius: 6px; padding: 6px 12px; color: var(--primary-color);"><?php echo $vacancies ?> </span></p>
                    </div>
                    <hr>
                    <p class="description mb-2"><?php echo $job_des ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Create Job Post Section -->
    <!-- Create Job Post Button div -->
    <div class="create-post-btn btn" type="div" data-bs-toggle="modal" data-bs-target="#createJobPostModal">
        <img src="icons/add.svg" alt="Create Post Button" style="height: 36px; width: 36px;">
    </div>

    <!-- Create Job Post Modal -->
    <div class="modal fade p-3" id="createJobPostModal" tabindex="-1" aria-labelledby="createJobPostModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-create-post modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="more-option-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <img src="icons/close-btn.svg" alt="">
                    </div>
                </div>

                <!-- Modal body -->
                <div class=" create-post-modal-body d-flex flex-column justify-content-center align-items-center w-100 p-3">
                    <h3 class="mb-3">Create a New Job Post</h3>
                    <form action="create_job_post-manager.php" method="POST" class="w-100 justify-content-center">

                        <!-- Job Title -->
                        <div class="mb-4 d-flex flex-column align-items-start">
                            <label for="jobTitle" class="form-label ms-2">Title</label>
                            <input type="text" class="form-control" id="jobTitle" placeholder="Enter job title" required name="title">
                        </div>

                        <div class="d-flex row mb-4">
                            <!-- Company Name -->
                            <div class="d-flex flex-column align-items-start col-8">
                                <label for="companyName" class="form-label ms-2">Company name</label>
                                <input type="text" class="form-control" id="companyName" placeholder="Enter company name" required name="company">
                            </div>

                            <!-- Vacancies -->
                            <div class="d-flex flex-column align-items-start col-4">
                                <label for="vacancies" class="form-label ms-2">Vacancies</label>
                                <input type="number" class="form-control" id="vacancies" placeholder="Enter number of vacancies" step="1" required name="vac">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3 d-flex flex-column align-items-start">
                            <label for="postDescription" class="form-label ms-2">Job description</label>
                            <textarea class="form-control" id="postDescription" rows="5" placeholder="Write something..."
                                required name="des"></textarea>
                        </div>

                        <!-- Default Parameters  -->
                        <input type="hidden" value="jobs_internships-posts.php" name="from">

                        <!-- Post Button -->
                        <div class="d-flex justify-content-end mb-2">
                            <button type="submit" class="btn btn-primary" name="post-btn">Post</button>
                        </div>
                    </form>
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

    <!-- Send job post info to delete_job_post page  -->
    <script>
        document.querySelectorAll(".delete-post").forEach(button => {
            button.addEventListener("click", function() {
                const postId = this.getAttribute("data-post-id");
                const fromPage = window.location.href;

                // Create a form dynamically
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "delete_job_post-manager.php";

                // Hidden input 1: post_id
                const input1 = document.createElement("input");
                input1.type = "hidden";
                input1.name = "job_id";
                input1.value = postId;
                form.appendChild(input1);

                // Hidden input 2: from_page
                const input2 = document.createElement("input");
                input2.type = "hidden";
                input2.name = "from";
                input2.value = fromPage;
                form.appendChild(input2);

                // Add and submit
                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
</body>

</html>