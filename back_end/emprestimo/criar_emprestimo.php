<?php
include '../../db.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    die("Erro: sessão expirada ou usuário não autenticado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valida e captura os dados do formulário
    $aluno_id = $_POST['aluno_id'] ?? null;
    $livro_id = $_POST['livro_id'] ?? null;
    $data_retirada = $_POST['data_retirada'] ?? null;
    $data_devolucao = $_POST['data_devolucao'] ?? null;
    $professor_id = $_SESSION['id'];

    // Valida as datas
    if (strtotime($data_devolucao) < strtotime($data_retirada)) {
        echo "<script>alert('Erro: A data de devolução não pode ser anterior à data de retirada.');</script>";
    } else {
        try {
            $sql = "INSERT INTO emprestimos (aluno_id, livro_id, data_retirada, data_devolucao, professor_id)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$aluno_id, $livro_id, $data_retirada, $data_devolucao, $professor_id]);

            echo "<script>alert('Empréstimo registrado com sucesso!');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Erro ao registrar o empréstimo: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Emprestimo de Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<style>
       body {
    font-family: Arial, sans-serif;
    background-color: #fff59d; /* fundo amarelo claro */
    color: #f9d976;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    width: 1040px;  /* +50% da largura base 560px */
    padding: 40px 60px; /* aumenta mais a largura (60px horizontal, 40px vertical) */
    box-sizing: border-box;
}

form {
    background-color: #ffffff; /* formulário branco */
    padding: 90px;
    border-radius: 20px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    width: 100%; /* ocupa toda largura do container */
    box-sizing: border-box;
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
    width: 200%;
}

/* Bordas amarelas nas caixas */
input[type="date"], select, input[type="text"], input[type="varchar"] {
    width: 100%;
    padding: 8px;
    margin: 4px 0 20px 0;
    border: 2px solid #f9d976;  /* borda amarela média */
    border-radius: 4px;
    box-sizing: border-box;
}

/* Botões com cor amarelo um pouco mais forte */
button, input[type="submit"], .btn-primary, .btn-outline-warning {
    background-color: #f9d976; /* amarelo médio */
    color: #333;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
    width: 100%;
    box-sizing: border-box;
    text-align: center;
}

button:hover, input[type="submit"]:hover, .btn-primary:hover, .btn-outline-warning:hover {
    background-color: #fff59d; /* amarelo mais claro no hover */
}

/* Botão voltar */
.btn-outline-warning {
    max-width: 250px;
    margin: 30px auto 0 auto;
    display: block;
    text-decoration: none;
    text-align: center;
}



    </style>
<body>

<!-- <h1>Ficha de Controle Empréstimo de Livro Sala de Leitura</h1> -->
<div class="container">
    <h2 class="text-center">Ficha de Controle Empréstimo de Livro Sala de Leitura</h2>
    <form action="criar_emprestimo.php" method="POST" class="form-container">
        <!-- Campo Aluno -->
        <div class="mb-3">
            <label for="aluno_id" class="form-label">Aluno:</label>
            <select name="aluno_id" id="aluno_id" class="form-select" required></select>
        </div>

        <!-- Campo Livro -->
        <div class="mb-3">
            <label for="livro_id" class="form-label">Livro:</label>
            <select name="livro_id" id="livro_id" class="form-select" required></select>
        </div>

        <!-- Datas -->
        <div class="mb-3">
            <label for="data_emprestimo" class="form-label">Data de Empréstimo:</label>
            <input type="date" name="data_retirada" id="data_emprestimo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="data_devolucao" class="form-label">Data de Devolução:</label>
            <input type="date" name="data_devolucao" id="data_devolucao" class="form-control" required>
        </div>

        <!-- Botão -->
        <button type="submit" class="btn btn-gradient w-100">Registrar Empréstimo</button>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    function initSelect2(selector, url, placeholderText) {
        $(selector).select2({
            placeholder: placeholderText,
            allowClear: false,  // Desabilitar o "x" para limpar a seleção
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term // texto digitado
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.id,    // id do aluno ou livro
                                text: item.text  // o nome do aluno ou livro que deve aparecer no select
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            language: {
                inputTooShort: function () {
                    return "Digite pelo menos 1 caractere";
                },
                noResults: function () {
                    return "Nenhum resultado encontrado";
                }
            }
        }).val(null).trigger("change");  // Garantir que o valor do select seja vazio ao iniciar
    }

    initSelect2('#aluno_id', 'buscar_aluno.php', 'Digite o nome do aluno');
    initSelect2('#livro_id', 'buscar_livro.php', 'Digite o nome do livro');
});
</script>

</body>
</html>

<a href="../../backup/inicial.php" class="back-button">
    <button class="btn">
        ←
    </button>
</a>