<?php
session_start();
include 'db_conn.php';
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $memberId = $user['member_id'];
    $stmt3 = $pdo->prepare("SELECT saldo FROM users WHERE member_id = :member_id");
    $stmt3->bindParam(":member_id", $memberId);
    $stmt3->execute();
    $rows3 = $stmt3->fetch(PDO::FETCH_ASSOC);


    $userEmail = $user['email'];
    $userName = $user['username'];
    $userTelp = $user['no_telepon'];
    $saldo = $rows3['saldo'];

    $stmt = $pdo->prepare(
        "SELECT invoice.invoice_id, game.game_name, invoice.uid_game, item.nominal_topup, item.harga_satuan, invoice.tanggal_transaksi, invoice.status_transaksi FROM users
            INNER JOIN invoice
                ON users.member_id = invoice.member_id
            INNER JOIN item
                ON invoice.item_id = item.item_id
            INNER JOIN game
                ON item.game_id = game.game_id WHERE invoice.member_id=:member_id;"
    );
    $stmt->bindParam(":member_id", $memberId);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Topup Game - PAY2WIN</title>
    <link rel="icon" href="assets\Web Logo\pay-2-win-full.png" />


    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    <script src="https://kit.fontawesome.com/785e8a7b97.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <style>
        .table {
            --bs-table-bg: rgb(0, 0, 0, 0.2) !important;
        }
    </style>
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
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link" aria-current="page"
                            href="home.php">HOME</a></li>
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link" href="about.php">ABOUT</a></li>
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link active"
                            href="history_transaction.php">HISTORY TRANSACTION</a></li>
                    <li class="nav-item me-lg-4 d-lg-block"><button type="button"
                            class="balance-info-btn btn btn-outline-light" data-id="<?php echo $memberId; ?>"
                            data-saldo="<?php echo $saldo; ?>" data-bs-toggle="modal"
                            data-bs-target="#balanceInfo">Balance: Rp. <?php echo number_format($saldo, 2, ',', '.') ?></button></li>   
                </ul>

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

    <!-- Table -->
    <div id="wrapper" style='margin-top: 150px !important; margin-bottom: 40px !important;'>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container" style="padding: 40px 0 20px 0;">
                    <div class="card animate border-black text-white mb-4"
                        style='border-radius: 1rem;background-color: rgb(0, 0, 0, 0.6) !important'>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"><strong>Riwayat Pembelian User</strong></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-dark" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Nama Game</th>
                                            <th>Game UID</th>
                                            <th>Jumlah Resource</th>
                                            <th>Harga</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Status Transaksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($rows as $row) {
                                            $invoiceID = $row["invoice_id"];
                                            $game_name = $row["game_name"];
                                            $uid_game = $row["uid_game"];
                                            $nominal_topup = $row["nominal_topup"];
                                            $harga_satuan = $row["harga_satuan"];
                                            $tanggal_transaksi = $row["tanggal_transaksi"];
                                            $status = $row["status_transaksi"];


                                            $invoice = $row["invoice_id"];
                                            echo "<tr>";
                                            echo "<td>INVZ$invoiceID</td>";
                                            echo "<td>$game_name</td>";
                                            echo "<td>$uid_game</td>";
                                            echo "<td>$nominal_topup</td>";
                                            echo "<td> Rp " . number_format($harga_satuan, 0, ',', '.') . "</td>";

                                            echo "<td>$tanggal_transaksi</td>";

                                            echo "<td>";
                                            if ($status == 1) {
                                                echo "<span class='badge text-bg-success text-success-emphasis bg-success-subtle border border-success-subtle rounded-2'>Sukses</span>";
                                            } elseif ($status == 0) {
                                                echo "<span class='badge text-bg-warning text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-2'>On Progress</span>";
                                            } elseif ($status == -1) {
                                                echo "<span class='badge text-bg-danger text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>Fail</span>";
                                            } else {
                                                echo "Unknown Status";
                                            }
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

    </script>

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

        
        $('#balanceInfo').on('hidden.bs.modal', function () {
            location.reload();
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



        $(document).ready(function () {
            $('#dataTable').DataTable();
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

<!-- Footer-->
<footer class="py-5 bg-dark" style="background-color: rgb(0, 0, 0, 0.6) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>

</html>
