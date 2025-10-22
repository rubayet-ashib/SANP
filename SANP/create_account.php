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

        <div class="row w-100 align-items-center">
            <!-- Left: Title & Illustration -->
            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center">
                <div class="mb-3">
                    <p class="title">Student<span><img src="resources/Logo.svg" alt="Site Logo"></span>Alumni</p>
                    <p class="title">Networking Portal</p>
                </div>

                <img src="resources/login-illustrator.webp" alt="Login Illustration" class="illustration img-fluid"
                    style="max-width: 550px;">
            </div>

            <!-- Right: Create Account Form -->
            <div class="col-lg-6 d-flex justify-content-center">
                <div class="login-card">
                    <h3>Create Account</h3>
                    <form action="create_account-manager.php" method="POST">

                        <!-- Student ID -->
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

                        <!-- E-mail -->
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <img src="icons/mail.svg" alt="E-mail" width="24" height="24">
                            </span>
                            <div class="form-floating">
                                <input type="email" class="form-control" id="floatingInputGroup2"
                                    placeholder="E-mail" required name="email">
                                <label for="floatingInputGroup2">E-mail</label>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <img src="icons/name.svg" alt="Name" width="24" height="24">
                            </span>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGroup3"
                                    placeholder="Name" required name="name">
                                <label for="floatingInputGroup3">Name</label>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <img src="icons/password.svg" alt="Password" width="24" height="24">
                            </span>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingInputGroup4"
                                    placeholder="Password" minlength="4" required name="password">
                                <label for="floatingInputGroup4">Password</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create-btn" id="toastTrigger">Create</button>
                    </form>
                    <div class="links">
                        <p class="text-muted"> Already have an account?
                            <a href="login.php" style="color: var(--primary-color);">
                                Login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body alert alert-danger mb-0">
                    You are not eligible to create an account!
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Toast Alert Script -->
    <script>
        const toastLiveExample = document.getElementById('liveToast')
        if (toastTrigger) {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
            <?php if (isset($_SESSION['invalid_user'])):
                unset($_SESSION['invalid_user']); ?>
                toastBootstrap.show();
            <?php endif; ?>
        }
    </script>

</body>

</html>