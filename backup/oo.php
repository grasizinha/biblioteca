<?php
include 'back_end/db.php';

$nome = 'Professor Teste';
$email = 'professor@teste.com';
$senha = 'senha123';  // Senha simples para teste

// Criptografando a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir o professor no banco de dados
$stmt = $pdo->prepare("INSERT INTO professores (nome, email, senha) VALUES (:nome, :email, :senha)");
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha_hash);
$stmt->execute();

echo "Professor de teste adicionado com sucesso!";
?>
