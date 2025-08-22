<?php
include "relatorios_back.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link rel="stylesheet" href="../estilos/estilos.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Alunos
            var dataAlunos = google.visualization.arrayToDataTable([
                ['Aluno', 'Empréstimos'],
                <?php foreach ($resultAlunos as $row) { echo "['" . addslashes($row['aluno_nome']) . "', " . $row['total'] . "],"; } ?>
            ]);
            var chartAlunos = new google.visualization.PieChart(document.getElementById('chart_alunos'));
            chartAlunos.draw(dataAlunos, { title: 'Alunos que mais leram', pieHole: 0.4 });

            // Livros
            var dataLivros = google.visualization.arrayToDataTable([
                ['Livro', 'Empréstimos'],
                <?php foreach ($resultLivros as $row) { echo "['" . addslashes($row['livro_titulo']) . "', " . $row['total'] . "],"; } ?>
            ]);
            var chartLivros = new google.visualization.PieChart(document.getElementById('chart_livros'));
            chartLivros.draw(dataLivros, { title: 'Livros mais lidos', pieHole: 0.4 });

            // Turmas
            var dataTurmas = google.visualization.arrayToDataTable([
                ['Turma', 'Empréstimos'],
                <?php foreach ($resultTurmas as $row) { echo "['" . addslashes($row['turma_nome']) . "', " . $row['total'] . "],"; } ?>
            ]);
            var chartTurmas = new google.visualization.PieChart(document.getElementById('chart_turmas'));
            chartTurmas.draw(dataTurmas, { title: 'Turmas com mais empréstimos', pieHole: 0.4 });
        }
    </script>
</head>
<body>
    <div style="display: flex; gap: 20px;">
        <!-- Área dos gráficos -->
        <div style="flex: 2; display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div id="chart_alunos" style="width: 100%; height: 300px;"></div>
            <div id="chart_livros" style="width: 100%; height: 300px;"></div>
            <div id="chart_turmas" style="width: 100%; height: 300px;"></div>
        </div>

            <!-- Botão de voltar -->
    <div style="grid-column: 1 / 3; margin-top: 10px; text-align: left;">
        <button onclick="window.location.href='../backup/listas_gerais.php'" 
            style="padding: 10px 20px; background-color:rgb(97, 66, 182); color: #fff; border: none; border-radius: 5px; cursor: pointer;">
            Voltar
        </button>
    </div>

        <!-- Área das observações -->
        <div style="flex: 1; border: 1px solid #ccc; padding: 10px; display: flex; flex-direction: column; max-height: 640px;">
            <h3>Observações dos Professores</h3>

            <div style="flex: 1; overflow-y: auto; margin-bottom: 10px;">
                <?php if ($temObservacoes): ?>
                    <?php foreach ($resultObservacoes as $obs): ?>
                        <div style="border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 10px; background-color: #f9f9f9;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <strong><?php echo htmlspecialchars($obs['professor_nome']); ?></strong>
                                <small style="color: #666;"><?php echo date('d/m/Y H:i', strtotime($obs['data_brasil'])); ?></small>
                            </div>
                            <p style="margin: 0;"><?php echo nl2br(htmlspecialchars($obs['texto'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma observação encontrada.</p>
                <?php endif; ?>
            </div>

            <!-- Botão para registrar observação -->
            <div style="text-align: center;">
                <button onclick="window.location.href='registrar_observacao.php'" 
                        style="padding: 10px 20px; background-color: #4CAF50; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                    Registrar Observação
                </button>
            </div>
        </div>
    </div>
</body>
</html>