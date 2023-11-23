<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gameName = $_POST["editGameName"];
    $deskripsi = $_POST["editDeskripsi"];
    $logo = $_POST["editLogo"];
    $gambarDeskripsi = $_POST["editGambarDeskripsi"];
    $gameId = $_POST["editGameId"];

    $stmt = $pdo->prepare("UPDATE game SET game_name = ?, deskripsi = ?, logo = ?, gambar_deskripsi = ? WHERE game_id = ?");
    try {
        if ($stmt->execute([$gameName, $deskripsi, $logo, $gambarDeskripsi, $gameId])) {
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
