<?php
session_start();
include 'db_conn.php';
$stmt = $pdo->query("SELECT * FROM game");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalRequest = $pdo->query("SELECT COUNT(*) FROM invoice WHERE status_transaksi = 0");
$totalRequestSaldo = $pdo->query("SELECT COUNT(*) FROM history_isi_saldo WHERE status_isi_saldo = 0");
$totalSaldo = $pdo->query("SELECT SUM(nominal_isi_saldo) FROM history_isi_saldo WHERE status_isi_saldo = 1");
$totalproduct = $pdo->query("SELECT COUNT(*) FROM game");
$totalpenjualan = $pdo->query(
    "SELECT SUM(item.harga_satuan) FROM users
INNER JOIN invoice ON users.member_id = invoice.member_id
INNER JOIN item ON invoice.item_id = item.item_id
INNER JOIN game ON item.game_id = game.game_id WHERE invoice.status_transaksi=1;
"
);

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $memberId = $user['member_id'];
    $userEmail = $user['email'];
    $userName = $user['username'];
    $_admin_status = $user['admin_access'];
    if ($_admin_status == 0) {
        header('location: home.php');
    }
} else {
    header('location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Page - PAY2WIN</title>

    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://kit.fontawesome.com/785e8a7b97.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="blob-c">
        <div class="shape-blob one"></div>
        <div class="shape-blob two"></div>
        <div class="shape-blob three"></div>
        <div class="shape-blob four"></div>
        <div class="shape-blob five"></div>
        <div class="shape-blob six"></div>
    </div>

    <!-- Navigation-->
    <nav class="py-4 navbar navbar-expand-lg navbar-dark fixed-top"
        style="background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);">
        <div class="container px-4 px-lg-5 text-white">
            <a class="navbar-brand" style="height: 52px;" href="admin.php">
                <img src="assets\Web Logo\pay-2-win-full.png" alt="PAY2WIN Logo" class="img-fluid"
                    style="max-height: 50px;margin-top: -2px;height: 100%;object-fit: cover;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav align-items-center me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link active" aria-current="page"
                            href="admin.php">HOME</a>
                    </li>
                    <div class="nav-item me-lg-4 d-lg-block dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">MANAGE DATA</a>
                        <div class="dropdown-menu dropdown-menu-dark">
                            <a href="manage_produk.php" class="dropdown-item">Manage Produk</a>
                            <a href="manage_user.php" class="dropdown-item">Manage Saldo User</a>
                            <a href="manage_transaksi.php" class="dropdown-item">Manage Transaksi</a>
                            <a href="saldo.php" class="dropdown-item">Riwayat Saldo User</a>
                            <a href="transaksi.php" class="dropdown-item">Riwayat Transaksi</a>
                        </div>
                    </div>
                </ul>

                <ul class="navbar-nav align-items-center mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item me-lg-4 d-lg-block">
                        <a class="nav-link" href="">
                            Welcome,
                            <?php echo $userName; ?> <i class="bi bi-person-circle"></i>
                        </a>
                    </li>
                    <li class="nav-item me-lg-4 d-lg-block">
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                            data-bs-target="#logoutModal">Log Out</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- card -->
    <section class="py-5" style="margin-top: 100px !important;">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">


                <!-- Total Produk Card -->
                <div class="col mb-5">
                    <div class='card animate text-white mb-3 h-100 d-flex align-items-center'
                        style='border-radius: 1rem; background-color: rgba(10, 10, 12, 0.4) !important'>
                        <div class='card-body p-4'>
                            <div class='text-center'>
                                <h4 class='fw-bolder'>Total Produk</h4>
                                <p class='card-text-secondary' style='font-size: 25px;'>
                                    <i class='fa-solid fa-box-archive'></i>
                                    <?php echo $totalproduct->fetchColumn(); ?>
                                </p>
                            </div>
                        </div>
                        <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                            <div class='text-center'><a href='manage_produk.php'><button
                                        class='btn btn-outline-light stretched-link' type='submit'>Learn
                                        More</button></a></div>
                        </div>
                    </div>
                </div>

                <!-- Manage Saldo User Card -->
                <div class="col mb-5">
                    <div class='card animate text-white mb-3 h-100 d-flex align-items-center'
                        style='border-radius: 1rem; background-color: rgba(10, 10, 12, 0.4) !important'>
                        <div class='card-body p-4'>
                            <div class='text-center'>
                                <h4 class='fw-bolder'>Total Saldo Pending</h4>
                                <p class='card-text-secondary' style='font-size: 25px;'>
                                    <i class='fa-solid fa-user'></i>
                                    <?php echo $totalRequestSaldo->fetchColumn(); ?>
                                </p>
                            </div>
                        </div>
                        <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                            <div class='text-center'><a href='manage_user.php'><button
                                        class='btn btn-outline-light stretched-link' type='submit'>Learn
                                        More</button></a></div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Saldo User Card -->
                <div class="col mb-5">
                    <div class='card animate text-white mb-3 h-100 d-flex align-items-center'style='border-radius: 1rem; background-color: rgba(10, 10, 12, 0.4) !important'>
                        <div class='card-body p-4'>
                            <div class='text-center'>
                                <h4 class='fw-bolder'>Total Saldo Semua User</h4>
                                <p class='card-text-secondary' style='font-size: 25px;'>
                                    <i class='fa-solid fa-user'></i>
                                    RP
                                    <?php
                                    $total_Saldo = $totalSaldo->fetchColumn();
                                    echo number_format($total_Saldo, 0, ',', '.');
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                            <div class='text-center'><a href='saldo.php'><button
                                        class='btn btn-outline-light stretched-link' type='submit'>Learn
                                        More</button></a></div>
                        </div>
                    </div>
                </div>

                <div class="w-100"></div>

                <!-- Manage Transaksi Card -->
                <div class="col mb-5">
                    <div class='card animate text-white mb-3 h-100 d-flex align-items-center'
                        style='border-radius: 1rem; background-color: rgba(10, 10, 12, 0.4) !important'>
                        <div class='card-body p-4'>
                            <div class='text-center'>
                                <h4 class='fw-bolder'>Total Transaksi Pending</h4>
                                <p class='card-text-secondary' style='font-size: 25px;'>
                                    <i class='fa-solid fa-user'></i>
                                    <?php echo $totalRequest->fetchColumn(); ?>
                                </p>
                            </div>
                        </div>
                        <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                            <div class='text-center'><a href='manage_transaksi.php'><button
                                        class='btn btn-outline-light stretched-link' type='submit'>Learn
                                        More</button></a></div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pembelian User Card -->
                <div class="col mb-5">
                    <div class='card animate text-white mb-3 h-100 d-flex align-items-center'
                        style='border-radius: 1rem; background-color: rgba(10, 10, 12, 0.4) !important'>
                        <div class='card-body p-4'>
                            <div class='text-center'>
                                <h4 class='fw-bolder'>Total Pembelian Semua User</h4>
                                <p class='card-text-secondary' style='font-size: 25px;'>
                                    <i class='fa-solid fa-credit-card' style='padding: 10px;'></i>
                                    RP
                                    <?php
                                    $total_penjualan = $totalpenjualan->fetchColumn();
                                    echo number_format($total_penjualan, 0, ',', '.');
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                            <div class='text-center'><a href='transaksi.php'><button
                                        class='btn btn-outline-light stretched-link' type='submit'>Learn
                                        More</button></a></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
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
    <!-- modal -->


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



        // Animate Card
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

</body>

<footer class="py-5 bg-dark" style="background-color: rgb(10, 10, 12) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>

</html>
