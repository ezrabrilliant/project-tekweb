<?php
session_start();
include 'db_conn.php'; // Sertakan file koneksi ke database di sini

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Query untuk menghapus pengguna dari database berdasarkan ID
    $stmt = $pdo->prepare("DELETE FROM users WHERE username = ?");
    $stmt->execute([$userId]);

    // Periksa apakah pengguna berhasil dihapus
    if ($stmt->rowCount() > 0) {
        // Pengguna berhasil dihapus
        echo json_encode(array('success' => true));
    } else {
        // Pengguna tidak ditemukan atau gagal dihapus
        echo json_encode(array('success' => false, 'message' => 'User not found or deletion failed.'));
    }
} else {
    // Jika permintaan bukan metode POST atau tidak mengandung data yang benar
    echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
}



?>
