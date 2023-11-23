
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


function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



if (isset($_POST['game_id']) && isset($_POST['gambar_resource']) && isset($_POST['nominal_resource']) && isset($_POST['harga_satuan']) && isset($_POST['newItemStock'])) {
    $gambarResource = validate($_POST['gambar_resource']);
    $nominalResource = $_POST['nominal_resource'];
    $harga = validate($_POST['harga_satuan']);
    $stock = validate($_POST['newItemStock']);
    $gameId = validate($_POST['game_id']);

    // Check if email, username, or telephone number already exists
    $stmt = $pdo->prepare("SELECT * FROM item WHERE nominal_topup = :nominal_topup AND game_id = :game_id");
    $stmt->bindParam(':nominal_topup', $nominalResource);
    $stmt->bindParam(':game_id', $gameId);
    
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        if ($existingUser['nominal_topup'] === $nominalResource) {
            $errorMsg = "Nominal resource sudah ada.";
        }  
    } else {
        // If no existing found, insert new item into the database
        $stmt = $pdo->prepare("INSERT INTO item VALUES (NULL,:status_stok,:nominal_topup,:harga_satuan, :resource_image, :game_id)");
        $stmt->bindParam(':status_stok', $stock);
        $stmt->bindParam(':nominal_topup', $nominalResource);
        $stmt->bindParam(':harga_satuan', $harga);
        $stmt->bindParam(':resource_image', $gambarResource);
        $stmt->bindParam(':game_id', $gameId);

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

    <title>Riwayat Pembelian User</title>

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
            position: relative;
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



    <?php $game_id = $_GET['id']; ?>
    <!-- <p></p> -->
      <!-- Page Wrapper -->
      <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <div class="container" style="padding: 160px 0 20px 0;">
                    <div class="card mb-4">
                        <div class="card-header"
                            style="display: flex; justify-content: space-between;align-items: center;padding: 10px;background-color: #f5f5f5;">
                            <h6 class="m-0 font-weight-bold text-dark"><strong>List Item</strong></h6>
                            <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal"
                                style="margin-left: 10px; text-bo"><i class="fa-solid fa-plus"
                                    style="padding:0 8px 0 0px"></i><strong>Tambah Item</strong></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Item ID</th>
                                            <th style="width: 5%;">Game ID</th>
                                            <th style="width: 15%;">Status Stock</th>
                                            <th style="width: 30%;">Gambar Resource</th>
                                            <th style="width: 10%;">Nominal Resource</th>
                                            <th style="width: 15%;">Harga</th>
                                            <th style="width: 20%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $pdo->prepare("SELECT * FROM item WHERE game_id = :game_id");
                                        $stmt->bindParam(":game_id", $game_id);
                                        $stmt->execute();
                                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($rows as $row) {
                                            $itemId = $row["item_id"];
                                            $gameId = $row["game_id"];
                                            $stock = $row["status_stok"];
                                            $gambar_resource = $row["resource_image"];
                                            $nominal_resource = $row["nominal_topup"];
                                            $harga = $row["harga_satuan"];
                                            
                                            echo "<tr>";
                                            echo "<td>$itemId</td>";
                                            echo "<td>$gameId</td>";
                                            if ($stock == 1) {
                                                echo "<td>Ready</td>";
                                            } else {
                                                echo "<td>Not Avalaible</td>";
                                            }
                                            echo "<td style='text-align: center;'><img src='$gambar_resource' width='100' height='100'></td>";
                                            echo "<td>$nominal_resource</td>";
                                            echo "<td>$harga</td>";
                                            echo "<td style='text-align: center; vertical-align: middle;'><button class='edit-item-btn btn btn-primary btn-sm' data-item-id='$itemId' data-stock='$stock' data-gambar-resource='$gambar_resource' data-nominal-resource= '$nominal_resource' data-harga='$harga'>Edit</button>";
                                            echo "<button class='delete-item-btn btn btn-danger btn-sm' style='margin-left:10px;'>Delete</button></td>";
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

    <!-- Modal Edit Game -->
    <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Edit Item Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Form untuk mengedit informasi pengguna -->
            <form id="editItemForm">
                <div class="mb-3">
                    <label for="editStock" class="form-label">Status Stock:</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editStock" name="editStock" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Ready</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="editGambarResource" class="form-label">Path Gambar Resource:</label>
                    <input type="text" class="form-control" id="editGambarResource" name="editGambarResource" required>
                </div>
                <div class="mb-3">
                    <label for="editNominalResource" class="form-label">Nominal Resource:</label>
                    <input type="text" class="form-control" id="editNominalResource" name="editNominalResource" required>
                </div>
                <div class="mb-3">
                    <label for="editHarga" class="form-label">Harga Resource:</label>
                    <input type="textarea" class="form-control" id="editHarga" name="editHarga" required>
                </div>
               <input type="hidden" id="editItemId" name="editItemId">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
    </div>
    </div>

    <!-- Modal Add Game -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Tambah Game</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="add_game" action="manage_item.php" method="post" class="m-3"
                        onsubmit="return validateForm()">
                        <div class="form-group mb-3">
                            <h4>Status Stok</h4>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="newItemStock" name="newItemStock" checked>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Ready</label>
                            </div>
                        </div>
                        <div class="form-group  mb-3">
                            <h4>Path Gambar Resource</h4><input type="textarea" class="form-control mt-1" placeholder="Deskripsi"
                                name="gambar_resource">
                        </div>
                        <div class="form-group  mb-3">
                            <h4>Nominal Resource</h4><input type="textarea" class="form-control mt-1" placeholder="Logo"
                                name="nominal_resource">
                        </div>
                        <div class="form-group  mb-3">
                            <h4>Harga</h4><input type="textarea" class="form-control mt-1" placeholder="Gambar deskripsi"
                                name="harga_satuan">
                        </div>
                        <?php echo "<input type='hidden' name='game_id' id='game_id' value = ".$game_id.">" ?>
                        <div class="text-center d-flex justify-content-between"  style="padding:10px 0 0 0">
                            <button type="button" class="btn text-white btn-danger" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <input type="submit" class="btn text-white btn-success w-25 login" value="Submit"
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

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>


    <script>

        function validateForm() {
            var checkbox = document.getElementById("newItemStock");
            var hasilCheckBox = 0;

            // Check if the checkbox is checked
            if (checkbox.checked) {
               // console.log("Checkbox is checked"); // 1
                hasilCheckBox = 1;
            } 
            var stock = hasilCheckBox;
            var gambar_resource = document.forms["add_item"]["gambar_resource"].value;
            var nominal = document.forms["add_item"]["nominal_resource"].value;
            var harga = document.forms["add_item"]["harga_satuan"].value;
            var game_id = document.form["add_item"]["game_id"].value;
            //var gambarDeskripsi = document.forms["add_item"]["gambar_deskripsi_input"].value;

            if (gambar_resource === "" || nominal === "" || harga === "") {
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
            $('.delete-item-btn').on('click', function () {
                var itemId = $(this).closest('tr').find('td:first').text(); // Mendapatkan ID pengguna dari kolom pertama tabel
                if (confirm('Apakah Anda yakin ingin menghapus item dengan ID ' + itemId + '?')) {
                    // Kirim permintaan penghapusan ke server menggunakan AJAX
                    $.ajax({
                        type: 'post',
                        url: 'delete_item.php', // Ganti dengan URL endpoint penghapusan di server Anda
                        data: { itemId: itemId },
                        success: function (response) {
                            // Tampilkan pesan sukses atau lakukan tindakan lain jika penghapusan berhasil
                            alert('Item dengan ID ' + itemId + ' telah dihapus.');
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
            $('.edit-item-btn').on('click', function () {
                var itemId = $(this).data('item-id');
                var stock = $(this).data('stock');
                var gambarResource = $(this).data('gambar-resource');
                var nominalResource = $(this).data('nominal-resource');
                var harga = $(this).data('harga');
                // Mengisi nilai input modal edit dengan data pengguna yang akan diedit
                $('#editItemId').val(itemId);
                $('#editStock').val(stock);
                $('#editGambarResource').val(gambarResource);
                $('#editNominalResource').val(nominalResource);
                $('#editHarga').val(harga);
                // Menampilkan modal edit
                $('#editItemModal').modal('show');
            });

            // Mengirim data pengguna yang diperbarui menggunakan AJAX
            $('#editItemForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'update_item.php', // Ganti dengan nama file yang sesuai di server Anda
                    data: $(this).serialize(),
                    success: function (response) {
                        // Tindakan setelah perubahan pengguna disimpan (misalnya, menutup modal)
                        $('#editItemModal').modal('hide');
                        alert('Perubahan item disimpan.');
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
