--
-- Base de données :  `tried`
--
DROP SCHEMA IF EXISTS `tried`;
CREATE DATABASE IF NOT EXISTS `tried` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin;
USE `tried`;

-- --------------------------------------------------------

--
-- Structure de la table `Personne`
--

DROP TABLE IF EXISTS Personne CASCADE;
CREATE TABLE `Personne` (
  `id_personne` int unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(50) NOT NULL,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `photo` VARCHAR(50) DEFAULT NULL,
  `promo` year NOT NULL CHECK (promo>'1995'),
  `num_tel` VARCHAR(15) DEFAULT NULL,
  `page_web` VARCHAR(50) DEFAULT NULL,
  `fonction` ENUM('Enseignant', 'Etudiant'),
  `statut` ENUM('Administrateur', 'Utilisateur')
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Structure de la table `Identifiants`
--
DROP TABLE IF EXISTS Tuteur CASCADE;
CREATE TABLE `Tuteur` (
  `id_tuteur` int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `note_moyenne` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Entreprise`
--
DROP TABLE IF EXISTS Entreprise CASCADE;
CREATE TABLE `Entreprise` (
  `id_entreprise` int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom_entreprise` VARCHAR(50) NOT NULL,
  `ville` int NOT NULL,
  `pays` VARCHAR(50) NOT NULL,
  `note_moyenne` float DEFAULT NULL,
  `lien_rapport` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Structure de la table `Stage`
--
DROP TABLE IF EXISTS Stage CASCADE;
CREATE TABLE `Stage` (
  `id_stage` int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `titre_sujet` VARCHAR(100) NOT NULL,
  `annee` year NOT NULL CHECK (annee>1995),
  `duree` int NOT NULL CHECK (duree<13 and duree>0),
  `pro_recherche` ENUM('Professionnel', 'Recherche'),
  `id_stagiaire1` int unsigned,
  `id_stagiaire2` int unsigned,
  `id_entreprise` int unsigned NOT NULL,
  `id_tuteur` int unsigned NOT NULL,
  `note_tuteur` int NOT NULL CHECK (note_tuteur>=0 and note_tuteur<=20),
  `note_entreprise` int NOT NULL CHECK (note_entreprise>=0 and note_entreprise<=20),
  `mots_cles` VARCHAR(50) DEFAULT NULL,
  `lien_rapport` VARCHAR(50) NOT NULL,
  CONSTRAINT `Stage_to_Personne` FOREIGN KEY (`id_stagiaire1`) REFERENCES `Personne` (`id_personne`),
  CONSTRAINT `Stage_to_Personne2` FOREIGN KEY (`id_stagiaire2`) REFERENCES `Personne` (`id_personne`),
  CONSTRAINT `Stage_to_Entreprise` FOREIGN KEY (`id_entreprise`) REFERENCES `Entreprise` (`id_entreprise`),
  CONSTRAINT `Stage_to_Tuteur` FOREIGN KEY (`id_tuteur`) REFERENCES `Tuteur` (`id_tuteur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Structure de la table `Identifiants`
--
DROP TABLE IF EXISTS Rapport CASCADE;
CREATE TABLE `Rapport` (
  `id_stage` int unsigned NOT NULL PRIMARY KEY,
  `rapport` text NOT NULL,
   CONSTRAINT `rapport_to_stage` FOREIGN KEY (`id_stage`) REFERENCES `Stage` (`id_stage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Identifiants`
--
DROP TABLE IF EXISTS Identifiants CASCADE;
CREATE TABLE `Identifiants` (
  `id_personne` int unsigned NOT NULL PRIMARY KEY,
  `password` CHAR(32) NOT NULL,
  CONSTRAINT `Mdp_to_Personne` FOREIGN KEY (`id_personne`) REFERENCES `Personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


--
-- Structure de la table `Stage_Temporaire`
--
DROP TABLE IF EXISTS Stage_Temporaire CASCADE;
CREATE TABLE `Stage_Temporaire` (
  `id_stage` int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `titre_sujet` VARCHAR(100) NOT NULL,
  `annee` year NOT NULL CHECK (annee>1995),
  `duree` int NOT NULL CHECK (duree<13 and duree>0),
  `pro_recherche` ENUM('Professionnel', 'Recherche'),
  `id_stagiaire1` int unsigned,
  `id_stagiaire2` int unsigned,
  `id_entreprise` int unsigned NOT NULL,
  `id_tuteur` int unsigned NOT NULL,
  `note_tuteur` int NOT NULL CHECK (note_tuteur>=0 and note_tuteur<=20),
  `note_entreprise` int NOT NULL CHECK (note_entreprise>=0 and note_entreprise<=20),
  `mots_cles` VARCHAR(50) DEFAULT NULL,
  `lien_rapport` VARCHAR(50) NOT NULL,
  `date_demande` date NOT NULL,
  `id_personne` int unsigned NOT NULL,
  CONSTRAINT `Stage_to_Personne11` FOREIGN KEY (`id_stagiaire1`) REFERENCES `Personne` (`id_personne`),
  CONSTRAINT `Stage_to_Personne12` FOREIGN KEY (`id_stagiaire2`) REFERENCES `Personne` (`id_personne`),
  CONSTRAINT `Stage_to_Entreprise1` FOREIGN KEY (`id_entreprise`) REFERENCES `Entreprise` (`id_entreprise`),
  CONSTRAINT `Stage_to_student1` FOREIGN KEY (`id_personne`) REFERENCES `Personne` (`id_personne`),
  CONSTRAINT `Stage_to_Tuteur1` FOREIGN KEY (`id_tuteur`) REFERENCES `Tuteur` (`id_tuteur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `Entreprise_Temporaire`
--
DROP TABLE IF EXISTS Entreprise_Temporaire CASCADE;
CREATE TABLE `Entreprise_Temporaire` (
  `id_entreprise` int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom_entreprise` VARCHAR(50) NOT NULL,
  `ville` int NOT NULL,
  `pays` VARCHAR(50) NOT NULL,
  `id_personne` int unsigned NOT NULL,
  `note_moyenne` float DEFAULT NULL,
  `lien_rapport` VARCHAR(50) NOT NULL,
  `date_demande` date NOT NULL,
  CONSTRAINT `Entreprise_to_personne1` FOREIGN KEY (`id_personne`) REFERENCES `Personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
