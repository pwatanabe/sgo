-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10-Dez-2015 às 18:40
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
  `juros` double NOT NULL,
  `oculto` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '1 À PAGAR 2 À RECEBER',
  `status` int(11) NOT NULL COMMENT '0 em aberto 1 Pago'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas`
--

INSERT INTO `contas` (`id`, `codigo`, `fornecedor_cliente`, `obra`, `banco`, `valor`, `multa`, `data_vencimento`, `parcelas`, `juros`, `oculto`, `descricao`, `tipo`, `status`) VALUES
(1, 'codigo', '6', 'obray', 'Bradesco', 500, 100, '2015-12-23', 5, 5, 0, 'descrição', 1, 0),
(2, 'codigo', 'Sem fornecedor ou cliente', 'obray', 'bradesco', 200, 5, '2015-12-08', 2, 6, 0, 'descricao', 1, 0),
(3, 'a receber', '7', 'obray', 'Bradesco', 500, 3600000, '2015-12-14', 20, 50, 0, 'dfasdf', 2, 0),
(4, '', 'Sem fornecedor ou cliente', 'obrax', '', 0, 0, '0000-00-00', 0, 0, 0, '', 2, 0),
(5, 'XXXX', '3', 'obray', 'Banco do Brasil', 5000, 500, '2015-12-17', 80, 5, 0, 'YYAYAYYAYA', 1, 0),
(6, 'JJJJJ', 'Sem fornecedor ou cliente', 'obray', 'HSBC', 900, 80, '2015-12-23', 50, 9, 0, 'PPPPPP', 1, 0),
(7, 'JJJJJ', 'Sem fornecedor ou cliente', 'obray', 'HSBC', 900, 80, '2015-12-23', 50, 9, 0, 'PPPPPP', 1, 0),
(8, 'adfadsf', '6', 'obrax', 'asdfasdf', 2342.34, 234.23, '2015-12-16', 23, 324234, 0, 'asdfasdf', 1, 0),
(9, 'adfadsf', '6', 'obrax', 'asdfasdf', 2342.34, 234.23, '2015-12-16', 23, 324234, 0, 'asdfasdf', 1, 0),
(10, '34234', '6', 'obrax', 'sdfasdf', 2342.34, 23.23, '2015-12-09', 2332, 234234, 0, 'sdfasdf', 1, 0),
(11, '234234', '6', 'obrax', '234234', 2342.34, 2343.24, '2015-12-09', 0, 0, 0, '', 1, 0),
(12, 'fadf', 'Sem fornecedor ou cliente', 'obray', '4sadfsdf', 2342.34, 2.34, '2015-12-08', 234, 23432, 0, 'asdfadsf', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contas`
--
ALTER TABLE `contas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contas`
--
ALTER TABLE `contas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
