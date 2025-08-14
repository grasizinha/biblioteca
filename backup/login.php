<?php
// Incluir o arquivo de conexão
include "conexao.php"; 

// Verificar se o formulário foi enviado para cadastrar um novo professor
if (isset($_POST["cadastrar"])) {
    var_dump($_POST);  // Exibir o conteúdo de $_POST

    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO professores (nome, cpf, email, senha) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Executar a consulta com os parâmetros
    if ($stmt->execute([$nome, $cpf, $email, $senha])) {

    }
}

// Buscar todos os professores cadastrados
$sql = "SELECT * FROM professores";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Professor</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<body>
    <h2>Cadastrar Professor</h2>
    <form method="POST" action="novo_professor.php"> 
        Nome: <input type="text" name="nome" required><br>
        CPF: <input type="text" name="cpf" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
    </form>

    <h2>Professor Cadastrados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>

        <?php 
        if ($result->rowCount() > 0) {  // Alteração para usar rowCount()
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["nome"]; ?></td>
                    <td><?php echo $row["cpf"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $row["id"]; ?>">Editar</a> |
                        <a href="index.php?excluir=<?php echo $row["id"]; ?>" onclick="return confirm('Tem certeza?');">Excluir</a>
                    </td>
                </tr>
        <?php } 
        } else { ?>
            <tr><td colspan="5">Nenhum professor cadastrado.</td></tr>
        <?php } ?>
    </table>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo Bootstrap</title>
</head>
</html>
