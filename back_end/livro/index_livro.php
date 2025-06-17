<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">
    <h1>Cadastrar Livro</h1>

    <!-- Formulário para criar um novo livro -->
    <form action="livro.php" method="POST" class="form-container">
        <label for="nome_livro">Nome Livro:</label>
        <input type="text" name="nome_livro" id="nome_livro" required><br><br>

        <label for="nome_autor">Nome Autor:</label>
        <input type="text" name="nome_autor" id="nome_autor" required><br><br>

        <button type="submit" class="btn">Cadastrar</button>
    </form>
</div>

<a href="../cadastro.php" class="back-button">
    <button class="btn">
        ←
    </button>
</a>
</body>
</html>