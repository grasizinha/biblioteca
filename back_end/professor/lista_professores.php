<?php
include '../../db.php';  // Conexão com o banco de dados

// Query para buscar todos os professores cadastrados
$sql = "SELECT * FROM professores";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Recuperar os resultados
$professores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Professores</title>
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

    <h1 style="text-align: center;">Lista de Professores Cadastrados</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop para exibir os professores cadastrados
            if(count($professores) > 0) {
                foreach ($professores as $professor) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($professor['id']) . "</td>";  // ID do professor
                    echo "<td>" . htmlspecialchars($professor['nome']) . "</td>";  // Nome do professor
                    echo "<td>" . htmlspecialchars($professor['cpf']) . "</td>";  // CPF do professor
                    echo "<td>" . htmlspecialchars($professor['email']) . "</td>";  // Email do professor
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum professor cadastrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
