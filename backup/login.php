 <?php
 session_start();
// include '../db.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $email = trim($_POST['email']);
//     $senha = trim($_POST['senha']);


//     $stmt = $pdo->prepare("SELECT * FROM professores WHERE email = :email");
//     $stmt->bindParam(':email', $email);
//     $stmt->execute();
//     $professor = $stmt->fetch(PDO::FETCH_ASSOC);

//     if (password_verify($senha, $professor['senha'])) {
//         $_SESSION['professor_id'] = $professor['id'];
//         header("Location: dashboard.php");
//         var_dump($email);
//         var_dump($senha);
//         var_dump($email);
//         exit;
//     } else {
//         var_dump($senha);
//         var_dump($professor["senha"]);
//         $erro = "Email ou senha inválidos!";
//     }
// }
 




// esta pagina confere no banco de dados a o email e a senha, e confere, depois inicia a sessão pegando o ID do professor para 

include '../db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $conn = new mysqli("localhost", "root", "", "biblioteca");

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM professores WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $tr=password_verify($senha, $row['senha']);
        var_dump($row['senha']);


        // Comparar a senha diretamente, pois não está usando hash
        if ($tr) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['nome'];
            $_SESSION['id'] = $row['id'];
            //var_dump($row['nome']);
            header("Location: inicial.php");
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
    
    $conn->close();
}

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit" class="btn">Entrar</button>

    </form>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    
       
   <?php 

// <style>
// /* Reset básico */
//  {
//     margin: 0;
//     padding: 0;
//     box-sizing: border-box;
// }

// /* Estilos do corpo */
// body {
//     font-family: 'Roboto', sans-serif;
//     background-color: #e3f2fd;
//     display: flex;
//     justify-content: center;
//     align-items: center;
//     height: 100vh;
// }

// /* Container do formulário */
// .login-container {
//     background-color: #fff;
//     padding: 40px;
//     border-radius: 10px;
//     box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
//     width: 100%;
//     max-width: 500px;
// }

// /* Título */
// h1 {
//     text-align: center;
//     color: #333;
//     margin-bottom: 20px;
// }

// /* Grupo de inputs */
// .input-group {
//     margin-bottom: 20px;
// }

// .input-group label {
//     display: block;
//     margin-bottom: 5px;
//     font-weight: 500;
//     color: #555;
// }

// .input-group input {
//     width: 97%;
//     padding: 10px;
//     border: 1px solid #ccc;
//     border-radius: 5px;
//     font-size: 16px;
//     color: #333;
// }

// /* Botão de submit */
// button {
//     width: 102%;
//     padding: 12px;
//     background-color: #1976d2;
//     color: white;
//     border: none;
//     border-radius: 5px;
//     font-size: 16px;
//     cursor: pointer;
//     transition: background-color 0.3s;
// }

// button:hover {
//     background-color: #1565c0;
// }

// /* Mensagem de erro */
// .error {
//     background-color: #f8d7da;
//     color: #721c24;
//     padding: 10px;
//     border-radius: 5px;
//     margin-bottom: 20px;
//     text-align: center;
// }
// </style>

