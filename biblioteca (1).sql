-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/08/2025 às 13:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `periodo` enum('manhã','tarde','noite') DEFAULT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `serie`, `periodo`, `email`) VALUES
(9, 'Karoline Giovana Salvador Zanardi', '3ºA', NULL, 'karol@gmail.com'),
(10, 'Lara Geovanna', '3ºD', NULL, 'larageovanna@gmail.com'),
(11, 'Lorena Ramos', '3ºA', NULL, 'lorena@gmail.com'),
(12, 'Adriana Souza', '3ºB', NULL, 'adriana@gmail.com'),
(13, 'Kevin Richard', '3ºB', NULL, 'adriana@gmail.com'),
(14, 'ana julia', '3 D', NULL, 'aninhamacaca@gmail.com'),
(15, 'douglinhas', '2 D', NULL, 'douglinhasamaanaju@gmail.com'),
(16, 'Andrelinda Lima', '3D', NULL, 'pastoraabencoada@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `emprestimo`
--

CREATE TABLE `emprestimo` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `livro_id` int(11) NOT NULL,
  `data_devolucao` date NOT NULL,
  `data_retirada` date NOT NULL,
  `bimestre` tinyint(4) DEFAULT NULL CHECK (`bimestre` between 1 and 4),
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `emprestimo`
--

INSERT INTO `emprestimo` (`id`, `aluno_id`, `professor_id`, `livro_id`, `data_devolucao`, `data_retirada`, `bimestre`, `status`) VALUES
(11, 9, 13, 11, '2025-06-26', '2025-07-03', NULL, 0),
(13, 10, 13, 5, '2025-06-26', '2025-07-03', NULL, 0),
(14, 11, 13, 8, '2025-06-26', '2025-07-04', NULL, 0),
(15, 13, 13, 10, '2025-06-26', '2025-07-03', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `autor` varchar(50) NOT NULL,
  `isbn` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `autor`, `isbn`) VALUES
(5, 'O que o Sol faz com as flores', 'Rupi Kaur', '9788542212334'),
(7, 'Os dois morrem no final', 'Adam Silvera', '9786555603033'),
(8, 'Para todos os garotos que já amei', 'Jenny Han', '9788580577273'),
(10, 'Harry Potter e a Câmara Secreta', 'J.K. Rowling', '9781781103692'),
(11, 'A Biblioteca da Meia-Noite', 'Matt Haig', '9786558380634'),
(13, 'Portuguese Business Dictionary', 'Morry Sofer', '9781589797222'),
(14, 'Arquitetura de Nuvem (AWS)', 'Manoel Veras', '9788574525686');

-- --------------------------------------------------------

--
-- Estrutura para tabela `observacoes`
--

CREATE TABLE `observacoes` (
  `id` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `texto` text NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professores`
--

INSERT INTO `professores` (`id`, `nome`, `cpf`, `senha`, `email`) VALUES
(13, 'Fernando', '11122233344', '$2y$10$aWOs2tHXFP08CLuTkAi6d.RgtjIRFePfLbWY0m9PkWqz2vdEdp4ka', 'fernandao@gmail.com'),
(83, 'Vitin', '99988765436', '$2y$10$az3k3P.CRV9ttHBkWnJEy.IrbBNuEZUK0KfFCL.nR33PS/HEpzFmK', 'vitinhocorinthiano@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `livro_id` (`livro_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `observacoes`
--
ALTER TABLE `observacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_anotacao_professor` (`id_professor`);

--
-- Índices de tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `observacoes`
--
ALTER TABLE `observacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD CONSTRAINT `emprestimo_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`),
  ADD CONSTRAINT `emprestimo_ibfk_2` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`),
  ADD CONSTRAINT `emprestimo_ibfk_3` FOREIGN KEY (`professor_id`) REFERENCES `professores` (`id`);

--
-- Restrições para tabelas `observacoes`
--
ALTER TABLE `observacoes`
  ADD CONSTRAINT `fk_anotacao_professor` FOREIGN KEY (`id_professor`) REFERENCES `professores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
