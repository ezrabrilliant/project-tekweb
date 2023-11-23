<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nominal_isi_saldo = $_POST["amount"];
    //$nama_file = $_FILES["bukti_bayar"];
    $t=time();
    $tanggal_isi = date("Y-m-d",$t);
    $member_id = $_POST["user_id"];
    

    $stmt = $pdo->prepare("INSERT INTO history_isi_saldo VALUES (NULL, ?, ?, ?, 0)");
    try {
        if ($stmt->execute([$nominal_isi_saldo, $tanggal_isi, $member_id])) {
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
