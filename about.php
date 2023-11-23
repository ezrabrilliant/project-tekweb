<?php
    session_start();
    include 'db_conn.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    
        // Access user information
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        main {
            flex-grow: 1;
            position: relative;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>
<body class="bg-dark">
    <?php
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            // Access user information
            $memberId = $user['member_id'];
            $userEmail = $user['email'];
            $userName = $user['username'];
            echo "
            <nav class='py-4 navbar navbar-expand-lg navbar-dark fixed-top' style='background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);'>
                <div class='container px-4 px-lg-5 text-white'>
                    <a class='navbar-brand' href='home.php'>
                        <h3>PAY2WIN</h3>
                    </a>
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'><span class='navbar-toggler-icon'></span></button>
                    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                        <ul class='navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4'>
                            <li class='nav-item me-4'><a class='nav-link' aria-current='page' href='home.php'>HOME</a></li>
                            <li class='nav-item me-4'><a class='nav-link active' href='about.php'>ABOUT</a></li>
                            <li class='nav-item me-4'><a class='nav-link' href='history_transaction.php'>HISTORY TRANSACTION</a></li>
                            <li class='nav-item me-4'><button type='button' class='balance-info-btn btn btn-outline-light' data-id='$memberId' data-saldo='$saldo' data-bs-toggle='modal' data-bs-target='#balanceInfo'>BALANCE & TOP UP</button></li>
                        </ul>
        
                        </ul>
                        <ul class='navbar-nav align-items-center'>
                            <li class='nav-item'>
                                <a class='nav-link me-3' href='#'>
                                    <p class='mb-0'>Welcome, $userName
                                    </p>
                                </a>
                            </li>
                            <li class='nav-item'>
                                <a href='#'>
                                    <button type='button' class='btn btn-outline-light' data-bs-toggle='modal' data-bs-target='#logoutModal'>Log Out</button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>";
        } else {
            echo "<nav class='py-4 navbar navbar-expand-lg navbar-dark bg-dark fixed-top'style='background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);'>
            <div class='container px-4 px-lg-5 text-white'>
                <a class='navbar-brand' href='index.php'>
                    <h3>PAY2WIN</h3>
                </a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent'aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                    <ul class='navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4'>
                        <li class='nav-item me-4'><a class='nav-link' aria-current='page' href='index.php'>HOME</a>
                        </li>
                        <li class='nav-item me-4'><a class='nav-link active' href='about.php'>ABOUT</a></li>
                    </ul>
                    <ul class='navbar-nav align-items-center'>
                        <li class='nav-item me-3'><a href='login.php' class='nav-link'><button class='btn btn-outline-light'type='submit'>Login</button></a></li>
                        <li class='nav-item'><a href='signup.php' class='nav-link'><button class='btn btn-outline-light'type='submit'>Sign up</button></a></li>
                    </ul>
                </div>
            </div>
        </nav>";
            
        }
    ?>

    <h2 class="text-center text-light" style='margin-top: 150px !important; margin-bottom: 40px !important;'>PAY2WIN</h2>
    <p class="text-center text-light">PAY2WIN is a website that provides a platform for gamers to buy in-game items using their balance. We provide a wide range of games that you can choose from. We also provide a top up feature for you to top up your balance. </p>


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


    <!-- Modal Balance & top up balance -->
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
                            <input type="number" class="form-control" placeholder="0" aria-label="Username" name="amount" required aria-describedby="basic-addon1">
                        </div>

                        <input type="hidden" id="curBalance" name="curBalance">
                        <input type="hidden" id="user_id" name="user_id">

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
                </div>
            </div>
        </div>
    </div>



    <!-- script -->
    <script>

        $(document).ready(function () {

            $('.balance-info-btn').on('click', function () {
                var memberId = $(this).data('id');
                var saldo = $(this).data('saldo');

                console.log(memberId);
                console.log(saldo);
                // Mengisi nilai input modal edit dengan data pengguna yang akan diedit
                $('#user_id').val(memberId);
                $('#curBalance').val(saldo);

                // Menampilkan modal edit
                $('#balanceInfo').modal('show');
            });

            $('#topUpForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'request_saldo.php', // Ganti dengan nama file yang sesuai di server Anda
                    data: $(this).serialize(),
                    success: function (response) {
                        // Tindakan setelah perubahan pengguna disimpan (misalnya, menutup modal)
                        $('#editGameModal').modal('hide');
                        alert('Permintaan isi saldo sudah dikirim ke admin kami, harap tunggu beberapa saat :).');
                        // Refresh halaman untuk memperbarui tampilan riwayat pembelian pengguna
                        location.reload();

                    },
                    error: function (xhr, status, error) {
                        // Tindakan jika penyimpanan perubahan gagal
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
            });

            $(document).ready(function () {
                $('#dataTable').DataTable();
            });

        });

        function logout() {
            // Buat permintaan AJAX ke server untuk menghapus sesi
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'logout.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Jika sesi dihapus dengan sukses, redirect ke halaman index.php
                    window.location.href = 'index.php';
                }
            };
            xhr.send();
        }
    </script>
</body>

<footer class="py-5 bg-dark" style="background-color: rgb(10, 10, 12) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>
</html>
