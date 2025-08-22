<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = $_POST['nome'] ?? '';
    $cpf   = $_POST['cpf'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $email = $_POST['email'] ?? '';

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
            window.location.href = 'criar_professor.php';
        </script>";

    } catch (PDOException $e) {
        echo "<script>
            alert('Erro ao cadastrar professor: " . $e->getMessage() . "');
            window.location.href = 'criar_professor.php';
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
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: url("https://play-lh.googleusercontent.com/proxy/OIynLVxYQ725Q0NFTPdTG0Qi5DYqtJBYLTzje5GI977e4U9-TgWhqBgUyXdtJqC5fSjzkvrG9xUujv5sETGEa4-xBApDcpDSmYhcK75rjpR3tD4IxzrIg9o=s1920-w1920-h1080") no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding-right: 50px;
    }

    .container {
        width: 100%;
        max-width: 400px;
        padding: 40px;
        background: rgba(255, 255, 255, 0.85);
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        text-align: left;
        backdrop-filter: blur(5px);
    }

    h1 {
        color: rgb(125, 166, 225);
        text-align: center;
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #bbb;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: rgb(53, 100, 182);
        box-shadow: 0 0 8px rgba(38, 57, 183, 0.4);
    }

    input[type="submit"] {
        background: linear-gradient(135deg,rgb(32, 124, 210),rgb(38, 110, 211));
        color: white;
        padding: 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background: linear-gradient(135deg,rgb(44, 70, 176),rgb(104, 154, 202));
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

    @media (max-width: 900px) {
        body {
            flex-direction: column;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 100%;
        }
    }
</style>
</head>
<body>

<a href="../inicial.php" class="botao-voltar" title="Voltar">&#8592; Voltar</a>

    <div class="container">
        <h1>Cadastro de Professor</h1>
        <form method="post" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" maxlength="14" oninput="mascaraCPF(this)" placeholder="000.000.000-00" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>

<script>
function mascaraCPF(input) {
    let v = input.value.replace(/\D/g, ''); // remove tudo que não é número
    v = v.slice(0, 11); // limita a 11 dígitos

    // aplica a máscara: 000.000.000-00
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

    input.value = v;
}
</script>
</body>
</html>
