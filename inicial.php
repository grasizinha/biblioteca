<?php session_start(); 
include './db.php'; // Inclui o arquivo de conexão com o banco de dados
if (!isset($_SESSION['nome'])) {
    header("Location: index.php"); // Redireciona para a página de login se não estiver logado
    exit();
}
// Verifica se a sessão está ativa e se o usuário está logado
if (!isset($_SESSION['nome'])) {
    header("Location: index.php"); // Redireciona para a página de login se não estiver logado
    exit();
} else {
    // Se a sessão estiver ativa, você pode acessar o nome do usuário
    $nomeUsuario = $_SESSION['nome'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Botões da Biblioteca</title>
    <style>
        body {
            display: flex;
            justify-content: center; /* Centraliza os elementos horizontalmente */
            align-items: flex-end; /* Alinha os itens à parte inferior da tela */
            height: 100vh;
            margin: 0;
            background-image: url('imagem/wp1904655.jpg'); /* Caminho da sua imagem */
            background-size: 100%; /* Diminui o tamanho da imagem (ajuste conforme necessário) */
            background-position: center;
            background-repeat: no-repeat; /* Evita que a imagem se repita */
        }

        .container {
            text-align: center;
            width: 30%; /* Largura do container de botões */
            padding: 50px; /* Espaçamento interno, ajustável */
            z-index: 1; /* Garante que o conteúdo fique sobre a imagem */
        }

        .botao {
            padding: 15px 30px;
            margin: 10px 0;
            font-size: 18px;
            background-color:rgb(57, 114, 161); /* Gradiente princesa */
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            transition: background 0.3s, transform 0.3s;
            box-shadow: 0 4px 8px rgba(9, 102, 134, 0.2);
        }

        .botao:hover {
            background: linear-gradient(135deg,rgb(40, 145, 180),rgb(35, 166, 202),rgb(22, 124, 153)); /* Inverte o gradiente ao passar o mouse */
            transform: translateY(-2px); /* Pequeno efeito de elevação */
        }
    </style>
</head>
<body>
    
    <div class="container">
    <h2>Bem Vindo, <?php echo $_SESSION['nome']; ?> </h2>
        <a href="./emprestimo/criar_emprestimo.php" class="botao">Empréstimo</a>
        <a href="./livro/buscar_livro.php" class="botao">Buscar Livro</a>
        <a href="./professor/criar_professor.php" class="botao">Cadastros professor</a>
        <a href="./aluno/criar_aluno.php" class="botao">Cadastros aluno</a>
        <a href="./backup/listas_gerais.php" class="botao">Listas Gerais</a>
    </div>

</body>
</html>
