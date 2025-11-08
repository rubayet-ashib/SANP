<?php
include("db_connect.php");
$db = connect();

session_start();
if (!isset($_SESSION['status'])) {
    header("location: login.php");
    return;
}

if (!isset($_POST['post_id'])) {
    if ($_SESSION['role'] == "alumni") {
        header("location: alumni-news_feed.php");
        exit;
    } else {
        header("location: student-news_feed.php");
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
    <title>Comments</title>

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
        </div>

        <!-- View comment container -->
        <div class="view-comment-container d-flex">
            <div class="comment-post-container col-6">
                <?php
                // Prepare and execute query for post info
                $sql = "SELECT * FROM posts WHERE post_id = ?";
                $stmt = $db->prepare($sql);
                if (!$stmt) {
                    die("Prepare failed: " . $db->error);
                }
                $stmt->bind_param("s", $_POST['post_id']);
                $stmt->execute();
                $row = $stmt->get_result()->fetch_assoc();

                // Get user info who posted
                $posted_by = $row['sid'];

                // Prepare and execute query for user info
                $sql = "SELECT * FROM users WHERE sid = ?";
                $stmt1 = $db->prepare($sql);
                if (!$stmt1) {
                    die("Prepare failed: " . $db->error);
                }
                $stmt1->bind_param("s", $posted_by);
                $stmt1->execute();
                $user_data = $stmt1->get_result()->fetch_assoc();
                $user_name = $user_data['name'];
                $user_avatar = "resources/default-avatar.png";
                if ($user_data['avatar'] != NULL) $user_avatar = $user_data['avatar'];
                $post_date = date("M j, Y", strtotime($row['timestamp']));
                $post_des = $row['description'];
                $post_image = $row['image'];
                ?>
                <div class="post-card pb-0">
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

                </div>
            </div>

            <div class="comment-secion col-6 d-flex flex-column">
                <div class="comments-container mb-3">
                    <?php
                    // Prepare and execute query for comment info
                    $sql = "SELECT * FROM comments WHERE post_id = ? ORDER BY timestamp DESC";
                    $stmt = $db->prepare($sql);
                    if (!$stmt) {
                        die("Prepare failed: " . $db->error);
                    }
                    $stmt->bind_param("s", $_POST['post_id']);
                    $stmt->execute();
                    $rel = $stmt->get_result();

                    while ($row = $rel->fetch_assoc()) {
                        // Get user info who commented
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
                        $comment_date = date("M j, Y", strtotime($row['timestamp']));
                        $comment_text = $row['comment'];
                        $tmp_comment_id = $row['post_id'] . $row['sid'] . $row['timestamp'];
                        $comment_id = str_replace(' ', '', $tmp_comment_id);
                    ?>
                        <div class="post-card">
                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="profile-pic me-3 <?php if ($user_avatar == "resources/default-avatar.png") echo "p-1" ?>">
                                        <img src="<?php echo $user_avatar ?>"
                                            alt="Profile Picture" />
                                    </div>
                                    <div class="d-flex flex-column justify-content-center align-items-start">
                                        <h6 class="mb-1 fw-bold"><?php echo $user_name ?></h6>
                                        <small class="text-muted"><?php echo $comment_date ?></small>
                                    </div>
                                </div>

                                <!-- More option trigger button -->
                                <div type="div" class="more-option" data-bs-toggle="modal" data-bs-target="#optionModal-<?php echo $comment_id; ?>">
                                    <img src="icons/more-option.svg" alt="">
                                </div>

                                <!-- More option menu -->
                                <div class="modal fade" id="optionModal-<?php echo $comment_id; ?>" tabindex="-1" aria-labelledby="optionModalLabel"
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
                                                    <span class="w-100" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $comment_id; ?>">Edit</span>
                                                <?php } ?>
                                                <?php if ($user == $_SESSION['sid'] || $_SESSION['role'] == "admin" || $_SESSION['sid'] == $posted_by) { ?>
                                                    <span class="delete-post w-100 " data-post-id="<?php echo $comment_id ?>">Delete</span>
                                                <?php } ?>
                                                <?php if ($user != $_SESSION['sid']) { ?>
                                                    <span class="w-100 " data-bs-toggle="modal" data-bs-target="#reportModal-<?php echo $comment_id; ?>">Report</span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Post Modal  -->
                                <div class="modal fade p-3" id="editModal-<?php echo $comment_id; ?>" tabindex="-1" aria-labelledby="editModalLabel"
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
                                                <h3 class="mb-3">Edit Comment</h3>
                                                <form action="edit_comment-manager.php" method="POST" class="w-100">

                                                    <!-- Description -->
                                                    <div class="mb-3 d-flex flex-column align-items-start">
                                                        <label for="postDescription" class="form-label ms-2">Your comment</label>
                                                        <textarea class="form-control" id="postDescription" rows="5" placeholder="Write something..."
                                                            required name="comment_text"><?php echo $comment_text ?></textarea>
                                                    </div>

                                                    <!-- Default Parameters  -->
                                                    <input type="hidden" value="<?php echo $comment_id ?>" name="comment_id">

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
                                <div class="modal fade p-3" id="reportModal-<?php echo $comment_id; ?>" tabindex="-1" aria-labelledby="reportModalLabel"
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
                                                <h3 class="mb-3">Report Comment</h3>
                                                <form action="report-manager.php" method="POST" class="w-100">

                                                    <!-- Description -->
                                                    <div class="mb-3 d-flex flex-column align-items-start">
                                                        <label for="postDescription" class="form-label ms-2">Description</label>
                                                        <textarea class="form-control" id="postDescription" rows="7" placeholder="Type your report..."
                                                            required name="des"></textarea>
                                                    </div>

                                                    <!-- Default Parameters  -->
                                                    <input type="hidden" value="<?php echo $comment_id ?>" name="target_id">

                                                    <input type="hidden" value="comment" name="type">

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
                            <div class="text-wrapper mb-4">
                                <p class="description"> <?php echo $comment_text ?> </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- Submit comment secion  -->
                <form class="comment-form-container d-flex justify-content-center align-items-end row gap-3" action="comment-manager.php" method="POST" style="display:none;">
                    <!-- Description -->
                    <div class="mb-3 mt-1 d-flex flex-column align-items-start col-10">
                        <textarea class="form-control" rows="3" placeholder="Write something..."
                            style="border-radius: 16px;" required name="comment-text"></textarea>
                    </div>

                    <!-- Send post_id -->
                    <input type="hidden" name="post_id" value="<?php echo $_POST['post_id'] ?>">

                    <!-- Comment Button -->
                    <button class="d-flex justify-content-end mb-3 col-2 comment-btn btn" type="submit" name="comment-btn">
                        <img src="icons/send-btn.svg" style="height: 24px; width: 24px;">
                    </button>
                </form>
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

    <!-- Send comment info to delete_comment page  -->
    <script>
        document.querySelectorAll(".delete-post").forEach(button => {
            button.addEventListener("click", function()
            {
                const commentId = this.getAttribute("data-post-id");
                const fromPage = window.location.href;

                // Create a form dynamically
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "delete_comment-manager.php";

                // Hidden input 1: comment_id
                const input1 = document.createElement("input");
                input1.type = "hidden";
                input1.name = "comment_id";
                input1.value = commentId;
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