-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 07-Jul-2023 às 15:33
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `showdb`
--

-- --------------------------------------------------------


--
-- Criação do Banco de dados
--

CREATE DATABASE showdb;
use showdb;

--
-- Estrutura da tabela `partidas`
--

DROP TABLE IF EXISTS `partidas`;
CREATE TABLE IF NOT EXISTS `partidas` (
  `idPartida` int NOT NULL AUTO_INCREMENT,
  `idJogador` int NOT NULL,
  `premiacao` decimal(10,2) NOT NULL,
  `eliminacoesUsadas` int NOT NULL DEFAULT '0',
  `numErros` int NOT NULL DEFAULT '0',
  `numAcertos` int NOT NULL DEFAULT '0',
  `numPerguntasRespondidas` int NOT NULL DEFAULT '0',
  `idPerguntaAtual` int NOT NULL,
  `motivoEncerramento` varchar(255) NOT NULL,
  `x1` int NOT NULL,
  PRIMARY KEY (`idPartida`),
  KEY `idJogador` (`idJogador`),
  KEY `idPerguntaAtual` (`idPerguntaAtual`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `partidas`
--

INSERT INTO `partidas` (`idPartida`, `idJogador`, `premiacao`, `eliminacoesUsadas`, `numErros`, `numAcertos`, `numPerguntasRespondidas`, `idPerguntaAtual`, `motivoEncerramento`, `x1`) VALUES
(27, 0, '0.00', 1, 0, 0, 0, 0, '', 0),
(26, 0, '0.00', 1, 0, 0, 0, 0, '', 0),
(25, 0, '0.00', 1, 0, 0, 0, 0, '', 0),
(24, 0, '0.00', 1, 0, 0, 0, 0, '', 0),
(23, 0, '0.00', 1, 0, 0, 0, 0, '', 0),
(22, 0, '0.00', 1, 0, 0, 0, 0, '', 0),
(21, 0, '0.00', 1, 0, 0, 0, 0, '', 0),
(20, 0, '0.00', 1, 0, 0, 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas`
--

DROP TABLE IF EXISTS `perguntas`;
CREATE TABLE IF NOT EXISTS `perguntas` (
  `idPerguntas` int NOT NULL AUTO_INCREMENT,
  `enunciado` varchar(255) NOT NULL,
  `alternativa1` varchar(255) NOT NULL,
  `alternativa2` varchar(255) NOT NULL,
  `alternativa3` varchar(255) NOT NULL,
  `alternativa4` varchar(255) NOT NULL,
  `resposta` varchar(255) NOT NULL,
  `revisao` tinyint NOT NULL DEFAULT '0',
  `criador_id` int NOT NULL,
  PRIMARY KEY (`idPerguntas`),
  KEY `criador_id` (`criador_id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `perguntas`
--

INSERT INTO `perguntas` (`idPerguntas`, `enunciado`, `alternativa1`, `alternativa2`, `alternativa3`, `alternativa4`, `resposta`, `revisao`, `criador_id`) VALUES
(1, 'Normalmente, quantos litros de sangue uma pessoa tem? Em média, quantos são retirados numa doação de sangue?', 'Entre 4 a 6 litros. São retirados 450 mililitros.', 'Tem 7 litros. São retirados 1,5 litros', 'Tem 0,5 litros. São retirados 0,5 litros', 'Tem entre 2 a 4 litros. São retirados 450 mililitros', 'Entre 4 a 6 litros. São retirados 450 mililitros.', 1, 1),
(36, 'Quais os países que têm a maior e a menor expectativa de vida do mundo?', 'Japão e Serra Leoa', 'Austrália e Afeganistão', 'Itália e Chade', 'Estados Unidos e Angola', 'Japão e Serra Leoa', 1, 5),
(37, 'Baseado no javascript - Quanto é 1+1?', '2', '11', '50', '200', '11', 1, 21),
(48, 'No ceu tem pao?', 'sim', 'nao', 'talvez', 'Jamais saberemos', 'D', 0, 5),
(35, 'Qual é o formato do salgadinho Doritos?', 'Redondo', 'Oval', 'Quadrado', 'Triangular', 'Triangular', 1, 5),
(29, 'Quem criou os personagens Mickey e Minnie Mouse?', 'Walt Disney', 'Disney', 'Walt', 'Disney Club', 'Walt Disney', 1, 5),
(31, 'Quanto é 20+10?', '35', '30', '22', '500', '30', 0, 5),
(40, 'Quem pintou \"Guernica\"?', 'Paul Cézanne', 'Pablo Picasso', 'Tarsila do Amaral', 'Salvador Dalí', 'Pablo Picasso', 1, 22),
(49, 'sdasdas', '1', 'asjdaklsd', 'asdjakslda', 'sdjkasdljas', 'A', 0, 17),
(47, 'dklaskdljaskdajs', 'askdjaslkd', 'sdkjaskd', 'skadjaksd', 'jksdjaskd', 'B', 0, 5),
(43, 'Quem inventou a lâmpada?', 'Thomas Edison', 'Graham Bell', 'Santos Dumont', 'Henry Ford', 'Thomas Edison', 1, 11),
(50, 'O que?', '1', 'asjdaklsd', 'asdjakslda', 'sdjkasdljas', 'A', 0, 17),
(51, 'O que o pao', 'das', '1', 'wqw\'', 'w2222', 'B', 0, 17),
(52, 'qual vai ser nossa nota?', '10', '10', '10', '9', 'B', 0, 31),
(53, 'qual vai ser nossa nota?', '10', '9', '8', '7', 'A', 0, 31),
(54, 'estamos passados?', 'Sim', 'não', 'talvez', 'só Deus sabe', 'A', 0, 32);

-- --------------------------------------------------------

--
-- Estrutura da tabela `revisoes`
--

DROP TABLE IF EXISTS `revisoes`;
CREATE TABLE IF NOT EXISTS `revisoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pergunta` int DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `aprovada` tinyint(1) DEFAULT NULL,
  `avaliadores` int NOT NULL,
  `usuarios_aprovados` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `usuarios_recusaram` text NOT NULL,
  `total` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pergunta` (`id_pergunta`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `revisoes`
--

INSERT INTO `revisoes` (`id`, `id_pergunta`, `id_usuario`, `aprovada`, `avaliadores`, `usuarios_aprovados`, `usuarios_recusaram`, `total`) VALUES
(21, 47, 5, 0, 0, NULL, '', 0),
(20, 46, 23, 1, 0, NULL, '', 0),
(22, 48, 5, 1, 0, ',5,31', '', 2),
(23, 50, 21, 0, 0, NULL, '', 0),
(24, 50, 16, 0, 0, NULL, '', 0),
(25, 50, 7, 0, 0, NULL, '', 0),
(26, 50, 8, 0, 0, NULL, '', 0),
(27, 50, 27, 0, 0, NULL, '', 0),
(28, 51, NULL, 0, 17, NULL, '', 0),
(29, 51, NULL, 0, 10, NULL, '', 0),
(30, 51, NULL, 0, 5, NULL, '', 0),
(31, 51, NULL, 0, 25, NULL, '', 0),
(32, 51, NULL, 0, 23, NULL, '', 0),
(33, 52, NULL, 0, 15, NULL, '', 0),
(34, 52, NULL, 0, 19, NULL, '', 0),
(35, 52, NULL, 0, 31, NULL, '', 0),
(36, 52, NULL, 0, 25, NULL, '', 0),
(37, 52, NULL, 0, 5, NULL, '', 0),
(38, 53, NULL, 1, 31, '31', '', 1),
(39, 53, NULL, 1, 6, NULL, '', 0),
(40, 53, NULL, 0, 26, NULL, '', 0),
(41, 53, NULL, 0, 15, NULL, '', 0),
(42, 53, NULL, 0, 23, NULL, '', 0),
(46, 54, NULL, 0, 5, NULL, '', 0),
(45, 54, NULL, 0, 19, NULL, '', 0),
(44, 54, NULL, 0, 28, NULL, '', 0),
(43, 54, NULL, 0, 29, NULL, '', 0),
(47, 54, NULL, 0, 26, NULL, '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` blob NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `partidas_jogadas` int NOT NULL,
  `quant_perguntas_respondidas` int NOT NULL,
  `quant_perguntas_enviadas` int NOT NULL,
  `perguntas_aceitas` int NOT NULL DEFAULT '0',
  `perguntas_nao_aceitas` int NOT NULL DEFAULT '0',
  `premiacao_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quat_eliminacoes_usadas` int NOT NULL DEFAULT '0',
  `numero_derrotas_erro` int NOT NULL DEFAULT '0',
  `derrotas_numeros_paradas` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `nickname`, `email`, `password`, `avatar`, `reset_token`, `partidas_jogadas`, `quant_perguntas_respondidas`, `quant_perguntas_enviadas`, `perguntas_aceitas`, `perguntas_nao_aceitas`, `premiacao_total`, `quat_eliminacoes_usadas`, `numero_derrotas_erro`, `derrotas_numeros_paradas`) VALUES
(5, 'Vicente Neto', 'Fallen', 'vneto500@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0x436170747572612064652074656c6120323032332d30342d3232203138353031302e6a7067, '57b516c532c5cdf2e07b317fa946cf1e', 5, 0, 5, 10, 2, '1000.00', 2, 5, 0),
(6, 'Lucas Gomes', 'LudaCasa', '', 'd41d8cd98f00b204e9800998ecf8427e', 0x486f772d546f2d436f756e7465722d4469676c6574742d496e2d412d506f6b652e77656270, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(7, 'Leonardo Costa', 'LeoCosta', 'vneto800@hotmail.com', '25f9e794323b453885f5181f1b624d0b', 0x53656d2074c3ad74756c6f2e706e67, '', 1, 0, 2, 1, 5, '200.00', 0, 0, 0),
(8, '', 'teste', 'teste@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(10, 'Lucas', 'Gomes', 'lucas123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0x77616c6c7061706572666c6172652e636f6d5f77616c6c70617065722e6a7067, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(11, 'casas', 'dasd', '1@hotmail.com', '202cb962ac59075b964b07152d234b70', 0x436170747572612064652074656c6120323032332d30352d3234203230353433332e6a7067, '', 0, 0, 1, 0, 0, '0.00', 0, 0, 0),
(16, 'teste', 'testando', 'teste@test.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(17, 'teste2', 'testando2', 'teste2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(18, 'teste3', 'testando3', 'teste3@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(15, 'cachorro', 'dog', 'dog@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(19, 'Manoel Lima', 'manedosovos', 'teste21@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0x31346431363961383664613732383236303062336566346432313065303665322e6a7067, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(21, 'teste6', 'testando6', 'teste6@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0x646f776e6c6f61642e706e67, '', 0, 0, 1, 0, 0, '0.00', 0, 0, 0),
(23, 'lucas lima', 'lucao', 'lu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, 0, 3, 0, 0, '0.00', 0, 0, 0),
(24, 'manoel lima', 'manolima', 'manolima12@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(25, 'Marcio Gomes', 'marcio', 'marcio@gmail.com', '202cb962ac59075b964b07152d234b70', 0x706f72746164615f756e646561642d6769726c2d6d75726465722d322e77656270, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(26, 'Mariana', '', 'mariana@gmail.com', '202cb962ac59075b964b07152d234b70', 0x312e77656270, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(27, 'sao joao', '', 'saojoao@gmail.com', '202cb962ac59075b964b07152d234b70', 0x647273746f6e655f352e77656270, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(28, 'Marcos', '', 'marcao123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(29, 'Maria Luiza', 'luiza@gmail.com', 'luiza@gmail.com', '202cb962ac59075b964b07152d234b70', 0x46793038743558616b4145467050762e77656270, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(30, 'gato', 'gatinho1', 'cat@gatinho.com', 'e10adc3949ba59abbe56e057f20f883e', 0x31346431363961383664613732383236303062336566346432313065303665322e6a7067, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(31, 'amladinha2', 'almada2', 'almada@gmail.com', '202cb962ac59075b964b07152d234b70', 0x312e77656270, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0),
(32, 'almada3', 'almadinha', 'almada@gmail3.com', '81dc9bdb52d04dc20036dbd8313ed055', 0x6d617872657364656661756c742e77656270, '', 0, 0, 0, 0, 0, '0.00', 0, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
