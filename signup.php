<?php
session_start();
include "db_conn.php";

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    header('location: home.php');
    exit();
}
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
            // User successfully registered, redirect to appropriate page
            header('location: home.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
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
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 align-items-center">
                    <li class="nav-item me-4"><a class="nav-link" aria-current="page" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item me-4"><a class="nav-link" href="about.php">ABOUT</a></li>
                </ul>
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-4">
                        <a href="login.php" class="nav-link">
                            <button class="btn btn-outline-light" type="submit">Login</button>
                        </a>
                    </li>
                    <li class="nav-item me-4">
                        <a href="signup.php" class="nav-link">
                            <button class="btn btn-outline-light active" type="submit">Sign up</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- signup -->
    <section style="margin-top: 100px !important; z-index: 1;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card animate bg-dark text-white"
                        style="border-radius: 1rem;background: rgba(0, 0, 0, 0.4) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold m-5 text-uppercase">Sign Up</h2>
                                <p class="text-white-50 mb-4">Sign up to get access to our services.</p>

                                <?php if (!empty($errorMsg)): ?>
                                    <div class="container">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Invalid! </strong>
                                            <?php echo $errorMsg; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <form id="phoneNumberForm" name="login" action="signup.php" method="post" class="m-3">
                                    <div class="form-outline form-white mb-4">
                                        <h4><label class="form-label" for="typeUsernameX">Username</label></h4>
                                        <input type="text" id="typeUsernameX" required
                                            class="form-control form-control-lg" placeholder="Username"
                                            name="username_input" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <h4><label class="form-label" for="typeEmailX">Email</label></h4>
                                        <input type="email" id="typeEmailX" required
                                            class="form-control form-control-lg" placeholder="Email"
                                            name="email_input" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <h3><label class="form-label" for="typeTeleponX">No. telepon</label></h3>
                                        <input type="tel" id="typeTeleponX" required
                                            class="form-control form-control-lg" placeholder="No. Telp"
                                            name="telepon_input" />
                                        <div class="invalid-feedback">
                                            Nomor telepon harus memiliki 10-13 digit dan diawali dengan '08'.
                                        </div>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <h4><label class="form-label" for="typePasswordX">Password</label></h4>
                                        <input type="password" id="typePasswordX" required
                                            class="form-control form-control-lg" placeholder="Password"
                                            name="password_input" />
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit"
                                        name="login-btn">Sign
                                        Up</button>

                                </form>

                            </div>

                            <div>
                                <p class="mb-0">Already have an account? <a href="login.php"
                                        class="text-white-50 fw-bold">Login</a></p>
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

        document.getElementById('phoneNumberForm').addEventListener('submit', function (event) {
            var phoneNumberInput = document.getElementById('typeTeleponX');
            var phoneError = document.getElementById('phoneError');

            // Clear previous error messages
            phoneNumberInput.classList.remove('is-invalid');
            phoneError.innerHTML = '';

            // Validate phone number
            var phoneNumber = phoneNumberInput.value;
            var phoneNumberPattern = /^08[0-9]{8,11}$/; // 10 to 13 digits, starting with '08'

            if (!phoneNumberPattern.test(phoneNumber)) {
                event.preventDefault();
                phoneNumberInput.classList.add('is-invalid');
                phoneError.innerHTML = 'Invalid phone number. Please enter a valid Indonesian phone number.';
            }
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
