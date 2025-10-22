<?php
    include("db_connect.php");
    $db = connect();

    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="resources/favicon.svg" type="image/x-icon">
    <title>Student & Alumni Networking Portal</title>

    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container login-container d-flex flex-column">
        <!-- Website Title -->
        <div class="mb-5">
            <p class="title">Student<span><img src="resources/Logo.svg" alt="Site Logo"></span>Alumni</p>
            <p class="title">Networking Portal</p>
        </div>

        <div class="row w-100 align-items-center">
            <!-- Left: Login Form -->
            <div class="col-md-6 d-flex justify-content-center">
                <div class="login-card">
                    <h3>Log In</h3>
                    <form action="login_manager.php" method="POST">

                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <img src="icons/student-id.svg" alt="Student ID" width="24" height="24">
                            </span>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGroup1"
                                    placeholder="Student ID" minlength="12" maxlength="12" required name="sid">
                                <label for="floatingInputGroup1">Student ID</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <img src="icons/password.svg" alt="Password" width="24" height="24">
                            </span>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingInputGroup2"
                                    placeholder="Password" minlength="4" required name="password">
                                <label for="floatingInputGroup2">Password</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="login-btn" id="toastTrigger">Log In</button>
                    </form>
                    <div class="links">
                        <p class="text-muted">Don’t have an account?
                            <a href="create_account.php" style="color: var(--primary-color);">
                                Create one
                            </a>
                        </p>

                        <p>
                            <a href="#" style="color: var(--primary-color);">
                                Forgot password?
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Illustration -->
            <div class="col-md-6 d-none d-md-flex justify-content-center">
                <img src="resources/login-illustrator.webp" alt="Login Illustration" class="illustration img-fluid"
                    style="max-width: 550px;">
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast1" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body alert alert-danger mb-0">
                    Invalid Student ID or Password!
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast2" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body alert alert-success mb-0">
                    Account created successfully! Log in to continue.
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Toast Alert Script -->
    <script>
        const toastLiveExample1 = document.getElementById('liveToast1')
        if (toastTrigger) {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample1)
            <?php if (isset($_SESSION['invalid_status'])):
                unset($_SESSION['invalid_status']);?>
                toastBootstrap.show();
            <?php endif; ?>
        }
    </script>

    <!-- Account Creation Successful Toast Script -->
    <script>
        const toastLiveExample2 = document.getElementById('liveToast2')
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample2)
        <?php if (isset($_SESSION['success_toast'])):
            unset($_SESSION['success_toast']);?>
            toastBootstrap.show();
        <?php endif; ?>
    </script>

</body>

</html>
