<?php
include __DIR__ . '/../db.php'; // mantém conexão PDO

date_default_timezone_set('America/Sao_Paulo');

// Consulta 1: Alunos que mais leram
$sqlAlunos = "SELECT a.nome AS aluno_nome, COUNT(e.id) AS total
              FROM emprestimo e
              JOIN alunos a ON e.aluno_id = a.id
              GROUP BY e.aluno_id
              ORDER BY total DESC
              LIMIT 5";
$stmtAlunos = $pdo->query($sqlAlunos);
$resultAlunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);
$temAlunos = count($resultAlunos) > 0;

// Consulta 2: Livros mais lidos
$sqlLivros = "SELECT l.titulo AS livro_titulo, COUNT(e.id) AS total
              FROM emprestimo e
              JOIN livros l ON e.livro_id = l.id
              GROUP BY e.livro_id
              ORDER BY total DESC
              LIMIT 5";
$stmtLivros = $pdo->query($sqlLivros);
$resultLivros = $stmtLivros->fetchAll(PDO::FETCH_ASSOC);
$temLivros = count($resultLivros) > 0;

// Consulta 3: Séries/Turmas com mais empréstimos
// Usando 'serie' da tabela alunos como referência de turma
$sqlTurmas = "SELECT a.serie AS turma_nome, COUNT(e.id) AS total
              FROM emprestimo e
              JOIN alunos a ON e.aluno_id = a.id
              GROUP BY a.serie
              ORDER BY total DESC
              LIMIT 5";
$stmtTurmas = $pdo->query($sqlTurmas);
$resultTurmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);
$temTurmas = count($resultTurmas) > 0;

// Consulta para observações
$sqlObservacoes = "SELECT n.id, n.texto, n.data, p.nome AS professor_nome,
                          CONVERT_TZ(n.data, '+00:00', '-03:00') AS data_brasil
                   FROM observacoes n
                   JOIN professores p ON n.id_professor = p.id
                   ORDER BY n.data DESC";
$stmtObservacoes = $pdo->query($sqlObservacoes);
$resultObservacoes = $stmtObservacoes->fetchAll(PDO::FETCH_ASSOC);
$temObservacoes = count($resultObservacoes) > 0;
?>