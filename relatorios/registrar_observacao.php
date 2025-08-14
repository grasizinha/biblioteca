<?php
include "../db.php"; // Conexão PDO

// Inicializa variáveis
$erro = "";
$sucesso = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $professor_id = $_POST['professor_id'] ?? '';
    $texto = trim($_POST['texto'] ?? '');

    if (!$professor_id || !$texto) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO observacoes (id_professor, texto) VALUES (:id_professor, :texto)");
            $stmt->execute([
                ':id_professor' => $professor_id,
                ':texto' => $texto
            ]);
            $sucesso = "Observação registrada com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao registrar observação: " . $e->getMessage();
        }
    }
}

// Busca lista de professores para o select
$stmtProfessores = $pdo->query("SELECT id, nome FROM professores ORDER BY nome");
$professores = $stmtProfessores->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Observação</title>
    <link rel="stylesheet" href="../estilos/estilos.css">
</head>
<body>
    <div style="max-width: 500px; margin: 50px auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px;">
        <h2>Registrar Observação</h2>

        <?php if ($erro): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($sucesso); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 10px;">
                <label for="professor_id">Professor:</label>
                <select name="professor_id" id="professor_id" style="width: 100%; padding: 5px;">
                    <option value="">Selecione</option>
                    <?php foreach ($professores as $prof): ?>
                        <option value="<?php echo $prof['id']; ?>"><?php echo htmlspecialchars($prof['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="texto">Observação:</label>
                <textarea name="texto" id="texto" rows="5" style="width: 100%; padding: 5px;"></textarea>
            </div>

            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                Registrar
            </button>
        </form>

        <div style="margin-top: 15px;">
            <a href="relatorios_front.php" style="color: #007BFF; text-decoration: none;">&laquo; Voltar para Relatórios</a>
        </div>
    </div>
</body>
</html>