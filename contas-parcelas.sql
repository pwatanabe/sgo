-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 21-Dez-2015 às 20:05
-- Versão do servidor: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_viacampus`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas`
--

CREATE TABLE IF NOT EXISTS `contas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(256) NOT NULL,
  `fornecedor_cliente` varchar(256) NOT NULL,
  `obra` varchar(256) NOT NULL,
  `banco` varchar(256) NOT NULL,
  `valor` double NOT NULL,
  `multa` double NOT NULL,
  `data_vencimento` date NOT NULL,
  `parcelas` int(11) NOT NULL,
  `juros` varchar(255) NOT NULL,
  `oculto` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '1 À PAGAR 2 À RECEBER',
  `status` int(11) NOT NULL COMMENT '0 em aberto 1 Pago',
  `id_empresa` int(11) NOT NULL,
  `periodo_juros` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas`
--

INSERT INTO `contas` (`id`, `codigo`, `fornecedor_cliente`, `obra`, `banco`, `valor`, `multa`, `data_vencimento`, `parcelas`, `juros`, `oculto`, `descricao`, `tipo`, `status`, `id_empresa`, `periodo_juros`) VALUES
(1, 'Pagas', '3', 'obray', 'Bradesco', 50, 2.34, '2015-12-16', 3, '1%', 0, 'asdfasdf', 1, 1, 3, 'mensal'),
(2, 'asdfasdf', 'Sem fornecedor ou cliente', 'obrax', 'Bradesco', 2342.34, 100, '2015-12-31', 25, '12', 0, '', 1, 0, 3, 'mensal'),
(3, 'asdfad', '6', 'x', 'badfadsf', 234324, 2342, '2015-12-09', 50, '23', 0, 'asdfasdf', 1, 0, 3, 'mensal'),
(4, 'xxx', 'Sem fornecedor ou cliente', 'obrax', 'bradesco', 20, 5.02, '2015-12-23', 10, '1%', 0, 'asdfasdf', 2, 0, 3, 'anual'),
(5, 'a receber', 'Sem fornecedor ou cliente', 'obray', 'Bradesco', 200, 10000, '2015-12-14', 20, '2', 0, 'xxxx', 2, 0, 3, 'mensal'),
(9, 'a recebereer', 'Sem fornecedor ou cliente', 'obray', 'asdfadsfasdf', 12.31, 12, '2015-12-07', 3, '2', 0, 'asdfasdfasdf', 2, 0, 3, 'mensal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `parcelas`
--

CREATE TABLE IF NOT EXISTS `parcelas` (
  `id` int(11) NOT NULL,
  `id_conta` int(11) NOT NULL,
  `data` date NOT NULL,
  `parcela_n` int(11) NOT NULL,
  `comprovante` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `parcelas`
--

INSERT INTO `parcelas` (`id`, `id_conta`, `data`, `parcela_n`, `comprovante`) VALUES
(1, 1, '2015-12-21', 2, 'EU.jpg'),
(2, 1, '2015-12-17', 3, 'LUCAS SOARES NOGUEIRA.pdf'),
(3, 1, '2015-12-30', 1, 'EU.jpg'),
(4, 1, '2015-12-30', 0, 'EU.jpg'),
(5, 1, '2015-12-17', 0, 'LUCAS SOARES NOGUEIRA.pdf'),
(6, 4, '2015-12-30', 10, '40637084.txt'),
(7, 5, '2015-12-30', 1, 'EU.jpg'),
(8, 5, '2015-12-30', 2, 'banner 2016.jpg'),
(9, 5, '2015-12-30', 15, 'LUCAS SOARES NOGUEIRA.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contas`
--
ALTER TABLE `contas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indexes for table `parcelas`
--
ALTER TABLE `parcelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contas`
--
ALTER TABLE `contas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `parcelas`
--
ALTER TABLE `parcelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
