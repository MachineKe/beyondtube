<?php
$host = '142.44.157.51';
$db = 'cefzwmvj_beyondtube';
$user = 'cefzwmvj_tube';
$pass = 'Ust,F45;2JNo';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    echo "✅ Connection successful!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
