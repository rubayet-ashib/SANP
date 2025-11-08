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
    <title>Student - Events</title>

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
                        <li><a href="student-notices.php">Notices</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="student-events.php" class="active">Events</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="student-search.php">Search</a></li>
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
                    <li><a href="student-news_feed.php">News Feed</a></li>
                    <!-- Visible to students only -->
                    <?php if ($_SESSION['role'] != "alumni") { ?>
                        <li><a href="student-batch.php">Batch</a></li>
                    <?php } ?>
                    <li><a href="student-notices.php">Notices</a></li>
                    <li><a href="student-events.php" class="active">Events</a></li>
                    <li><a href="student-search.php">Search</a></li>
                </ul>
            </div>
        </div>

        <!-- Post Container -->
        <div class="post-container">
            <?php
            // Prepare and execute query for event info
            $sql = "SELECT * FROM events WHERE type = 'student' AND approve_status = 1 ORDER BY timestamp DESC";
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
                                <h6 class="mb-3 fw-bold" style="font-size: 2rem;"><?php echo $title ?></h6>

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

                        <!-- More option trigger button -->
                        <div type="div" class="more-option" data-bs-toggle="modal" data-bs-target="#optionModal-<?php echo $event_id; ?>">
                            <img src="icons/more-option.svg" alt="">
                        </div>

                        <!-- More option menu -->
                        <div class="modal fade" id="optionModal-<?php echo $event_id; ?>" tabindex="-1" aria-labelledby="optionModalLabel"
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
                                        <?php if ($posted_by == $_SESSION['sid']) { ?>
                                            <span class="w-100" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $event_id; ?>">Edit</span>
                                        <?php } ?>
                                        <?php if ($posted_by == $_SESSION['sid'] || $_SESSION['role'] == "admin") { ?>
                                            <span class="delete-event w-100 " data-post-id="<?php echo $event_id ?>">Delete</span>
                                        <?php } ?>
                                        <?php if ($posted_by != $_SESSION['sid']) { ?>
                                            <span class="w-100 " data-bs-toggle="modal" data-bs-target="#reportModal-<?php echo $event_id; ?>">Report</span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Event Modal  -->
                        <div class="modal fade p-3" id="editModal-<?php echo $event_id; ?>" tabindex="-1" aria-labelledby="editModalLabel"
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
                                        <h3 class="mb-3">Update Event</h3>
                                        <form action="edit_event-manager.php" method="POST" enctype="multipart/form-data" class="w-100">

                                            <!-- Title -->
                                            <div class="mb-4 d-flex flex-column align-items-start">
                                                <label for="eventTitle" class="form-label ms-2">Title</label>
                                                <input type="text" class="form-control" id="eventTitle" placeholder="Enter event title" required name="title" value="<?php echo $title ?>">
                                            </div>

                                            <!-- Start & end date  -->
                                            <div class="d-flex justify-content-between mb-3 ms-2 me-2">
                                                <div>
                                                    <label for="start-date" class="form-label">Start date: </label>
                                                    <input type="date" id="start-date" required name="start-date" value="<?php echo $row['start_date'] ?>">
                                                </div>
                                                <div>
                                                    <label for="end-date" class="form-label">End date: </label>
                                                    <input type="date" id="end-date" required name="end-date" value="<?php echo $row['end_date'] ?>">
                                                </div>
                                            </div>

                                            <!-- Description -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="eventDescription" class="form-label ms-2">Description</label>
                                                <textarea class="form-control" id="eventDescription" rows="5" placeholder="Write something..."
                                                    required name="des"><?php echo $event_des ?></textarea>
                                            </div>

                                            <!-- Default Parameters  -->
                                            <input type="hidden" value="<?php echo $event_id ?>" name="event_id">

                                            <input type="hidden" value="student-events.php" name="from">

                                            <!-- Image Upload -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="eventImage" class="form-label ms-2">Upload
                                                    Image (Optional)</label>
                                                <input type="file" class="form-control" id="eventImage" accept="image/*" name="image">
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
                        <div class="modal fade p-3" id="reportModal-<?php echo $event_id; ?>" tabindex="-1" aria-labelledby="reportModalLabel"
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
                                        <h3 class="mb-3">Report Event</h3>
                                        <form action="report-manager.php" method="POST" class="w-100">

                                            <!-- Description -->
                                            <div class="mb-3 d-flex flex-column align-items-start">
                                                <label for="eventDescription" class="form-label ms-2">Description</label>
                                                <textarea class="form-control" id="eventDescription" rows="7" placeholder="Type your report..."
                                                    required name="des"></textarea>
                                            </div>

                                            <!-- Default Parameters  -->
                                            <input type="hidden" value="<?php echo $event_id ?>" name="target_id">

                                            <input type="hidden" value="event" name="type">

                                            <input type="hidden" value="student-events.php" name="from">

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
                        <p class="description mb-2"><?php echo $event_des ?> </p>
                    </div>

                    <!-- Post Image -->
                    <div class="post-image mt-2" style="margin-bottom: -0.5rem;">
                        <img src="<?php echo $event_image ?>"
                            alt="" />
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Create Event Section -->
        <!-- Create Event Button div (visible to students and admins)-->
        <?php if ($_SESSION['role'] != "alumni") { ?>
            <div class="create-post-btn btn" type="div" data-bs-toggle="modal" data-bs-target="#createEventModal">
                <img src="icons/add.svg" alt="Create Event Button" style="height: 36px; width: 36px;">
            </div>
        <?php } ?>

        <!-- Create Event Modal -->
        <div class="modal fade p-3" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel"
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
                        <h3 class="mb-3">Create a New Event</h3>
                        <form action="create_event-manager.php" method="POST" enctype="multipart/form-data" class="w-100">

                            <!-- Title -->
                            <div class="mb-4 d-flex flex-column align-items-start">
                                <label for="eventTitle" class="form-label ms-2">Title</label>
                                <input type="text" class="form-control" id="eventTitle" placeholder="Enter event title" required name="title">
                            </div>

                            <!-- Start & end date  -->
                            <div class="d-flex justify-content-between mb-3 ms-2 me-2">
                                <div>
                                    <label for="start-date" class="form-label">Start date: </label>
                                    <input type="date" id="start-date" required name="start-date">
                                </div>
                                <div>
                                    <label for="end-date" class="form-label">End date: </label>
                                    <input type="date" id="end-date" required name="end-date">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <label for="eventDescription" class="form-label ms-2">Description</label>
                                <textarea class="form-control" id="eventDescription" rows="5" placeholder="Write something..."
                                    required name="des"></textarea>
                            </div>

                            <!-- Default Parameters  -->
                            <input type="hidden" value="student" name="type">

                            <input type="hidden" value="student-events.php" name="from">

                            <!-- Image Upload -->
                            <div class="mb-3 d-flex flex-column align-items-start">
                                <label for="eventImage" class="form-label ms-2">Upload
                                    Image (Optional)</label>
                                <input type="file" class="form-control" id="eventImage" accept="image/*" name="image">
                                <small class="text-muted ms-1 mt-1">Max size: 2MB</small>
                            </div>

                            <!-- Create Button -->
                            <div class="d-flex justify-content-end mb-2">
                                <button type="submit" class="btn btn-primary" name="create-btn">Create</button>
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

    <!-- Prevent selecting an end date earlier than start -->
    <script>
        const start = document.getElementById('start-date');
        const end = document.getElementById('end-date');

        start.addEventListener('change', () => {
            end.min = start.value;
        });

        end.addEventListener('change', () => {
            start.max = end.value;
        });
    </script>

    <!-- Send event info to delete_event page  -->
    <script>
        document.querySelectorAll(".delete-event").forEach(button => {
            button.addEventListener("click", function()
            {
                const eventId = this.getAttribute("data-post-id");
                const fromPage = window.location.href;

                // Create a form dynamically
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "delete_event-manager.php";

                // Hidden input 1: event_id
                const input1 = document.createElement("input");
                input1.type = "hidden";
                input1.name = "event_id";
                input1.value = eventId;
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