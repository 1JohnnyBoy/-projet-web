-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 23 avr. 2026 à 18:49
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `email_base`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse_email`
--

CREATE TABLE `adresse_email` (
  `Id` int(11) NOT NULL COMMENT 'Auto-incrément',
  `Username` varchar(128) NOT NULL,
  `Mail` varchar(128) NOT NULL,
  `MDP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `adresse_email`
--

INSERT INTO `adresse_email` (`Id`, `Username`, `Mail`, `MDP`) VALUES
(4, 'youngboi', 'babiere@gmail.com', '$2y$10$4ywSvBBZJ6fduCqMHHO4t.XYkbCZuL75ZTaV.gyk0ev5vVpk1fzYK'),
(5, 'youngboi2', 'ebordanyongo@gmail.com', '$2y$10$xaeGSCpnBam8vYU8SyYmxe2RCRbWQElhaDGkG0IJVzJiasBioZVXC');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse_email`
--
ALTER TABLE `adresse_email`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse_email`
--
ALTER TABLE `adresse_email`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto-incrément', AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
