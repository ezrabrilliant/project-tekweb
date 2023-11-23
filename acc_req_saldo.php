<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_POST["updateUserId"];
    $histId = $_POST["updateHistoryId"];
    $isi_saldo = $_POST["updateIsiSaldo"];

  
    $stmt = $pdo->prepare("UPDATE history_isi_saldo SET status_isi_saldo = 1 WHERE history_id = :history_id");
    $stmt->bindParam(":history_id", $histId);
    $stmt->execute();

    $stmt = $pdo->prepare("SELECT saldo FROM users WHERE member_id = :member_id");
    $stmt->bindParam(":member_id", $memberId);
    $stmt->execute();
    $curSaldo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($curSaldo) {
        $newSaldo = $curSaldo['saldo'] + $isi_saldo;

        $stmt = $pdo->prepare("UPDATE users SET saldo = :new_saldo WHERE member_id = :member_id");
        $stmt->bindParam(":new_saldo", $newSaldo);
        $stmt->bindParam(":member_id", $memberId);
        $stmt->execute();
        
        echo "Saldo updated successfully.";
    } else {
        echo "Member not found or invalid member ID.";
    }
} else {
    echo "Invalid request method.";
}
?>
