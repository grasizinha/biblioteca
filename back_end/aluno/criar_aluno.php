<?php
include '../../db.php';
// Verifica se os dados foram enviados pelo formulário
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $serie = $_POST["serie"];

    // Query para inserir aluno
    $sql = "INSERT INTO aluno (nome, email, serie) VALUES (:nome, :email, :serie)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":serie", $serie);

    if ($stmt->execute()) {
        echo "Aluno cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar aluno.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <style>
 body {
    font-family: 'Arial', sans-serif;
    background-color: #e3f2fd; /* Fundo azul bebê */
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center; /* Centraliza horizontalmente */
    align-items: center;     /* Centraliza verticalmente */
    height: 100vh;           /* Altura total da tela */
    box-sizing: border-box;  /* Inclui padding e border no cálculo da largura e altura */
}

.container {
    width: 100%;
    max-width: 600px; /* Largura máxima do formulário */
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box; /* Inclui padding e border no cálculo da largura e altura */
}

h1 {
    text-align: center;
    color: #1976d2; /* Cor do título */
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; /* Inclui padding e border no cálculo da largura */
}

        input[type="submit"] {
            background-color: #1976d2; /* Fundo do botão azul */
            color: white; /* Cor do texto do botão */
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 200%;
            max-width: 560px;
        }

input[type="submit"] {
    background-color: #1976d2;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Aluno</h1>
        <form method="post" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="serie">Serie:</label>
            <input type="text" id="serie" name="serie" required>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <input type="submit" value="Cadastrar">
        </form>
</head>

</html>


