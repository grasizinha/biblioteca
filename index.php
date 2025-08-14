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
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <div class="login-box">
        <h2>Login de Professor</h2>
        <?php if (isset($erro)) { echo "<div class='erro'>" . htmlspecialchars($erro) . "</div>"; } ?>
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
