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

    $memberId = $user['member_id'];
    $userEmail = $user['email'];
    $userName = $user['username'];
} else {
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

    <title>Manage Saldo User - PAY2WIN</title>

    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/785e8a7b97.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>

<body class="bg-dark">

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
            <a class="navbar-brand" style="height: 52px;" href="home.php">
                <img src="assets\Web Logo\pay-2-win-full.png" alt="PAY2WIN Logo" class="img-fluid"
                    style="max-height: 50px;margin-top: -2px;height: 100%;object-fit: cover;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav align-items-center me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item me-lg-4 d-lg-block"><a class="nav-link" aria-current="page"
                            href="admin.php">HOME</a>
                    </li>
                    <div class="nav-item me-lg-4 d-lg-block dropdown">
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


    <div id="wrapper" style='margin-top: 150px !important; margin-bottom: 40px !important;'>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container" style="padding: 40px 0 20px 0;">
                    <div class="card border-black text-white mb-4 animate"
                        style='border-radius: 1rem;background-color: rgb(0, 0, 0, 0.4) !important'>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-light"><strong>List Request Topup Saldo Wallet User</strong></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-dark" id="dataTable" width="100%"
                                    cellspacing="0" style="--bs-table-bg: rgb(0, 0, 0, 0.2) !important;">
                                    <thead>
                                        <tr>
                                            <th>Member ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Tanggal Request</th>
                                            <th>Permintaan Nominal isi saldo</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($rows as $row) {
                                            $historyId = $row["history_id"];
                                            $member_id = $row["member_id"];
                                            $username = $row["username"];
                                            $email = $row["email"];
                                            $tanggal_request = $row["tanggal_request"];
                                            $nominal_isi_saldo = $row["nominal_isi_saldo"];
                                            echo "<tr>";
                                            echo "<td>$member_id</td>";
                                            echo "<td>$username</td>";
                                            echo "<td>$email</td>";
                                            echo "<td>$tanggal_request</td>";
                                            echo "<td>$nominal_isi_saldo</td>";
                                            echo "<td><button class='acc-req-btn btn btn-primary btn-sm' data-history-id='$historyId' data-id='$member_id' data-nominal-isi-saldo='$nominal_isi_saldo'><i class='fa-solid fa-check'></i></button>";
                                            echo "<button class='dec-req-btn btn btn-danger btn-sm' data-history-id='$historyId' style='margin-left:10px;'><i class='fa-solid fa-xmark'></i></button></td>";
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

    <!-- modal logout-->
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

    <!-- Modal konfirmasi uang diterima -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Konfirmasi uang diterima</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda sudah yakin jika uang sudah diterima?</p>
                    <form id="konfirmasiUangDiterima">
                        <input type="hidden" id="confirmUserId" name="updateUserId">
                        <input type="hidden" id="confirmHistoryId" name="updateHistoryId">
                        <input type="hidden" id="confirmIsiSaldo" name="updateIsiSaldo">

                        <div class="text-center d-flex justify-content-between" style="padding:10px 0 0 0">
                            <button type="button" class="btn text-white btn-danger" data-bs-dismiss="modal"aria-label="Close"><i class="fa-solid fa-ban" style="padding-right:10px;"></i> Cancel</button>
                            <input type="hidden" id="editGameId" name="editGameId">
                            <button type="submit" class="btn btn-success"> <i class="fa-solid fa-check" style="padding-right:10px;"></i>Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tolak uang diterima -->
    <div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="declineModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Tolak uang diterima</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Apakah anda yakin ingin menolak uang diterima?</p>
                    <form id="tolakUangDiterima">
                        <input type="hidden" id="declineUserId" name="declineUserId">
                        <input type="hidden" id="declineHistoryId" name="declineHistoryId">
                        <input type="hidden" id="declineIsiSaldo" name="declineIsiSaldo">
                        
                        <div class="text-center d-flex justify-content-between" style="padding:10px 0 0 0">
                            <button type="button" class="btn text-white btn-danger" data-bs-dismiss="modal"aria-label="Close"><i class="fa-solid fa-ban" style="padding-right:10px;"></i> Cancel</button>
                            <input type="hidden" id="editGameId" name="editGameId">
                            <button type="submit" class="btn btn-success"> <i class="fa-solid fa-check" style="padding-right:10px;"></i>Yes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <script>
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

            $(document).ready(function () {
                $('#dataTable').on('click', '.acc-req-btn', function () {
                    var userId = $(this).data('id');
                    var nominal_isi_saldo = $(this).data('nominal-isi-saldo');
                    var historyId = $(this).data('history-id');
                    $('#confirmUserId').val(userId);
                    $('#confirmHistoryId').val(historyId);
                    $('#confirmIsiSaldo').val(nominal_isi_saldo);
                    $('#confirmModal').modal('show');
                });

                $('#konfirmasiUangDiterima').on('submit', function (event) {
                    event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'acc_req_saldo.php',
                        data: $(this).serialize(),
                        success: function (response) {
                            $('#confirmModal').modal('hide');
                            alert('Request saldo pengguna telah dikirim.');
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error('Terjadi kesalahan: ' + error);
                        }
                    });
                });

                // Ketika tombol tolak diklik
                $('#dataTable').on('click', '.dec-req-btn', function () {
                    var userId = $(this).data('id');
                    var nominal_isi_saldo = $(this).data('nominal-isi-saldo');
                    var historyId = $(this).data('history-id');
                    $('#declineUserId').val(userId);
                    $('#declineHistoryId').val(historyId);
                    $('#declineIsiSaldo').val(nominal_isi_saldo);
                    $('#declineModal').modal('show');
                });

                $('#tolakUangDiterima').on('submit', function (event) {
                    event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'dec_req_saldo.php',
                        data: $(this).serialize(),
                        success: function (response) {
                            $('#declineModal').modal('hide');
                            alert('Request saldo pengguna telah ditolak.');
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error('Terjadi kesalahan: ' + error);
                        }
                    });
                });
                $('#dataTable').DataTable();
            });
        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<footer class="py-5 bg-dark" style="background-color: rgb(10, 10, 12) !important">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PAY2WIN 2023</p>
    </div>
</footer>

</html>
