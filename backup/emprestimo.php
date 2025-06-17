<?php
include 'verificar_sessao.php';
include 'db.php';

// Buscar todos os alunos e livros para exibir nas listas
$alunos = $pdo->query("SELECT * FROM alunos")->fetchAll();
$livros = $pdo->query("SELECT * FROM livros")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aluno_id = $_POST['aluno_id'];
    $livro_id = $_POST['livro_id'];
    $data_emprestimo = $_POST['data_emprestimo'];
    $data_devolucao = $_POST['data_devolucao'];

    // Inserir o empréstimo no banco de dados
    $stmt = $pdo->prepare("INSERT INTO emprestimos (aluno_id, livro_id, data_emprestimo, data_devolucao) VALUES (:aluno_id, :livro_id, :data_emprestimo, :data_devolucao)");
    $stmt->bindParam(':aluno_id', $aluno_id);
    $stmt->bindParam(':livro_id', $livro_id);
    $stmt->bindParam(':data_emprestimo', $data_emprestimo);
    $stmt->bindParam(':data_devolucao', $data_devolucao);
    $stmt->execute();
}

$emprestimos = $pdo->query("SELECT e.id, a.nome AS aluno, l.titulo AS livro, e.data_emprestimo, e.data_devolucao FROM emprestimos e JOIN alunos a ON e.aluno_id = a.id JOIN livros l ON e.livro_id = l.id")->fetchAll();
?>

<h2>Registrar Empréstimo</h2>
<form method="post" action="">
    <label for="aluno_id">Aluno:</label>
    <select name="aluno_id" required>
        <?php foreach ($alunos as $aluno): ?>
            <option value="<?= $aluno['id'] ?>"><?= $aluno['nome'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="livro_id">Livro:</label>
    <select name="livro_id" required>
        <?php foreach ($livros as $livro): ?>
            <option value="<?= $livro['id'] ?>"><?= $livro['titulo'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="data_emprestimo">Data de Empréstimo:</label>
    <input type="date" name="data_emprestimo" required><br>

    <label for="data_devolucao">Data de Devolução:</label>
    <input type="date" name="data_devolucao" required><br>

    <input type="submit" value="Registrar Empréstimo">
</form>

<h2>Empréstimos Registrados</h2>
<table>
    <tr>
        <th>Aluno</th>
        <th>Livro</th>
        <th>Data de Empréstimo</th>
        <th>Data de Devolução</th>
    </tr>
    <?php foreach ($emprestimos as $emprestimo): ?>
        <tr>
            <td><?= $emprestimo['aluno'] ?></td>
            <td><?= $emprestimo['livro'] ?></td>
            <td><?= $emprestimo['data_emprestimo'] ?></td>
            <td><?= $emprestimo['data_devolucao'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
