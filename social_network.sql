-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 27 fév. 2024 à 20:59
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `social_network`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `id_posts` int NOT NULL,
  `id_users` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_posts_FK` (`id_posts`),
  KEY `comments_users0_FK` (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `content`, `created_at`, `id_posts`, `id_users`) VALUES
(1, 'ca dit quoi', '2024-02-27 19:04:52', 1, 5),
(2, 'ça joue ce soir ?', '2024-02-27 19:48:44', 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `id_users` int NOT NULL,
  `id_users_is_followed` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `followers_users_FK` (`id_users`),
  KEY `followers_users0_FK` (`id_users_is_followed`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `followers`
--

INSERT INTO `followers` (`id`, `created_at`, `id_users`, `id_users_is_followed`) VALUES
(1, '2024-02-27 20:34:54', 5, 5),
(2, '2024-02-27 20:48:36', 6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `like_posts`
--

DROP TABLE IF EXISTS `like_posts`;
CREATE TABLE IF NOT EXISTS `like_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `id_users` int NOT NULL,
  `id_posts` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `like_posts_users_FK` (`id_users`),
  KEY `like_posts_posts0_FK` (`id_posts`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `like_posts`
--

INSERT INTO `like_posts` (`id`, `created_at`, `id_users`, `id_posts`) VALUES
(1, '2024-02-27 20:26:28', 5, 1),
(2, '2024-02-27 20:48:35', 6, 1),
(7, '2024-02-27 21:55:43', 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `id_users` int NOT NULL,
  `id_users_recieve` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_users_FK` (`id_users`),
  KEY `messages_users0_FK` (`id_users_recieve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `id_users` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_users_FK` (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `content`, `created_at`, `id_users`) VALUES
(1, 'ouaiii la team', '2024-02-27 18:20:14', 5),
(2, 'Test Nouvel publication', '2024-02-27 20:55:37', 5);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `birthday`, `phone`, `active`, `created_at`, `photo`) VALUES
(5, 'Clément', 'zefren', 'zefren', 'zefren@hotmail.fr', '$2y$10$B7jRNHL5D6ERV8xgFa0KAutdG89u.c8nlPa2IvwuEGrJuCqeYSpC.', '2024-02-02', NULL, 1, '2024-02-27 19:19:53', 'https://i.ebayimg.com/images/g/OQYAAOSwiWlZ1PQz/s-l1200.jpg'),
(6, 'Steve', 'steve', 'steve', 'steve@hotmail.fr', '$2y$10$B7jRNHL5D6ERV8xgFa0KAutdG89u.c8nlPa2IvwuEGrJuCqeYSpC.', '2024-02-02', NULL, 1, '2024-02-27 20:48:11', '');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_posts_FK` FOREIGN KEY (`id_posts`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_users_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_users0_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `followers_users_FK` FOREIGN KEY (`id_users_is_followed`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `like_posts`
--
ALTER TABLE `like_posts`
  ADD CONSTRAINT `like_posts_posts0_FK` FOREIGN KEY (`id_posts`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `like_posts_users_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_users0_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_users_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_users_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
