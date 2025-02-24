<?php
session_start();
include("Includes/Functions_Admin.php");

// Check if the user is already logged in (optional)
if(isset($_COOKIE['LoggedIn']) || isset($_COOKIE['RememberMeLogIn'])){
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Register &mdash; My Own Blog</title>
    <link rel="stylesheet" type="text/css" href="Login/css/my-login.css">
    <link rel="stylesheet" type="text/css" href="Login/bootstrap/css/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">

    <style>
        /* Make the container of the form scrollable */
        .card-wrapper {
            max-height: 90vh; /* Limit the height to 90% of the viewport */
            overflow-y: auto; /* Enable vertical scrolling */
        }
    </style>
</head>
<body class="my-login-page">
    <section class="h-100">
        <div id="particles-js"></div>
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <img src="plugins/images/admin-logo.png">
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Register</h4>
                            <?php echo (isset($error_message)) ? '<div class="alert alert-danger">'.$error_message.'</div>' : ''; ?>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Fullname">Full Name</label>
                                            <input id="Fullname" type="text" class="form-control" name="Fullname" required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="Email">E-Mail Address</label>
                                            <input id="Email" type="email" class="form-control" name="Email" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="Username">Username</label>
                                            <input id="Username" type="text" class="form-control" name="Username" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="Phone">Phone</label>
                                            <input id="Phone" type="tel" class="form-control" name="Phone" required>
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="Country">Location</label>
                                            <input id="Country" type="text" class="form-control" name="Country" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="Role">Role</label>
                                            <select id="Role" class="form-control" name="Role" required>
                                                <option value="user">User</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="Password">Password</label>
                                            <input id="Password" type="password" class="form-control" name="Password" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group no-margin">
                                    <button name="register" type="submit" class="btn btn-primary btn-block">
                                        Register
                                    </button>
                                </div>
                                <div class="margin-top20 text-center">
                                    Already have an account? <a href="login.php">Login Here</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; 2025 &mdash; Travel Magica
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="Login/js/particles.min.js"></script>
    <script src="Login/js/app.js"></script>
    <script src="Login/js/jquery.min.js"></script>
    <script src="Login/bootstrap/js/bootstrap.min.js"></script>
    <script src="Login/js/my-login.js"></script>
</body>
</html>