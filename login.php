<?php
session_start();
include "db_conn.php";

// Initialize variables
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

    // Fetch user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_admin_status = $user['admin_access'];

        // Store user information in a session variable
        $_SESSION['user'] = $user;

        // Pengecekan admin atau bukan
        if ($_admin_status == 1) {
            header('location: http://localhost/admin.php');
        } else {
            header('location: http://localhost/home.php');
        }
    } else {
        $errorMsg = "Email atau password salah. Please try again.";
        header('location: http://localhost/login.php?error=' . urlencode($errorMsg));
        exit();
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
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        main {
            flex-grow: 1;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="bg-dark">

    <!-- Navigation -->
    <nav class="py-4 navbar navbar-expand-lg navbar-dark bg-dark fixed-top"
        style="background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
        <div class="container px-4 px-lg-5 text-white">
            <a class="navbar-brand" href="index.php">
                <h3>PAY2WIN</h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item me-4"><a class="nav-link" aria-current="page" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item me-4"><a class="nav-link" href="about.php">ABOUT</a></li>
                </ul>
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-3"><a href="login.php" class="nav-link"><button
                                class="btn active btn-outline-light" type="submit">Login</button></a></li>
                    <li class="nav-item"><a href="signup.php" class="nav-link"><button class="btn btn-outline-light"
                                type="submit">Sign up</button></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- login -->
    <section style="margin-top: 100px !important">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold m-5 text-uppercase">Login</h2>
                            <p class="text-white-50 mb-5">Log in to access your account.</p>
                            <form name="login" action="login.php" method="post" class="m-3">
                                <div class="form-outline form-white mb-4">
                                    <h4><label class="form-label" for="typeUsernameX">Username</label></h4>
                                    <input type="text" id="typeUsernameX" class="form-control form-control-lg"
                                        placeholder="Username" name="username_input" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <h4><label class="form-label" for="typePasswordX">Password</label></h4>
                                    <input type="password" id="typePasswordX" class="form-control form-control-lg"
                                        placeholder="Password" name="password_input" />
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit"
                                    name="login-btn">Login</button>

                                <?php if (isset($_GET['error']) && !empty($_GET['error'])): ?>
                                    <p class="text-danger text-center mt-3">
                                        <?php echo urldecode($_GET['error']); ?>
                                    </p>
                                <?php endif; ?>

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


</body>

<footer class="py-5 bg-dark" style="background-color: rgb(10, 10, 12) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>

</html>
