<?php
include '../../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Verifica se os campos obrigatórios não estão vazios
    if ($nome == '' || $cpf == '' || $senha == '' || $email == '') {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    global $pdo;

    try {
        $sql = "INSERT INTO professores (nome, cpf, senha, email) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $cpf, $senhaHash, $email]);

        echo "<script>
            alert('Professor cadastrado com sucesso!');
            window.location.href = 'criar_professores.php';
        </script>";

    } catch (PDOException $e) {
        echo "<script>
            alert('Erro ao cadastrar professor: " . $e->getMessage() . "');
            window.location.href = 'criar_professores.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professor</title>
    <style>
        /* Estilos para o formulário */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e3f2fd;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 200%;
            max-width: 600px;
            padding: 60px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #1976d2;
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
        }

        input[type="submit"] {
            background-color: #1976d2;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Professor</h1>
        <form method="post" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>
