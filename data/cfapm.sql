-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : lun. 25 nov. 2024 à 14:34
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

--
-- Déchargement des données de la table `Cat`
--

INSERT INTO `Cat` (`cat_id`, `name`, `birthdate`, `sex`, `breed`, `color`, `eyes`, `pedigree`, `chip`, `breeder`, `father`, `mother`, `user_id`) VALUES
(8, 'Éclipse', '2024-11-16', 'femelle', 'persan', 'bleu taby', 'jaunes', 'dd', 151204, 'mme dupont', 'colibri', 'prout', 11),
(9, 'mitaine', '2024-11-26', 'male', 'sheitan', 'chat', 'verts', '1651654132', 46545120, 'né dans un moulin ', 'inconnu', 'je sais pas', 10),
(10, 'mistouline', '2024-10-29', 'femelle', 'crotte', 'chat', 'verts', '1651654132', 151204, 'trouvée dans les escaliers', 'inconnu', 'inconnue ', 10),
(11, 'muscade', '2024-12-03', 'male', 'braincell', 'roux et blanc', 'bleus', '1651654132', 151204, 'trouvé dans un pot de fleurs', 'inconnu', 'inconnue ', 10),
(12, 'muad\'dib', '2024-11-03', 'male', 'gros chat', 'roux et blanc', 'jaunes', '1651654132', 151204, 'ramené par muscade', 'inconnu', 'inconnue ', 10);

-- --------------------------------------------------------

--
-- Structure de la table `Cat_registration`
--

CREATE TABLE `Cat_registration` (
  `cat_registration_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cat_id` int NOT NULL,
  `show_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Cat_show`
--

CREATE TABLE `Cat_show` (
  `show_id` int NOT NULL,
  `date_show` date NOT NULL,
  `show_adress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `number_show` varchar(255) NOT NULL,
  `show_city` varchar(255) NOT NULL,
  `pdf_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Cat_show`
--

INSERT INTO `Cat_show` (`show_id`, `date_show`, `show_adress`, `number_show`, `show_city`, `pdf_path`) VALUES
(4, '2024-11-01', 'route', '111', 'nice', '/var/www/html//pdf_exports/expo_1732539576.pdf'),
(5, '2024-12-02', 'route', '3', 'nice', ''),
(6, '2024-12-02', 'route', '3', 'nice', ''),
(7, '2024-12-02', 'route', '3', 'nice', ''),
(8, '2024-12-02', 'route', '3', 'nice', '');

-- --------------------------------------------------------

--
-- Structure de la table `Registrations`
--

CREATE TABLE `Registrations` (
  `user_id` int NOT NULL,
  `show_id` int NOT NULL,
  `id` int NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `pdf_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Registrations`
--

INSERT INTO `Registrations` (`user_id`, `show_id`, `id`, `price`, `pdf_path`) VALUES
(10, 4, 1, 4, '/var/www/html//pdf_exports/inscription_1732539615.pdf'),
(10, 4, 2, 4, '/var/www/html//pdf_exports/inscription_1732539731.pdf'),
(10, 4, 3, 4, '/var/www/html//pdf_exports/inscription_1732539766.pdf'),
(10, 8, 4, 1, 'expositions/8_bulletin.pdf'),
(10, 8, 5, 1, 'uploads/8_bulletin.pdf'),
(10, 8, 6, 1, 'uploads/8_bulletin.pdf'),
(10, 8, 7, 1, 'uploads/8_bulletin.pdf'),
(10, 8, 8, 1, 'uploads/8_bulletin.pdf'),
(10, 5, 9, 1, 'uploads/5_bulletin.pdf'),
(10, 5, 10, 1, 'uploads/5_bulletin.pdf'),
(10, 8, 11, 1, 'uploads/8_bulletin.pdf'),
(10, 8, 12, 1, 'uploads/8_bulletin.pdf'),
(10, 7, 13, 1, 'uploads/7_bulletin.pdf'),
(10, 4, 14, 1, 'uploads/4_bulletin.pdf'),
(10, 8, 15, 1, 'uploads/8_bulletin.pdf'),
(10, 8, 16, 1, 'uploads/8_bulletin.pdf');

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
-- Index pour la table `Cat_registration`
--
ALTER TABLE `Cat_registration`
  ADD PRIMARY KEY (`cat_registration_id`);

--
-- Index pour la table `Cat_show`
--
ALTER TABLE `Cat_show`
  ADD PRIMARY KEY (`show_id`);

--
-- Index pour la table `Registrations`
--
ALTER TABLE `Registrations`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `Cat_registration`
--
ALTER TABLE `Cat_registration`
  MODIFY `cat_registration_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Cat_show`
--
ALTER TABLE `Cat_show`
  MODIFY `show_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `Registrations`
--
ALTER TABLE `Registrations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
