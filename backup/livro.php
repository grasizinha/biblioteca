<?php
include 'verificar_sessao.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];

    $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";
    $response = file_get_contents($url);
    $bookData = json_decode($response, true);

    if (isset($bookData['items'][0])) {
        $book = $bookData['items'][0]['volumeInfo'];
        $titulo = $book['title'];
        $autor = implode(", ", $book['authors']);
        $ano = $book['publishedDate'];

        $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, isbn, ano) VALUES (:titulo, :autor, :isbn, :ano)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->bindParam(':ano', $ano);
        $stmt->execute();
    } else {
        echo "Livro não encontrado!";
    }
}

$livros = $pdo->query("SELECT * FROM livros")->fetchAll();
?>

<h2>Cadastrar Livro</h2>
<form method="post" action="">
    ISBN: <input type="text" name="isbn" required><br>
    <input type="submit" value="Cadastrar">
</form>

<h2>Lista de Livros</h2>
<table>
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Ano</th>
    </tr>
    <?php foreach ($livros as $livro): ?>
        <tr>
            <td><?= $livro['titulo'] ?></td>
            <td><?= $livro['autor'] ?></td>
            <td><?= $livro['ano'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
