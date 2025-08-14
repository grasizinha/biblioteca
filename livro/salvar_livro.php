<?php
header('Content-Type: text/html; charset=utf-8');
include '../../db.php';  // ajuste o caminho conforme seu projeto

$titulo = trim($_POST['titulo'] ?? '');
$autor = trim($_POST['autor'] ?? '');
$isbn = trim($_POST['isbn'] ?? '');

$message = '';
$class = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($titulo && $autor && $isbn) {
        try {
            // Verifica se ISBN já existe
            $checkSql = "SELECT COUNT(*) FROM livros WHERE isbn = :isbn";
            $stmtCheck = $conn->prepare($checkSql);
            $stmtCheck->execute([':isbn' => $isbn]);
            $count = $stmtCheck->fetchColumn();

            if ($count > 0) {
                $message = "ISBN já cadastrado.";
                $class = "error";
            } else {
                $sql = "INSERT INTO livros (titulo, autor, isbn) VALUES (:titulo, :autor, :isbn)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':titulo' => $titulo,
                    ':autor' => $autor,
                    ':isbn' => $isbn
                ]);
                $message = "Livro cadastrado com sucesso!";
                $class = "success";
            }
        } catch (PDOException $e) {
            $message = "Erro ao cadastrar livro: " . $e->getMessage();
            $class = "error";
        }
    } else {
        $message = "Preencha todos os campos.";
        $class = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Resultado do Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff9c4; /* amarelo claro */
            color: #fbc02d; /* amarelo médio */
            padding: 20px;
        }
        .message {
            font-size: 20px;
            margin-top: 20px;
        }
        .error {
            color: #d32f2f;
        }
        .success {
            color: #388e3c;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #fbc02d;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Resultado do Cadastro</h1>
    <p class="message <?php echo $class; ?>"><?php echo htmlspecialchars($message); ?></p>
    <a href="salvar_livro.html">Voltar para o formulário</a>
</body>
</html>
