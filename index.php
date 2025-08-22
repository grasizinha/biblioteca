<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["entrar"])) {
    $cpf = trim($_POST["cpf"]);
    $senha = trim($_POST["senha"]);

    if (!empty($cpf) && !empty($senha)) {
        $sql = "SELECT * FROM professores WHERE cpf = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cpf]);

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica senha
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['professor_id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                header("Location: inicial.php");
                exit();
            } else {
                $erro = "Senha incorreta!";
            }
        } else {
            $erro = "Usuário não encontrado!";
        }
    } else {
        $erro = "Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* Fundo com a imagem */
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            background: url("https://wallpapers.com/images/hd/princess-tiana-req95ud3g1e4re2f.jpg") no-repeat center center/cover;
        }

        /* Container */
        .login-box {
            background: rgba(240, 245, 247, 0.9);
            padding: 30px;
            border-radius: 20px;
            width: 350px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(21, 120, 150, 0.3);
        }

        /* Título */
        .login-box h2 {
            margin-bottom: 20px;
            color:rgb(33, 36, 119);
            font-size: 22px;
        }

        /* Labels */
        .login-box label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #333;
            text-align: left;
        }

        /* Inputs */
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 5px 0;
            border: 2px solidrgb(51, 120, 209);
            border-radius: 10px;
            outline: none;
            font-size: 14px;
        }

        .login-box input:focus {
            border-color:rgb(19, 43, 78);
        }

        /* Botão */
        .login-box button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: linear-gradient(135deg,rgb(16, 58, 92),rgb(22, 80, 130));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-box button:hover {
            background: linear-gradient(135deg,rgb(3, 139, 144),rgb(26, 161, 182));
            transform: scale(1.05);
        }

        /* Mensagem de erro */
        .erro {
            background:rgb(43, 202, 213);
            color:rgb(31, 84, 160);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login de Professor</h2>
        <?php if (isset($erro)) { echo "<div class='erro'>" . htmlspecialchars($erro) . "</div>"; } ?>

        <!-- FORMULÁRIO (faltava no seu código) -->
        <form method="POST">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit" name="entrar">Entrar</button>
        </form>
    </div>
</body>
</html>
