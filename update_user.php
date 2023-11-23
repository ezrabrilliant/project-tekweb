<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST["editUserId"];
    $username = $_POST["editUsername"];
    $email = $_POST["editEmail"];
    $phone = $_POST["editPhone"];

    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, no_telepon = ? WHERE member_id = ?");
    try {
        if ($stmt->execute([$username, $email, $phone, $userId])) {
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
