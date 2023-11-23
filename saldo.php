<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    // Access user information
    $memberId = $user['member_id'];
    $userEmail = $user['email'];
    $userName = $user['username'];
    // Add more fields as needed

    // Display user information
    // echo "Welcome, $userName! Your email is $userEmail.";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['statusOpt']) && $_POST['statusOpt'] !== "") {

        $selectedValue = $_POST['statusOpt'];

        // Check the selected value
        if ($selectedValue === -1) {
            $stmt = $pdo->query(
                "SELECT users.username, history_isi_saldo.nominal_isi_saldo, history_isi_saldo.status_isi_saldo, history_isi_saldo.tanggal_request, history_isi_saldo.history_id FROM users
                INNER JOIN history_isi_saldo
                    ON users.member_id = history_isi_saldo.member_id
                    WHERE history_isi_saldo.status_isi_saldo = -1;"
            );
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else if ($selectedValue == 0) {
            // Handle other cases if needed
        } else if ($selectedValue == 1) {
            // Handle other cases if needed
        } else {

        }
    } else {
        $stmt = $pdo->query(
            "SELECT users.username, history_isi_saldo.nominal_isi_saldo, history_isi_saldo.status_isi_saldo, history_isi_saldo.tanggal_request, history_isi_saldo.history_id FROM users
            INNER JOIN history_isi_saldo
                    ON users.member_id = history_isi_saldo.member_id;"
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
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

    <title>Riwayat Saldo User</title>

    <script src="https://kit.fontawesome.com/785e8a7b97.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

        .checkbox-menu li label {
            display: block;
            padding: 3px 10px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            white-space: nowrap;
            margin: 0;
            transition: background-color .4s ease;
        }

        .checkbox-menu li input {
            margin: 0px 5px;
            top: 2px;
            position: relative;
        }

        .checkbox-menu li label:hover,
        .checkbox-menu li label:focus {
            background-color: #f5f5f5;
            color: black;
        }
    </style>
</head>

<body class="bg-dark">

    <!-- Navigation-->
    <nav class="py-4 navbar navbar-expand-lg navbar-dark fixed-top"
        style="background: rgba(0, 0, 0, 0.6) !important; backdrop-filter: blur(10px) saturate(125%); z-index: 7; -webkit-backdrop-filter: blur(10px) saturate(125%);">
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
                        <a href="#" class="nav-link dropdown-toggle active" style="z-index: 7;"
                            data-bs-toggle="dropdown">MANAGE DATA</a>
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
                            <div class="row align-items-center justify-content-between">
                                <div class="col-md-6">
                                    <h6 class="m-0 font-weight-bold text-dark">
                                        <strong>
                                            Riwayat Saldo User
                                        </strong>
                                    </h6>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="dropdown" style="position: relative;">
                                        <button class="btn btn-light btn-outline-dark dropdown-toggle" type="button"
                                            id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            Filter By
                                        </button>
                                        <ul class="dropdown-menu checkbox-menu dropdown-menu-end" data-bs-theme="dark"  style="z-index: 3;" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <label class="form-check-label" for="checkboxFail">
                                                    <input class="form-check-input" checked type="checkbox"
                                                        name="statusOpt" value="-1" id="checkboxFail"> Fail
                                                </label>
                                            </li>
                                            <li>
                                                <label class="form-check-label" for="checkboxProgress">
                                                    <input class="form-check-input active" checked type="checkbox"
                                                        name="statusOpt" value="0" id="checkboxProgress"> On Progress
                                                </label>
                                            </li>
                                            <li>
                                                <label class="form-check-label" for="checkboxSuccess">
                                                    <input class="form-check-input active" checked type="checkbox"
                                                        name="statusOpt" value="1" id="checkboxSuccess"> Success
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                    <thead>
                                        <tr>
                                            <th>Id History</th>
                                            <th>Username</th>
                                            <th>Nominal</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <?php
                                        foreach ($rows as $row) {
                                            $username = $row["username"];
                                            $price = $row["nominal_isi_saldo"];
                                            $date = $row["tanggal_request"];
                                            $status = $row["status_isi_saldo"];
                                            $historyid = $row["history_id"];

                                            echo "<tr>";
                                            echo "<td>$historyid</td>";
                                            echo "<td>$username</td>";
                                            echo "<td> Rp " . number_format($price, 0, ',', '.') . "</td>";
                                            echo "<td>$date</td>";
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

    <!-- modal logout-->
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
            $('#dataTable').DataTable();

            $('input[name="statusOpt"]').on('change', function () {
                applyFilter();
            });

            function applyFilter() {
                var selectedValues = $('input[name="statusOpt"]:checked').map(function () {
                    return this.value;
                }).get();

                $.ajax({
                    type: 'post',
                    url: 'get_table_saldo.php',
                    data: { statusOpt: selectedValues },
                    success: function (response) {
                        $('#tableBody').html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
            }
        });

    </script>


    <script>
        // Prevent dropdown from closing when clicking on checkboxes
        $('.dropdown-menu').on('click', function (e) {
            e.stopPropagation();
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
