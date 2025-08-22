<?php
include '../db.php';

$livro = $_GET['livro'] ?? '';
$results = [];
$message = '';

if ($livro) {
    $query = urlencode($livro);
    $url = "https://www.googleapis.com/books/v1/volumes?q={$query}&maxResults=10";
    $response = file_get_contents($url);

    if ($response) {
        $data = json_decode($response, true);
        if (!empty($data['items'])) {
            $results = $data['items'];
        }
    }
}

// Salvar livro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_book'])) {
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? null;
    $isbn = $_POST['isbn'] ?? null;

    if ($titulo) { // agora apenas título é obrigatório
        try {
            $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, isbn) VALUES (:titulo, :autor, :isbn)");
            $stmt->execute([
                ':titulo' => $titulo,
                ':autor'  => $autor,
                ':isbn'   => $isbn
            ]);
            $message = ['type' => 'success', 'text' => 'Livro salvo com sucesso!'];
        } catch (PDOException $e) {
            $message = ['type' => 'error', 'text' => 'Erro ao salvar o livro: ' . $e->getMessage()];
        }
    } else {
        $message = ['type' => 'error', 'text' => 'Título é obrigatório.'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Busca de Livros</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    background-image: url('../imagem/grasii.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 2rem;
    color: #fff;
}

.container {
    background: rgba(255 255 255 / 0.15);
    border-radius: 12px;
    padding: 1.5rem 2rem;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 12px 24px rgba(118, 75, 162, 0.6);
    backdrop-filter: blur(10px);
}

h1 {
    margin: 0 0 1rem;
    font-weight: 600;
    text-align: center;
    letter-spacing: 0.05em;
}

input[type="search"] {
    width: 100%;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    border: none;
    outline: none;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    background-color: rgba(255 255 255 / 0.25);
    color: #fff;
    transition: background-color 0.3s ease;
}

input[type="search"]:focus {
    background-color: rgba(255 255 255 / 0.4);
    box-shadow: 0 0 10px #764ba2;
}

.results {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 400px;
    overflow-y: auto;
}

.book {
    display: flex;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 12px;
    align-items: center;
    transition: background-color 0.3s;
}

.book:hover {
    background-color: rgba(0, 0, 0, 0.45);
}

.book img {
    width: 60px;
    height: auto;
    border-radius: 6px;
    flex-shrink: 0;
    margin-right: 16px;
}

.book-info {
    flex: 1;
}

.book-title {
    font-weight: 600;
    font-size: 1rem;
    margin: 0 0 6px;
    color: #ffd700;
}

.book-authors, .book-isbn {
    margin: 0;
    font-size: 0.9rem;
    color: #ddd;
    margin-bottom: 4px;
}

.save-btn {
    background-color: #764ba2;
    border: none;
    color: #f0f0f5;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
    user-select: none;
}

.save-btn:hover:enabled {
    background-color: #667eea;
}

.save-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.message {
    margin-top: 1rem;
    font-weight: 600;
    text-align: center;
    padding: 0.75rem;
    border-radius: 8px;
    user-select: none;
}

.message.success {
    background-color: #2ecc71;
    color: white;
}

.message.error {
    background-color: #e74c3c;
    color: white;
}

.no-results {
    text-align: center;
    margin-top: 2rem;
    color: #eee;
    font-style: italic;
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
</style>
</head>
<body>

<a href="../inicial.php" class="botao-voltar" title="Voltar">&#8592; Voltar</a>

<div class="container">
    <h1>Busca de Livros</h1>

    <?php if($message): ?>
        <div class="message <?= $message['type'] ?>"><?= $message['text'] ?></div>
    <?php endif; ?>

    <form method="get">
        <input type="search" name="livro" placeholder="Digite o nome do livro" value="<?= htmlspecialchars($livro) ?>" required>
    </form>

    <?php if($livro): ?>
        <?php if($results): ?>
            <ul class="results">
                <?php foreach($results as $book): 
                    $info = $book['volumeInfo'];
                    $titulo = $info['title'] ?? '';
                    $autor = isset($info['authors']) ? implode(', ', $info['authors']) : 'Desconhecido';
                    $isbn = $info['industryIdentifiers'][0]['identifier'] ?? 'N/A';
                ?>
                    <li class="book">
                        <?php if(!empty($info['imageLinks']['thumbnail'])): ?>
                            <img src="<?= $info['imageLinks']['thumbnail'] ?>" alt="<?= htmlspecialchars($titulo) ?>">
                        <?php endif; ?>
                        <div class="book-info">
                            <div class="book-title"><?= htmlspecialchars($titulo) ?></div>
                            <div class="book-authors">Autor: <?= htmlspecialchars($autor) ?></div>
                            <div class="book-isbn">ISBN: <?= htmlspecialchars($isbn) ?></div>
                            <form method="post" style="margin:0;">
                                <input type="hidden" name="titulo" value="<?= htmlspecialchars($titulo) ?>">
                                <input type="hidden" name="autor" value="<?= htmlspecialchars($autor) ?>">
                                <input type="hidden" name="isbn" value="<?= htmlspecialchars($isbn) ?>">
                                <button type="submit" name="save_book" class="save-btn">Salvar Livro</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="no-results">Nenhum livro encontrado.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>