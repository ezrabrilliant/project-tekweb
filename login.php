<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['user'])) {
    $_admin_status = $_SESSION['user']['admin_access'];

    if ($_admin_status == 1) {
        header('location: admin.php');
    } else {
        header('location: home.php');
    }
    exit();
}

$_username;
$_password;
$_admin_status = 0;
$errorMsg = "";

if (isset($_POST['username_input']) && isset($_POST['password_input'])) {
    $_username = $_POST['username_input'];
    $_password = $_POST['password_input'];
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :pass");
    $stmt->bindParam(':username', $_username);
    $stmt->bindParam(':pass', $_password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_admin_status = $user['admin_access'];
        $_SESSION['user'] = $user;
        if ($_admin_status == 1) {
            header('location: admin.php');
        } else {
            header('location: home.php');
        }
        exit();
    } else {
        $errorMsg = "Email atau password salah. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - PAY2WIN</title>
    <link rel="icon" href="assets\Web Logo\pay-2-win-full.png" />

    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body class="body">

    <!-- Background -->
    <div class="blob-c">
        <div class="shape-blob one"></div>
        <div class="shape-blob two"></div>
        <div class="shape-blob three"></div>
        <div class="shape-blob four"></div>
        <div class="shape-blob five"></div>
        <div class="shape-blob six"></div>
    </div>


    <!-- Navigation -->
    <nav class="py-4 navbar navbar-expand-lg navbar-dark fixed-top"
        style="background: rgba(0, 0, 0, 0.4) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
        <div class="container px-4 px-lg-5 text-white">
            <a class="navbar-brand" style="height: 52px;" href="index.php">
                <img src="assets\Web Logo\pay-2-win-full.png" alt="PAY2WIN Logo" class="img-fluid"
                    style="max-height: 50px;margin-top: -2px;height: 100%;object-fit: cover;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse align-items-center" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 align-items-center">
                    <li class="nav-item me-4"><a class="nav-link" aria-current="page" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item me-4"><a class="nav-link" href="about.php">ABOUT</a></li>
                </ul>

                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-4">
                        <a href="login.php" class="nav-link">
                            <button class="btn btn-outline-light active" type="submit">Login</button>
                        </a>
                    </li>
                    <li class="nav-item me-4">
                        <a href="signup.php" class="nav-link">
                            <button class="btn btn-outline-light" type="submit">Sign up</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- login -->
    <section style="margin-top: 100px !important; z-index: 1">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card animate bg-dark text-white"
                        style="border-radius: 1rem;background: rgba(0, 0, 0, 0.4) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold m-5 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-4">Log in to access your account.</p>

                                <?php if (!empty($errorMsg)): ?>
                                    <div class="container">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error! </strong>
                                            <?php echo $errorMsg; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <form name="login" action="login.php" method="post" class="m-3">
                                    <div class="form-outline form-white mb-4">
                                        <h4><label class="form-label" for="typeUsernameX">Username</label></h4>
                                        <input required type="text" id="typeUsernameX" class="form-control form-control-lg"
                                            placeholder="Username" name="username_input" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <h4><label class="form-label" for="typePasswordX">Password</label></h4>
                                        <input required type="password" id="typePasswordX" class="form-control form-control-lg"
                                            placeholder="Password" name="password_input" />
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit"
                                        name="login-btn">Login</button>
                                </form>

                            </div>

                            <div>
                                <p class="mb-0">Don't have an account? <a href="signup.php"
                                        class="text-white-50 fw-bold">Sign Up</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        //Script Animation Card 
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                root: null,
                rootMargin: "0px",
                threshold: 0.5
            };

            var observer = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("animate");
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            var elements = document.querySelectorAll(".card");

            elements.forEach(function (element) {
                observer.observe(element);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<!-- Footer-->
<footer class="py-5 bg-dark" style="background-color: rgb(0, 0, 0, 0.4) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>


</html>
