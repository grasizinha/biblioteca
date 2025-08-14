<?php
include 'verificar_sessao.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];

    $stmt = $pdo->prepare("INSERT INTO alunos (nome, matricula) VALUES (:nome, :matricula)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':matricula', $matricula);
    $stmt->execute();
}

$alunos = $pdo->query("SELECT * FROM alunos")->fetchAll();
?>

<h2>Cadastrar Aluno</h2>
<form method="post" action="">
    Nome: <input type="text" name="nome" required><br>
    Matrícula: <input type="text" name="matricula" required><br>
    <input type="submit" value="Cadastrar">
</form>

<h2>Lista de Alunos</h2>
<table>
    <tr>
        <th>Nome</th>
        <th>Matrícula</th>
    </tr>
    <?php foreach ($alunos as $aluno): ?>
        <tr>
            <td><?= $aluno['nome'] ?></td>
            <td><?= $aluno['matricula'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
