-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para forms
CREATE DATABASE IF NOT EXISTS `forms` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `forms`;

-- Copiando estrutura para tabela forms.form
CREATE TABLE IF NOT EXISTS `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `starts` datetime DEFAULT NULL,
  `ends` datetime DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `share` tinyint(4) DEFAULT NULL,
  `posted` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_form_users` (`author_id`),
  CONSTRAINT `FK_form_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.form: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela forms.form_options
CREATE TABLE IF NOT EXISTS `form_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `option_text` varchar(255) DEFAULT NULL,
  `option_true` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_form_options_form_questions` (`question_id`),
  CONSTRAINT `FK_form_options_form_questions` FOREIGN KEY (`question_id`) REFERENCES `form_questions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=695 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.form_options: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela forms.form_questions
CREATE TABLE IF NOT EXISTS `form_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `question_type` varchar(50) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `form_id_question_type_question_text` (`form_id`,`question_type`,`question_text`) USING HASH,
  KEY `FK_form_questions_form` (`form_id`),
  CONSTRAINT `FK_form_questions_form` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=336 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.form_questions: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela forms.form_share
CREATE TABLE IF NOT EXISTS `form_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `external_user_id` int(11) DEFAULT NULL,
  `access_hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_form_share_form` (`form_id`),
  KEY `FK_form_share_users_share` (`external_user_id`),
  CONSTRAINT `FK_form_share_form` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_form_share_users_share` FOREIGN KEY (`external_user_id`) REFERENCES `users_share` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=418 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.form_share: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela forms.response
CREATE TABLE IF NOT EXISTS `response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `external_user_id` int(11) DEFAULT NULL,
  `response_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_response_form` (`form_id`),
  KEY `FK_response_users` (`user_id`),
  CONSTRAINT `FK_response_form` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_response_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=424 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.response: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela forms.response_answers
CREATE TABLE IF NOT EXISTS `response_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `response_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `answer_text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_response_answers_response` (`response_id`),
  KEY `FK_response_answers_form_questions` (`question_id`),
  KEY `FK_response_answers_form_options` (`option_id`),
  CONSTRAINT `FK_response_answers_form_options` FOREIGN KEY (`option_id`) REFERENCES `form_options` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_response_answers_form_questions` FOREIGN KEY (`question_id`) REFERENCES `form_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_response_answers_response` FOREIGN KEY (`response_id`) REFERENCES `response` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3451 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.response_answers: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela forms.resultados
CREATE TABLE IF NOT EXISTS `resultados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_beneficiario` int(11) NOT NULL,
  `nome_beneficiario` varchar(150) NOT NULL,
  `data_resultado` date DEFAULT NULL,
  `num_autorizacao` int(11) NOT NULL,
  `tipo_resultado` varchar(100) NOT NULL,
  `texto_resultado` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.resultados: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela forms.resultados_arquivos
CREATE TABLE IF NOT EXISTS `resultados_arquivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resultado_id` int(11) DEFAULT NULL,
  `arquivo` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resultado_id` (`resultado_id`),
  CONSTRAINT `resultados_arquivos_ibfk_1` FOREIGN KEY (`resultado_id`) REFERENCES `resultados` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.resultados_arquivos: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela forms.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `group` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_users_users_groups` (`group`),
  CONSTRAINT `FK_users_users_groups` FOREIGN KEY (`group`) REFERENCES `users_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.users: ~1 rows (aproximadamente)
INSERT INTO `users` (`id`, `username`, `name`, `surname`, `password`, `email`, `group`, `active`, `admin`) VALUES
	(1, 'admin', 'Admin', 'Portal', 'U2FsdGVkX19RVoBGzb73vcklkKuWgjtQQYjWoPF0jsA=', 'admin@gmail.com', 1, 1, 1);

-- Copiando estrutura para tabela forms.users_groups
CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `read` tinyint(4) DEFAULT NULL,
  `create` tinyint(4) DEFAULT NULL,
  `edit` tinyint(4) DEFAULT NULL,
  `delete` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.users_groups: ~2 rows (aproximadamente)
INSERT INTO `users_groups` (`id`, `name`, `read`, `create`, `edit`, `delete`) VALUES
	(1, 'Principal', 1, 1, 1, 1),
	(6, 'Visualizador', 1, 0, 0, 0);

-- Copiando estrutura para tabela forms.users_share
CREATE TABLE IF NOT EXISTS `users_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=362 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela forms.users_share: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
