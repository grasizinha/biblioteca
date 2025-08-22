<?php
include "../db.php"; // Conexão com o banco de dados

$sql = "SELECT 
            emprestimo.id AS id_emprestimo, 
            alunos.nome AS nome_aluno, 
            professores.nome AS nome_professor, 
            livros.titulo AS titulo_livros, 
            emprestimo.data_retirada, 
            emprestimo.data_devolucao 
        FROM emprestimo
        INNER JOIN alunos ON emprestimo.aluno_id = alunos.id
        INNER JOIN professores ON emprestimo.professor_id = professores.id
        INNER JOIN livros ON emprestimo.livro_id = livros.id";

try {
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    die("Erro na consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empréstimos</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background: url("../imagem/tianadsd.jpg") no-repeat center center fixed;
        background-size: cover;
        color: #333;
    }

    h1 {
        text-align: center;
        margin-top: 30px;
        color: #f8e1f4; /* Rosa clarinho */
        text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
        font-family: 'Georgia', serif;
    }

    table {
        width: 80%;
        margin: 30px auto;
        border-collapse: collapse;
        background-color: rgba(100, 65, 164, 0.85); /* Roxo escuro semitransparente */
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
    }

    th, td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.3);
    }

    th {
        background-color: rgba(196, 136, 255, 0.9); /* Lilás vivo */
        color: #fff;
        font-weight: 700;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.4);
    }

    td {
        color: #fdf5fb; /* Rosa bem clarinho */
    }

    tr:hover {
        background-color: rgba(255, 182, 193, 0.3); /* Rosa bebê suave */
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        table {
            width: 95%;
        }
    }
</style>

</head>
<body>

<h1>Lista de Empréstimos</h1>

<?php if ($result->rowCount() > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID Empréstimo</th>
                <th>Aluno</th>
                <th>Professor</th>
                <th>Livro</th>
                <th>Data Retirada</th>
                <th>Data Devolução</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($row["id_emprestimo"]) ?></td>
                    <td><?= htmlspecialchars($row["nome_aluno"]) ?></td>
                    <td><?= htmlspecialchars($row["nome_professor"]) ?></td>
                    <td><?= htmlspecialchars($row["titulo_livros"]) ?></td>
                    <td><?= htmlspecialchars($row["data_retirada"]) ?></td>
                    <td><?= htmlspecialchars($row["data_devolucao"]) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum empréstimo encontrado.</p>
<?php endif; ?>

</body>
</html>

<?php
$pdo = null;
?>