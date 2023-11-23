<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemId = $_POST["editItemId"];
    if (isset($_POST["editStock"])) {
        $stock = 1;
    } else {
        $stock = 0;
    }
    $gambarResource = $_POST["editGambarResource"];
    $nominalResource = $_POST["editNominalResource"];
    $harga = $_POST["editHarga"];
   
    $stmt = $pdo->prepare("UPDATE item SET status_stok = ?, nominal_topup = ?, harga_satuan = ?, resource_image = ? WHERE item_id = ?");
    try {
        if ($stmt->execute([$stock, $nominalResource, $harga, $gambarResource, $itemId])) {
            echo "Data pengguna berhasil diperbarui.";
        } else {
            echo "Terjadi kesalahan saat memperbarui data pengguna.";
        }
    } catch (PDOException $e) {
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>


