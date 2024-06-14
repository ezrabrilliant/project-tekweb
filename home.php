<?php
session_start();
include 'db_conn.php';
$stmt = $pdo->query("SELECT * FROM game");
$stmt1 = $pdo->query("WITH ItemSales AS (
    SELECT
        i.game_id,
        g.game_name,
        g.logo,
        SUM(COUNT(i.item_id)) OVER (PARTITION BY i.game_id) AS jumlah_penjualan,
        RANK() OVER (ORDER BY COUNT(i.item_id) DESC) AS sales_rank
    FROM
        item i
        JOIN invoice inv ON i.item_id = inv.item_id
        JOIN game g ON g.game_id = i.game_id
    GROUP BY
        i.game_id, g.game_name, g.logo
)
SELECT
    game_name,
    game_id,
    logo,
    jumlah_penjualan
FROM
    ItemSales
WHERE
    sales_rank <= 10;
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);



if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    // Access user information
    $memberId = $user['member_id'];
    $userEmail = $user['email'];
    $userName = $user['username'];
    $password = $user['password'];
    $saldo = $user['saldo'];

    $stmt1 = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :pass");
    $stmt1->bindParam(':username', $userName);
    $stmt1->bindParam(':pass', $password);
    $stmt1->execute();

    $user = $stmt1->fetch(PDO::FETCH_ASSOC);
    // Fetch user data
    $saldo = $user['saldo'];
} else {
    // Redirect or display an error message if the user is not logged in
    header('location: login.php'); // Redirect to the login page
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Topup Game - PAY2WIN</title>
    <link rel="icon" href="assets\Web Logo\pay-2-win-full.png" />

    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    <script src="https://kit.fontawesome.com/785e8a7b97.js" crossorigin="anonymous"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            opacity: 0;
        }

        .animate {
            animation: fadeIn 0.8s ease-out;
            animation-fill-mode: forwards;
        }

        #carouselExampleIndicators {
            border-radius: 1rem;
            overflow: hidden;
        }
    </style>
</head>

