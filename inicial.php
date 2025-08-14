<?php session_start(); ?>
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
            background-image: url('codigo da foto'); /* Caminho da sua imagem */
            background-size: 100%; /* Diminui o tamanho da imagem (ajuste conforme necessário) */
            background-position: center 15%; /* Move a imagem para baixo (ajuste o valor conforme necessário) */
            background-repeat: no-repeat; /* Evita que a imagem se repita */
        }

        .container {
            text-align: center;
            width: 30%; /* Largura do container de botões */
            padding: 20px; /* Espaçamento interno, ajustável */
            z-index: 1; /* Garante que o conteúdo fique sobre a imagem */
        }

        .botao {
            padding: 15px 30px;
            margin: 10px 0; /* Espaçamento entre os botões */
            font-size: 18px;
            background-color: rgba(255, 255,149); /* Azul com transparência */
            color: black;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            width: 100%; /* Faz os botões ocuparem toda a largura do container */
            transition: background-color 0.3s;
        }

        .botao:hover {
            background-color: rgba(255, 255, 176); /* Azul mais escuro com transparência */
        }
    </style>
</head>
<body>
    
    <div class="container">
    <?php echo $_SESSION['nome']; ?>
        <a href="./emprestimo/criar_emprestimo.php" class="botao">Empréstimo</a>
        <a href="./livro/buscar_livro.php" class="botao">Buscar Livro</a>
        <a href="./professor/criar_professor.php" class="botao">Cadastros professor</a>
        <a href="./aluno/criar_aluno.php" class="botao">Cadastros aluno</a>
        <a href="./backup/listas_gerais.php" class="botao">Listas Gerais</a>
    </div>

</body>
</html>
