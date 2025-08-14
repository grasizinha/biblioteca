<?php
header('Content-Type: application/json');
include '../../db.php'; // Ajuste conforme sua estrutura

$titulo = trim($_POST['titulo'] ?? '');
$autor = trim($_POST['autor'] ?? '');
$isbn = trim($_POST['isbn'] ?? '');

try {
    if ($titulo === '' || $autor === '' || $isbn === '') {
        echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos.']);
        exit;
    }

    if (!preg_match('/^[0-9Xx]+$/', $isbn)) {
        echo json_encode(['status' => 'error', 'message' => 'Formato de ISBN inválido.']);
        exit;
    }

    $sql = "INSERT INTO livros (titulo, autor, isbn) VALUES (:titulo, :autor, :isbn)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':isbn' => $isbn
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Livro cadastrado com sucesso!']);
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo json_encode(['status' => 'error', 'message' => 'ISBN já cadastrado.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
    }
}
?>
