<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_POST["decMemberId"];
    $invoiceId = $_POST["decInvoiceId"];
    $harga = $_POST["decHarga"];

    $stmt = $pdo->prepare("SELECT saldo FROM users WHERE member_id = :member_id");
    $stmt->bindParam(':member_id', $memberId);
    $stmt->execute();
    $hasil = $stmt->fetch(PDO::FETCH_ASSOC);
    $curSaldo = $hasil['saldo'];

    $saldoBaru = $curSaldo + $harga;

    // update jalan
    $stmt = $pdo->prepare("UPDATE users SET saldo = :saldoBaru WHERE member_id = :member_id");
    $stmt->bindParam(':saldoBaru', $saldoBaru);
    $stmt->bindParam(':member_id', $memberId);
    $stmt->execute();

    $stmt = $pdo->prepare("UPDATE invoice SET status_transaksi = -1 WHERE invoice_id = :invoice_id");
    $stmt->bindParam(":invoice_id", $invoiceId);
    $stmt->execute();

} else {
    echo "Invalid request method.";
}
?>
