<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Principal</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: Arial, sans-serif;
      background: url("https://dentrodachamine.files.wordpress.com/2015/01/tiaelotteprincesas.png") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: flex-start; /* Mantém o menu na esquerda */
      align-items: center;
    }

    .menu {
      background: rgba(255, 255, 255, 0.9); /* Fundo branco translúcido */
      padding: 30px;
      border-radius: 15px;
      margin-left: 50px; /* Espaço da borda esquerda */
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    .menu h1 {
      margin-bottom: 25px;
      color:rgb(210, 87, 169);
      font-size: 26px;
    }

    .botao {
      display: block;
      width: 220px;
      margin: 12px auto;
      padding: 12px;
      text-decoration: none;
      background: linear-gradient(45deg,rgb(220, 108, 205),rgb(207, 113, 194)); /* Degradê roxo */
      color: white;
      font-weight: bold;
      border-radius: 10px;
      text-align: center;
      transition: 0.3s ease;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
    }

    .botao:hover {
      background: linear-gradient(45deg,rgb(214, 135, 211),rgb(145, 93, 143));
      transform: scale(1.05);
    }

    /* Responsivo */
    @media (max-width: 768px) {
      body {
        justify-content: center; /* Centraliza em telas pequenas */
        padding: 20px;
      }
      .menu {
        margin-left: 0;
        width: 100%;
        max-width: 320px;
      }
      .botao {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="menu">
    <h1>Menu Principal</h1>
    <a href="../aluno/lista_alunos.php" class="botao">Lista de Alunos</a>
    <a href="../professor/lista_professores.php" class="botao">Lista de Professores</a>
    <a href="../emprestimo/lista_emprestimo.php" class="botao">Lista de Empréstimos</a>
    <a href="../relatorios/relatorios_front.php" class="botao">Relatórios</a>
    <a href="../inicial.php" class="botao">Voltar</a>
  </div>
</body>
</html>
