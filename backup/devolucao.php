<?php
include 'verificar_sessao.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emprestimo_id = $_POST['emprestimo_id'];
    $data_devolucao = $_POST['data_devolucao'];

    // Atualizar a data de devolução no banco de dados
    $stmt = $pdo->prepare("UPDATE emprestimos SET data_devolucao = :data_devolucao WHERE id = :emprestimo_id");
    $stmt->bindParam(':data_devolucao', $data_devolucao);
    $stmt->bindParam(':emprestimo_id', $emprestimo_id);
    $stmt->execute();
}

$emprestimos_abertos = $pdo->query("SELECT e.id, a.nome AS aluno, l.titulo AS livro, e.data_emprestimo, e.data_devolucao FROM emprestimos e JOIN alunos a ON e.aluno_id = a.id JOIN livros l ON e.livro_id = l.id WHERE e.data_devolucao IS NULL")->fetchAll();
?>

<h2>Registrar Devolução</h2>
<form method="post" action="">
    <label for="emprestimo_id">Empréstimo:</label>
    <select name="emprestimo_id" required>
        <?php foreach ($emprestimos_abertos as $emprestimo): ?>
            <option value="<?= $emprestimo['id'] ?>"><?= $emprestimo['aluno'] ?> - <?= $emprestimo['livro'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="data_devolucao">Data de Devolução:</label>
    <input type="date" name="data_devolucao" required><br>

    <input type="submit" value="Registrar Devolução">
</form>