<body class="body">

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
        style="background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
        <div class="container px-4 px-lg-5 text-white">
            <a class="navbar-brand" style="height: 52px;" href="home.php">
                <img src="assets\Web Logo\pay-2-win-full.png" alt="PAY2WIN Logo" class="img-fluid"
                    style="max-height: 50px;margin-top: -2px;height: 100%;object-fit: cover;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 align-items-center">
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link active" aria-current="page"
                            href="home.php">HOME</a></li>
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link" href="about.php">ABOUT</a></li>
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link" href="history_transaction.php">HISTORY
                            TRANSACTION</a></li>
                    <li class="nav-item me-lg-4 d-lg-block"><button type="button"
                            class="balance-info-btn btn btn-outline-light" data-id="<?php echo $memberId; ?>"
                            data-saldo="<?php echo $saldo; ?>" data-bs-toggle="modal"
                            data-bs-target="#balanceInfo">Balance: Rp. <?php echo number_format($saldo, 2, ',', '.') ?></button></li>
                </ul>

                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link" href="#">
                            <p class="mb-0">Welcome,
                                <?php echo $userName; ?>
                            </p>
                        </a></li>
                    <li class="nav-item me-lg-4 d-lg-block"><a href="#"><button type="button"
                                class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#logoutModal">Log
                                Out</button></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header-->
    <header class="">
    <div class="container d-flex justify-content-center" style="margin-top: 150px !important; margin-bottom: 30px !important;">
        <div id="carouselExampleIndicators" class="carousel slide" style="width: 1000px; height: 350px;">
            <div class="carousel-indicators" style="z-index: 1;">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                    class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner" style="border-radius: 1rem;">
                <div class="carousel-item active" data-bs-interval="3000">
                    <img src="assets/banner2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="assets/banner1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="assets/banner3.jpeg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</header>

    <!-- Paling Laris -->
    <section class="py-5">
        <h1 class="text-center text-white">Paling Laris</h1>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                foreach ($rows1 as $row1) {
                    $id = $row1["game_id"];
                    echo "<div class='col mb-5'>
                    <div class='card border-black text-white mb-3 h-80' style='border-radius: 1rem;background-color: rgb(0, 0, 0, 0.6) !important'>
                    <img class='card-img-top' style='border-radius: 1rem;' src='" . $row1['logo'] . "' alt='...' />
                    <div class='card-body p-4'>
                    <div class='text-center'><h5 class='fw-bolder'>" . $row1['game_name'] . "</h5></div>
                    </div>
                    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                    <div class='text-center'><a href='details.php?id=$id'><button class='btn btn-outline-light  stretched-link' type='submit'>Learn More</button></a></div>
                    </div></div></div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Game Terbaru-->
    <section class="">
        <h1 class="text-center text-white">Produk Terbaru</h1>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- LOOPING BUAT LOAD GAMBAR DARI DATABASE game -->
                <?php
                foreach ($rows as $row) {
                    $id = $row["game_id"];
                    //echo($id);
                    echo "
                    <div class='col mb-5'>
                    <div class='card border-black text-white mb-3 h-80' style='border-radius: 1rem;background-color: rgb(0, 0, 0, 0.6) !important'>
                    <img class='card-img-top' style='border-radius: 1rem;' src='" . $row['logo'] . "' alt='...' />
                    <div class='card-body p-4'>
                    <div class='text-center'><h5 class='fw-bolder'>" . $row['game_name'] . "</h5></div>
                    </div>
                    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                    <div class='text-center'><a href='details.php?id=$id'><button class='btn btn-outline-light stretched-link' type='submit'>Learn More</button></a></div>
                    </div></div></div>";
                }
                ?>
            </div>
        </div>
    </section>


    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to Logout?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
    </div>

    <!--- Modal Balance & top up balance -->
    <div class="modal fade" id="balanceInfo" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Balance Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="topUpForm">
                        <h5>Current Balance: Rp.
                            <?php echo number_format($saldo, 2, ',', '.') ?>
                        </h5>
                        <p>Input nominal isi saldo wallet mu</p>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="number" class="form-control" placeholder="0" aria-label="Username"
                                id="inputAmount" name="inputAmount" required aria-describedby="basic-addon1">
                        </div>
                        <input type="hidden" id="curBalance" name="curBalance">

                        <div class="text-center d-flex justify-content-between" style="padding:10px 0 0 0">
                            <button type="button" class="btn text-white btn-outline-danger" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <input type="submit" class="btn text-white btn-outline-success w-25 login" value="Pay"
                                name="login-btn">
                        </div>
                        <?php if (!empty($errorMsg)): ?>
                            <p class="text-danger text-center mt-3">
                                <?php echo $errorMsg; ?>
                            </p>
                        <?php endif; ?>
                    </form>
                    <!-- Payment Details Section (Initially Hidden) -->
                    <div id="paymentDetails" style="display: none;">
                        <h5>Payment Details:</h5>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span>BCA: &nbsp;</span><span id="copy1">0234567999</span>
                                        <button class="btn btn-sm btn-outline-light" style="margin-left:10px"
                                            data-clipboard-target="#copy1">
                                            <i class="fa-solid fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>Total Amount: Rp. <span id="totalAmount"></span></p>
                        <form id="confirmForm">
                            <input type="hidden" id="amount" name="amount">
                            <input type="hidden" id="user_id" name="user_id">
                            <input type="submit" class="btn text-white btn-outline-success w-100 login" value="Confirm">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- script -->
    <script>

        // Logout Script
        function logout() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'logout.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.href = 'index.php';
                }
            };
            xhr.send();
        }

        // Balance Info Script
        $(document).ready(function () {
            $('.balance-info-btn').on('click', function () {
                var memberId = $(this).data('id');
                var saldo = $(this).data('saldo');

                console.log(memberId);
                console.log(saldo);
                $('#user_id').val(memberId);
                $('#curBalance').val(saldo);
                $('#balanceInfo').modal('show');
            });
        });

        // Top Up Script
        $(document).ready(function () {
            $('#topUpForm').on('submit', function (event) {
                event.preventDefault();

                var amount = parseFloat($(this).find('input[name="inputAmount"]').val());
                if (isNaN(amount) || amount <= 0) {
                    $('#alertContainer').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Please enter a valid amount.</div>');
                    return false;
                }
                var formattedAmount = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);

                $('#totalAmount').text(formattedAmount);


                amount = document.getElementById('inputAmount').value;
                console.log(amount);
                $('#paymentDetails').show();
                $('#amount').val(amount);

                $(this).find('input[name="inputAmount"]').prop('disabled', true);
                $(this).find('input[name="login-btn"]').prop('disabled', true);

            });

            $('#topUpForm').on('click', 'input[name="login-btn"]', function () {
                $('#topUpForm').submit();
            });

            $('#confirmForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'request_saldo.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#editGameModal').modal('hide');
                        alert('Permintaan isi saldo sudah dikirim ke admin kami, harap tunggu beberapa saat :).');
                        location.reload();

                    },
                    error: function (xhr, status, error) {
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
            });
        });

        //Copy Button Script
        const target = document.getElementById('copy1');
        const button = target.nextElementSibling;
        const clipboard = new ClipboardJS(button);
        clipboard.on('success', function (e) {
            var checkIcon = button.querySelector('.ki-check');
            var copyIcon = button.querySelector('.ki-copy');
            if (checkIcon) {
                return;
            }
        });

        $('#balanceInfo').on('hidden.bs.modal', function () {
            location.reload();
        });

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

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        //Script auto next script
        document.addEventListener('DOMContentLoaded', function () {
            var carousel = document.getElementById('carouselExampleIndicators');
            var carouselInstance = new bootstrap.Carousel(carousel, {
                interval: false
            });

            function nextSlide() {
                carouselInstance.next();
            }

            setInterval(nextSlide, 2500);
        });
    </script>


</body>

<!-- Footer-->
<footer class="py-5" style="background-color: rgb(0, 0, 0, 0.6) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>

</html>
