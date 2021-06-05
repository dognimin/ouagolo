-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 17 mai 2021 à 10:06
-- Version du serveur :  5.7.34
-- Version de PHP : 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `techouse_projet_ouagolo_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `tb_etablissements`
--

CREATE TABLE `tb_etablissements` (
  `etablissement_code` varchar(9) NOT NULL,
  `type_etablissement_code` varchar(7) NOT NULL,
  `raison_sociale` varchar(100) NOT NULL,
  `niveau_code` varchar(7) DEFAULT NULL,
  `pays_code` varchar(3) NOT NULL,
  `region_code` varchar(5) NOT NULL,
  `departement_code` varchar(5) NOT NULL,
  `commune_code` varchar(5) NOT NULL,
  `latitude` varchar(15) DEFAULT NULL,
  `longitude` varchar(15) DEFAULT NULL,
  `site_web` varchar(100) DEFAULT NULL,
  `secteur_activite_code` varchar(5) NOT NULL,
  `adresse_geographique` varchar(100) DEFAULT NULL,
  `adresse_postale` varchar(100) DEFAULT NULL,
  `etablissement_date_debut` date NOT NULL,
  `etablissement_date_fin` date DEFAULT NULL,
  `utilisation_id_creation` varchar(45) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisation_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_etablissements`
--

