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
    <title>Resources</title>

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
                                <li class="nav-item"><a class="nav-link active"
                                        href="resources-resources.php">Resources</a></li>
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
                        <li><a href="resources-resources.php" class="active">Resources</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="resources-search.php">Search</a></li>
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
                    <li><a href="resources-resources.php" class="active">Resources</a></li>
                    <li><a href="resources-search.php">Search</a></li>
                </ul>
            </div>
        </div>

        <!-- Post Container -->
        <div class="post-container">
            <?php
            // Prepare and execute query for post info
            $sql = "SELECT * FROM resources WHERE approve_status = 1 ORDER BY timestamp DESC";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $db->error);
            }
            $stmt->execute();
            $rel = $stmt->get_result();

            // Access database
            while ($row = $rel->fetch_assoc()) {
                // Get post_id and user info who posted
                $res_id = $row['resource_id'];
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
                $post_date = date("M j, Y", strtotime($row['timestamp']));
                $title = $row['title'];
                $post_des = $row['description'];
                $filepath = $row['filepath'];
            ?>
                <div class="post-card">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="profile-pic me-3">
                                <img src="<?= $user_avatar ?>"
                                    alt="Profile Picture" />
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold"><?= $user_name ?></h6>
                                <small class="text-muted"><?= $post_date ?></small>
                            </div>
                        </div>

                        <!-- More option trigger button -->
                        <div type="div" class="more-option" data-bs-toggle="modal" data-bs-target="#optionModal-<?php echo $res_id; ?>">
                            <img src="icons/more-option.svg" alt="">
                        </div>

                        <!-- More option menu -->
                        <div class="modal fade" id="optionModal-<?php echo $res_id; ?>" tabindex="-1" aria-labelledby="optionModalLabel"
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
                                            <span class="w-100" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $res_id; ?>">Edit</span>
                                        <?php } ?>
                                        <?php if ($user == $_SESSION['sid'] || $_SESSION['role'] == "admin") { ?>
                                            <span class="delete-resource w-100 " data-post-id="<?php echo $res_id ?>">Delete</span>
                                        <?php } ?>
                                        <?php if ($user != $_SESSION['sid']) { ?>
                                            <span class="w-100 " data-bs-toggle="modal" data-bs-target="#reportModal-<?php echo $res_id; ?>">Report</span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Post Modal  -->
                        <div class="modal fade p-3" id="editModal-<?php echo $res_id; ?>" tabindex="-1" aria-labelledby="editModalLabel"
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
                                        <h3 class="mb-3">Edit Information</h3>
                                        <form action="edit_resource-manager.php" method="POST" enctype="multipart/form-data" class="w-100">

                                            <!-- Title -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="resTitle" class="form-label ms-2">Title</label>
                                                <input type="text" class="form-control" id="resTitle" placeholder="Enter resource title" required name="title" value="<?= $title ?>">
                                            </div>

                                            <!-- Default Parameters  -->
                                            <input type="hidden" value="<?= $res_id ?>" name="res_id">

                                            <!-- Tag -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <div><label for="tags1" class="form-label ms-2">Tags</label></div>
                                                <div class="d-flex justify-content-between gap-2">
                                                    <div>
                                                        <select class="form-select w-100" aria-label="Default select example" id="tags1" required name="tags[]">
                                                            <option value="" selected disabled>Tag 1 (Required)</option>
                                                            <?php include("tags_list.php") ?>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <select class="form-select" aria-label="Default select example" name="tags[]">
                                                            <option value="" selected>Tag 2 (Optional)</option>
                                                            <?php include("tags_list.php") ?>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <select class="form-select" aria-label="Default select example" name="tags[]">
                                                            <option value="" selected>Tag 3 (Optional)</option>
                                                            <?php include("tags_list.php") ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Description -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="postDescription" class="form-label ms-2">Description</label>
                                                <textarea class="form-control" id="postDescription" rows="5" placeholder="Write something..." required name="des"><?= $post_des ?></textarea>
                                            </div>

                                            <!-- Default Parameters  -->
                                            <input type="hidden" value="resources-resources.php" name="from">

                                            <!-- Upload File -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="resFile" class="form-label ms-2">Attach File (Optional)</label>
                                                <input type="file" class="form-control" id="resFile" accept="application/pdf" name="pdf">
                                                <small class="text-muted ms-1 mt-1">Max size: 2MB</small>
                                            </div>

                                            <!-- Add Button -->
                                            <div class="d-flex justify-content-end mb-2">
                                                <button type="submit" class="btn btn-primary" name="update-btn">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Post Modal  -->
                        <div class="modal fade p-3" id="reportModal-<?php echo $res_id; ?>" tabindex="-1" aria-labelledby="reportModalLabel"
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
                                        <h3 class="mb-3">Report Resource</h3>
                                        <form action="report-manager.php" method="POST" class="w-100">

                                            <!-- Description -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="postDescription" class="form-label ms-2">Description</label>
                                                <textarea class="form-control" id="postDescription" rows="7" placeholder="Type your report..."
                                                    required name="des"></textarea>
                                            </div>

                                            <!-- Default Parameters  -->
                                            <input type="hidden" value="<?php echo $res_id ?>" name="target_id">

                                            <input type="hidden" value="resource" name="type">

                                            <input type="hidden" value="resources-resources.php" name="from">

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
                        <p class="notice-title mb-2" style="font-size: 1.5rem;"><?= $title ?></p>
                        <div class="d-flex gap-3 align-items-center justify-content-start mb-3">
                            <p class="notice-title">Tags: </p>
                            <?php
                            // Prepare and execute query for tags
                            $sql = "SELECT t.course FROM resource_tags r JOIN tags t ON  r.value = t.value WHERE r.resource_id = ?";
                            $stmt1 = $db->prepare($sql);
                            if (!$stmt1) {
                                die("Prepare failed: " . $db->error);
                            }
                            $stmt1->bind_param("i", $res_id);
                            $stmt1->execute();
                            $rel1 = $stmt1->get_result();

                            while ($tags = $rel1->fetch_assoc()) { ?>
                                <div class="tag-box">
                                    <span class="date-value"><?= $tags['course'] ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <p class="description mb-2"><?= $post_des ?></p>
                    </div>

                    <?php if ($filepath != NULL) { ?>
                        <!-- Post Footer -->
                        <div class="post-footer d-flex align-items-end justify-content-end">
                            <form action="download.php" method="get">
                                <input type="hidden" name="filepath" value="<?= $filepath ?>">
                                <button type="submit" class="download-btn mt-1 mb-3 me-3">Download</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <!-- Add resource Section -->
        <div class="create-post-btn btn" type="div" data-bs-toggle="modal" data-bs-target="#createPostModal">
            <img src="icons/add.svg" alt="Add Resource Button" style="height: 36px; width: 36px;">
        </div>

        <!-- Add Resource Modal -->
        <div class="modal fade p-3" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel"
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
                        <h3 class="mb-3">Add a New Resource</h3>
                        <form action="add_resource-manager.php" method="POST" enctype="multipart/form-data" class="w-100">

                            <!-- Title -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <label for="resTitle" class="form-label ms-2">Title</label>
                                <input type="text" class="form-control" id="resTitle" placeholder="Enter resource title" required name="title">
                            </div>

                            <!-- Tag -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <div><label for="tags1" class="form-label ms-2">Tags</label></div>
                                <div class="d-flex justify-content-between gap-2">
                                    <div><select class="form-select w-100" aria-label="Default select example" id="tags1" required name="tags[]">
                                            <option value="" selected disabled>Tag 1 (Required)</option>
                                            <?php include("tags_list.php") ?>
                                        </select></div>

                                    <div><select class="form-select" aria-label="Default select example" name="tags[]">
                                            <option value="" selected>Tag 2 (Optional)</option>
                                            <?php include("tags_list.php") ?>
                                        </select></div>

                                    <div><select class="form-select" aria-label="Default select example" name="tags[]">
                                            <option value="" selected>Tag 3 (Optional)</option>
                                            <?php include("tags_list.php") ?>
                                        </select></div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <label for="postDescription" class="form-label ms-2">Description</label>
                                <textarea class="form-control" id="postDescription" rows="5" placeholder="Write something..." required name="des"></textarea>
                            </div>

                            <!-- Default Parameters  -->
                            <input type="hidden" value="resources-resources.php" name="from">

                            <!-- Upload File -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <label for="resFile" class="form-label ms-2">Attach File (Optional)</label>
                                <input type="file" class="form-control" id="resFile" accept="application/pdf" name="pdf">
                                <small class="text-muted ms-1 mt-1">Max size: 2MB</small>
                            </div>

                            <!-- Add Button -->
                            <div class="d-flex justify-content-end mb-2">
                                <button type="submit" class="btn btn-primary" name="add-btn">Add</button>
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

    <!-- Search Filter Script -->
    <script>
        document.getElementById('dropdownSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.dropdown-menu .dropdown-item');

            items.forEach(item => {
                let text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // Optional: Change button text on selection
        const dropdownItems = document.querySelectorAll('.dropdown-item');
        const dropdownButton = document.querySelector('.dropdown-toggle');

        dropdownItems.forEach(item => {
            item.addEventListener('click', () => {
                dropdownButton.textContent = item.textContent;
            });
        });
    </script>

    <!-- Send post info to delete_resource page  -->
    <script>
        document.querySelectorAll(".delete-resource").forEach(button => {
            button.addEventListener("click", function() {
                const resId = this.getAttribute("data-post-id");
                const fromPage = window.location.href;

                // Create a form dynamically
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "delete_resource-manager.php";

                // Hidden input 1: post_id
                const input1 = document.createElement("input");
                input1.type = "hidden";
                input1.name = "res_id";
                input1.value = resId;
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