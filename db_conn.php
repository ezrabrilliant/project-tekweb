<?php
    $host = 'telematics.petra.ac.id';
    $dbname = 'tekweb05';
    $username = '';
    $password = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
