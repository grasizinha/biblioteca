<?php
include '../db.php';  // Conexão com o banco de dados

// Query para buscar todos os alunos cadastrados
$biblioteca = "SELECT * FROM professores";
$stmt = $pdo->prepare($biblioteca);
$stmt->execute();

// Recuperar os resultados
$professores = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop para exibir os alunos cadastrados
            if(count($professores) > 0) {
                foreach ($professores as $professor) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($professor['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($professor['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($professor['cpf']) . "</td>";
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
