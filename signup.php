<?php
session_start();
include "db_conn.php";

// Initialize variables
$errorMsg = "";

if (isset($_POST['email_input']) && isset($_POST['password_input']) && isset($_POST['username_input']) && isset($_POST['telepon_input'])) {
    $_email = validate($_POST['email_input']);
    $_password = $_POST['password_input'];
    $_telp = validate($_POST['telepon_input']);
    $_username = validate($_POST['username_input']);

    // Check if email, username, or telephone number already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username OR no_telepon = :telp");
    $stmt->bindParam(':email', $_email);
    $stmt->bindParam(':username', $_username);
    $stmt->bindParam(':telp', $_telp);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        if ($existingUser['email'] === $_email) {
            $errorMsg = "Email sudah digunakan.";
        } elseif ($existingUser['username'] === $_username) {
            $errorMsg = "Username sudah digunakan.";
        } elseif ($existingUser['no_telepon'] === $_telp) {
            $errorMsg = "Nomor telepon sudah digunakan.";
        }
    } else {
        // If no existing user found, insert new user into the database
        $stmt = $pdo->prepare("INSERT INTO users VALUES (NULL,:email,:passw,:telp,:username,0,NULL)");
        $stmt->bindParam(':email', $_email);
        $stmt->bindParam(':passw', $_password);
        $stmt->bindParam(':telp', $_telp);
        $stmt->bindParam(':username', $_username);

        if ($stmt->execute() && $stmt->rowCount() == 1) {
            // redirect into home.php
            header('location: http://localhost/home.php');
        } else {
            // Error occurred while registering the user
            $errorMsg = "Registrasi gagal. Silakan coba lagi.";
        }
    }
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Signup</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SYoprKt7/CmPVmSAIQI2Ag4lB+U5qXs5JqN2M"
        crossorigin="anonymous"></script>
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
                    <li class="nav-item me-3">
                        <a href="login.php" class="nav-link">
                            <button class="btn btn-outline-light" type="submit">
                                Login
                            </button>
                        </a>
                    </li>
                    <li class="nav-item"><a href="signup.php" class="nav-link"><button
                                class="btn active btn-outline-light" type="submit">Sign up</button></a></li>
                </ul>
            </div>
        </div>
    </nav>
      
    <!-- Form Sign Up-->
        class="d-flex flex-column justify-content-center align-items-center">
        <div class="col-md-6 col-sm-12">
            <div class="login-form">
                <form name="login" action="signup.php" method="post" class="m-3">
                    <div class="form-group">
                        <h4>Email</h4><input type="text" class="form-control mt-1 mb-3" placeholder="Email" name="email_input">
                    </div>
                    <div class="form-group  mb-3">
                        <h4>Password</h4><input type="password" class="form-control mt-1" placeholder="Password" name="password_input">
                    </div>
                    <div class="form-group  mb-3">
                        <h4>No telepon</h4><input type="text" class="form-control mt-1" placeholder="No telepon" name="telepon_input">
                    </div>
                    <div class="form-group  mb-3">
                        <h4>Username</h4><input type="text" class="form-control mt-1" placeholder="Username" name="username_input">
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn text-white bg-dark  w-25 login" value="Login" name="login-btn">
                    </div>
                    <?php if (!empty($errorMsg)): ?>
                        <p class="text-danger text-center mt-3"><?php echo $errorMsg; ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
