<?php
include '../db.php';

// Verifica se os dados foram enviados pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = $_POST["nome"];
    $email = $_POST["email"];
    $serie = $_POST["serie"];

    // Query para inserir aluno
    $sql = "INSERT INTO alunos (nome, email, serie) VALUES (:nome, :email, :serie)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":serie", $serie);

    if ($stmt->execute()) {
        echo "<script>alert('Aluno cadastrado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar aluno.');</script>";
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
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: flex-start; /* Conteúdo alinhado à esquerda */
            align-items: center;
            background: url("../imagem/sapo.jpg") no-repeat center center;
            background-size: cover; /* Faz a imagem ocupar toda a tela */
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            margin-left: 50px; /* Afasta da borda esquerda */
            background-color: rgba(255, 255, 255, 0.92); /* Fundo branco translúcido */
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            color:rgb(104, 205, 159); /* Roxo princesa */
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #bbb;
            border-radius: 8px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background: linear-gradient(45deg,rgb(112, 211, 145),rgb(100, 197, 153)); /* Roxo degradê */
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s ease;
        }

        input[type="submit"]:hover {
            background: linear-gradient(45deg,rgb(75, 188, 177),rgb(82, 201, 165));
            transform: scale(1.05);
        }

        .botao-voltar {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            font-size: 1.5rem;
            color: white;
            background-color: rgba(0,0,0,0.3);
            padding: 5px 10px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .botao-voltar:hover {
            background-color: rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

<a href="../inicial.php" class="botao-voltar" title="Voltar">&#8592; Voltar</a>

    <div class="container">
        <h1>Cadastro de Aluno</h1>
        <form method="post" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="serie">Série:</label>
            <input type="text" id="serie" name="serie" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>

</body>
</html>
