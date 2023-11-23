<?php
// get_table_saldo.php

session_start();
include 'db_conn.php';

function renderTableRow($row)
{
    $username = $row["username"];
    $price = $row["nominal_isi_saldo"];
    $date = $row["tanggal_request"];
    $status = $row["status_isi_saldo"];
    $historyid = $row["history_id"];

    echo "<tr>";
    echo "<td>$historyid</td>";
    echo "<td>$username</td>";
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
            $query = "SELECT users.username, history_isi_saldo.nominal_isi_saldo, history_isi_saldo.status_isi_saldo, history_isi_saldo.tanggal_request, history_isi_saldo.history_id FROM users
                    INNER JOIN history_isi_saldo
                        ON users.member_id = history_isi_saldo.member_id
                    WHERE history_isi_saldo.status_isi_saldo IN ($placeholders)";
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
