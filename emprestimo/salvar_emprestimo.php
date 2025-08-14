<?php
// Conexão com PDO (arquivo separável ou inline)
$host = 'localhost';
$db   = 'biblioteca';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
$pdo = new PDO($dsn, $user, $pass, $options);

try {
    // obter dados do formulário
    $aluno_id = $_POST['id_aluno'] ?? null;
    $data_retirada = $_POST['data_retirada'] ?? null;
    $data_devolucao = $_POST['data_devolucao'] ?? null;

    if (empty($id_aluno) || empty($data_retirada) || empty($data_devolucao)) {
        throw new Exception("Dados obrigatórios ausentes: aluno, data de retirada ou devolução.");
    }

    // consulta aluno
    $sql_aluno = "SELECT * FROM alunos WHERE id = :id";
    $stmt = $pdo->prepare($sql_aluno);
    $stmt->execute([':id' => $aluno_id]);
    $aluno = $stmt->fetch();
    if (!$aluno) {
        throw new Exception("Aluno não encontrado (ID {$aluno_id}).");
    }

    // insere na tabela empréstimos
    $sql_emp = "INSERT INTO emprestimos (aluno_id, data_retirada, data_devolucao, status) VALUES (:aluno_id, :retirada, :devolucao, 'O')";
    $stmt2 = $pdo->prepare($sql_emp);
    $stmt2->execute([
        ':aluno_id'   => $aluno_id,
        ':retirada'   => $data_retirada,
        ':devolucao'  => $data_devolucao
    ]);
    $emprestimo_id = $pdo->lastInsertId();

    echo "Empréstimo registrado com sucesso! ID: {$emprestimo_id}";

} catch (Exception $e) {
    echo "Erro: " . htmlspecialchars($e->getMessage());
}
?>