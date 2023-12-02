<?php
session_start();
include 'db_conn.php';
$stmt = $pdo->query("SELECT * FROM game");
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
} else {
    // Redirect or display an error message if the user is not logged in
    header('location: login.php'); // Redirect to the login page
    exit;
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['nama_game_input']) && isset($_POST['deskripsi_input']) && isset($_POST['logo_input']) && isset($_POST['gambar_deskripsi_input'])) {
    $_nama_game = validate($_POST['nama_game_input']);
    $_deskripsi = $_POST['deskripsi_input'];
    $_logo = validate($_POST['logo_input']);
    $_gambar_deskripsi = validate($_POST['gambar_deskripsi_input']);

    // Check if email, username, or telephone number already exists
    $stmt = $pdo->prepare("SELECT * FROM game WHERE game_name = :game_name OR deskripsi = :deskripsi OR logo = :logo OR gambar_deskripsi = :gambar_deskripsi");
    $stmt->bindParam(':game_name', $_nama_game);
    $stmt->bindParam(':deskripsi', $_deskripsi);
    $stmt->bindParam(':logo', $_logo);
    $stmt->bindParam(':gambar_deskripsi', $_gambar_deskripsi);

    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        if ($existingUser['game_name'] === $_nama_game) {
            $errorMsg = "Nama game sudah digunakan.";
        } elseif ($existingUser['logo'] === $_logo) {
            $errorMsg = "Logo sudah digunakan.";
        } elseif ($existingUser['gambar_deskripsi'] === $_gambar_deskripsi) {
            $errorMsg = "Gambar di deskripsi sudah digunakan";
        }
    } else {
        // If no existing user found, insert new user into the database
        $stmt = $pdo->prepare("INSERT INTO game VALUES (NULL,:game_name,:deskripsi,:logo,:gambar_deskripsi)");
        $stmt->bindParam(':game_name', $_nama_game);
        $stmt->bindParam(':deskripsi', $_deskripsi);
        $stmt->bindParam(':logo', $_logo);
        $stmt->bindParam(':gambar_deskripsi', $_gambar_deskripsi);

        if ($stmt->execute() && $stmt->rowCount() == 1) {
            // User successfully registered, redirect to appropriate page
            header('location: manage_produk.php');
            exit();
        } else {
            // Error occurred while registering the user
            $errorMsg = "Registrasi gagal. Silakan coba lagi.";
        }
    }
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

    <title>Manage Produk - PAY2WIN</title>

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
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container" style="padding: 160px 0 20px 0;">
                    <div class="card border-black text-white mb-4 animate"
                        style='border-radius: 1rem;background-color: rgb(0, 0, 0, 0.4) !important'>
                        <div class="card-header"
                            style="display: flex; justify-content: space-between;align-items: center;padding: 10px;border-radius: 1rem;background-color: rgb(0, 0, 0, 0.0) !important">
                            <h6 class="m-0 font-weight-bold text-light"><strong>List Produk</strong></h6>
                            <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addGameModal"
                                style="margin-left: 10px; text-bo"><i class="fa-solid fa-plus"
                                    style="padding:0 8px 0 0px"></i><strong>Tambah Produk</strong></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-dark" id="dataTable" width="100%"
                                    cellspacing="0" style="--bs-table-bg: rgb(0, 0, 0, 0.2) !important;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Produk ID</th>
                                            <th style="width: 15%;">Produk Name</th>
                                            <th style="width: 10%;">Logo</th>
                                            <th style="width: 20%;">Description Image</th>
                                            <th style="width: 20%;">Description</th>
                                            <th style="width: 30%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($rows as $row) {
                                            $id = $row["game_id"];
                                            $gameName = $row["game_name"];
                                            $gameDescription = $row["deskripsi"];
                                            $gameLogo = $row["logo"];
                                            $gameDescriptionImage = $row["gambar_deskripsi"];
                                            echo "<tr>";
                                            echo "<td>$id</td>";
                                            echo "<td>$gameName</td>";
                                            echo "<td style='text-align: center;'><img src='$gameLogo' width='100' height='100'></td>";
                                            echo "<td style='text-align: center;'><img src='$gameDescriptionImage' width='250' height='100'></td>";
                                            echo "<td>$gameDescription</td>";
                                            echo "<td style='text-align: center; vertical-align: middle;'><button class='edit-admin-btn btn btn-primary btn-sm' data-id='$id' data-game-name='$gameName' data-deskripsi='$gameDescription' data-game-logo='$gameLogo' data-gambar-deskripsi='$gameDescriptionImage'><i class='fa-solid fa-pen-to-square'></i></button>";
                                            echo "<a href='manage_item.php?id=$id'><button class='btn btn-warning btn-sm' style='margin-left:10px;' type='submit'><i class='fa-solid fa-file-pen'></i></button></a>";
                                            echo "<button class='delete-game-btn btn btn-danger btn-sm' style='margin-left:10px;'><i class='fa-solid fa-trash'></i></button></td>";
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

    <!-- Modal Logout -->
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

    <!-- Modal Edit Game -->
    <div class="modal fade" id="editGameModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Produk Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengedit informasi pengguna -->
                    <form id="editGameForm">
                        <div class="mb-3">
                            <label for="editGameName" class="form-label">Produk Name:</label>
                            <input type="text" class="form-control" id="editGameName" name="editGameName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDeskripsi" class="form-label">Deskripsi:</label>
                            <input type="text" class="form-control" id="editDeskripsi" name="editDeskripsi" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLogo" class="form-label">Path Logo:</label>
                            <input type="text" class="form-control" id="editLogo" name="editLogo" required>
                        </div>
                        <div class="mb-3">
                            <label for="editGambarDeskripsi" class="form-label">Path Gambar Deskripsi:</label>
                            <input type="textarea" class="form-control" id="editGambarDeskripsi"
                                name="editGambarDeskripsi" required>
                        </div>

                        <div class="text-center d-flex justify-content-between" style="padding:10px 0 0 0">
                            <button type="button" class="btn text-white btn-danger" data-bs-dismiss="modal"aria-label="Close"><i class="fa-solid fa-ban" style="padding-right:10px;"></i> Cancel</button>
                            <input type="hidden" id="editGameId" name="editGameId">
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk" style="padding-right:10px;"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Game -->
    <div class="modal fade" id="addGameModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="add_game" action="manage_produk.php" method="post" class="m-3"
                        onsubmit="return validateForm()">
                        <div class="form-group">
                            <h4>Nama Produk</h4><input type="text" class="form-control mt-1 mb-3"
                                placeholder="Nama game" name="nama_game_input">
                        </div>
                        <div class="form-group  mb-3">
                            <h4>Deskripsi</h4><input type="textarea" class="form-control mt-1" placeholder="Deskripsi"
                                name="deskripsi_input">
                        </div>
                        <div class="form-group  mb-3">
                            <h4>Logo</h4><input type="textarea" class="form-control mt-1" placeholder="Logo"
                                name="logo_input">
                        </div>
                        <div class="form-group  mb-3">
                            <h4>Gambar Deskripsi</h4><input type="textarea" class="form-control mt-1"
                                placeholder="Gambar deskripsi" name="gambar_deskripsi_input">
                        </div>
                        <div class="text-center d-flex justify-content-between" style="padding:10px 0 0 0">
                            <button type="button" class="btn text-white btn-danger" data-bs-dismiss="modal"
                                aria-label="Close"> Cancel</button>
                                <input type="submit" class="btn text-white btn-success w-25 login" value="Submit" name="login-btn">
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

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>


    <script>

        function validateForm() {
            var namaGame = document.forms["add_game"]["nama_game_input"].value;
            var deskripsi = document.forms["add_game"]["deskripsi_input"].value;
            var inputLogo = document.forms["add_game"]["logo_input"].value;
            var gambarDeskripsi = document.forms["add_game"]["gambar_deskripsi_input"].value;

            if (namaGame === "" || deskripsi === "" || inputLogo === "" || gambarDeskripsi === "") {
                alert("All fields must be filled out");
                return false;
            }
            return true;
        }

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

            // Delete User Button (gunakan jQuery untuk menyisipkan konfirmasi)
            $('.delete-game-btn').on('click', function () {
                var gameId = $(this).closest('tr').find('td:first').text(); // Mendapatkan ID pengguna dari kolom pertama tabel
                if (confirm('Apakah Anda yakin ingin menghapus game dengan ID ' + gameId + '?')) {
                    // Kirim permintaan penghapusan ke server menggunakan AJAX
                    $.ajax({
                        type: 'post',
                        url: 'delete_game.php', // Ganti dengan URL endpoint penghapusan di server Anda
                        data: { gameId: gameId },
                        success: function (response) {
                            // Tampilkan pesan sukses atau lakukan tindakan lain jika penghapusan berhasil
                            alert('Game dengan ID ' + gameId + ' telah dihapus.');
                            // Refresh halaman setelah penghapusan
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            // Tampilkan pesan kesalahan atau lakukan tindakan lain jika penghapusan gagal
                            console.error('Terjadi kesalahan: ' + error);
                        }
                    });
                }
            });

            // INI BUAT NAMPILIN DETAIL GAME NYA WAKTU EDIT DIKLIK
            // Mengelola tombol "Edit" ketika diklik
            $('.edit-admin-btn').on('click', function () {
                var gameId = $(this).data('id');
                var gameName = $(this).data('game-name');
                var deskripsi = $(this).data('deskripsi');
                var gameLogo = $(this).data('game-logo');
                var gambarDeskripsi = $(this).data('gambar-deskripsi');
                // Mengisi nilai input modal edit dengan data pengguna yang akan diedit
                $('#editGameId').val(gameId);
                $('#editGameName').val(gameName);
                $('#editDeskripsi').val(deskripsi);
                $('#editLogo').val(gameLogo);
                $('#editGambarDeskripsi').val(gambarDeskripsi);


                // Menampilkan modal edit
                $('#editGameModal').modal('show');
            });

            // Mengirim data pengguna yang diperbarui menggunakan AJAX
            $('#editGameForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'update_game.php', // Ganti dengan nama file yang sesuai di server Anda
                    data: $(this).serialize(),
                    success: function (response) {
                        // Tindakan setelah perubahan pengguna disimpan (misalnya, menutup modal)
                        $('#editGameModal').modal('hide');
                        alert('Perubahan produk disimpan.');
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
