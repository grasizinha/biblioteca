<?php
include '../../db.php';

$term = isset($_GET['term']) ? $_GET['term'] : '';

$sql = "SELECT id, nome FROM aluno WHERE nome LIKE :term";
$stmt = $pdo->prepare($sql);
$stmt->execute(['term' => "%$term%"]);

$alunos = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $alunos[] = [
        'id' => $row['id'],
        'text' => $row['nome']
    ];
}

echo json_encode($alunos);
?>
