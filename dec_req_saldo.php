<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $histId = $_POST["histId"];

  
    $stmt = $pdo->prepare("UPDATE history_isi_saldo SET status_isi_saldo = -1 WHERE history_id = :history_id");
    $stmt->bindParam(":history_id", $histId);
    $stmt->execute();

    
} else {
    echo "Invalid request method.";
}
?>
