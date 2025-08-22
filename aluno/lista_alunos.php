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
