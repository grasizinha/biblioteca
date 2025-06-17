<?php
include "../../db.php"; // Não esqueça do ponto e vírgula!

$sql = "SELECT 
            emprestimo.id AS id_emprestimo, 
            aluno.nome AS nome_aluno, 
            professores.nome AS nome_professor, 
            livro.titulo AS titulo_livro, 
            emprestimo.data_retirada, 
            emprestimo.data_devolucao 
        FROM emprestimo
        INNER JOIN aluno ON emprestimo.aluno_id = aluno.id
        INNER JOIN professores ON emprestimo.professor_id = professores.id
        INNER JOIN livro ON emprestimo.livro_id = livro.id";

try {
    $result = $pdo->query($sql);

    if ($result->rowCount() > 0) {
        echo "<h1>Lista de Empréstimos</h1>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>
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
                <tbody>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["id_emprestimo"]) . "</td>
                    <td>" . htmlspecialchars($row["nome_aluno"]) . "</td>
                    <td>" . htmlspecialchars($row["nome_professor"]) . "</td>
                    <td>" . htmlspecialchars($row["titulo_livro"]) . "</td>
                    <td>" . htmlspecialchars($row["data_retirada"]) . "</td>
                    <td>" . htmlspecialchars($row["data_devolucao"]) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "Nenhum empréstimo encontrado.";
    }
} catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
}

$pdo = null;
?>
