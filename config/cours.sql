-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 19 Février 2015 à 13:45
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `cours`
--
CREATE DATABASE IF NOT EXISTS `cours` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cours`;

-- --------------------------------------------------------

--
-- Structure de la table `experience`
--

CREATE TABLE IF NOT EXISTS `experience` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `experience`
--

INSERT INTO `experience` (`id`, `Title`, `content`, `creation_date`) VALUES
(1, 'Hero Corp', 'Captain sport extrême.\r\nJ''y vais à fond.', '2015-01-26 22:59:52'),
(2, 'Marvel', 'It''s a bird ? It''s a plane ? It''s Superman !', '2015-01-27 21:45:08');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL,
  `role` varchar(20) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `role`, `creation_date`) VALUES
(1, 'user', 'OESZwF1tNBqtgF5hkFyEqVKD+Q5ugylof6fI0aDzipuFQ5tT3XO4NXiCzB6Bcz7KlhcoDlGhjnEwdOQYlQJwAg==', 'user@user.com', 'ROLE_USER', '2015-01-27 21:22:37'),
(2, 'admin', '2NIUNISoVyySNn9l5ntsONo4JFisKQvu/Cq6LLdfarXjRMvkIqRevFDQrbSmbOhrMvojVFlv+MKJccX2hX/ZzQ==', 'admin@admin.com', 'ROLE_ADMIN', '2015-01-27 21:24:19');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
