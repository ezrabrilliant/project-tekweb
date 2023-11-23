<?php
session_start();
include 'db_conn.php';
$stmt = $pdo->query(
    "SELECT h.history_id, u.member_id, u.username, u.email, h.tanggal_request, h.nominal_isi_saldo
    FROM users u
    JOIN history_isi_saldo h
    ON u.member_id = h.member_id WHERE h.status_isi_saldo = 0;"
);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    // Access user information
    $memberId = $user['member_id'];
    $userEmail = $user['email'];
    $userName = $user['username'];
    // Add more fields as needed

    // Display user information
    // echo "Welcome, $userName! Your email is $userEmail.";
    $stmt = $pdo->query(
        "SELECT * FROM users
        INNER JOIN invoice
            ON users.member_id = invoice.member_id
        INNER JOIN item
            ON invoice.item_id = item.item_id
        INNER JOIN game
            ON item.game_id = game.game_id WHERE invoice.status_transaksi = 0;"
    );
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Redirect or display an error message if the user is not logged in
    header('location: login.php'); // Redirect to the login page
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Transaksi</title>

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

    <!-- Navigation-->
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item me-4"><a class="nav-link" aria-current="page" href="admin.php">HOME</a>
                    </li>
                    <div class="nav-item me-4 dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">MANAGE DATA</a>
                        <div class="dropdown-menu dropdown-menu-dark">
                            <a href="manage_produk.php" class="dropdown-item">Manage Produk</a>
                            <a href="manage_user.php" class="dropdown-item">Manage Saldo User</a>
                            <a href="manage_transaksi.php" class="dropdown-item">Manage Transaksi</a>
                            <a href="saldo.php" class="dropdown-item">Riwayat Saldo User</a>
                            <a href="transaksi.php" class="dropdown-item">Riwayat Transaksi</a>
                        </div>
                    </div>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link me-4" href="">
                            Welcome,
                            <?php echo $userName; ?> <i class="bi bi-person-circle"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                            data-bs-target="#logoutModal">Log Out</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <div class="container" style="padding: 160px 0 20px 0;">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-dark"><strong>List Request Topup Resource User</strong>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Member ID</th>
                                            <th>Username</th>
                                            <th>Nama Game</th>
                                            <th>UID Game</th>
                                            <th>Jumlah Resource</th>
                                            <th>Price</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($rows as $row) {
                                            $invoiceId = $row["invoice_id"];
                                            $tanggal_request = $row["tanggal_transaksi"];
                                            $memberId = $row["member_id"];
                                            $username = $row["username"];
                                            $nama_game = $row["game_name"];
                                            $uid_game = $row["uid_game"];
                                            $jml_resource = $row["nominal_topup"];
                                            $harga = $row["harga_satuan"];


                                            echo "<tr>";
                                            echo "<td>$invoiceId</td>";
                                            echo "<td>$tanggal_request</td>";
                                            echo "<td>$memberId</td>";
                                            echo "<td>$username</td>";
                                            echo "<td>$nama_game</td>";
                                            echo "<td>$uid_game</td>";
                                            echo "<td>$jml_resource</td>";
                                            echo "<td> Rp " . number_format($harga, 0, ',', '.') . "</td>";
                                            // echo "<td>$harga</td>";
                                            echo "<td><button class='acc-req-btn btn btn-primary btn-sm' data-invoice-id='$invoiceId' data-member-id='$memberId' data-harga='$harga'><i class='fa-solid fa-check'></i></button>";

                                            //echo "<td><button class='edit-admin-btn btn btn-primary btn-sm' data-id='$member_id' data-username='$username' data-email='$email' data-phone='$phone' data-total-spent='$total_spent'>Edit</button>";
                                            echo "<button class='dec-req-btn btn btn-danger btn-sm' data-invoice-id='$invoiceId' data-member-id='$memberId' data-harga='$harga' style='margin-left:10px;'><i class='fa-solid fa-xmark'></i></button></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>

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

    <!-- Modal Konfirmasi Kirim Resource User -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pengiriman Resource Game</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengedit informasi pengguna -->
                    <p>Apakah UID Valid ?</p>
                    <form id="konfirmasiResource">
                        <input type="hidden" id="updateMemberId" name="updateMemberId">
                        <input type="hidden" id="updateInvoiceId" name="updateInvoiceId">
                        <input type="hidden" id="updateHarga" name="updateHarga">
                        <button type="submit" class="btn btn-primary">Iya sudah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Konfirmasi Kirim Resource User -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Konfirmasi Pengiriman Resource Game</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengedit informasi pengguna -->
                    <p>Apakah UID Invalid ?</p>
                    <form id="declineResource">
                        <input type="hidden" id="decMemberId" name="decMemberId">
                        <input type="hidden" id="decInvoiceId" name="decInvoiceId">
                        <input type="hidden" id="decHarga" name="decHarga">
                        <button type="submit" class="btn btn-danger">Iya UID Invalid</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
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

        $(document).ready(function () {
            // Event delegation for "UID Game Valid" buttons
            $('#dataTable').on('click', '.acc-req-btn', function () {
                var memberId = $(this).data('member-id');
                var invoiceId = $(this).data('invoice-id');
                var harga = $(this).data('harga');

                $('#updateMemberId').val(memberId);
                $('#updateInvoiceId').val(invoiceId);
                $('#updateHarga').val(harga);

                $('#confirmModal').modal('show');
            });

            // Event delegation for "UID Game Invalid" buttons
            $('#dataTable').on('click', '.dec-req-btn', function () {
                var memberId = $(this).data('member-id');
                var invoiceId = $(this).data('invoice-id');
                var harga = $(this).data('harga');

                $('#decMemberId').val(memberId);
                $('#decInvoiceId').val(invoiceId);
                $('#decHarga').val(harga);

                $('#rejectModal').modal('show');
            });

            // Mengelola tombol "Edit" ketika diklik
            $('.acc-req-btn').on('click', function () {
                var memberId = $(this).data('member-id');
                var invoiceId = $(this).data('invoice-id');
                var harga = $(this).data('harga');



                // Mengisi nilai input modal edit dengan data pengguna yang akan diedit
                $('#updateMemberId').val(memberId);
                $('#updateInvoiceId').val(invoiceId);
                $('#updateHarga').val(harga);

                // Menampilkan modal edit
                $('#confirmModal').modal('show');
            });

            // Mengirim data pengguna yang diperbarui menggunakan AJAX
            $('#konfirmasiResource').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'acc_req_resource.php', // Ganti dengan nama file yang sesuai di server Anda
                    data: $(this).serialize(),
                    success: function (response) {
                        // Tindakan setelah perubahan pengguna disimpan (misalnya, menutup modal)
                        $('#confirmModal').modal('hide');
                        alert('Request resource pengguna telah dikirim.');
                        // Refresh halaman untuk memperbarui tampilan riwayat pembelian pengguna
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        // Tindakan jika penyimpanan perubahan gagal
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
            });

            $('#declineResource').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'dec_req_resource.php', // Ganti dengan nama file yang sesuai di server Anda
                    data: $(this).serialize(),
                    success: function (response) {
                        // Tindakan setelah perubahan pengguna disimpan (misalnya, menutup modal)
                        $('#rejectModal').modal('hide');
                        alert('Request resource pengguna telah ditolak dan saldo dikembalikan ke pengguna.');
                        // Refresh halaman untuk memperbarui tampilan riwayat pembelian pengguna
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        // Tindakan jika penyimpanan perubahan gagal
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
            });
            $('#dataTable').DataTable();
        });

    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

<footer class="py-5 bg-dark" style="background-color: rgb(10, 10, 12) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>


</html>
