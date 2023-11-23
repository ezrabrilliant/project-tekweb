<?php
// get_table_data.php

session_start();
include 'db_conn.php';


function renderTableRow($row)
{
    $username = $row["username"];
    $product_name = $row["game_name"];
    $price = $row["harga_satuan"];
    $date = $row["tanggal_transaksi"];
    $invoice = $row["invoice_id"];
    $status = $row["status_transaksi"];

    echo "<tr>";
    echo "<td>$invoice</td>";
    echo "<td>$username</td>";
    echo "<td>$product_name</td>";
    echo "<td> Rp " . number_format($price, 0, ',', '.') . "</td>";
    echo "<td>$date</td>";
    echo "<td>";
    if ($status == 1) {
        echo "<span class='badge text-bg-success text-success-emphasis bg-success-subtle border border-success-subtle rounded-2'>Sukses</span>";
    } elseif ($status == 0) {
        echo "<span class='badge text-bg-warning text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-2'>On Progress</span>";
    } elseif ($status == -1) {
        echo "<span class='badge text-bg-danger text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2'>Fail</span>";
    } else {
        echo "Unknown Status";
    }
    echo "</td>";
    echo "</tr>";
}


if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    // Access user information
    $memberId = $user['member_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['statusOpt']) && !empty($_POST['statusOpt'])) {
        $selectedValues = $_POST['statusOpt'];

        // Validate and sanitize the selected values to prevent SQL injection
        $validValues = array_filter($selectedValues, function ($value) {
            return in_array($value, ['-1', '0', '1']);
        });

        if (!empty($validValues)) {
            $placeholders = implode(',', array_fill(0, count($validValues), '?'));
            $query = "SELECT users.username, game.game_name, item.harga_satuan, invoice.tanggal_transaksi, invoice.invoice_id, invoice.status_transaksi
            FROM users
            INNER JOIN invoice ON users.member_id = invoice.member_id
            INNER JOIN item ON invoice.item_id = item.item_id
            INNER JOIN game ON item.game_id = game.game_id 
            WHERE invoice.status_transaksi IN ($placeholders)";
            $stmt = $pdo->prepare($query);
            $stmt->execute($validValues);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                renderTableRow($row);
            }
        } else {
            echo "Invalid filter values.";
        }
    }
} else {
    // Handle the case if the user is not logged in
    echo "User not logged in.";
}
?>
