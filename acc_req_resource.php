<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $memberId = $_POST["updateMemberId"];
    $invoiceId = $_POST["updateInvoiceId"];
    $harga = $_POST["updateHarga"];

  
    $stmt = $pdo->prepare("UPDATE invoice SET status_transaksi = 1 WHERE invoice_id = :invoice_id");
    $stmt->bindParam(":invoice_id", $invoiceId);
    $stmt->execute();

} else {
    echo "Invalid request method.";
}
?>
