-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 18 jan. 2026 à 14:38
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_sport`
--

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id_joueur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `numero_licence` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `taille` int(11) DEFAULT NULL COMMENT 'en cm',
  `poids` decimal(5,2) DEFAULT NULL COMMENT 'en kg',
  `statut` enum('Actif','Blessé','Suspendu','Absent') DEFAULT 'Actif',
  `commentaire` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `nom`, `prenom`, `numero_licence`, `date_naissance`, `taille`, `poids`, `statut`, `commentaire`) VALUES
(1, 'simonet', 'paul', '101442247', '2000-05-04', 200, 102.00, 'Suspendu', 'trop fort ce mec'),
(2, 'sedff', 'sdffd', '4786767', '4688-05-08', 546, 456.00, 'Actif', '456456');

-- --------------------------------------------------------

--
-- Structure de la table `match_rencontre`
--

CREATE TABLE `match_rencontre` (
  `id_match` int(11) NOT NULL,
  `date_heure` datetime NOT NULL,
  `nom_equipe_adverse` varchar(100) NOT NULL,
  `lieu_rencontre` enum('Domicile','Exterieur') NOT NULL,
  `resultat_equipe` int(11) DEFAULT NULL,
  `resultat_adverse` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `match_rencontre`
--

INSERT INTO `match_rencontre` (`id_match`, `date_heure`, `nom_equipe_adverse`, `lieu_rencontre`, `resultat_equipe`, `resultat_adverse`) VALUES
(1, '2005-02-15 10:20:00', 'ricket', 'Exterieur', 0, 110),
(2, '2012-02-10 06:20:00', 'poulit', 'Domicile', 10, 5);

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

CREATE TABLE `participer` (
  `id_match` int(11) NOT NULL,
  `id_joueur` int(11) NOT NULL,
  `est_titulaire` tinyint(1) DEFAULT 0,
  `poste` varchar(50) DEFAULT NULL,
  `evaluation` int(11) DEFAULT NULL COMMENT 'Note de 1 à 5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participer`
--

INSERT INTO `participer` (`id_match`, `id_joueur`, `est_titulaire`, `poste`, `evaluation`) VALUES
(1, 2, 1, '', NULL),
(2, 2, 1, 'attaqquant', 4);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `login`, `email`, `mot_de_passe`) VALUES
(3, 'admin', 'admin@example.com', '$2y$10$APVp7g3yURfpoeyMx.FYp.fzKxTneRXJERS8nAcs5hDoIuzleoxo2');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id_joueur`),
  ADD UNIQUE KEY `numero_licence` (`numero_licence`);

--
-- Index pour la table `match_rencontre`
--
ALTER TABLE `match_rencontre`
  ADD PRIMARY KEY (`id_match`);

--
-- Index pour la table `participer`
--
ALTER TABLE `participer`
  ADD PRIMARY KEY (`id_match`,`id_joueur`),
  ADD KEY `id_joueur` (`id_joueur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id_joueur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `match_rencontre`
--
ALTER TABLE `match_rencontre`
  MODIFY `id_match` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participer`
--
ALTER TABLE `participer`
  ADD CONSTRAINT `participer_ibfk_1` FOREIGN KEY (`id_match`) REFERENCES `match_rencontre` (`id_match`) ON DELETE CASCADE,
  ADD CONSTRAINT `participer_ibfk_2` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id_joueur`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Vue pour les joueurs avec poste préféré
--
CREATE VIEW joueurs_avec_poste AS
SELECT j.*, COALESCE((
    SELECT poste 
    FROM participer p 
    WHERE p.id_joueur = j.id_joueur AND p.poste IS NOT NULL AND p.poste != '' 
    GROUP BY poste 
    ORDER BY COUNT(*) DESC 
    LIMIT 1
), 'Non défini') AS preferred_poste
FROM joueur j;
