<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $t=time();
    $tanggal_transaksi = date("Y-m-d",$t);
    $userId = $_POST["user_id"];
    $itemId = $_POST["item_id"];
    $gameId = $_POST["game_id"];
    $uid_game = $_POST["uid_game"];

    $stmt = $pdo->prepare("SELECT harga_satuan FROM item WHERE item_id = :item_id");
    $stmt->bindParam(':item_id', $itemId);
    $stmt->execute();
    $hasil = $stmt->fetch(PDO::FETCH_ASSOC);
    $harga_item = $hasil['harga_satuan'];

    $stmt = $pdo->prepare("SELECT saldo FROM users WHERE member_id = :member_id");
    $stmt->bindParam(':member_id', $userId);
    $stmt->execute();
    $hasil = $stmt->fetch(PDO::FETCH_ASSOC);
    $saldo = $hasil['saldo'];



   
    if($saldo < $harga_item) {
        header("Location: details.php?error=Insufficient balance to purchase this item");
        exit;
    } else {
        $stmt = $pdo->prepare("UPDATE users SET saldo = saldo - (SELECT harga_satuan FROM item WHERE item_id = :item_id) WHERE member_id = :member_id");
        $stmt->bindParam(':item_id', $itemId);
        $stmt->bindParam(':member_id', $userId);
        $stmt->execute();

        $stmt = $pdo->prepare("INSERT INTO invoice VALUES (NULL, :tanggal_transaksi, :uid_game, 0, :item_id, :member_id)");
        $stmt->bindParam(':tanggal_transaksi', $tanggal_transaksi);
        $stmt->bindParam(':uid_game', $uid_game);
        $stmt->bindParam(':item_id', $itemId);
        $stmt->bindParam(':member_id', $userId);
        $stmt->execute();
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>
