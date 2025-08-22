<?php
session_start();
include "../db.php";

if (isset($_POST["registrar_emprestimo"])) {
    $aluno_id = $_POST["aluno_id"];
    $professor_id = $_POST["professor_id"];
    $livro_id = $_POST["livro_id"];
    $data_emprestimo = $_POST["data_emprestimo"];
    $data_devolucao = $_POST["data_devolucao"];

    if (isset($_SESSION['professor_id'])) {
        if ($data_devolucao < $data_emprestimo) {
            echo "<script>alert('Erro: A data de devolução não pode ser anterior à data de empréstimo.');</script>";
        } else {
            $sql = "INSERT INTO emprestimo (aluno_id, livro_id, professor_id, data_retirada, data_devolucao) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$aluno_id, $livro_id, $professor_id, $data_emprestimo, $data_devolucao])) {
                echo "<script>
                        alert('Empréstimo registrado com sucesso!');
                        window.location.href = 'criar_emprestimo.php';
                      </script>";
            } else {
                echo "<script>alert('Erro ao registrar empréstimo!');</script>";
            }
        }
    } else {
        echo "<script>alert('Erro: Professor não está logado.');</script>";
    }
}

// Buscar dados
$sql_alunos = "SELECT * FROM alunos";
$result_alunos = $pdo->query($sql_alunos);

$sql_livros = "SELECT * FROM livros";
$result_livros = $pdo->query($sql_livros);

$sql_professores = "SELECT * FROM professores";
$result_professores = $pdo->query($sql_professores);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Registrar Empréstimo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: url('../imagem/grasii.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            background-color: rgba(226, 233, 235, 0.85);
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 8px 20px rgba(108, 145, 160, 0.3);
            backdrop-filter: blur(5px);
            display: flex;
            flex-direction: column;
        }

        h3 {
            text-align: center;
            color: rgb(31, 67, 111);
            margin-top: 0;
            font-size: 1.5rem;
        }

        label {
            font-weight: bold;
            color: rgb(46, 120, 120);
            margin-bottom: 6px;
            margin-top: 12px;
        }

        select,
        input[type="date"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid rgb(90, 192, 226);
            font-size: 1rem;
            background-color: rgb(227, 227, 236);
            transition: all 0.3s ease;
        }

        select:focus,
        input[type="date"]:focus,
        button:focus {
            outline: none;
            border-color: rgb(45, 167, 200);
            box-shadow: 0 0 8px rgb(90, 107, 214);
        }

        button {
            background-color: rgb(70, 114, 130);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: rgb(112, 203, 225);
            transform: scale(1.05);
        }

        .botao-voltar {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            font-size: 1.5rem;
            color: white;
            background-color: rgba(0,0,0,0.3);
            padding: 5px 10px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .botao-voltar:hover {
            background-color: rgba(0,0,0,0.5);
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <a href="../inicial.php" class="botao-voltar" title="Voltar">&#8592; Voltar</a>

    <form method="POST">
        <h3>Registrar Empréstimo</h3>

        <label for="aluno_id">Aluno:</label>
        <select name="aluno_id" required>
            <?php while ($row = $result_alunos->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
            <?php } ?>
        </select>

        <label for="professor_id">Professor:</label>
        <select name="professor_id" required>
            <?php while ($row = $result_professores->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
            <?php } ?>
        </select>

        <label for="livro_id">Livro:</label>
        <select name="livro_id" required>
            <?php while ($row = $result_livros->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['titulo'] ?></option>
            <?php } ?>
        </select>

        <label for="data_emprestimo">Data de Empréstimo:</label>
        <input type="date" name="data_emprestimo" required>

        <label for="data_devolucao">Data de Devolução:</label>
        <input type="date" name="data_devolucao" required>

        <button type="submit" name="registrar_emprestimo">Registrar Empréstimo</button>
    </form>
</body>

</html>

<?php $pdo = null; ?>
