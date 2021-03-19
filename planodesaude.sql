-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Mar-2021 às 22:42
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `planodesaude`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(1) NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `nome` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id`, `email`, `senha`, `nome`) VALUES
(1, 'admin@mail.com', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `medicoID` int(11) NOT NULL,
  `pacienteID` int(11) NOT NULL,
  `receita` text NOT NULL,
  `observação` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consultas`
--

INSERT INTO `consultas` (`id`, `data`, `medicoID`, `pacienteID`, `receita`, `observação`) VALUES
(1, '2021-03-19', 2, 2, 'Miodarona', 'Arritimia'),
(2, '2021-03-19', 2, 2, 'Dipirona', 'Dor de cabeça');

-- --------------------------------------------------------

--
-- Estrutura da tabela `exames`
--

CREATE TABLE `exames` (
  `id` int(11) NOT NULL,
  `laboratorioID` int(11) NOT NULL,
  `pacienteID` int(11) NOT NULL,
  `tipo` text NOT NULL,
  `resultado` text NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `exames`
--

INSERT INTO `exames` (`id`, `laboratorioID`, `pacienteID`, `tipo`, `resultado`, `data`) VALUES
(1, 2, 2, 'Sangue', 'Encaminhar para o doutor Igor', '2021-03-19'),
(2, 2, 2, 'Sangue', 'A+', '2021-03-19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `laboratorios`
--

CREATE TABLE `laboratorios` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `nome` text NOT NULL,
  `endereco` text NOT NULL,
  `telefone` text NOT NULL,
  `cnpj` text NOT NULL,
  `tipos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `laboratorios`
--

INSERT INTO `laboratorios` (`id`, `email`, `senha`, `nome`, `endereco`, `telefone`, `cnpj`, `tipos`) VALUES
(2, 'amaralcosta@mail.com', 'amaralcosta', 'Amaral Costa', 'Rua Amaral Costa 90', '5340034505', '48071433000164', 'Sangue,Urina'),
(3, 'laboratorio@mail.com', 'laboratorio', 'Laboratorio A', 'Rua Laboratorio 12', '5340028922', '26.803.992/0001-89', 'Sangue');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `endereco` text NOT NULL,
  `especialidade` text NOT NULL,
  `idade` int(11) NOT NULL,
  `telefone` text NOT NULL,
  `crm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `medicos`
--

INSERT INTO `medicos` (`id`, `nome`, `email`, `senha`, `endereco`, `especialidade`, `idade`, `telefone`, `crm`) VALUES
(2, 'Igor', 'igor@mail.com', 'igor', 'Rua Igor 9', 'Cardiologista', 41, '53999037729', '12314334'),
(3, 'Medico', 'medico@mail.com', 'medico', 'Rua Medico 124', 'Pediatra', 45, '53984366433', '13144312');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `nome` text NOT NULL,
  `endereco` text NOT NULL,
  `telefone` text NOT NULL,
  `cpf` text NOT NULL,
  `genero` char(1) NOT NULL,
  `idade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `email`, `senha`, `nome`, `endereco`, `telefone`, `cpf`, `genero`, `idade`) VALUES
(2, 'thayllor@mail.com', 'thayllor', 'Thayllor', 'Rua Thayllor 939', '5340028922', '08704687078', 'M', 21),
(3, 'paciente@mail.com', 'paciente', 'Paciente', 'Rua Paciente', '5140029822', '899.378.000-56', 'M', 23);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Índices para tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `exames`
--
ALTER TABLE `exames`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `laboratorios`
--
ALTER TABLE `laboratorios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD UNIQUE KEY `cnpj` (`cnpj`) USING HASH;

--
-- Índices para tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD UNIQUE KEY `crm` (`crm`) USING HASH;

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD UNIQUE KEY `cpf` (`cpf`) USING HASH;

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `exames`
--
ALTER TABLE `exames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `laboratorios`
--
ALTER TABLE `laboratorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
