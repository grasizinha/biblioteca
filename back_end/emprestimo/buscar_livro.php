<?php
include '../../db.php';

$term = isset($_GET['term']) ? $_GET['term'] : '';

$sql = "SELECT id, titulo FROM livro WHERE titulo LIKE :term";
$stmt = $pdo->prepare($sql);
$stmt->execute(['term' => "%$term%"]);

$livros = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $livros[] = [
        'id' => $row['id'],
        'text' => $row['titulo']
    ];
}

echo json_encode($livros);
?>