INSERT INTO `tb_etablissements` (`etablissement_code`, `type_etablissement_code`, `raison_sociale`, `niveau_code`, `pays_code`, `region_code`, `departement_code`, `commune_code`, `latitude`, `longitude`, `site_web`, `secteur_activite_code`, `adresse_geographique`, `adresse_postale`, `etablissement_date_debut`, `etablissement_date_fin`, `utilisation_id_creation`, `date_creation`, `utilisation_id_edition`, `date_edition`) VALUES
('000100009', 'csu', 'CROU HOUPHOUET BOIGNY', 'N1', 'CIV', '0001', '0001', '0001', '', '', NULL, 'PUB', '', '', '2021-05-06', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 21:43:14', NULL, NULL),
('000199998', 'csu', 'CENTRE MEDICAL INITIAL REFERENT', 'n1', 'CIV', '0001', '0001', '0001', '', '', NULL, 'PRV', '', '', '2021-05-06', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 14:08:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_etablissements_agents`
--

CREATE TABLE `tb_etablissements_agents` (
  `utilisateur_id` varchar(45) NOT NULL,
  `etablissement_code` varchar(7) NOT NULL,
  `etablissement_agent_date_debut` date NOT NULL,
  `etablissement_agent_date_fin` date DEFAULT NULL,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisation_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_etablissements_coordonnees`
--

CREATE TABLE `tb_etablissements_coordonnees` (
  `etablissement_code` varchar(9) NOT NULL,
  `type_coordonnee_code` varchar(6) NOT NULL,
  `coordonnee_valeur` varchar(100) NOT NULL,
  `coordonnee_date_debut` date NOT NULL,
  `coordonnee_date_fin` date DEFAULT NULL,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisation_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_etablissements_coordonnees`
--

INSERT INTO `tb_etablissements_coordonnees` (`etablissement_code`, `type_coordonnee_code`, `coordonnee_valeur`, `coordonnee_date_debut`, `coordonnee_date_fin`, `utilisateur_id_creation`, `date_creation`, `utilisation_id_edition`, `date_edition`) VALUES
('000100009', 'MOBPRO', '0707000000', '2021-05-06', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 22:14:04', NULL, NULL),
('000100009', 'SITWEB', 'https://cmir.ci', '2021-05-06', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 22:16:56', NULL, NULL),
('000199998', 'MELPER', 'test@test.com', '2021-05-10', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-10 11:12:57', NULL, NULL),
('000199998', 'MELPRO', 'initial@centre.com', '2021-05-06', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:42:03', NULL, NULL),
('000199998', 'MOBPER', '0101010101', '2021-05-09', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-09 16:50:26', NULL, NULL),
('000199998', 'MOBPRO', '0707010101', '2021-05-06', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 20:02:33', NULL, NULL),
('000199998', 'TELFIX', '2720000000', '2021-05-06', NULL, '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:52:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_etablissements_niveaux_sanitaires`
--

CREATE TABLE `tb_etablissements_niveaux_sanitaires` (
  `niveau_sanitaire_code` varchar(10) NOT NULL,
  `niveau_sanitaire_libelle` varchar(100) NOT NULL,
  `niveau` int(11) NOT NULL,
  `niveau_sanitaire_date_debut` date NOT NULL,
  `niveau_sanitaire_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_etablissements_niveaux_sanitaires`
--

INSERT INTO `tb_etablissements_niveaux_sanitaires` (`niveau_sanitaire_code`, `niveau_sanitaire_libelle`, `niveau`, `niveau_sanitaire_date_debut`, `niveau_sanitaire_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('N1', 'NIVEAU 1', 1, '2021-05-03', NULL, '2021-05-03 13:42:35', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_etablissements_professionnels`
--

CREATE TABLE `tb_etablissements_professionnels` (
  `etablissement_code` varchar(9) NOT NULL,
  `professionnel_code` varchar(9) NOT NULL,
  `etablissement_professionnel_date_debut` date NOT NULL,
  `etablissement_professionnel_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_etablissements_responsables`
--

CREATE TABLE `tb_etablissements_responsables` (
  `utilisateur_id` varchar(45) NOT NULL,
  `etablissement_code` varchar(7) NOT NULL,
  `etablissement_responsable_date_debut` date NOT NULL,
  `etablissement_responsable_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_etablissements_types`
--

CREATE TABLE `tb_etablissements_types` (
  `niveau_sanitaire_code` varchar(10) NOT NULL,
  `type_etablissement_code` varchar(10) NOT NULL,
  `type_etablissement_libelle` varchar(100) NOT NULL,
  `type_etablissement_date_debut` date NOT NULL,
  `type_etablissement_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisation_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_etablissements_types`
--

INSERT INTO `tb_etablissements_types` (`niveau_sanitaire_code`, `type_etablissement_code`, `type_etablissement_libelle`, `type_etablissement_date_debut`, `type_etablissement_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisation_id_edition`) VALUES
('N1', 'CSU', 'CENTRE DE SANTE URBAIN', '2021-05-03', NULL, '2021-05-03 14:10:27', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_log_historique_connexions`
--

CREATE TABLE `tb_log_historique_connexions` (
  `connexion_id` int(11) NOT NULL,
  `utilisateur_id` varchar(45) NOT NULL,
  `connexion_adresse_ip` varchar(100) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_log_historique_connexions`
--

INSERT INTO `tb_log_historique_connexions` (`connexion_id`, `utilisateur_id`, `connexion_adresse_ip`, `date_creation`) VALUES
(1, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-04-30 12:04:42'),
(2, '16012012918420210430134121608c090196e24537856', '160.120.129.184', '2021-04-30 13:43:07'),
(3, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-04-30 14:58:05'),
(4, '16012012918420210430142857608c142929902425196', '160.120.129.184', '2021-04-30 16:14:08'),
(5, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-03 09:11:04'),
(6, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-03 11:03:12'),
(7, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-03 12:15:16'),
(8, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-03 13:31:44'),
(9, '16012012918420210430115828608bf0e4467c8240168', '196.43.233.204', '2021-05-04 22:20:12'),
(10, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-06 13:24:30'),
(11, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-06 19:08:32'),
(12, '16012012918420210430115828608bf0e4467c8240168', '102.137.11.156', '2021-05-06 20:45:08'),
(13, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-07 09:33:45'),
(14, '16012012918420210430115828608bf0e4467c8240168', '41.87.59.168', '2021-05-08 11:52:39'),
(15, '16012012918420210430115828608bf0e4467c8240168', '102.138.195.59', '2021-05-08 19:21:17'),
(16, '16012012918420210430115828608bf0e4467c8240168', '196.32.175.155', '2021-05-09 14:37:32'),
(17, '16012012918420210430115828608bf0e4467c8240168', '196.32.175.155', '2021-05-09 16:44:31'),
(18, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-10 11:11:26'),
(19, '16012012918420210430115828608bf0e4467c8240168', '196.32.175.155', '2021-05-14 13:35:03'),
(20, '16012012918420210430115828608bf0e4467c8240168', '196.32.175.155', '2021-05-14 19:31:48'),
(21, '16012012918420210430115828608bf0e4467c8240168', '196.32.175.155', '2021-05-14 21:03:03'),
(22, '16012012918420210430115828608bf0e4467c8240168', '196.32.175.155', '2021-05-15 12:59:38'),
(23, '16012012918420210430115828608bf0e4467c8240168', '196.32.175.155', '2021-05-15 22:26:10'),
(24, '16012012918420210430115828608bf0e4467c8240168', '160.120.129.184', '2021-05-17 09:52:50'),
(25, '16012012918420210430134121608c090196e24537856', '160.154.157.31', '2021-05-17 09:54:55');

-- --------------------------------------------------------

--
-- Structure de la table `tb_log_historique_piste_audit`
--

CREATE TABLE `tb_log_historique_piste_audit` (
  `piste_audit_id` int(11) NOT NULL,
  `piste_audit_adresse_ip` varchar(100) NOT NULL,
  `piste_audit_url` text NOT NULL,
  `piste_audit_action` varchar(50) NOT NULL,
  `piste_audit_details` text NOT NULL,
  `utilisateur_id` varchar(45) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_log_historique_piste_audit`
--

INSERT INTO `tb_log_historique_piste_audit` (`piste_audit_id`, `piste_audit_adresse_ip`, `piste_audit_url`, `piste_audit_action`, `piste_audit_details`, `utilisateur_id`, `date_creation`) VALUES
(1, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'CREATION', '{\"id_user\":\"\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"dognimin.koulibali\",\"email\":\"dognimin.koulibali@gmail.com\",\"civilite\":\"\",\"nom\":\"KOULIBALI\",\"nom_patronymique\":\"\",\"prenoms\":\"DOGNIMIN\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"\"}', '1', '2021-04-30 11:58:28'),
(2, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:04:42'),
(3, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_mot_de_passe.php', 'MISE A JOUR MDP', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:07:21'),
(4, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_profil_utilisateur.php', 'EDITION', '{\"code\":\"admn\",\"libelle\":\"Administrateur\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:17:50'),
(5, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_type_accident.php', 'EDITION', '{\"code\":\"atmp\",\"libelle\":\"accident de travail \\/ maladie professionnelle\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:26:40'),
(6, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_categorie_socio_professionnelle.php', 'EDITION', '{\"code\":\"SAL\",\"libelle\":\"salari\\u00e9\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:27:59'),
(7, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_civilite.php', 'EDITION', '{\"code\":\"m\",\"libelle\":\"monsieur\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:28:28'),
(8, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_sexe.php', 'EDITION', '{\"code\":\"m\",\"libelle\":\"monsieur\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:28:47'),
(9, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_sexe.php', 'EDITION', '{\"code\":\"f\",\"libelle\":\"feminin\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:29:02'),
(10, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_situation_familiale.php', 'EDITION', '{\"code\":\"cel\",\"libelle\":\"celibataire\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:30:36'),
(11, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_secteur_activite.php', 'EDITION', '{\"code\":\"prv\",\"libelle\":\"prive\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:32:19'),
(12, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_secteur_activite.php', 'EDITION', '{\"code\":\"pub\",\"libelle\":\"public\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:32:59'),
(13, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_profession.php', 'EDITION', '{\"code\":\"0001\",\"libelle\":\"Assureur\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:34:49'),
(14, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_profession.php', 'EDITION', '{\"code\":\"0002\",\"libelle\":\"Banques \\/ Finances \\/ Bourse\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:35:23'),
(15, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/sumit_qualite_civilite.php', 'EDITION', '{\"code\":\"pay\",\"libelle\":\"payeur\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:41:55'),
(16, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_type_coordonnee.php', 'EDITION', '{\"code\":\"mobper\",\"libelle\":\"mobile personnel\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:45:47'),
(17, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_types_pieces.php', 'EDITION', '{\"code\":\"cni\",\"libelle\":\"carte nationale d\'identit\\u00e9\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:46:30'),
(18, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_devise_monetaire.php', 'EDITION', '{\"code\":\"xof\",\"libelle\":\"franc cfa\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:49:24'),
(19, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_groupe_sanguin.php', 'EDITION', '{\"code\":\"a\",\"libelle\":\"a\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:49:39'),
(20, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_groupe_sanguin.php', 'EDITION', '{\"code\":\"o\",\"libelle\":\"o\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:49:51'),
(21, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_groupe_sanguin.php', 'EDITION', '{\"code\":\"b\",\"libelle\":\"b\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:50:03'),
(22, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_groupe_sanguin.php', 'EDITION', '{\"code\":\"ab\",\"libelle\":\"ab\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:50:15'),
(23, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_rhesus.php', 'EDITION', '{\"code\":\"-\",\"libelle\":\"negatif\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:50:41'),
(24, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_rhesus.php', 'EDITION', '{\"code\":\"+\",\"libelle\":\"positif\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:50:53'),
(25, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_geo_pays.php', 'EDITION', '{\"code\":\"civ\",\"nom\":\"c\\u00f4te d\'ivoire\",\"gentile\":\"ivoiriens\",\"indicatif\":\"225\",\"latitude\":\"7\\u00b032\'23.96\\\"N\",\"longitude\":\"5\\u00b032\'49.488\\\"O\",\"code_devise\":\"XOF\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:55:41'),
(26, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_geo_region.php', 'EDITION', '{\"code_pays\":\"CIV\",\"code\":\"0001\",\"nom\":\"DISTRICT D\'ABIDJAN\",\"latitude\":\"1234567\",\"longitude\":\"2345678\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:56:29'),
(27, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_geo_departement.php', 'EDITION', '{\"code_region\":\"0001\",\"code\":\"0001\",\"nom\":\"Cocody\",\"latitude\":\"765432\",\"longitude\":\"765433\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 12:57:18'),
(28, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_geo_commune.php', 'EDITION', '{\"code_departement\":\"0001\",\"code\":\"0001\",\"nom\":\"COCODY\",\"latitude\":\"345676543\",\"longitude\":\"56765432\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:00:01'),
(29, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Pathologies/submit_pathologie_chapitre.php', 'EDITION', '{\"code\":\"A00-B99\",\"libelle\":\"Certaines maladies infectieuses et parasitaires\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:10:02'),
(30, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Pathologies/submit_pathologie_sous_chapitre.php', 'EDITION', '{\"code\":\"A00-A09\",\"code_chapitre\":\"A00-B99\",\"libelle\":\"Maladies intestinales infectieuses\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:10:50'),
(31, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Pathologies/submit_pathologie.php', 'EDITION', '{\"code\":\"A00\",\"code_sous_chapitre\":\"A00-A09\",\"libelle\":\"Chol\\u00e9ra\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:13:15'),
(32, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"landry.seye\",\"email\":\"landry.seye@techouse.io\",\"civilite\":\"M\",\"nom\":\"SEYE\",\"nom_patronymique\":\"\",\"prenoms\":\"BI LANDRY\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:35:06'),
(33, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"landry.seye\",\"email\":\"landry.seye@techouse.io\",\"civilite\":\"M\",\"nom\":\"SEYE\",\"nom_patronymique\":\"\",\"prenoms\":\"BI LANDRY\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:41:21'),
(34, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'landry.seye@techouse.io', '16012012918420210430134121608c090196e24537856', '2021-04-30 13:43:07'),
(35, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_mot_de_passe.php', 'MISE A JOUR MDP', '********', '16012012918420210430134121608c090196e24537856', '2021-04-30 13:44:05'),
(36, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"16012012918420210430134121608c090196e24537856\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"landry.seye\",\"email\":\"landry.seye@techouse.io\",\"civilite\":\"M\",\"nom\":\"SEYE\",\"nom_patronymique\":\"\",\"prenoms\":\"LANDRY\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 13:45:25'),
(37, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"16012012918420210430134121608c090196e24537856\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"landry.seye\",\"email\":\"landry.seye@techouse.io\",\"civilite\":\"M\",\"nom\":\"SEYE\",\"nom_patronymique\":\"\",\"prenoms\":\"BI LANDRY\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 13:47:02'),
(38, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"16012012918420210430115828608bf0e4467c8240168\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"dognimin.koulibali\",\"email\":\"dognimin.koulibali@gmail.com\",\"civilite\":\"M\",\"nom\":\"KOULIBALI\",\"nom_patronymique\":\"\",\"prenoms\":\"DOGNIMIN\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:47:39'),
(39, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"16012012918420210430134121608c090196e24537856\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"landry.seye\",\"email\":\"landry.seye@techouse.io\",\"civilite\":\"M\",\"nom\":\"SEYE\",\"nom_patronymique\":\"\",\"prenoms\":\"LANDRY\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 13:50:05'),
(40, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"16012012918420210430115828608bf0e4467c8240168\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"dognimin.koulibali\",\"email\":\"dognimin.koulibali@gmail.com\",\"civilite\":\"M\",\"nom\":\"KOULIBALI\",\"nom_patronymique\":\"\",\"prenoms\":\"DOGNIMIN\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:50:55'),
(41, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"16012012918420210430134121608c090196e24537856\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"landry.seye\",\"email\":\"landry.seye@techouse.io\",\"civilite\":\"M\",\"nom\":\"SEYE\",\"nom_patronymique\":\"\",\"prenoms\":\"BI LANDRY\",\"date_naissance\":\"10\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 13:51:21'),
(42, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/ActesMedicaux/submit_acte_lettre_cle.php', 'EDITION', '{\"code\":\"C\",\"prix\":\"1000\",\"libelle\":\"Consultation\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:59:19'),
(43, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"cheickna.doumbia\",\"email\":\"cheickna.doumbia@techouse.io\",\"civilite\":\"M\",\"nom\":\"DOUMBIA\",\"nom_patronymique\":\"\",\"prenoms\":\"CHEICKNA\",\"date_naissance\":\"02\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 14:12:30'),
(44, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Pathologies/submit_pathologie_chapitre.php', 'EDITION', '{\"code\":\"CHAP1\",\"libelle\":\"chapitre1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:12:35'),
(45, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Pathologies/submit_pathologie_sous_chapitre.php', 'EDITION', '{\"code\":\"SCHAP1\",\"code_chapitre\":\"CHAP1\",\"libelle\":\"sous chapitre 1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:13:39'),
(46, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Pathologies/submit_pathologie.php', 'EDITION', '{\"code\":\"P1\",\"code_sous_chapitre\":\"SCHAP1\",\"libelle\":\"PATHOLOGIE1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:14:35'),
(47, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/ActesMedicaux/submit_acte_lettre_cle.php', 'EDITION', '{\"code\":\"Z\",\"prix\":\"2000\",\"libelle\":\"Radiologie\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:16:26'),
(48, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/ActesMedicaux/submit_acte_medical_titre.php', 'EDITION', '{\"code\":\"T1\",\"libelle\":\"titre1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:17:10'),
(49, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/ActesMedicaux/submit_acte_medical_chapitre.php', 'EDITION', '{\"code\":\"CHAP1\",\"titre\":\"T1\",\"libelle\":\"chapitre1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:21:26'),
(50, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php', 'EDITION', '{\"id_user\":\"\",\"num_secu\":\"\",\"num_matricule\":\"\",\"nom_utilisateur\":\"cheickna.doumbia\",\"email\":\"cheickna.doumbia@techouse.io\",\"civilite\":\"M\",\"nom\":\"DOUMBIA\",\"nom_patronymique\":\"\",\"prenoms\":\"CHEICKNA\",\"date_naissance\":\"02\\/04\\/2002\",\"sexe\":\"M\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 14:28:57'),
(51, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/ActesMedicaux/submit_acte_medical_section.php', 'EDITION', '{\"code\":\"sect1\",\"code_chapitre\":\"CHAP1\",\"libelle\":\"section1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:31:48'),
(52, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/ActesMedicaux/submit_acte_article.php', 'EDITION', '{\"code_chapitre\":\"CHAP1\",\"code\":\"ART1\",\"code_section\":\"SECT1\",\"libelle\":\"article1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:44:01'),
(53, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/ActesMedicaux/submit_acte_medical.php', 'EDITION', '{\"code\":\"ACT1\",\"code_article\":\"ART1\",\"valeur\":\"2\",\"code_lettre\":\"C\",\"libelle\":\"acte medical 1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:44:40'),
(54, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_medicaments_laboratoire_pharmaceutique.php', 'EDITION', '{\"code\":\"LAB1\",\"libelle\":\"laboratoire1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:46:14'),
(55, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_presentation.php', 'EDITION', '{\"code\":\"PRE1\",\"libelle\":\"presentation\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:46:52'),
(56, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_famille_forme.php', 'EDITION', '{\"code\":\"F1\",\"libelle\":\"famille1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:47:48'),
(57, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_forme.php', 'EDITION', '{\"code\":\"Fe1\",\"libelle\":\"forme1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:48:31'),
(58, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_type_medicament.php', 'EDITION', '{\"code\":\"TYP1\",\"libelle\":\"TYPE1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:49:06'),
(59, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_classe_therapeuthique.php', 'EDITION', '{\"code\":\"CL1\",\"libelle\":\"classe1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:49:46'),
(60, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_forme_administration.php', 'EDITION', '{\"code\":\"FA1\",\"libelle\":\"forme administration 1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:50:22'),
(61, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_unite_dosage.php', 'EDITION', '{\"code\":\"U1\",\"libelle\":\"unite1\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:50:57'),
(62, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_denomination_commune_internationale.php', 'EDITION', '{\"code\":\"DCI1\",\"libelle\":\"PARACETAMOL\"}', '16012012918420210430134121608c090196e24537856', '2021-04-30 14:51:55'),
(63, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 14:58:05'),
(64, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_profil.php', 'MISE A JOUR STATUT', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 15:50:59'),
(65, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_profil.php', 'MISE A JOUR DU PROFIL', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 15:52:18'),
(66, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_profil.php', 'MISE A JOUR DU PROFIL', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 15:55:42'),
(67, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_statut.php', 'MISE A JOUR STATUT', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 15:56:18'),
(68, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'cheickna.doumbia@techouse.io', '16012012918420210430142857608c142929902425196', '2021-04-30 16:14:08'),
(69, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_mot_de_passe.php', 'MISE A JOUR MDP', '********', '16012012918420210430142857608c142929902425196', '2021-04-30 16:14:45'),
(70, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_statut.php', 'MISE A JOUR STATUT', '********', '16012012918420210430142857608c142929902425196', '2021-04-30 16:21:02'),
(71, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-03 09:11:04'),
(72, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-03 11:03:12'),
(73, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_profil.php', 'MISE A JOUR DU PROFIL', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-05-03 11:11:35'),
(74, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-03 12:15:16'),
(75, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-03 13:31:44'),
(76, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_niveau_sanitaire.php', 'EDITION', '{\"code\":\"N1\",\"libelle\":\"Niveau 1\",\"niveau\":\"1\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-03 13:42:35'),
(77, '154.68.36.83', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_type_etablissement.php', 'EDITION', '{\"code\":\"CSU\",\"libelle\":\"centre de sant\\u00e9 urbain\",\"code_niveau\":\"N1\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-03 14:10:27'),
(78, '196.43.233.204', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-04 22:20:12'),
(79, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 13:24:30'),
(80, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement.php', 'EDITION', '{\"code\":\"000199998\",\"raison_sociale\":\"Centre m\\u00e9dical initial r\\u00e9f\\u00e9rent\",\"type_etablissement\":\"csu\",\"niveau\":\"n1\",\"secteur\":\"PRV\",\"adresse_geo\":\"\",\"adresse_post\":\"\",\"longitude\":\"\",\"latitude\":\"\",\"pays\":\"CIV\",\"region\":\"0001\",\"departement\":\"0001\",\"commune\":\"0001\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 14:08:10'),
(81, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:08:32'),
(82, '160.154.151.95', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_type_coordonnee.php', 'EDITION', '{\"code\":\"SITWEB\",\"libelle\":\"Site web\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:35:29'),
(83, '160.154.151.95', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_type_coordonnee.php', 'EDITION', '{\"code\":\"MELPER\",\"libelle\":\"Email personnel\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:36:17'),
(84, '160.154.151.95', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_type_coordonnee.php', 'EDITION', '{\"code\":\"MELPRO\",\"libelle\":\"Email professionnel\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:36:46'),
(85, '160.154.151.95', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_type_coordonnee.php', 'EDITION', '{\"code\":\"MOBPRO\",\"libelle\":\"Mobile professionnel\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:37:44'),
(86, '160.154.151.95', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_type_coordonnee.php', 'EDITION', '{\"code\":\"TELFIX\",\"libelle\":\"T\\u00e9l\\u00e9phone fixe\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:39:10'),
(87, '160.154.151.95', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement_coordonnee.php', 'EDITION', '{\"code_etablissement\":\"000199998\",\"type_coord\":\"MELPRO\",\"valeur\":\"initial@centre.com\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:42:03'),
(88, '160.154.151.95', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement_coordonnee.php', 'EDITION', '{\"code_etablissement\":\"000199998\",\"type_coord\":\"TELFIX\",\"valeur\":\"2720000000\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 19:52:06'),
(89, '160.154.151.95', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement_coordonnee.php', 'EDITION', '{\"code_etablissement\":\"000199998\",\"type_coord\":\"MOBPRO\",\"valeur\":\"0707010101\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 20:02:33'),
(90, '102.137.11.156', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 20:45:08'),
(91, '102.137.11.156', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement.php', 'EDITION', '{\"code\":\"000100009\",\"raison_sociale\":\"CROU HOUPHOUET BOIGNY\",\"type_etablissement\":\"csu\",\"niveau\":\"N1\",\"secteur\":\"PUB\",\"adresse_geo\":\"\",\"adresse_post\":\"\",\"longitude\":\"\",\"latitude\":\"\",\"pays\":\"CIV\",\"region\":\"0001\",\"departement\":\"0001\",\"commune\":\"0001\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 21:43:14'),
(92, '102.137.11.156', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement_coordonnee.php', 'EDITION', '{\"code_ets\":\"000100009\",\"type_coord\":\"MOBPRO\",\"valeur\":\"0707000000\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 22:14:04'),
(93, '102.137.11.156', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement_coordonnee.php', 'EDITION', '{\"code_ets\":\"000100009\",\"type_coord\":\"SITWEB\",\"valeur\":\"https:\\/\\/cmir.ci\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-06 22:16:56'),
(94, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-07 09:33:45'),
(95, '41.87.59.168', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-08 11:52:39'),
(96, '102.138.195.59', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-08 19:21:17'),
(97, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-09 14:37:32'),
(98, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-09 16:44:31'),
(99, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement_coordonnee.php', 'EDITION', '{\"code_ets\":\"000199998\",\"type_coord\":\"MOBPER\",\"valeur\":\"0101010101\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-09 16:50:26'),
(100, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-10 11:11:26'),
(101, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement_coordonnee.php', 'EDITION', '{\"code_ets\":\"000199998\",\"type_coord\":\"MELPER\",\"valeur\":\"test@test.com\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-10 11:12:57'),
(102, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_profil_utilisateur.php', 'EDITION', '{\"code\":\"CSRESP\",\"libelle\":\"Responsable centre de sant\\u00e9\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-10 11:18:10'),
(103, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-14 13:35:03'),
(104, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-14 19:31:48'),
(105, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-14 21:03:03'),
(106, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_groupe_sanguin.php', 'EDITION', '{\"id_user\":\"16012012918420210430115828608bf0e4467c8240168\",\"code_groupe\":\"A\",\"code_rhesus\":\"+\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-14 21:43:42'),
(107, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_groupe_sanguin.php', 'EDITION', '{\"id_user\":\"16012012918420210430115828608bf0e4467c8240168\",\"code_groupe\":\"AB\",\"code_rhesus\":\"+\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-14 21:44:02'),
(108, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 12:59:38'),
(109, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:26:10'),
(110, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"01\",\"libelle\":\"m\\u00e9decine g\\u00e9n\\u00e9rale\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:40:45'),
(111, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"02\",\"libelle\":\"immunologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:41:08'),
(112, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"03\",\"libelle\":\"radiologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:41:22'),
(113, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"04\",\"libelle\":\"chirurgie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:41:50'),
(114, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"05\",\"libelle\":\"neurologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:42:16'),
(115, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"06\",\"libelle\":\"pneumologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:42:30'),
(116, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"07\",\"libelle\":\"cardiologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:42:52'),
(117, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"08\",\"libelle\":\"odontologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:43:12'),
(118, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"09\",\"libelle\":\"dermatologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:43:31'),
(119, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"10\",\"libelle\":\"service d\'accueil de traitement des urgences\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:43:44'),
(120, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"11\",\"libelle\":\"traumatologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:44:11'),
(121, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"12\",\"libelle\":\"m\\u00e9decine interne\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:44:32'),
(122, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"13\",\"libelle\":\"endocrinologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:45:09'),
(123, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"14\",\"libelle\":\"anatomo-pathologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:45:26'),
(124, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"15\",\"libelle\":\"h\\u00e9matologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:45:47'),
(125, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"16\",\"libelle\":\"gastro-ent\\u00e9rologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:46:07'),
(126, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"17\",\"libelle\":\"urologie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:46:29'),
(127, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"18\",\"libelle\":\"pharmacie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:46:45'),
(128, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"19\",\"libelle\":\"maternit\\u00e9\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:46:57'),
(129, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"20\",\"libelle\":\"P\\u00e9diatrie\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:47:11'),
(130, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_etablissement_service.php', 'EDITION', '{\"code\":\"21\",\"libelle\":\"Service des grands br\\u00fbl\\u00e9s\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 22:47:31'),
(131, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_ets_service.php', 'EDITION', '{\"code_ets\":\"000199998\",\"code_service\":\"01\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 23:11:31'),
(132, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_ets_service.php', 'EDITION', '{\"code_ets\":\"000199998\",\"code_service\":\"05\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 23:13:36'),
(133, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_ets_service.php', 'EDITION', '{\"code_ets\":\"000199998\",\"code_service\":\"18\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 23:14:50'),
(134, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_profil_utilisateur.php', 'EDITION', '{\"code\":\"CSAGNT\",\"libelle\":\"Agent de centre\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 23:40:22'),
(135, '196.32.175.155', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_profil.php', 'MISE A JOUR DU PROFIL', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 23:41:47'),
(136, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '16012012918420210430115828608bf0e4467c8240168', '2021-05-17 09:52:50'),
(137, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_statut.php', 'MISE A JOUR STATUT', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-05-17 09:54:37'),
(138, '160.154.157.31', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'landry.seye@techouse.io', '16012012918420210430134121608c090196e24537856', '2021-05-17 09:54:55'),
(139, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_ordre_nationnale.php', 'EDITION', '{\"code\":\"1\",\"libelle\":\"Ordre des pharmaciens\"}', '16012012918420210430115828608bf0e4467c8240168', '2021-05-17 09:56:43'),
(140, '160.120.129.184', 'https://projets.techouse.io/ouagolo/_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_profil.php', 'MISE A JOUR DU PROFIL', '********', '16012012918420210430115828608bf0e4467c8240168', '2021-05-17 10:01:48');

-- --------------------------------------------------------

--
-- Structure de la table `tb_professionnels_sante`
--

CREATE TABLE `tb_professionnels_sante` (
  `utilisateur_id` varchar(45) NOT NULL,
  `professionnel_code` varchar(9) NOT NULL,
  `professionnel_date_debut` date NOT NULL,
  `professionnel_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_actes_articles`
--

CREATE TABLE `tb_ref_actes_articles` (
  `article_code` varchar(7) NOT NULL,
  `chapitre_code` varchar(7) NOT NULL,
  `section_code` varchar(7) DEFAULT NULL,
  `article_libelle` varchar(100) NOT NULL,
  `article_date_debut` date NOT NULL,
  `article_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_actes_articles`
--

INSERT INTO `tb_ref_actes_articles` (`article_code`, `chapitre_code`, `section_code`, `article_libelle`, `article_date_debut`, `article_date_fin`, `date_creation`, `utilisateur_id_creation`, `utilisateur_id_edition`, `date_edition`) VALUES
('ART1', 'CHAP1', 'SECT1', 'ARTICLE1', '2021-04-30', NULL, '2021-04-30 14:44:01', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_actes_chapitres`
--

CREATE TABLE `tb_ref_actes_chapitres` (
  `chapitre_code` varchar(7) NOT NULL,
  `titre_code` varchar(7) NOT NULL,
  `chapitre_libelle` varchar(100) NOT NULL,
  `chapitre_date_debut` date NOT NULL,
  `chapitre_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_actes_chapitres`
--

INSERT INTO `tb_ref_actes_chapitres` (`chapitre_code`, `titre_code`, `chapitre_libelle`, `chapitre_date_debut`, `chapitre_date_fin`, `date_creation`, `utilisateur_id_creation`, `utilisateur_id_edition`, `date_edition`) VALUES
('CHAP1', 'T1', 'CHAPITRE1', '2021-04-30', NULL, '2021-04-30 14:21:26', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_actes_medicaux`
--

CREATE TABLE `tb_ref_actes_medicaux` (
  `acte_code` varchar(7) NOT NULL,
  `article_code` varchar(7) NOT NULL,
  `acte_libelle` varchar(100) NOT NULL,
  `acte_date_debut` date NOT NULL,
  `acte_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_actes_medicaux`
--

INSERT INTO `tb_ref_actes_medicaux` (`acte_code`, `article_code`, `acte_libelle`, `acte_date_debut`, `acte_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('ACT1', 'ART1', 'ACTE MEDICAL 1', '2021-04-30', NULL, '2021-04-30 14:44:40', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_actes_medicaux_coefficients`
--

CREATE TABLE `tb_ref_actes_medicaux_coefficients` (
  `acte_code` varchar(7) NOT NULL,
  `lettre_cle_code` varchar(5) NOT NULL,
  `coefficient_valeur` float NOT NULL,
  `coefficient_date_debut` date NOT NULL,
  `coeffient_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_actes_medicaux_coefficients`
--

INSERT INTO `tb_ref_actes_medicaux_coefficients` (`acte_code`, `lettre_cle_code`, `coefficient_valeur`, `coefficient_date_debut`, `coeffient_date_fin`, `date_creation`, `utilisateur_id_creation`, `utilisateur_id_edition`, `date_edition`) VALUES
('ACT1', 'C', 2, '2021-04-30', NULL, '2021-04-30 14:44:40', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_actes_sections`
--

CREATE TABLE `tb_ref_actes_sections` (
  `section_code` varchar(7) NOT NULL,
  `chapitre_code` varchar(7) NOT NULL,
  `section_libelle` varchar(100) NOT NULL,
  `section_date_debut` date NOT NULL,
  `section_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_actes_sections`
--

INSERT INTO `tb_ref_actes_sections` (`section_code`, `chapitre_code`, `section_libelle`, `section_date_debut`, `section_date_fin`, `date_creation`, `utilisateur_id_creation`, `utilisateur_id_edition`, `date_edition`) VALUES
('SECT1', 'CHAP1', 'SECTION1', '2021-04-30', NULL, '2021-04-30 14:31:48', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_actes_titres`
--

CREATE TABLE `tb_ref_actes_titres` (
  `titre_code` varchar(7) NOT NULL,
  `titre_libelle` varchar(100) NOT NULL,
  `titre_date_debut` date NOT NULL,
  `titre_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_actes_titres`
--

INSERT INTO `tb_ref_actes_titres` (`titre_code`, `titre_libelle`, `titre_date_debut`, `titre_date_fin`, `date_creation`, `utilisateur_id_creation`, `utilisateur_id_edition`, `date_edition`) VALUES
('T1', 'TITRE1', '2021-04-30', NULL, '2021-04-30 14:17:10', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_categories_professionnelles_sante`
--

CREATE TABLE `tb_ref_categories_professionnelles_sante` (
  `categorie_professionnelle_sante_code` varchar(7) NOT NULL,
  `categorie_professionnelle_sante_libelle` varchar(100) NOT NULL,
  `categorie_professionnelle_sante_date_debut` date NOT NULL,
  `categorie_professionnelle_sante_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisation_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_categories_socio_professionnelles`
--

CREATE TABLE `tb_ref_categories_socio_professionnelles` (
  `categorie_socio_professionnelle_code` varchar(3) NOT NULL,
  `categorie_socio_professionnelle_libelle` varchar(45) NOT NULL,
  `categorie_socio_professionnelle_date_debut` date NOT NULL,
  `categorie_socio_professionnelle_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_categories_socio_professionnelles`
--

INSERT INTO `tb_ref_categories_socio_professionnelles` (`categorie_socio_professionnelle_code`, `categorie_socio_professionnelle_libelle`, `categorie_socio_professionnelle_date_debut`, `categorie_socio_professionnelle_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('SAL', 'SALARIE', '2021-04-30', NULL, '2021-04-30 12:27:59', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_civilites`
--

CREATE TABLE `tb_ref_civilites` (
  `civilite_code` varchar(4) NOT NULL,
  `civilite_libelle` varchar(45) NOT NULL,
  `civilite_date_debut` date NOT NULL,
  `civilite_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_civilites`
--

INSERT INTO `tb_ref_civilites` (`civilite_code`, `civilite_libelle`, `civilite_date_debut`, `civilite_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('M', 'MONSIEUR', '2021-04-30', NULL, '2021-04-30 12:28:28', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_etablissements_services`
--

CREATE TABLE `tb_ref_etablissements_services` (
  `etablissement_service_code` varchar(10) NOT NULL,
  `etablissement_service_libelle` varchar(100) NOT NULL,
  `etablissement_service_date_debut` date NOT NULL,
  `etablissement_service_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisation_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_etablissements_services`
--

INSERT INTO `tb_ref_etablissements_services` (`etablissement_service_code`, `etablissement_service_libelle`, `etablissement_service_date_debut`, `etablissement_service_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisation_id_edition`) VALUES
('01', 'MEDECINE GENERALE', '2021-05-15', NULL, '2021-05-15 22:40:45', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('02', 'IMMUNOLOGIE', '2021-05-15', NULL, '2021-05-15 22:41:08', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('03', 'RADIOLOGIE', '2021-05-15', NULL, '2021-05-15 22:41:22', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('04', 'CHIRURGIE', '2021-05-15', NULL, '2021-05-15 22:41:50', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('05', 'NEUROLOGIE', '2021-05-15', NULL, '2021-05-15 22:42:16', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('06', 'PNEUMOLOGIE', '2021-05-15', NULL, '2021-05-15 22:42:30', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('07', 'CARDIOLOGIE', '2021-05-15', NULL, '2021-05-15 22:42:52', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('08', 'ODONTOLOGIE', '2021-05-15', NULL, '2021-05-15 22:43:12', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('09', 'DERMATOLOGIE', '2021-05-15', NULL, '2021-05-15 22:43:31', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('10', 'SERVICE D\'ACCUEIL DE TRAITEMENT DES URGENCES', '2021-05-15', NULL, '2021-05-15 22:43:44', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('11', 'TRAUMATOLOGIE', '2021-05-15', NULL, '2021-05-15 22:44:11', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('12', 'MEDECINE INTERNE', '2021-05-15', NULL, '2021-05-15 22:44:32', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('13', 'ENDOCRINOLOGIE', '2021-05-15', NULL, '2021-05-15 22:45:09', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('14', 'ANATOMO-PATHOLOGIE', '2021-05-15', NULL, '2021-05-15 22:45:26', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('15', 'HEMATOLOGIE', '2021-05-15', NULL, '2021-05-15 22:45:47', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('16', 'GASTRO-ENTEROLOGIE', '2021-05-15', NULL, '2021-05-15 22:46:07', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('17', 'UROLOGIE', '2021-05-15', NULL, '2021-05-15 22:46:29', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('18', 'PHARMACIE', '2021-05-15', NULL, '2021-05-15 22:46:45', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('19', 'MATERNITE', '2021-05-15', NULL, '2021-05-15 22:46:57', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('20', 'PEDIATRIE', '2021-05-15', NULL, '2021-05-15 22:47:11', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('21', 'SERVICE DES GRANDS BRULES', '2021-05-15', NULL, '2021-05-15 22:47:31', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_geo_communes`
--

CREATE TABLE `tb_ref_geo_communes` (
  `departement_code` varchar(5) NOT NULL,
  `commune_code` varchar(5) NOT NULL,
  `commune_nom` varchar(45) NOT NULL,
  `commune_latitude` varchar(15) DEFAULT NULL,
  `commune_longitude` varchar(15) DEFAULT NULL,
  `commune_date_debut` date NOT NULL,
  `commune_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_geo_communes`
--

INSERT INTO `tb_ref_geo_communes` (`departement_code`, `commune_code`, `commune_nom`, `commune_latitude`, `commune_longitude`, `commune_date_debut`, `commune_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('0001', '0001', 'COCODY', '345676543', '56765432', '2021-04-30', NULL, '2021-04-30 13:00:01', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_geo_departements`
--

CREATE TABLE `tb_ref_geo_departements` (
  `region_code` varchar(4) NOT NULL,
  `departement_code` varchar(5) NOT NULL,
  `departement_nom` varchar(45) NOT NULL,
  `departement_latitude` varchar(15) DEFAULT NULL,
  `departement_longitude` varchar(15) DEFAULT NULL,
  `departement_date_debut` date NOT NULL,
  `departement_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_geo_departements`
--

INSERT INTO `tb_ref_geo_departements` (`region_code`, `departement_code`, `departement_nom`, `departement_latitude`, `departement_longitude`, `departement_date_debut`, `departement_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('0001', '0001', 'ABIDJAN', '765432', '765433', '2021-04-30', NULL, '2021-04-30 12:57:18', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_geo_pays`
--

CREATE TABLE `tb_ref_geo_pays` (
  `pays_code` varchar(3) NOT NULL,
  `pays_nom` varchar(45) NOT NULL,
  `pays_gentile` varchar(45) DEFAULT NULL COMMENT 'Gentilé: Dénomination des habitants d''un lieu',
  `pays_indicatif_telephonique` int(11) DEFAULT NULL,
  `pays_latitude` varchar(15) DEFAULT NULL,
  `pays_longitude` varchar(15) DEFAULT NULL,
  `pays_drapeau_image` varchar(45) DEFAULT NULL,
  `monnaie_code` varchar(3) DEFAULT NULL,
  `pays_date_debut` date NOT NULL,
  `pays_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_geo_pays`
--

INSERT INTO `tb_ref_geo_pays` (`pays_code`, `pays_nom`, `pays_gentile`, `pays_indicatif_telephonique`, `pays_latitude`, `pays_longitude`, `pays_drapeau_image`, `monnaie_code`, `pays_date_debut`, `pays_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('CIV', 'COTE D\'IVOIRE', 'IVOIRIENS', 225, '7°32\'23.96\"N', '5°32\'49.488\"O', NULL, 'XOF', '2021-04-30', NULL, '2021-04-30 12:55:41', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_geo_regions`
--

CREATE TABLE `tb_ref_geo_regions` (
  `pays_code` varchar(3) NOT NULL,
  `region_code` varchar(4) NOT NULL,
  `region_nom` varchar(45) NOT NULL,
  `region_latitude` varchar(15) DEFAULT NULL,
  `region_longitude` varchar(15) DEFAULT NULL,
  `region_date_debut` date NOT NULL,
  `region_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_geo_regions`
--

INSERT INTO `tb_ref_geo_regions` (`pays_code`, `region_code`, `region_nom`, `region_latitude`, `region_longitude`, `region_date_debut`, `region_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('CIV', '0001', 'DISTRICT D\'ABIDJAN', '1234567', '2345678', '2021-04-30', NULL, '2021-04-30 12:56:29', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_groupes_sanguins`
--

CREATE TABLE `tb_ref_groupes_sanguins` (
  `groupe_sanguin_code` varchar(2) NOT NULL,
  `groupe_sanguin_libelle` varchar(45) NOT NULL,
  `groupe_sanguin_date_debut` date NOT NULL,
  `groupe_sanguin_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_groupes_sanguins`
--

INSERT INTO `tb_ref_groupes_sanguins` (`groupe_sanguin_code`, `groupe_sanguin_libelle`, `groupe_sanguin_date_debut`, `groupe_sanguin_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('A', 'A', '2021-04-30', NULL, '2021-04-30 12:49:39', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('AB', 'AB', '2021-04-30', NULL, '2021-04-30 12:50:15', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('B', 'B', '2021-04-30', NULL, '2021-04-30 12:50:03', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('O', 'O', '2021-04-30', NULL, '2021-04-30 12:49:51', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_lettres_cles`
--

CREATE TABLE `tb_ref_lettres_cles` (
  `lettre_cle_code` varchar(5) NOT NULL,
  `lettre_cle_libelle` varchar(100) NOT NULL,
  `lettre_cle_prix_unitaire` int(11) NOT NULL,
  `lettre_cle_date_debut` date NOT NULL,
  `lettre_cle_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_lettres_cles`
--

INSERT INTO `tb_ref_lettres_cles` (`lettre_cle_code`, `lettre_cle_libelle`, `lettre_cle_prix_unitaire`, `lettre_cle_date_debut`, `lettre_cle_date_fin`, `date_creation`, `utilisateur_id_creation`, `utilisateur_id_edition`, `date_edition`) VALUES
('C', 'CONSULTATION', 1000, '2021-04-30', NULL, '2021-04-30 13:59:19', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('Z', 'RADIOLOGIE', 2000, '2021-04-30', NULL, '2021-04-30 14:16:26', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_classes_therapeutiques`
--

CREATE TABLE `tb_ref_medicaments_classes_therapeutiques` (
  `classe_therapeutique_code` varchar(7) NOT NULL,
  `classe_therapeutique_libelle` varchar(100) NOT NULL,
  `classe_therapeutique_date_debut` date NOT NULL,
  `classe_therapeutique_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` date DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_classes_therapeutiques`
--

INSERT INTO `tb_ref_medicaments_classes_therapeutiques` (`classe_therapeutique_code`, `classe_therapeutique_libelle`, `classe_therapeutique_date_debut`, `classe_therapeutique_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('CL1', 'CLASSE1', '2021-04-30', NULL, '2021-04-30 14:49:46', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_dci`
--

CREATE TABLE `tb_ref_medicaments_dci` (
  `dci_code` varchar(20) NOT NULL,
  `forme_code` varchar(7) NOT NULL,
  `dci_dosage` int(11) NOT NULL,
  `unite_dosage_code` varchar(7) NOT NULL,
  `dci_libelle` varchar(100) NOT NULL,
  `dci_date_debut` date NOT NULL,
  `dci_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` date DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_dci`
--

INSERT INTO `tb_ref_medicaments_dci` (`dci_code`, `forme_code`, `dci_dosage`, `unite_dosage_code`, `dci_libelle`, `dci_date_debut`, `dci_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('DCI1', '', 0, '', 'PARACETAMOL', '2021-04-30', NULL, '2021-04-30 14:51:55', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_familles_formes`
--

CREATE TABLE `tb_ref_medicaments_familles_formes` (
  `famille_code` varchar(7) NOT NULL,
  `famille_libelle` varchar(100) NOT NULL,
  `famille_date_debut` date NOT NULL,
  `famille_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_familles_formes`
--

INSERT INTO `tb_ref_medicaments_familles_formes` (`famille_code`, `famille_libelle`, `famille_date_debut`, `famille_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('F1', 'FAMILLE1', '2021-04-30', NULL, '2021-04-30 14:47:48', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_formes`
--

CREATE TABLE `tb_ref_medicaments_formes` (
  `forme_code` varchar(7) NOT NULL,
  `forme_libelle` varchar(100) NOT NULL,
  `forme_date_debut` date NOT NULL,
  `forme_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_formes`
--

INSERT INTO `tb_ref_medicaments_formes` (`forme_code`, `forme_libelle`, `forme_date_debut`, `forme_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('FE1', 'FORME1', '2021-04-30', NULL, '2021-04-30 14:48:31', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_formes_administrations`
--

CREATE TABLE `tb_ref_medicaments_formes_administrations` (
  `forme_administration_code` varchar(7) NOT NULL,
  `forme_administration_libelle` varchar(100) NOT NULL,
  `forme_administration_date_debut` date NOT NULL,
  `forme_administration_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` date DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_formes_administrations`
--

INSERT INTO `tb_ref_medicaments_formes_administrations` (`forme_administration_code`, `forme_administration_libelle`, `forme_administration_date_debut`, `forme_administration_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('FA1', 'FORME ADMINISTRATION 1', '2021-04-30', NULL, '2021-04-30 14:50:22', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_laboratoires_pharmaceutiques`
--

CREATE TABLE `tb_ref_medicaments_laboratoires_pharmaceutiques` (
  `laboratoire_code` varchar(7) NOT NULL,
  `laboratoire_libelle` varchar(100) NOT NULL,
  `laboratoire_date_debut` date NOT NULL,
  `laboratoire_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_laboratoires_pharmaceutiques`
--

INSERT INTO `tb_ref_medicaments_laboratoires_pharmaceutiques` (`laboratoire_code`, `laboratoire_libelle`, `laboratoire_date_debut`, `laboratoire_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('LAB1', 'LABORATOIRE1', '2021-04-30', NULL, '2021-04-30 14:46:14', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_presentations`
--

CREATE TABLE `tb_ref_medicaments_presentations` (
  `presentation_code` varchar(7) NOT NULL,
  `presentation_libelle` varchar(100) NOT NULL,
  `presentation_date_debut` date NOT NULL,
  `presentation_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` date DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_presentations`
--

INSERT INTO `tb_ref_medicaments_presentations` (`presentation_code`, `presentation_libelle`, `presentation_date_debut`, `presentation_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('PRE1', 'PRESENTATION', '2021-04-30', NULL, '2021-04-30 14:46:52', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_types_medicaments`
--

CREATE TABLE `tb_ref_medicaments_types_medicaments` (
  `type_medicament_code` varchar(7) NOT NULL,
  `type_medicament_libelle` varchar(100) NOT NULL,
  `type_medicament_date_debut` date NOT NULL,
  `type_medicament_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` date DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_types_medicaments`
--

INSERT INTO `tb_ref_medicaments_types_medicaments` (`type_medicament_code`, `type_medicament_libelle`, `type_medicament_date_debut`, `type_medicament_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('TYP1', 'TYPE1', '2021-04-30', NULL, '2021-04-30 14:49:06', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_medicaments_unites_de_dosage`
--

CREATE TABLE `tb_ref_medicaments_unites_de_dosage` (
  `unite_dosage_code` varchar(7) NOT NULL,
  `unite_dosage_libelle` varchar(20) NOT NULL,
  `unite_dosage_date_debut` date NOT NULL,
  `unite_dosage_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` date DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_medicaments_unites_de_dosage`
--

INSERT INTO `tb_ref_medicaments_unites_de_dosage` (`unite_dosage_code`, `unite_dosage_libelle`, `unite_dosage_date_debut`, `unite_dosage_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('U1', 'UNITE1', '2021-04-30', NULL, '2021-04-30 14:50:57', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_monnaies`
--

CREATE TABLE `tb_ref_monnaies` (
  `monnaie_code` varchar(3) NOT NULL,
  `monnaie_libelle` varchar(45) NOT NULL,
  `monnaie_symbole` varchar(10) DEFAULT NULL,
  `monnaie_logo` varchar(100) DEFAULT NULL,
  `monnaie_date_debut` date NOT NULL,
  `monnaie_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_monnaies`
--

INSERT INTO `tb_ref_monnaies` (`monnaie_code`, `monnaie_libelle`, `monnaie_symbole`, `monnaie_logo`, `monnaie_date_debut`, `monnaie_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('XOF', 'FRANC CFA', NULL, NULL, '2021-04-30', NULL, '2021-04-30 12:49:24', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_ordres_nationnaux`
--

CREATE TABLE `tb_ref_ordres_nationnaux` (
  `orde_nationnal_code` varchar(7) NOT NULL,
  `orde_nationnal_libelle` varchar(100) NOT NULL,
  `orde_nationnal_date_debut` date NOT NULL,
  `orde_nationnal_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisation_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_ordres_nationnaux`
--

INSERT INTO `tb_ref_ordres_nationnaux` (`orde_nationnal_code`, `orde_nationnal_libelle`, `orde_nationnal_date_debut`, `orde_nationnal_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisation_id_edition`) VALUES
('1', 'ORDRE DES PHARMACIENS', '2021-05-17', NULL, '2021-05-17 09:56:43', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_pathologies`
--

CREATE TABLE `tb_ref_pathologies` (
  `pathologie_code` varchar(3) NOT NULL,
  `sous_chapitre_code` varchar(7) NOT NULL,
  `pathologie_libelle` varchar(100) NOT NULL,
  `pathologie_date_debut` date NOT NULL,
  `pathologie_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_pathologies`
--

INSERT INTO `tb_ref_pathologies` (`pathologie_code`, `sous_chapitre_code`, `pathologie_libelle`, `pathologie_date_debut`, `pathologie_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('A00', 'A00-A09', 'CHOLERA', '2021-04-30', NULL, '2021-04-30 13:13:15', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('P1', 'SCHAP1', 'PATHOLOGIE1', '2021-04-30', NULL, '2021-04-30 14:14:35', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_pathologies_chapitres`
--

CREATE TABLE `tb_ref_pathologies_chapitres` (
  `chapitre_code` varchar(7) NOT NULL,
  `chapitre_libelle` varchar(100) NOT NULL,
  `chapitre_date_debut` date NOT NULL,
  `chapitre_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` date DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_pathologies_chapitres`
--

INSERT INTO `tb_ref_pathologies_chapitres` (`chapitre_code`, `chapitre_libelle`, `chapitre_date_debut`, `chapitre_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('A00-B99', 'CERTAINES MALADIES INFECTIEUSES ET PARASITAIRES', '2021-04-30', NULL, '2021-04-30 13:10:02', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('CHAP1', 'CHAPITRE1', '2021-04-30', NULL, '2021-04-30 14:12:35', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_pathologies_sous_chapitres`
--

CREATE TABLE `tb_ref_pathologies_sous_chapitres` (
  `sous_chapitre_code` varchar(7) NOT NULL,
  `chapitre_code` varchar(7) NOT NULL,
  `sous_chapitre_libelle` varchar(100) NOT NULL,
  `sous_chapitre_date_debut` date NOT NULL,
  `sous_chapitre_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_pathologies_sous_chapitres`
--

INSERT INTO `tb_ref_pathologies_sous_chapitres` (`sous_chapitre_code`, `chapitre_code`, `sous_chapitre_libelle`, `sous_chapitre_date_debut`, `sous_chapitre_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('A00-A09', 'A00-B99', 'MALADIES INTESTINALES INFECTIEUSES', '2021-04-30', NULL, '2021-04-30 13:10:50', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('SCHAP1', 'CHAP1', 'SOUS CHAPITRE 1', '2021-04-30', NULL, '2021-04-30 14:13:39', '16012012918420210430134121608c090196e24537856', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_professions`
--

CREATE TABLE `tb_ref_professions` (
  `profession_code` varchar(4) NOT NULL,
  `profession_libelle` varchar(45) NOT NULL,
  `profession_date_debut` date NOT NULL,
  `profession_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_professions`
--

INSERT INTO `tb_ref_professions` (`profession_code`, `profession_libelle`, `profession_date_debut`, `profession_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('0001', 'ASSUREUR', '2021-04-30', NULL, '2021-04-30 12:34:49', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('0002', 'BANQUES / FINANCES / BOURSE', '2021-04-30', NULL, '2021-04-30 12:35:23', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_profils_utilisateurs`
--

CREATE TABLE `tb_ref_profils_utilisateurs` (
  `profil_utilisateur_code` varchar(6) NOT NULL,
  `profil_utilisateur_libelle` varchar(45) NOT NULL,
  `profil_utilisateur_date_debut` date NOT NULL,
  `profil_utilisateur_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_profils_utilisateurs`
--

INSERT INTO `tb_ref_profils_utilisateurs` (`profil_utilisateur_code`, `profil_utilisateur_libelle`, `profil_utilisateur_date_debut`, `profil_utilisateur_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('ADMN', 'ADMINISTRATEUR', '2021-04-30', NULL, '2021-04-30 12:17:50', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('CSAGNT', 'AGENT ETS', '2021-05-15', NULL, '2021-05-15 23:40:22', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('CSRESP', 'RESPONSABLE ETS', '2021-05-10', NULL, '2021-05-10 11:18:10', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_qualites_civiles`
--

CREATE TABLE `tb_ref_qualites_civiles` (
  `qualite_civile_code` varchar(3) NOT NULL,
  `qualite_civile_libelle` varchar(45) NOT NULL,
  `qualite_civile_date_debut` date NOT NULL,
  `qualite_civile_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_qualites_civiles`
--

INSERT INTO `tb_ref_qualites_civiles` (`qualite_civile_code`, `qualite_civile_libelle`, `qualite_civile_date_debut`, `qualite_civile_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('PAY', 'PAYEUR', '2021-04-30', NULL, '2021-04-30 12:41:55', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_rhesus`
--

CREATE TABLE `tb_ref_rhesus` (
  `rhesus_code` varchar(1) NOT NULL,
  `rhesus_libelle` varchar(45) NOT NULL,
  `rhesus_date_debut` date NOT NULL,
  `rhesus_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_rhesus`
--

INSERT INTO `tb_ref_rhesus` (`rhesus_code`, `rhesus_libelle`, `rhesus_date_debut`, `rhesus_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('+', 'POSITIF', '2021-04-30', NULL, '2021-04-30 12:50:53', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('-', 'NEGATIF', '2021-04-30', NULL, '2021-04-30 12:50:41', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_secteurs_activites`
--

CREATE TABLE `tb_ref_secteurs_activites` (
  `secteur_activite_code` varchar(3) NOT NULL,
  `secteur_activite_libelle` varchar(45) NOT NULL,
  `secteur_activite_date_debut` date NOT NULL,
  `secteur_activite_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_secteurs_activites`
--

INSERT INTO `tb_ref_secteurs_activites` (`secteur_activite_code`, `secteur_activite_libelle`, `secteur_activite_date_debut`, `secteur_activite_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('PRV', 'PRIVE', '2021-04-30', NULL, '2021-04-30 12:32:19', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('PUB', 'PUBLIC', '2021-04-30', NULL, '2021-04-30 12:32:59', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_sexes`
--

CREATE TABLE `tb_ref_sexes` (
  `sexe_code` varchar(1) NOT NULL,
  `sexe_libelle` varchar(45) NOT NULL,
  `sexe_date_debut` date NOT NULL,
  `sexe_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_sexes`
--

INSERT INTO `tb_ref_sexes` (`sexe_code`, `sexe_libelle`, `sexe_date_debut`, `sexe_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('F', 'FEMININ', '2021-04-30', NULL, '2021-04-30 12:29:02', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('M', 'MASCULIN', '2021-04-30', NULL, '2021-04-30 12:28:47', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_situations_familiales`
--

CREATE TABLE `tb_ref_situations_familiales` (
  `situation_familiale_code` varchar(3) NOT NULL,
  `situation_familiale_libelle` varchar(45) NOT NULL,
  `situation_familiale_date_debut` date NOT NULL,
  `situation_familiale_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_situations_familiales`
--

INSERT INTO `tb_ref_situations_familiales` (`situation_familiale_code`, `situation_familiale_libelle`, `situation_familiale_date_debut`, `situation_familiale_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('CEL', 'CELIBATAIRE', '2021-04-30', NULL, '2021-04-30 12:30:36', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_types_accidents`
--

CREATE TABLE `tb_ref_types_accidents` (
  `types_accidents_code` varchar(6) NOT NULL,
  `types_accidents_libelle` varchar(45) NOT NULL,
  `types_accidents_date_debut` date NOT NULL,
  `types_accidents_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_types_accidents`
--

INSERT INTO `tb_ref_types_accidents` (`types_accidents_code`, `types_accidents_libelle`, `types_accidents_date_debut`, `types_accidents_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('ATMP', 'ACCIDENT DE TRAVAIL / MALADIE PROFESSIONNELLE', '2021-04-30', NULL, '2021-04-30 12:26:40', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_types_coordonnees`
--

CREATE TABLE `tb_ref_types_coordonnees` (
  `type_coordonnee_code` varchar(6) NOT NULL,
  `type_coordonnee_libelle` varchar(45) NOT NULL,
  `type_coordonnee_date_debut` date NOT NULL,
  `type_coordonnee_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_types_coordonnees`
--

INSERT INTO `tb_ref_types_coordonnees` (`type_coordonnee_code`, `type_coordonnee_libelle`, `type_coordonnee_date_debut`, `type_coordonnee_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('MELPER', 'EMAIL PERSONNEL', '2021-05-06', NULL, '2021-05-06 19:36:17', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('MELPRO', 'EMAIL PROFESSIONNEL', '2021-05-06', NULL, '2021-05-06 19:36:46', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('MOBPER', 'MOBILE PERSONNEL', '2021-04-30', NULL, '2021-04-30 12:45:47', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('MOBPRO', 'MOBILE PROFESSIONNEL', '2021-05-06', NULL, '2021-05-06 19:37:44', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('SITWEB', 'SITE WEB', '2021-05-06', NULL, '2021-05-06 19:35:29', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('TELFIX', 'TELEPHONE FIXE', '2021-05-06', NULL, '2021-05-06 19:39:10', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_types_personnes`
--

CREATE TABLE `tb_ref_types_personnes` (
  `type_personne_code` varchar(1) NOT NULL,
  `type_personne_libelle` varchar(45) NOT NULL,
  `type_personne_date_debut` date NOT NULL,
  `type_personne_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_types_pieces_identites`
--

CREATE TABLE `tb_ref_types_pieces_identites` (
  `type_piece_identite_code` varchar(6) NOT NULL,
  `type_piece_identite_libelle` varchar(45) NOT NULL,
  `type_piece_identite_date_debut` date NOT NULL,
  `type_piece_identite_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_types_pieces_identites`
--

INSERT INTO `tb_ref_types_pieces_identites` (`type_piece_identite_code`, `type_piece_identite_libelle`, `type_piece_identite_date_debut`, `type_piece_identite_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('CNI', 'CARTE NATIONALE D\'IDENTITE', '2021-04-30', NULL, '2021-04-30 12:46:30', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_services_hospitaliers`
--

CREATE TABLE `tb_services_hospitaliers` (
  `etablissement_code` varchar(9) NOT NULL,
  `etablissement_service_code` varchar(10) NOT NULL,
  `service_hospitalier_date_debut` date NOT NULL,
  `service_hospitalier_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisation_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_services_hospitaliers`
--

INSERT INTO `tb_services_hospitaliers` (`etablissement_code`, `etablissement_service_code`, `service_hospitalier_date_debut`, `service_hospitalier_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisation_id_edition`) VALUES
('000199998', '01', '2021-05-15', NULL, '2021-05-15 23:11:31', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('000199998', '05', '2021-05-15', NULL, '2021-05-15 23:13:36', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('000199998', '18', '2021-05-15', NULL, '2021-05-15 23:14:50', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs`
--

CREATE TABLE `tb_utilisateurs` (
  `utilisateur_id` varchar(45) NOT NULL,
  `utilisateur_nip` varchar(20) DEFAULT NULL,
  `utilisateur_email` varchar(100) NOT NULL,
  `utilisateur_num_secu` varchar(20) DEFAULT NULL,
  `utilisateur_num_matricule` varchar(20) DEFAULT NULL,
  `utilisateur_pseudo` varchar(30) NOT NULL,
  `civilite_code` varchar(4) DEFAULT NULL,
  `utilisateur_prenoms` varchar(50) NOT NULL,
  `utilisateur_nom` varchar(30) NOT NULL,
  `utilisateur_nom_patronymique` varchar(30) DEFAULT NULL,
  `utilisateur_date_naissance` date DEFAULT NULL,
  `utilisateur_photo` text,
  `profil_utilisateur_code` varchar(6) DEFAULT NULL,
  `sexe_code` varchar(1) DEFAULT NULL,
  `situation_familiale_code` varchar(3) DEFAULT NULL,
  `categorie_socio_professionnelle_code` varchar(3) DEFAULT NULL,
  `pays_code` varchar(3) NOT NULL,
  `region_code` varchar(5) NOT NULL,
  `departement_code` varchar(5) NOT NULL,
  `commune_code` varchar(5) NOT NULL,
  `adresse_geographique` varchar(50) NOT NULL,
  `adresse_postal` varchar(50) NOT NULL,
  `profession_code` varchar(4) DEFAULT NULL,
  `secteur_activite_code` varchar(3) DEFAULT NULL,
  `groupe_sanguin_code` varchar(2) DEFAULT NULL,
  `rhesus_code` varchar(1) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_utilisateurs`
--

INSERT INTO `tb_utilisateurs` (`utilisateur_id`, `utilisateur_nip`, `utilisateur_email`, `utilisateur_num_secu`, `utilisateur_num_matricule`, `utilisateur_pseudo`, `civilite_code`, `utilisateur_prenoms`, `utilisateur_nom`, `utilisateur_nom_patronymique`, `utilisateur_date_naissance`, `utilisateur_photo`, `profil_utilisateur_code`, `sexe_code`, `situation_familiale_code`, `categorie_socio_professionnelle_code`, `pays_code`, `region_code`, `departement_code`, `commune_code`, `adresse_geographique`, `adresse_postal`, `profession_code`, `secteur_activite_code`, `groupe_sanguin_code`, `rhesus_code`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('16012012918420210430115828608bf0e4467c8240168', NULL, 'dognimin.koulibali@gmail.com', '', '', 'dognimin.koulibali', 'M', 'DOGNIMIN', 'KOULIBALI', '', '2002-04-10', NULL, 'CSAGNT', 'M', NULL, NULL, '', '', '', '', '', '', NULL, NULL, 'AB', '+', '2021-04-30 11:58:28', '1', '2021-05-17 10:01:48', '16012012918420210430115828608bf0e4467c8240168'),
('16012012918420210430134121608c090196e24537856', NULL, 'landry.seye@techouse.io', '', '', 'landry.seye', 'M', 'BI LANDRY', 'SEYE', '', '2002-04-10', NULL, 'ADMN', 'M', NULL, NULL, '', '', '', '', '', '', NULL, NULL, NULL, NULL, '2021-04-30 13:41:21', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 15:55:42', '16012012918420210430115828608bf0e4467c8240168'),
('16012012918420210430142857608c142929902425196', NULL, 'cheickna.doumbia@techouse.io', '', '', 'cheickna.doumbia', 'M', 'CHEICKNA', 'DOUMBIA', '', '2002-04-02', NULL, 'CSRESP', 'M', NULL, NULL, '', '', '', '', '', '', NULL, NULL, 'AB', '+', '2021-04-30 14:28:57', '16012012918420210430115828608bf0e4467c8240168', '2021-05-15 23:41:47', '16012012918420210430115828608bf0e4467c8240168');

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs_coordonnees`
--

CREATE TABLE `tb_utilisateurs_coordonnees` (
  `utilisateur_id` varchar(45) NOT NULL,
  `type_coordonnee_code` varchar(6) NOT NULL,
  `coordonnee_valeur` varchar(100) NOT NULL,
  `coordonnee_date_debut` date NOT NULL,
  `coordonnee_date_fin` date DEFAULT NULL,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  `date_edition` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs_ecu`
--

CREATE TABLE `tb_utilisateurs_ecu` (
  `utilisateur_id` varchar(45) NOT NULL,
  `ecu_nom` varchar(15) NOT NULL,
  `ecu_prenoms` varchar(50) NOT NULL,
  `ecu_telephone` varchar(10) NOT NULL,
  `ecu_date_debut` date NOT NULL,
  `ecu_date_fin` date DEFAULT NULL,
  `type_personne_code` varchar(7) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs_mots_de_passe`
--

CREATE TABLE `tb_utilisateurs_mots_de_passe` (
  `utilisateur_id` varchar(45) NOT NULL,
  `mot_de_passe` text NOT NULL,
  `user_mot_de_passe_statut` tinyint(1) NOT NULL,
  `mot_de_passe_date_debut` date NOT NULL,
  `mot_de_passe_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_utilisateurs_mots_de_passe`
--

INSERT INTO `tb_utilisateurs_mots_de_passe` (`utilisateur_id`, `mot_de_passe`, `user_mot_de_passe_statut`, `mot_de_passe_date_debut`, `mot_de_passe_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('16012012918420210430115828608bf0e4467c8240168', '$2y$11$p0gBoTl.ubQRybV2aEE4fe.bebnLmDJei9nrRkt/WEbz2uJ.am3rq', 0, '2021-04-30', '2021-04-29', '2021-04-30 11:58:28', '1', '2021-04-30 12:07:20', '16012012918420210430115828608bf0e4467c8240168'),
('16012012918420210430115828608bf0e4467c8240168', '$2y$11$eS1Z/QKMIgDFso//NfaqTuS2JbNPpCdZT50Lj2DHDdORJEs.yWSjG', 1, '2021-04-30', NULL, '2021-04-30 12:07:21', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('16012012918420210430134121608c090196e24537856', '$2y$11$1DjKFbtK5mv7zmyyoGlGL.T64lElO/qlrZlQUBev/PEYskf32whQK', 0, '2021-04-30', '2021-04-29', '2021-04-30 13:41:21', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 13:44:05', '16012012918420210430134121608c090196e24537856'),
('16012012918420210430134121608c090196e24537856', '$2y$11$VZfErZe1bunizyUGALoluOQxSpJOdmdtVWYFsK87tulHkzRzkEzqi', 1, '2021-04-30', NULL, '2021-04-30 13:44:05', '16012012918420210430134121608c090196e24537856', NULL, NULL),
('16012012918420210430142857608c142929902425196', '$2y$11$aw57gtWnWNBDEVo6PLid/uJfPUNwh/DRKtYPH3byJuv6FPQPz/VaC', 0, '2021-04-30', '2021-04-29', '2021-04-30 14:28:57', '16012012918420210430115828608bf0e4467c8240168', '2021-04-30 16:14:45', '16012012918420210430142857608c142929902425196'),
('16012012918420210430142857608c142929902425196', '$2y$11$k2g/9BctsVhGqx64CVYXWuVb0/ufp4Q26vRlP7SZzPQXyk.1auyMC', 1, '2021-04-30', NULL, '2021-04-30 16:14:45', '16012012918420210430142857608c142929902425196', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs_professionnels_sante`
--

CREATE TABLE `tb_utilisateurs_professionnels_sante` (
  `utilisateur_id` varchar(45) NOT NULL,
  `professionnel_sante_code` varchar(9) NOT NULL,
  `categorie_professionnelle_sante_code` varchar(7) NOT NULL,
  `numero_immatriculation` varchar(15) NOT NULL,
  `orde_nationnal_code` varchar(7) NOT NULL,
  `ordre_national_numero` int(11) NOT NULL,
  `professionnel_sante_date_debut` date NOT NULL,
  `professionnel_sante_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` timestamp NULL DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs_statuts`
--

CREATE TABLE `tb_utilisateurs_statuts` (
  `utilisateur_id` varchar(45) NOT NULL,
  `statut` tinyint(1) NOT NULL,
  `statut_date_debut` date NOT NULL,
  `statut_passe_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_utilisateurs_statuts`
--

INSERT INTO `tb_utilisateurs_statuts` (`utilisateur_id`, `statut`, `statut_date_debut`, `statut_passe_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('16012012918420210430115828608bf0e4467c8240168', 1, '2021-04-30', NULL, '2021-04-30 11:58:28', '1', NULL, NULL),
('16012012918420210430134121608c090196e24537856', 0, '2021-04-30', '2021-05-16', '2021-04-30 16:21:02', '16012012918420210430142857608c142929902425196', '2021-05-17 09:54:37', '16012012918420210430115828608bf0e4467c8240168'),
('16012012918420210430134121608c090196e24537856', 1, '2021-04-14', '2021-05-16', '2021-04-30 13:41:21', '16012012918420210430115828608bf0e4467c8240168', '2021-05-17 09:54:37', '16012012918420210430115828608bf0e4467c8240168'),
('16012012918420210430134121608c090196e24537856', 1, '2021-05-17', NULL, '2021-05-17 09:54:37', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL),
('16012012918420210430142857608c142929902425196', 1, '2021-04-30', NULL, '2021-04-30 14:28:57', '16012012918420210430115828608bf0e4467c8240168', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tb_etablissements`
--
ALTER TABLE `tb_etablissements`
  ADD PRIMARY KEY (`etablissement_code`,`etablissement_date_debut`),
  ADD KEY `niveau_code` (`niveau_code`),
  ADD KEY `region_code` (`region_code`),
  ADD KEY `departement_code` (`departement_code`),
  ADD KEY `commune_code` (`commune_code`),
  ADD KEY `secteur_activite_code` (`secteur_activite_code`),
  ADD KEY `pays_code` (`pays_code`),
  ADD KEY `type_etablissement_code` (`type_etablissement_code`);

--
-- Index pour la table `tb_etablissements_agents`
--
ALTER TABLE `tb_etablissements_agents`
  ADD PRIMARY KEY (`utilisateur_id`,`etablissement_code`,`etablissement_agent_date_debut`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `etablissement_code` (`etablissement_code`);

--
-- Index pour la table `tb_etablissements_coordonnees`
--
ALTER TABLE `tb_etablissements_coordonnees`
  ADD PRIMARY KEY (`etablissement_code`,`type_coordonnee_code`,`coordonnee_date_debut`),
  ADD KEY `etablissement_code` (`etablissement_code`),
  ADD KEY `type_coordonnee_code` (`type_coordonnee_code`);

--
-- Index pour la table `tb_etablissements_niveaux_sanitaires`
--
ALTER TABLE `tb_etablissements_niveaux_sanitaires`
  ADD PRIMARY KEY (`niveau_sanitaire_code`,`niveau_sanitaire_date_debut`),
  ADD UNIQUE KEY `niveau_sanitaire_libelle` (`niveau_sanitaire_libelle`);

--
-- Index pour la table `tb_etablissements_professionnels`
--
ALTER TABLE `tb_etablissements_professionnels`
  ADD PRIMARY KEY (`etablissement_code`,`professionnel_code`,`etablissement_professionnel_date_debut`),
  ADD KEY `professionnel_code` (`professionnel_code`);

--
-- Index pour la table `tb_etablissements_responsables`
--
ALTER TABLE `tb_etablissements_responsables`
  ADD PRIMARY KEY (`utilisateur_id`,`etablissement_code`,`etablissement_responsable_date_debut`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `etablissement_code` (`etablissement_code`);

--
-- Index pour la table `tb_etablissements_types`
--
ALTER TABLE `tb_etablissements_types`
  ADD PRIMARY KEY (`type_etablissement_code`,`type_etablissement_date_debut`),
  ADD UNIQUE KEY `type_etablissement_libelle` (`type_etablissement_libelle`),
  ADD KEY `niveau_sanitaire_code` (`niveau_sanitaire_code`);

--
-- Index pour la table `tb_log_historique_connexions`
--
ALTER TABLE `tb_log_historique_connexions`
  ADD PRIMARY KEY (`connexion_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `tb_log_historique_piste_audit`
--
ALTER TABLE `tb_log_historique_piste_audit`
  ADD PRIMARY KEY (`piste_audit_id`);

--
-- Index pour la table `tb_professionnels_sante`
--
ALTER TABLE `tb_professionnels_sante`
  ADD PRIMARY KEY (`professionnel_code`,`professionnel_date_debut`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `tb_ref_actes_articles`
--
ALTER TABLE `tb_ref_actes_articles`
  ADD PRIMARY KEY (`article_code`,`article_date_debut`),
  ADD UNIQUE KEY `lettres_clees_libelle` (`article_libelle`),
  ADD KEY `section_code` (`section_code`),
  ADD KEY `chapitre_code` (`chapitre_code`);

--
-- Index pour la table `tb_ref_actes_chapitres`
--
ALTER TABLE `tb_ref_actes_chapitres`
  ADD PRIMARY KEY (`chapitre_code`,`chapitre_date_debut`),
  ADD UNIQUE KEY `chapitre_libelle` (`chapitre_libelle`),
  ADD KEY `titre_code` (`titre_code`);

--
-- Index pour la table `tb_ref_actes_medicaux`
--
ALTER TABLE `tb_ref_actes_medicaux`
  ADD PRIMARY KEY (`acte_code`,`acte_date_debut`),
  ADD UNIQUE KEY `medicaux_libelle` (`acte_libelle`),
  ADD KEY `tb_actes_medicaux_ibfk_1` (`article_code`);

--
-- Index pour la table `tb_ref_actes_medicaux_coefficients`
--
ALTER TABLE `tb_ref_actes_medicaux_coefficients`
  ADD PRIMARY KEY (`acte_code`,`lettre_cle_code`,`coefficient_date_debut`),
  ADD UNIQUE KEY `lettres_clees_libelle` (`lettre_cle_code`),
  ADD KEY `acte_code` (`acte_code`,`lettre_cle_code`);

--
-- Index pour la table `tb_ref_actes_sections`
--
ALTER TABLE `tb_ref_actes_sections`
  ADD PRIMARY KEY (`section_code`,`section_date_debut`),
  ADD UNIQUE KEY `lettres_clees_libelle` (`section_libelle`),
  ADD KEY `chapitre_code` (`chapitre_code`);

--
-- Index pour la table `tb_ref_actes_titres`
--
ALTER TABLE `tb_ref_actes_titres`
  ADD PRIMARY KEY (`titre_code`,`titre_date_debut`),
  ADD UNIQUE KEY `lettres_clees_libelle` (`titre_libelle`);

--
-- Index pour la table `tb_ref_categories_professionnelles_sante`
--
ALTER TABLE `tb_ref_categories_professionnelles_sante`
  ADD PRIMARY KEY (`categorie_professionnelle_sante_code`,`categorie_professionnelle_sante_date_debut`),
  ADD UNIQUE KEY `categorie_professionnelle_sante_libelle` (`categorie_professionnelle_sante_libelle`);

--
-- Index pour la table `tb_ref_categories_socio_professionnelles`
--
ALTER TABLE `tb_ref_categories_socio_professionnelles`
  ADD PRIMARY KEY (`categorie_socio_professionnelle_code`,`categorie_socio_professionnelle_date_debut`),
  ADD UNIQUE KEY `categorie_libelle_UNIQUE` (`categorie_socio_professionnelle_libelle`);

--
-- Index pour la table `tb_ref_civilites`
--
ALTER TABLE `tb_ref_civilites`
  ADD PRIMARY KEY (`civilite_code`,`civilite_date_debut`),
  ADD UNIQUE KEY `civilite_libelle_UNIQUE` (`civilite_libelle`);

--
-- Index pour la table `tb_ref_etablissements_services`
--
ALTER TABLE `tb_ref_etablissements_services`
  ADD PRIMARY KEY (`etablissement_service_code`,`etablissement_service_date_debut`),
  ADD UNIQUE KEY `etablissement_service_libelle` (`etablissement_service_libelle`);

--
-- Index pour la table `tb_ref_geo_communes`
--
ALTER TABLE `tb_ref_geo_communes`
  ADD PRIMARY KEY (`commune_code`,`commune_date_debut`),
  ADD KEY `departement_code` (`departement_code`);

--
-- Index pour la table `tb_ref_geo_departements`
--
ALTER TABLE `tb_ref_geo_departements`
  ADD PRIMARY KEY (`departement_code`,`departement_date_debut`),
  ADD KEY `departement_region_FK_idx` (`region_code`);

--
-- Index pour la table `tb_ref_geo_pays`
--
ALTER TABLE `tb_ref_geo_pays`
  ADD PRIMARY KEY (`pays_code`,`pays_date_debut`),
  ADD UNIQUE KEY `pays_nom_UNIQUE` (`pays_nom`),
  ADD KEY `monnaie_code` (`monnaie_code`);

--
-- Index pour la table `tb_ref_geo_regions`
--
ALTER TABLE `tb_ref_geo_regions`
  ADD PRIMARY KEY (`region_code`,`region_date_debut`),
  ADD KEY `region_pays_FK_idx` (`pays_code`);

--
-- Index pour la table `tb_ref_groupes_sanguins`
--
ALTER TABLE `tb_ref_groupes_sanguins`
  ADD PRIMARY KEY (`groupe_sanguin_code`,`groupe_sanguin_date_debut`),
  ADD UNIQUE KEY `profession_libelle` (`groupe_sanguin_libelle`);

--
-- Index pour la table `tb_ref_lettres_cles`
--
ALTER TABLE `tb_ref_lettres_cles`
  ADD PRIMARY KEY (`lettre_cle_code`,`lettre_cle_date_debut`),
  ADD KEY `lettre_cle_libelle` (`lettre_cle_libelle`);

--
-- Index pour la table `tb_ref_medicaments_classes_therapeutiques`
--
ALTER TABLE `tb_ref_medicaments_classes_therapeutiques`
  ADD PRIMARY KEY (`classe_therapeutique_code`,`classe_therapeutique_date_debut`),
  ADD UNIQUE KEY `classe_therapeutique_libelle_2` (`classe_therapeutique_libelle`),
  ADD KEY `classe_therapeutique_libelle` (`classe_therapeutique_libelle`);

--
-- Index pour la table `tb_ref_medicaments_dci`
--
ALTER TABLE `tb_ref_medicaments_dci`
  ADD PRIMARY KEY (`dci_code`,`dci_date_debut`),
  ADD UNIQUE KEY `dci_libelle` (`dci_libelle`),
  ADD KEY `forme_code` (`forme_code`),
  ADD KEY `unite_dosage_code` (`unite_dosage_code`);

--
-- Index pour la table `tb_ref_medicaments_familles_formes`
--
ALTER TABLE `tb_ref_medicaments_familles_formes`
  ADD PRIMARY KEY (`famille_code`,`famille_date_debut`),
  ADD UNIQUE KEY `famille_libelle_2` (`famille_libelle`),
  ADD KEY `famille_libelle` (`famille_libelle`);

--
-- Index pour la table `tb_ref_medicaments_formes`
--
ALTER TABLE `tb_ref_medicaments_formes`
  ADD PRIMARY KEY (`forme_code`,`forme_date_debut`),
  ADD UNIQUE KEY `forme_libelle_2` (`forme_libelle`),
  ADD KEY `forme_libelle` (`forme_libelle`);

--
-- Index pour la table `tb_ref_medicaments_formes_administrations`
--
ALTER TABLE `tb_ref_medicaments_formes_administrations`
  ADD PRIMARY KEY (`forme_administration_code`,`forme_administration_date_debut`),
  ADD UNIQUE KEY `forme_administration_libelle_2` (`forme_administration_libelle`),
  ADD KEY `forme_administration_libelle` (`forme_administration_libelle`);

--
-- Index pour la table `tb_ref_medicaments_laboratoires_pharmaceutiques`
--
ALTER TABLE `tb_ref_medicaments_laboratoires_pharmaceutiques`
  ADD PRIMARY KEY (`laboratoire_code`,`laboratoire_date_debut`),
  ADD UNIQUE KEY `laboratoire_libelle_2` (`laboratoire_libelle`),
  ADD KEY `laboratoire_libelle` (`laboratoire_libelle`);

--
-- Index pour la table `tb_ref_medicaments_presentations`
--
ALTER TABLE `tb_ref_medicaments_presentations`
  ADD PRIMARY KEY (`presentation_code`,`presentation_date_debut`),
  ADD UNIQUE KEY `presentation_libelle_2` (`presentation_libelle`),
  ADD KEY `presentation_libelle` (`presentation_libelle`);

--
-- Index pour la table `tb_ref_medicaments_types_medicaments`
--
ALTER TABLE `tb_ref_medicaments_types_medicaments`
  ADD PRIMARY KEY (`type_medicament_code`,`type_medicament_date_debut`),
  ADD UNIQUE KEY `type_medicament_libelle` (`type_medicament_libelle`),
  ADD KEY `type-medicament_libelle` (`type_medicament_libelle`);

--
-- Index pour la table `tb_ref_medicaments_unites_de_dosage`
--
ALTER TABLE `tb_ref_medicaments_unites_de_dosage`
  ADD PRIMARY KEY (`unite_dosage_code`,`unite_dosage_date_debut`),
  ADD UNIQUE KEY `unite_dosage_libelle` (`unite_dosage_libelle`),
  ADD KEY `unite_administration_libelle` (`unite_dosage_libelle`);

--
-- Index pour la table `tb_ref_monnaies`
--
ALTER TABLE `tb_ref_monnaies`
  ADD PRIMARY KEY (`monnaie_code`,`monnaie_date_debut`),
  ADD UNIQUE KEY `monnaie_libelle_UNIQUE` (`monnaie_libelle`);

--
-- Index pour la table `tb_ref_ordres_nationnaux`
--
ALTER TABLE `tb_ref_ordres_nationnaux`
  ADD PRIMARY KEY (`orde_nationnal_code`,`orde_nationnal_date_debut`),
  ADD UNIQUE KEY `orde_nationnal_libelle` (`orde_nationnal_libelle`);

--
-- Index pour la table `tb_ref_pathologies`
--
ALTER TABLE `tb_ref_pathologies`
  ADD PRIMARY KEY (`pathologie_code`,`pathologie_date_debut`),
  ADD UNIQUE KEY `pathologie_libelle` (`pathologie_libelle`),
  ADD KEY `sous_chapitre_code` (`sous_chapitre_code`);

--
-- Index pour la table `tb_ref_pathologies_chapitres`
--
ALTER TABLE `tb_ref_pathologies_chapitres`
  ADD PRIMARY KEY (`chapitre_code`,`chapitre_date_debut`),
  ADD UNIQUE KEY `chapitre_libelle` (`chapitre_libelle`);

--
-- Index pour la table `tb_ref_pathologies_sous_chapitres`
--
ALTER TABLE `tb_ref_pathologies_sous_chapitres`
  ADD PRIMARY KEY (`sous_chapitre_code`,`sous_chapitre_date_debut`),
  ADD UNIQUE KEY `sous_chapitre_libelle` (`sous_chapitre_libelle`),
  ADD KEY `chapitre_code` (`chapitre_code`);

--
-- Index pour la table `tb_ref_professions`
--
ALTER TABLE `tb_ref_professions`
  ADD PRIMARY KEY (`profession_code`,`profession_date_debut`),
  ADD UNIQUE KEY `profession_libelle` (`profession_libelle`);

--
-- Index pour la table `tb_ref_profils_utilisateurs`
--
ALTER TABLE `tb_ref_profils_utilisateurs`
  ADD PRIMARY KEY (`profil_utilisateur_code`,`profil_utilisateur_date_debut`),
  ADD UNIQUE KEY `profil_utilisateur_libelle` (`profil_utilisateur_libelle`);

--
-- Index pour la table `tb_ref_qualites_civiles`
--
ALTER TABLE `tb_ref_qualites_civiles`
  ADD PRIMARY KEY (`qualite_civile_code`,`qualite_civile_date_debut`),
  ADD UNIQUE KEY `civilite_libelle_UNIQUE` (`qualite_civile_libelle`);

--
-- Index pour la table `tb_ref_rhesus`
--
ALTER TABLE `tb_ref_rhesus`
  ADD PRIMARY KEY (`rhesus_code`,`rhesus_date_debut`),
  ADD UNIQUE KEY `profession_libelle` (`rhesus_libelle`);

--
-- Index pour la table `tb_ref_secteurs_activites`
--
ALTER TABLE `tb_ref_secteurs_activites`
  ADD PRIMARY KEY (`secteur_activite_code`,`secteur_activite_date_debut`),
  ADD UNIQUE KEY `type_identifiant_libelle` (`secteur_activite_libelle`);

--
-- Index pour la table `tb_ref_sexes`
--
ALTER TABLE `tb_ref_sexes`
  ADD PRIMARY KEY (`sexe_code`,`sexe_date_debut`),
  ADD UNIQUE KEY `sexe_libelle` (`sexe_libelle`);

--
-- Index pour la table `tb_ref_situations_familiales`
--
ALTER TABLE `tb_ref_situations_familiales`
  ADD PRIMARY KEY (`situation_familiale_code`,`situation_familiale_date_debut`),
  ADD UNIQUE KEY `situation_familiale_libelle` (`situation_familiale_libelle`);

--
-- Index pour la table `tb_ref_types_accidents`
--
ALTER TABLE `tb_ref_types_accidents`
  ADD PRIMARY KEY (`types_accidents_code`,`types_accidents_date_debut`),
  ADD UNIQUE KEY `types_accidents_libelle` (`types_accidents_libelle`);

--
-- Index pour la table `tb_ref_types_coordonnees`
--
ALTER TABLE `tb_ref_types_coordonnees`
  ADD PRIMARY KEY (`type_coordonnee_code`,`type_coordonnee_date_debut`),
  ADD UNIQUE KEY `type_coordonnee_libelle` (`type_coordonnee_libelle`);

--
-- Index pour la table `tb_ref_types_personnes`
--
ALTER TABLE `tb_ref_types_personnes`
  ADD PRIMARY KEY (`type_personne_code`,`type_personne_date_debut`),
  ADD UNIQUE KEY `sexe_libelle` (`type_personne_libelle`);

--
-- Index pour la table `tb_ref_types_pieces_identites`
--
ALTER TABLE `tb_ref_types_pieces_identites`
  ADD PRIMARY KEY (`type_piece_identite_code`,`type_piece_identite_date_debut`),
  ADD UNIQUE KEY `type_piece_identite_libelle` (`type_piece_identite_libelle`);

--
-- Index pour la table `tb_services_hospitaliers`
--
ALTER TABLE `tb_services_hospitaliers`
  ADD PRIMARY KEY (`etablissement_code`,`etablissement_service_code`,`service_hospitalier_date_debut`),
  ADD KEY `etablissement_service_code` (`etablissement_service_code`);

--
-- Index pour la table `tb_utilisateurs`
--
ALTER TABLE `tb_utilisateurs`
  ADD PRIMARY KEY (`utilisateur_id`),
  ADD UNIQUE KEY `utilisateur_email` (`utilisateur_email`,`utilisateur_pseudo`),
  ADD KEY `type_utilisateur_code` (`profil_utilisateur_code`),
  ADD KEY `sexe_code` (`sexe_code`),
  ADD KEY `civilite_code` (`civilite_code`),
  ADD KEY `situation_familiale_code` (`situation_familiale_code`),
  ADD KEY `categorie_socio_professionnelle_code` (`categorie_socio_professionnelle_code`),
  ADD KEY `profession_code` (`profession_code`),
  ADD KEY `secteur_activite_code` (`secteur_activite_code`),
  ADD KEY `groupe_sanguin_code` (`groupe_sanguin_code`),
  ADD KEY `rhesus_code` (`rhesus_code`) USING BTREE,
  ADD KEY `pays_naissance` (`pays_code`),
  ADD KEY `region_naissance` (`region_code`),
  ADD KEY `departement_naissance` (`departement_code`),
  ADD KEY `commune_naissance` (`commune_code`);

--
-- Index pour la table `tb_utilisateurs_coordonnees`
--
ALTER TABLE `tb_utilisateurs_coordonnees`
  ADD PRIMARY KEY (`utilisateur_id`,`type_coordonnee_code`,`coordonnee_date_debut`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `type_coordonnee_code` (`type_coordonnee_code`);

--
-- Index pour la table `tb_utilisateurs_ecu`
--
ALTER TABLE `tb_utilisateurs_ecu`
  ADD PRIMARY KEY (`utilisateur_id`,`ecu_telephone`,`ecu_date_debut`),
  ADD UNIQUE KEY `ecu_telephone` (`ecu_telephone`),
  ADD KEY `type_personne_ecu_code` (`type_personne_code`);

--
-- Index pour la table `tb_utilisateurs_mots_de_passe`
--
ALTER TABLE `tb_utilisateurs_mots_de_passe`
  ADD PRIMARY KEY (`utilisateur_id`,`user_mot_de_passe_statut`,`mot_de_passe_date_debut`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `tb_utilisateurs_professionnels_sante`
--
ALTER TABLE `tb_utilisateurs_professionnels_sante`
  ADD PRIMARY KEY (`utilisateur_id`,`professionnel_sante_code`,`categorie_professionnelle_sante_code`,`orde_nationnal_code`),
  ADD KEY `utilisateur_id` (`utilisateur_id`,`categorie_professionnelle_sante_code`,`orde_nationnal_code`),
  ADD KEY `categorie_professionnelle_sante_code` (`categorie_professionnelle_sante_code`),
  ADD KEY `orde_nationnal_code` (`orde_nationnal_code`);

--
-- Index pour la table `tb_utilisateurs_statuts`
--
ALTER TABLE `tb_utilisateurs_statuts`
  ADD PRIMARY KEY (`utilisateur_id`,`statut`,`statut_date_debut`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tb_log_historique_connexions`
--
ALTER TABLE `tb_log_historique_connexions`
  MODIFY `connexion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `tb_log_historique_piste_audit`
--
ALTER TABLE `tb_log_historique_piste_audit`
  MODIFY `piste_audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tb_etablissements`
--
ALTER TABLE `tb_etablissements`
  ADD CONSTRAINT `tb_etablissements_ibfk_1` FOREIGN KEY (`commune_code`) REFERENCES `tb_ref_geo_communes` (`commune_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_ibfk_2` FOREIGN KEY (`departement_code`) REFERENCES `tb_ref_geo_departements` (`departement_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_ibfk_3` FOREIGN KEY (`niveau_code`) REFERENCES `tb_etablissements_niveaux_sanitaires` (`niveau_sanitaire_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_ibfk_4` FOREIGN KEY (`pays_code`) REFERENCES `tb_ref_geo_pays` (`pays_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_ibfk_5` FOREIGN KEY (`region_code`) REFERENCES `tb_ref_geo_regions` (`region_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_ibfk_6` FOREIGN KEY (`secteur_activite_code`) REFERENCES `tb_ref_secteurs_activites` (`secteur_activite_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_ibfk_7` FOREIGN KEY (`type_etablissement_code`) REFERENCES `tb_etablissements_types` (`type_etablissement_code`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_etablissements_coordonnees`
--
ALTER TABLE `tb_etablissements_coordonnees`
  ADD CONSTRAINT `tb_etablissements_coordonnees_ibfk_1` FOREIGN KEY (`type_coordonnee_code`) REFERENCES `tb_ref_types_coordonnees` (`type_coordonnee_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_coordonnees_ibfk_2` FOREIGN KEY (`etablissement_code`) REFERENCES `tb_etablissements` (`etablissement_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_etablissements_professionnels`
--
ALTER TABLE `tb_etablissements_professionnels`
  ADD CONSTRAINT `tb_etablissements_professionnels_ibfk_1` FOREIGN KEY (`professionnel_code`) REFERENCES `tb_professionnels_sante` (`professionnel_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_professionnels_ibfk_2` FOREIGN KEY (`etablissement_code`) REFERENCES `tb_etablissements` (`etablissement_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_etablissements_responsables`
--
ALTER TABLE `tb_etablissements_responsables`
  ADD CONSTRAINT `tb_etablissements_responsables_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_etablissements_responsables_ibfk_2` FOREIGN KEY (`etablissement_code`) REFERENCES `tb_etablissements` (`etablissement_code`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_etablissements_types`
--
ALTER TABLE `tb_etablissements_types`
  ADD CONSTRAINT `tb_etablissements_types_ibfk_1` FOREIGN KEY (`niveau_sanitaire_code`) REFERENCES `tb_etablissements_niveaux_sanitaires` (`niveau_sanitaire_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_professionnels_sante`
--
ALTER TABLE `tb_professionnels_sante`
  ADD CONSTRAINT `tb_professionnels_sante_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_actes_articles`
--
ALTER TABLE `tb_ref_actes_articles`
  ADD CONSTRAINT `tb_ref_actes_articles_ibfk_1` FOREIGN KEY (`section_code`) REFERENCES `tb_ref_actes_sections` (`section_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_ref_actes_articles_ibfk_2` FOREIGN KEY (`chapitre_code`) REFERENCES `tb_ref_actes_chapitres` (`chapitre_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_actes_chapitres`
--
ALTER TABLE `tb_ref_actes_chapitres`
  ADD CONSTRAINT `tb_ref_actes_chapitres_ibfk_1` FOREIGN KEY (`titre_code`) REFERENCES `tb_ref_actes_titres` (`titre_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_actes_medicaux`
--
ALTER TABLE `tb_ref_actes_medicaux`
  ADD CONSTRAINT `tb_ref_actes_medicaux_ibfk_1` FOREIGN KEY (`article_code`) REFERENCES `tb_ref_actes_articles` (`article_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_actes_sections`
--
ALTER TABLE `tb_ref_actes_sections`
  ADD CONSTRAINT `tb_ref_actes_sections_ibfk_1` FOREIGN KEY (`chapitre_code`) REFERENCES `tb_ref_actes_chapitres` (`chapitre_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_geo_regions`
--
ALTER TABLE `tb_ref_geo_regions`
  ADD CONSTRAINT `tb_ref_geo_regions_ibfk_1` FOREIGN KEY (`pays_code`) REFERENCES `tb_ref_geo_pays` (`pays_code`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_services_hospitaliers`
--
ALTER TABLE `tb_services_hospitaliers`
  ADD CONSTRAINT `tb_services_hospitaliers_ibfk_1` FOREIGN KEY (`etablissement_code`) REFERENCES `tb_etablissements` (`etablissement_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_services_hospitaliers_ibfk_2` FOREIGN KEY (`etablissement_service_code`) REFERENCES `tb_ref_etablissements_services` (`etablissement_service_code`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs`
--
ALTER TABLE `tb_utilisateurs`
  ADD CONSTRAINT `tb_utilisateurs_ibfk_1` FOREIGN KEY (`categorie_socio_professionnelle_code`) REFERENCES `tb_ref_categories_socio_professionnelles` (`categorie_socio_professionnelle_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_10` FOREIGN KEY (`commune_code`) REFERENCES `tb_ref_geo_communes` (`commune_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_11` FOREIGN KEY (`pays_code`) REFERENCES `tb_ref_geo_pays` (`pays_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_12` FOREIGN KEY (`departement_code`) REFERENCES `tb_ref_geo_departements` (`departement_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_2` FOREIGN KEY (`civilite_code`) REFERENCES `tb_ref_civilites` (`civilite_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_3` FOREIGN KEY (`profession_code`) REFERENCES `tb_ref_professions` (`profession_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_4` FOREIGN KEY (`secteur_activite_code`) REFERENCES `tb_ref_secteurs_activites` (`secteur_activite_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_5` FOREIGN KEY (`sexe_code`) REFERENCES `tb_ref_sexes` (`sexe_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_6` FOREIGN KEY (`situation_familiale_code`) REFERENCES `tb_ref_situations_familiales` (`situation_familiale_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_7` FOREIGN KEY (`profil_utilisateur_code`) REFERENCES `tb_ref_profils_utilisateurs` (`profil_utilisateur_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_8` FOREIGN KEY (`groupe_sanguin_code`) REFERENCES `tb_ref_groupes_sanguins` (`groupe_sanguin_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_9` FOREIGN KEY (`rhesus_code`) REFERENCES `tb_ref_rhesus` (`rhesus_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs_coordonnees`
--
ALTER TABLE `tb_utilisateurs_coordonnees`
  ADD CONSTRAINT `tb_utilisateurs_coordonnees_ibfk_1` FOREIGN KEY (`type_coordonnee_code`) REFERENCES `tb_ref_types_coordonnees` (`type_coordonnee_code`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs_ecu`
--
ALTER TABLE `tb_utilisateurs_ecu`
  ADD CONSTRAINT `tb_utilisateurs_ecu_ibfk_1` FOREIGN KEY (`type_personne_code`) REFERENCES `tb_ref_types_personnes` (`type_personne_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ecu_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs_mots_de_passe`
--
ALTER TABLE `tb_utilisateurs_mots_de_passe`
  ADD CONSTRAINT `tb_utilisateurs_mots_de_passe_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs_professionnels_sante`
--
ALTER TABLE `tb_utilisateurs_professionnels_sante`
  ADD CONSTRAINT `tb_utilisateurs_professionnels_sante_ibfk_1` FOREIGN KEY (`categorie_professionnelle_sante_code`) REFERENCES `tb_ref_categories_professionnelles_sante` (`categorie_professionnelle_sante_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_professionnels_sante_ibfk_2` FOREIGN KEY (`orde_nationnal_code`) REFERENCES `tb_ref_ordres_nationnaux` (`orde_nationnal_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_professionnels_sante_ibfk_3` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs_statuts`
--
ALTER TABLE `tb_utilisateurs_statuts`
  ADD CONSTRAINT `tb_utilisateurs_statuts_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
