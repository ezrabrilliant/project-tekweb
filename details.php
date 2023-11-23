<?php
session_start();
include 'db_conn.php';
$game_id = isset($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM game where game_id=:game_id");
$stmt->bindParam(':game_id', $game_id);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['details'] = $rows;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Game Details - Proyek Tekweb</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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

        .animated {
            opacity: 0;
        }

        .animate {
            animation: fadeIn 0.8s ease-out;
            animation-fill-mode: forwards;
        }

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

<body class='bg-dark'>
    <?php
    if (isset($_SESSION['user'])) { // kalau user nya udh login bisa bayar
        include 'db_conn.php';
        $user = $_SESSION['user'];

        // Access user information
        $memberId = $user['member_id'];

        // Update saldo user
        $stmt3 = $pdo->prepare("SELECT saldo FROM users WHERE member_id = :member_id");
        $stmt3->bindParam(":member_id", $memberId);
        $stmt3->execute();
        $rows3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        
        $userEmail = $user['email'];
        $userName = $user['username'];
        $password = $user['password'];
        $saldo = $rows3['saldo'];


        $stmt1 = $pdo->prepare("SELECT * FROM game WHERE game_id = :id");
        $stmt1->bindParam(':id', $_GET['id']);
        $stmt1->execute();
        $rows1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        $stmt2 = $pdo->prepare("SELECT * FROM item WHERE game_id = :id ORDER BY nominal_topup ASC");
        $stmt2->bindParam(':id', $_GET['id']);
        $stmt2->execute();
        $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // navbar
        echo "
        <nav class='py-4 navbar navbar-expand-lg navbar-dark fixed-top' style='background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);'>
            <div class='container px-4 px-lg-5 text-white'>
                <a class='navbar-brand' href='home.php'>
                    <h3>PAY2WIN</h3>
                </a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'><span class='navbar-toggler-icon'></span></button>
                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                    <ul class='navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4'>
                        <li class='nav-item me-4'><a class='nav-link active' aria-current='page' href='home.php'>HOME</a></li>
                        <li class='nav-item me-4'><a class='nav-link' href='about.php'>ABOUT</a></li>
                        <li class='nav-item me-4'><a class='nav-link' href='history_transaction.php'>HISTORY TRANSACTION</a></li>
                        <li class='nav-item me-4'><button type='button' class='balance-info-btn btn btn-outline-light' data-id='<?php echo $memberId; ?>' data-saldo='<?php echo $saldo; ?>' data-bs-toggle='modal' data-bs-target='#balanceInfo'>BALANCE & TOP UP</button></li>
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

        // show all product
        echo "
        <div class='container px-4 px-lg-5' style='margin-top: 150px !important; margin-bottom: 40px !important;'>
            <div class='row'>
                <div class='col-md-4'>
                    <div class='card bg-dark animated' style='border-radius: 1rem; background: rgba(0, 0, 0, 0.3) !important;'>
                        <div class='thumbnail'>
                            <img class='img-responsive img-fluid' style='border-radius: 1rem;' src='{$rows1['gambar_deskripsi']}' alt=''>
                        </div>
                        <h1 class='text-center text-white mt-3 mb-3'>{$rows1['game_name']}</h1>
                        <p class='text-white m-4'>{$rows1['deskripsi']}</p>
                    </div>
                </div>
                <div class='col-md-8'>
                    <div class='card text-black ms-md-5' style='border-radius: 1rem; background: rgba(0, 0, 0, 0.3) !important; backdrop-filter: blur(10px) saturate(125%); -webkit-backdrop-filter: blur(10px) saturate(125%);'>
                        <div class='card-body p-5 text-center'>
                            <h2 class='fw-bold text-uppercase text-light'>PILIH NOMINAL TOPUP</h2>
                            <div class='container px-4 px-lg-5 mt-5'>
                                <div class='row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3'>
        ";

        foreach ($rows2 as $row) {
            $namaGame = $rows1['game_name'];
            echo "
        <div class='col mb-5'>
        <div class='card h-100 animated' style='border-radius: 1rem; background-color: rgba(0, 0, 0, 0.2) !important;'>
            <div class='thumbnail d-flex align-items-center'>
                <img class='card-img-top img-fluid' src='{$row['resource_image']}' alt=''>
            </div>
            <div class='card-footer p-3 pt-0 border-top-0'>
                <div class='text-center text-light'>
                        <p class='fw-bolder'>" . number_format($row['nominal_topup'], 0, ',', '.') . "</p>
                    </div>
                    <div class='text-center text-light'>
                        <h5 class='fw-bolder'>Rp." . number_format($row['harga_satuan'], 0, ',', '.') . "</h5>
                    </div>
                    <div class='text-center'>
                        <form action='details.php'>
                            <button class='buy-item-btn btn btn-outline-light' data-nama-game = '$namaGame' data-jml-resource = '{$row['nominal_topup']}' data-saldo-user = '{$saldo}' data-harga = '{$row['harga_satuan']}' data-member-id='{$memberId}' data-game-id='{$rows1['game_id']}' data-item-id='{$row['item_id']}' type='button'>Beli</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        ";
        }

        echo "
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>";

    } else { // kalau user tidak login
    
        include 'db_conn.php';
        $stmt1 = $pdo->prepare("SELECT * FROM game WHERE game_id = :id");
        $stmt1->bindParam(':id', $_GET['id']);
        $stmt1->execute();
        $rows1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        $stmt2 = $pdo->prepare("SELECT * FROM item WHERE game_id = :id ORDER BY nominal_topup ASC");
        $stmt2->bindParam(':id', $_GET['id']);
        $stmt2->execute();
        $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // navbar
        echo "
        <nav class='py-4 navbar navbar-expand-lg navbar-dark bg-dark fixed-top'style='background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 2; -webkit-backdrop-filter: blur(10px) saturate(125%);'>
        <div class='container px-4 px-lg-5 text-white'>
            <a class='navbar-brand' href='index.php'>
                <h3>PAY2WIN</h3>
            </a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent'aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4'>
                    <li class='nav-item me-4'><a class='nav-link active' aria-current='page' href='index.php'>HOME</a>
                    </li>
                    <li class='nav-item me-4'><a class='nav-link' href='about.php'>ABOUT</a></li>
                </ul>
                <ul class='navbar-nav align-items-center'>
                    <li class='nav-item me-3'><a href='login.php' class='nav-link'><button class='btn btn-outline-light'type='submit'>Login</button></a></li>
                    <li class='nav-item'><a href='signup.php' class='nav-link'><button class='btn btn-outline-light'type='submit'>Sign up</button></a></li>
                </ul>
            </div>
        </div>
    </nav>";

        // show all product
        echo "
            <div class='container px-4 px-lg-5' style='margin-top: 150px !important; margin-bottom: 40px !important;'>
                <div class='row'>
                <div class='col-md-4'>
                    <div class='card bg-dark' style='border-radius: 1rem; background: rgba(0, 0, 0, 0.3) !important;'>
                        <div class='thumbnail'>
                            <img class='img-responsive img-fluid' style='border-radius: 1rem;' src='{$rows1['gambar_deskripsi']}' alt=''>
                        </div>
                        <h1 class='text-center text-white mt-3 mb-3'>{$rows1['game_name']}</h1>
                        <p class='text-white m-4'>{$rows1['deskripsi']}</p>
                    </div>
                </div>
                <div class='col-md-8'>
                    <div class='card text-black ms-md-5' style='border-radius: 1rem; background: rgba(0, 0, 0, 0.3) !important; backdrop-filter: blur(10px) saturate(125%); -webkit-backdrop-filter: blur(10px) saturate(125%);'>
                        <div class='card-body p-5 text-center'>
                            <h2 class='fw-bold text-uppercase text-light'>PILIH NOMINAL TOPUP</h2>
                                <div class='container px-4 px-lg-5 mt-5'>
                                    <div class='row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3'>
            ";

        foreach ($rows2 as $row) {
            $namaGame = $rows1['game_name'];
            echo "
            <div class='col mb-5'>
            <div class='card h-100 border-light' style='border-radius: 1rem; background-color: rgba(0, 0, 0, 0.2) !important;'>
                <div class='thumbnail d-flex align-items-center'>
                    <img class='card-img-top img-fluid' style='border-radius: 1rem;' src='{$row['resource_image']}' alt=''>
                </div>
                <div class='card-footer p-3 pt-0 border-top-0'>
                    <div class='text-center text-light'>
                        <p class='fw-bolder'>" . number_format($row['nominal_topup'], 0, ',', '.') . "</p>
                    </div>
                    <div class='text-center text-light'>
                        <h5 class='fw-bolder'>Rp." . number_format($row['harga_satuan'], 0, ',', '.') . "</h5>
                    </div>
                    <div class='text-center'>
                        <form action='login.php'>
                            <button class='btn btn-outline-light' type='submit'>Beli</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
            ";
        }

        echo "
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

    }
    ?>

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

    <!-- Modal Buy Item -->
    <div class="modal fade" id="buyItem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Topup <span id="itemName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="confirmForm">
                        <input type="hidden" id="item_id" name="item_id">
                        <input type="hidden" id="game_id" name="game_id">
                        <input type="hidden" id="user_id" name="user_id">

                        <h5>Nama Produk: <span id="itemName1"></span></h5>
                        <h5>Jumlah: <span id="jmlResource"></span></h5>
                        <h5>Harga: Rp. <span id="harga"></span></h5>
                        <div class="form-group  mb-3 mt-3">
                            <p>Input ID/UID/NOMER</p><input type="text" id="uid_game" placeholder="input ID/UID/NOMER"
                                name="uid_game" required>
                        </div>
                        <div class="text-center d-flex justify-content-between" style="padding:10px 0 0 0">
                            <button type="button" class="btn text-white btn-danger" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <input type="submit" class="btn text-white btn-success w-25 login" value="Pay"
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

     <!-- Modal Saldo Ga Cukup -->
    <div class="modal fade" id="saldoGaCukup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h1>Maaf saldo anda tidak cukup untuk membeli item ini</h1>
                    <div class="text-center d-flex justify-content-between" style="padding:10px 0 0 0">
                            <button type="button" class="btn text-white btn-danger" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <input type="submit" class="btn text-white btn-success w-25 login" value="Okay"
                                name="login-btn">
                    </div>
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
                            <input type="number" class="form-control" placeholder="0" aria-label="Username"
                                aria-describedby="basic-addon1">
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

            $('.buy-item-btn').on('click', function () {
                // Get the modal element by its ID
                var modal = document.getElementById("buyItem");
                // Get the elements inside the modal to update
                var modalContent = modal.querySelector(".modal-content");
                var modalBody = modalContent.querySelector(".modal-body");

                var game_id = $(this).data('game-id');
                var item_id = $(this).data('item-id');
                var member_id = $(this).data('member-id');
                var harga = $(this).data('harga');
                var saldoUser = $(this).data('saldo-user');
                var namaGame = $(this).data('nama-game');
                var jmlResource = $(this).data('jml-resource');

                document.getElementById("itemName").textContent = namaGame;
                document.getElementById("itemName1").textContent = namaGame;
                document.getElementById("jmlResource").textContent = jmlResource;
                var formattedHarga = new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(harga);
                document.getElementById("harga").textContent = formattedHarga;


               // Set the values for hidden input fields
                $('#item_id').val(item_id);
                $('#game_id').val(game_id);
                $('#user_id').val(member_id);

                if (harga > saldoUser) {
                    $('#saldoGaCukup').modal('show');
                } else {
                    console.log(game_id);
                    console.log(item_id);
                    console.log(member_id);
                    $('#buyItem').modal('show');
                }
            });


            $('#confirmForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'insert_invoice.php', // Ganti dengan nama file yang sesuai di server Anda
                    data: $(this).serialize(),
                    success: function (response) {
                        // Tindakan setelah perubahan pengguna disimpan (misalnya, menutup modal)
                        $('#buyItem').modal('hide');
                        alert('Berhasil membeli produk !.');
                        // Refresh halaman untuk memperbarui tampilan riwayat pembelian pengguna
                        location.reload();

                    },
                    error: function (xhr, status, error) {
                        // Tindakan jika penyimpanan perubahan gagal
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
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

            var elements = document.querySelectorAll(".animated");

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
