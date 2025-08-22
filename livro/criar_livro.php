<?php
header('Content-Type: application/json');
include '../db.php'; // Ajuste conforme sua estrutura

$titulo = trim($_POST['titulo'] ?? '');
$autor = trim($_POST['autor'] ?? '');
$isbn = trim($_POST['isbn'] ?? '');

// Título e autor continuam obrigatórios
if ($titulo === '' || $autor === '') {
    echo json_encode(['status' => 'error', 'message' => 'Preencha título e autor.']);
    exit;
}

// ISBN só valida se houver valor
if ($isbn !== '' && !preg_match('/^[0-9Xx]+$/', $isbn)) {
    echo json_encode(['status' => 'error', 'message' => 'Formato de ISBN inválido.']);
    exit;
}

try {
    $sql = "INSERT INTO livros (titulo, autor, isbn) VALUES (:titulo, :autor, :isbn)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':isbn' => $isbn ?: null  // Se vazio, salva NULL no banco
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