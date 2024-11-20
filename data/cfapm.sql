-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : mer. 20 nov. 2024 à 12:20
-- Version du serveur : 8.0.37
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cfapm`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `user_id` int NOT NULL,
  `role` varchar(255) NOT NULL,
  `member` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`user_id`, `role`, `member`, `email`) VALUES
(10, 'admin', '0', 'admin@cfbda.fr');

-- --------------------------------------------------------

--
-- Structure de la table `Cat`
--

CREATE TABLE `Cat` (
  `cat_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `eyes` varchar(255) NOT NULL,
  `pedigree` varchar(255) NOT NULL,
  `chip` int NOT NULL,
  `breeder` varchar(255) NOT NULL,
  `father` varchar(255) NOT NULL,
  `mother` varchar(255) NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `user_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phone` int NOT NULL,
  `adress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`user_id`, `email`, `name`, `surname`, `phone`, `adress`, `password`) VALUES
(10, 'admin@cfbda.fr', 'admin', 'admin', 667703832, '10 les magnolias 58300 decize', '$argon2id$v=19$m=65536,t=4,p=1$ZjBIZlpSanIucno2d0tWdg$afrlBYXPk5qkMaI70kb/EnOrvjdw1oXUz/bk4psPb+U'),
(11, 'mp@cfbda.fr', 'pourradier', 'mégane', 667703832, 'rue de la californie', '$argon2id$v=19$m=65536,t=4,p=1$enQ0VW1xTW5scGZ0ZjRpZw$8aWADxF3MFSkVXJ2tFVgTpdc8MLmlWRPJ6Ic4j5dmjg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Cat`
--
ALTER TABLE `Cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Cat`
--
ALTER TABLE `Cat`
  MODIFY `cat_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
