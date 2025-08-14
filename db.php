<?php
$host = "localhost";
$dbname = "biblioteca";
$user = "root";  // ou seu usuário do MySQL
$pass = "";      // ou sua senha do MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco: " . $e->getMessage();
}
?>
