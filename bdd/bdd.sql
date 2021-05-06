-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 06 mai 2021 à 19:42
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `p1905223`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `adId` int(11) NOT NULL AUTO_INCREMENT,
  `adpseudo` varchar(255) NOT NULL,
  `adpwd` varchar(255) NOT NULL,
  PRIMARY KEY (`adId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `catId` int(11) NOT NULL AUTO_INCREMENT,
  `nomCat` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`catId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`catId`, `nomCat`) VALUES
(1, 'Anime'),
(2, 'Nature'),
(3, 'Astronomie');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
  `nomFich` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `catId` int(11) DEFAULT NULL,
  `usrId` int(11) DEFAULT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`photoId`, `nomFich`, `description`, `catId`, `usrId`) VALUES
(1, './data/koro.png', 'Le personnage Koro Sensei de l\'anime Assassination Classroom', 1, NULL),
(2, './data/tokyoghoul.jpg', 'Kaneki de l\'anime Tokyo Ghoul', 1, NULL),
(3, './data/another.jpg', 'Mei Misaki et Koichi de l\'anime Another', 1, NULL),
(4, './data/fleur.jpg', 'Image de fleurs jaunes', 2, NULL),
(5, './data/chene.jpg', 'Image d\'un chêne', 2, NULL),
(6, './data/amazonie.jpg', 'L\'Amazonie vue du ciel', 2, NULL),
(7, './data/nebuleuse.jpg', 'Photo d\'une nébuleuse planétaire', 3, NULL),
(8, './data/supernovae.jpg', 'Photo de l\'explosion d\'une supernova', 3, NULL),
(9, './data/trounoir.jpg', 'Photo d\'un trou noir', 3, NULL),
(10, 'Map 3.png', 'zqrqz', 3, 2),
(11, 'cerclesnow.png', 'Photo', 2, 2),
(12, 'neige.png', 'neige', 2, 2),
(13, 'neige.png', 'neige', 2, 2),
(14, 'cerclesnow.png', 'jsaisoka', 1, 2),
(15, 'neige.png', 'jsp', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleId` int(10) UNSIGNED NOT NULL DEFAULT '2',
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `connectedOn` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `roleId`, `pseudo`, `mdp`, `etat`, `connectedOn`) VALUES
(1, 0, 'p1905392', '', 'disconnected', NULL),
(2, 2, 'sonia', '1234', 'connected', '2021-05-06 18:06:27'),
(4, 2, 'coucou', '1234', 'disconnected', NULL),
(5, 2, 'da', '1234', 'disconnected', NULL),
(6, 2, 'aeae', '1234', 'disconnected', NULL),
(8, 2, 'efbz', '1234', 'disconnected', NULL),
(9, 2, 'yuubgdzq', '1234', 'disconnected', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
