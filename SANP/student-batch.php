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
            $sql = "SELECT b.batch_id AS batch_id, batch_name, logo, session FROM batches b JOIN users u ON b.batch_id = u.batch_id WHERE u.sid = ?";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $db->error);
            }
            $stmt->bind_param("s", $_SESSION['sid']);
            $stmt->execute();
            $rel = $stmt->get_result();
            $data = $rel->fetch_assoc();

            $batch_id = $data['batch_id'];
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

            <?php
            // Prepare and execute query for post info
            $sql = "SELECT * FROM posts WHERE type = 'student-batch' AND batch_id = ? ORDER BY timestamp DESC";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $db->error);
            }
            $stmt->bind_param("s", $batch_id);
            $stmt->execute();
            $rel = $stmt->get_result();

            // Access database
            while ($row = $rel->fetch_assoc()) {
                // Get post_id and user info who posted
                $post_id = $row['post_id'];
                $user = $row['sid'];

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
                $post_des = $row['description'];
                $post_image = $row['image'];
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
                                <small class="text-muted"><?php echo $post_date ?></small>
                            </div>
                        </div>

                        <!-- More option trigger button -->
                        <div type="div" class="more-option" data-bs-toggle="modal" data-bs-target="#optionModal-<?php echo $post_id; ?>">
                            <img src="icons/more-option.svg" alt="">
                        </div>

                        <!-- More option menu -->
                        <div class="modal fade" id="optionModal-<?php echo $post_id; ?>" tabindex="-1" aria-labelledby="optionModalLabel"
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
                                            <span class="w-100" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $post_id; ?>">Edit</span>
                                        <?php } ?>
                                        <?php if ($user == $_SESSION['sid'] || $_SESSION['role'] == "admin") { ?>
                                            <span class="delete-post w-100 " data-post-id="<?php echo $post_id ?>">Delete</span>
                                        <?php } ?>
                                        <?php if ($user != $_SESSION['sid']) { ?>
                                            <span class="w-100 " data-bs-toggle="modal" data-bs-target="#reportModal-<?php echo $post_id; ?>">Report</span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Post Modal  -->
                        <div class="modal fade p-3" id="editModal-<?php echo $post_id; ?>" tabindex="-1" aria-labelledby="editModalLabel"
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
                                        <h3 class="mb-3">Edit Post</h3>
                                        <form action="edit_post-manager.php" method="POST" enctype="multipart/form-data" class="w-100">

                                            <!-- Description -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="postDescription" class="form-label ms-2">Description</label>
                                                <textarea class="form-control" id="postDescription" rows="5" placeholder="Write something..."
                                                    required name="des"><?php echo $post_des ?></textarea>
                                            </div>

                                            <!-- Default Parameters  -->
                                            <input type="hidden" value="<?php echo $post_id ?>" name="post_id">

                                            <input type="hidden" value="student-batch.php" name="from">

                                            <!-- Image Upload -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="postImage" class="form-label ms-2">Upload
                                                    Image</label>
                                                <input type="file" class="form-control" id="postImage" accept="image/*" name="image">
                                                <small class="text-muted ms-1 mt-1">Max size: 2MB</small>
                                            </div>

                                            <!-- Update Button -->
                                            <div class="d-flex justify-content-end mb-2">
                                                <button type="submit" class="btn btn-primary" name="update-btn">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Post Modal  -->
                        <div class="modal fade p-3" id="reportModal-<?php echo $post_id; ?>" tabindex="-1" aria-labelledby="reportModalLabel"
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
                                        <h3 class="mb-3">Report Post</h3>
                                        <form action="report_post-manager.php" method="POST" class="w-100">

                                            <!-- Description -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="postDescription" class="form-label ms-2">Description</label>
                                                <textarea class="form-control" id="postDescription" rows="7" placeholder="Type your report..."
                                                    required name="des"></textarea>
                                            </div>

                                            <!-- Default Parameters  -->
                                            <input type="hidden" value="<?php echo $post_id ?>" name="post_id">

                                            <input type="hidden" value="student-batch.php" name="from">

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
                    <div class="text-wrapper">
                        <p class="description mb-2">
                            <?php echo $post_des ?>
                        </p>
                    </div>

                    <!-- Post Image -->
                    <div class="post-image mt-2">
                        <img src="<?php echo $post_image ?>"
                            alt="" />
                    </div>

                    <!-- Post Footer -->
                    <div class="post-footer d-flex align-items-center">
                        <!-- Like Section -->
                        <?php
                        // Get total like count
                        $sql = "SELECT COUNT(sid) AS like_count FROM likes WHERE post_id = ? GROUP BY post_id";
                        $stmt2 = $db->prepare($sql);
                        if (!$stmt2) {
                            die("Prepare failed: " . $db->error);
                        }
                        $stmt2->bind_param("s", $post_id);
                        $stmt2->execute();
                        $rel2 = $stmt2->get_result();
                        $data = $rel2->fetch_assoc();
                        $total_count = 0;
                        if ($rel2->num_rows > 0) $total_count = $data['like_count'];

                        // Get if liked or not
                        $sql = "SELECT * FROM likes WHERE post_id = ? AND sid = ?";
                        $stmt3 = $db->prepare($sql);
                        if (!$stmt3) {
                            die("Prepare failed: " . $db->error);
                        }
                        $stmt3->bind_param("ss", $post_id, $_SESSION['sid']);
                        $stmt3->execute();
                        $rel3 = $stmt3->get_result();
                        $isLiked = 0;
                        if ($rel3->num_rows > 0) $isLiked = 1;
                        ?>

                        <div class="like-container flex-fill d-flex justify-content-center align-items-center <?php echo $isLiked ? 'liked' : '' ?>" data-post-id="<?php echo $post_id ?>">
                            <div class="like d-flex align-items-center gap-3">
                                <img src="<?php echo $isLiked ? 'icons/like-hover.svg' : 'icons/like.svg' ?>" class="like-icon">
                                <span class="count like-count" style="color: <?php echo $isLiked ? '#4c00ff' : '#343a40' ?>"><?php echo $total_count ?></span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="divider"></div>

                        <!-- Comment Section -->
                        <?php
                        // Get total comment count
                        $sql = "SELECT COUNT(sid) AS comment_count FROM comments WHERE post_id = ? GROUP BY post_id";
                        $stmt4 = $db->prepare($sql);
                        if (!$stmt4) {
                            die("Prepare failed: " . $db->error);
                        }
                        $stmt4->bind_param("s", $post_id);
                        $stmt4->execute();
                        $rel4 = $stmt4->get_result();
                        $data = $rel4->fetch_assoc();
                        $total_comment_count = 0;
                        if ($rel4->num_rows > 0) $total_comment_count = $data['comment_count'];

                        // Get if commented or not
                        $sql = "SELECT * FROM comments WHERE post_id = ? AND sid = ?";
                        $stmt5 = $db->prepare($sql);
                        if (!$stmt5) {
                            die("Prepare failed: " . $db->error);
                        }
                        $stmt5->bind_param("ss", $post_id, $_SESSION['sid']);
                        $stmt5->execute();
                        $rel5 = $stmt5->get_result();
                        $isCommented = 0;
                        if ($rel5->num_rows > 0) $isCommented = 1;
                        ?>

                        <div class="comment-container flex-fill d-flex justify-content-center align-items-center <?php echo $isCommented ? 'commented' : '' ?>" data-post-id="<?php echo $post_id ?>">
                            <div class="comment d-flex align-items-center gap-3">
                                <img src="<?php echo $isCommented ? 'icons/comment-hover.svg' : 'icons/comment.svg' ?>" class="comment-icon">
                                <span class="count comment-count" style="color: <?php echo $isCommented ? '#4c00ff' : '#343a40' ?>"><?php echo $total_comment_count ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Create Post Section -->
        <!-- Create Post Button div (visible to students and admins)-->
        <?php if ($_SESSION['role'] != "alumni") { ?>
            <div class="create-post-btn btn" type="div" data-bs-toggle="modal" data-bs-target="#createPostModal">
                <img src="icons/add.svg" alt="Create Post Button" style="height: 36px; width: 36px;">
            </div>
        <?php } ?>

        <!-- Create Post Modal -->
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
                        <h3 class="mb-3">Create a New Post</h3>
                        <form action="create_post-manager.php" method="POST" enctype="multipart/form-data" class="w-100">

                            <!-- Description -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <label for="postDescription" class="form-label ms-2">Description</label>
                                <textarea class="form-control" id="postDescription" rows="5" placeholder="Write something..."
                                    required name="des"></textarea>
                            </div>

                            <!-- Default Parameters  -->
                            <input type="hidden" value="student-batch" name="type">

                            <input type="hidden" value="student-batch.php" name="from">

                            <input type="hidden" value="<?php echo $batch_id ?>" name="batch_id">

                            <!-- Image Upload -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <label for="postImage" class="form-label ms-2">Upload
                                    Image</label>
                                <input type="file" class="form-control" id="postImage" accept="image/*" name="image">
                                <small class="text-muted ms-1 mt-1">Max size: 2MB</small>
                            </div>

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

    <!-- Like handle script -->
    <script>
        document.querySelectorAll('.like-container').forEach(likeDiv => {
            likeDiv.addEventListener('click', function() {
                const postId = this.dataset.postId;
                const countSpan = this.querySelector('.like-count');
                const icon = this.querySelector('.like-icon');

                // Disable clicking temporarily (prevents spam)
                this.style.pointerEvents = 'none';

                fetch('like-manager.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'post_id=' + postId + '&source=ajax'
                    })
                    .then(res => res.text())
                    .then(newCount => {
                        countSpan.textContent = newCount;
                        // Toggle icon and count color
                        this.classList.toggle('liked');
                        if (this.classList.contains('liked')) {
                            icon.src = 'icons/like-hover.svg';
                            countSpan.style.color = "#4c00ff";
                        } else {
                            icon.src = 'icons/like.svg';
                            countSpan.style.color = "#343a40";
                        }
                        this.style.pointerEvents = 'auto';
                    });
            });
        });
    </script>

    <!-- Send comment info to comment view page  -->
    <script>
        document.querySelectorAll(".comment-container").forEach(button => {
            button.addEventListener("click", function() {
                const postId = this.getAttribute("data-post-id");
                const fromPage = window.location.href;

                // Create a form dynamically
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "comments.php";
                form.target = "blank";

                // Hidden input 1: post_id
                const input1 = document.createElement("input");
                input1.type = "hidden";
                input1.name = "post_id";
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

    <!-- Send post info to delete_post page  -->
    <script>
        document.querySelectorAll(".delete-post").forEach(button => {
            button.addEventListener("click", function() {
                const postId = this.getAttribute("data-post-id");
                const fromPage = window.location.href;

                // Create a form dynamically
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "delete_post-manager.php";

                // Hidden input 1: post_id
                const input1 = document.createElement("input");
                input1.type = "hidden";
                input1.name = "post_id";
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