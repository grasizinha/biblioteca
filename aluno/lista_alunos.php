<?php
include '../db.php';  // Conexão com o banco de dados

// Query para buscar todos os alunos cadastrados
$biblioteca = "SELECT * FROM alunos";
$stmt = $pdo->prepare($biblioteca);
$stmt->execute();

// Recuperar os resultados
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Lista de Alunos Cadastrados</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Série</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop para exibir os alunos cadastrados
            if(count($alunos) > 0) {
                foreach ($alunos as $aluno) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($aluno['id']) . "</td>";  // ID do aluno
                    echo "<td>" . htmlspecialchars($aluno['nome']) . "</td>";  // Nome do aluno
                    echo "<td>" . htmlspecialchars($aluno['email']) . "</td>";  // Email do aluno
                    echo "<td>" . htmlspecialchars($aluno['serie']) . "</td>";  // Série do aluno
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum aluno cadastrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
