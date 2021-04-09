-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : jeu. 08 avr. 2021 à 23:11
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ouagolo_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `tb_log_historique_connexions`
--

DROP TABLE IF EXISTS `tb_log_historique_connexions`;
CREATE TABLE IF NOT EXISTS `tb_log_historique_connexions` (
  `connexion_id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` varchar(45) NOT NULL,
  `connexion_adresse_ip` varchar(100) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`connexion_id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_log_historique_connexions`
--

INSERT INTO `tb_log_historique_connexions` (`connexion_id`, `utilisateur_id`, `connexion_adresse_ip`, `date_creation`) VALUES
(1, '12700120210407115351606d9d4f06abd699448198', '127.0.0.1', '2021-04-07 11:54:43'),
(2, '12700120210407115351606d9d4f06abd699448198', '127.0.0.1', '2021-04-07 11:57:45'),
(3, '12700120210407115351606d9d4f06abd699448198', '127.0.0.1', '2021-04-07 12:41:32'),
(4, '12700120210407115351606d9d4f06abd699448198', '127.0.0.1', '2021-04-08 13:47:44');

-- --------------------------------------------------------

--
-- Structure de la table `tb_log_historique_piste_audit`
--

DROP TABLE IF EXISTS `tb_log_historique_piste_audit`;
CREATE TABLE IF NOT EXISTS `tb_log_historique_piste_audit` (
  `piste_audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `piste_audit_adresse_ip` varchar(100) NOT NULL,
  `piste_audit_url` text NOT NULL,
  `piste_audit_action` varchar(50) NOT NULL,
  `piste_audit_details` text NOT NULL,
  `utilisateur_id` varchar(45) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`piste_audit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_log_historique_piste_audit`
--

INSERT INTO `tb_log_historique_piste_audit` (`piste_audit_id`, `piste_audit_adresse_ip`, `piste_audit_url`, `piste_audit_action`, `piste_audit_details`, `utilisateur_id`, `date_creation`) VALUES
(1, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Utilisateurs/submit_utilisateur.php', 'CREATION', '{\"id_user\":\"\",\"num_secu\":\"3841443513209\",\"num_matricule\":\"\",\"nom_utilisateur\":\"dognimin.koulibali\",\"email\":\"dognimin.koulibali@gmail.com\",\"civilite\":\"\",\"nom\":\"KOULIBALI\",\"nom_patronymique\":\"\",\"prenoms\":\"DOGNIMIN\",\"date_naissance\":\"25\\/06\\/1988\",\"sexe\":\"\"}', '1', '2021-04-07 11:53:51'),
(2, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 11:54:43'),
(3, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Utilisateurs/submit_utilisateur_mot_de_passe.php', 'MISE A JOUR MDP', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 11:55:45'),
(4, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 11:57:45'),
(5, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 12:41:32'),
(6, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 14:29:19'),
(7, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 14:31:20'),
(8, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 14:32:08'),
(9, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 14:35:15'),
(10, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 14:46:03'),
(11, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 14:46:48'),
(12, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 14:47:02'),
(13, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '********', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 14:56:58'),
(14, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_categorie_socio_professionnelle.php', 'EDITION', '{\"code\":\"AAA\",\"libelle\":\"DFFGHHH\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 15:15:52'),
(15, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_categorie_socio_professionnelle.php', 'EDITION', '{\"code\":\"aaa\",\"libelle\":\"aaaaaaa\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 15:17:16'),
(16, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_categorie_socio_professionnelle.php', 'EDITION', '{\"code\":\"ETU\",\"libelle\":\"ETUDIANT\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 15:18:16'),
(17, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_civilite.php', 'EDITION', '{\"code\":\"M\",\"libelle\":\"monsieur\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:33:17'),
(18, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_civilite.php', 'EDITION', '{\"code\":\"mme\",\"libelle\":\"madame\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:33:42'),
(19, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_sexe.php', 'EDITION', '{\"code\":\"m\",\"libelle\":\"masculin\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:34:18'),
(20, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_sexe.php', 'EDITION', '{\"code\":\"f\",\"libelle\":\"feminin\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:34:34'),
(21, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_situation_familiale.php', 'EDITION', '{\"code\":\"cel\",\"libelle\":\"celibataire\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:34:54'),
(22, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_situation_familiale.php', 'EDITION', '{\"code\":\"mar\",\"libelle\":\"marie(e)\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:35:19'),
(23, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_secteur_activite.php', 'EDITION', '{\"code\":\"pub\",\"libelle\":\"public\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:35:40'),
(24, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_secteur_activite.php', 'EDITION', '{\"code\":\"prv\",\"libelle\":\"priv\\u00e9\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:35:58'),
(25, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profession.php', 'EDITION', '{\"code\":\"01\",\"libelle\":\"developpeur d\'applications\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:36:28'),
(26, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/sumit_qualite_civilite.php', 'EDITION', '{\"code\":\"pay\",\"libelle\":\"payeur\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:37:04'),
(27, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_devise_monetaire.php', 'EDITION', '{\"code\":\"xof\",\"libelle\":\"F CFA\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:37:39'),
(28, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_devise_monetaire.php', 'EDITION', '{\"code\":\"EUR\",\"libelle\":\"Euro\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:38:30'),
(29, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_type_coordonnee.php', 'EDITION', '{\"code\":\"MOBPER\",\"libelle\":\"MOBILE PERSONNEL\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:55:23'),
(30, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_types_pieces.php', 'EDITION', '{\"code\":\"NAI\",\"libelle\":\"EXTRAIT DE NAISSANCE\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:56:25'),
(31, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_types_pieces.php', 'EDITION', '{\"code\":\"CC\",\"libelle\":\"CARTE CONSULAIre\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 18:57:05'),
(32, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_groupe_sanguin.php', 'EDITION', '{\"code\":\"a\",\"libelle\":\"a\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 19:56:41'),
(33, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_groupe_sanguin.php', 'EDITION', '{\"code\":\"b\",\"libelle\":\"b\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 19:56:55'),
(34, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_groupe_sanguin.php', 'EDITION', '{\"code\":\"o\",\"libelle\":\"o\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 19:57:05'),
(35, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_groupe_sanguin.php', 'EDITION', '{\"code\":\"ab\",\"libelle\":\"ab\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 19:57:16'),
(36, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_rhesus.php', 'EDITION', '{\"code\":\"-\",\"libelle\":\"negatif\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 20:11:00'),
(37, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_rhesus.php', 'EDITION', '{\"code\":\"-\",\"libelle\":\"negatif\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 20:12:54'),
(38, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_rhesus.php', 'EDITION', '{\"code\":\"+\",\"libelle\":\"positif\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 20:13:13'),
(39, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_devise_monetaire.php', 'EDITION', '{\"code\":\"XOF\",\"libelle\":\"F CFA\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 20:54:49'),
(40, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_devise_monetaire.php', 'EDITION', '{\"code\":\"USD\",\"libelle\":\"dollar am\\u00e9ricain\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 20:55:12'),
(41, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_devise_monetaire.php', 'EDITION', '{\"code\":\"eur\",\"libelle\":\"euro\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-07 20:55:28'),
(42, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_pays.php', 'EDITION', '{\"code\":\"CIV\",\"nom\":\"C\\u00f4te d\'Ivoire\",\"gentile\":\"Ivoirien\",\"indicatif\":\"225\",\"latitude\":\"5\\u00b0 18\' 34 N\",\"longitude\":\"-4\\u00b0 0\' 45 O\",\"code_devise\":\"XOF\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 10:05:50'),
(43, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_pays.php', 'EDITION', '{\"code\":\"FRA\",\"nom\":\"FRANCE\",\"gentile\":\"FRANCAIS\",\"indicatif\":\"33\",\"latitude\":\"46.227638\",\"longitude\":\"2.213749\",\"code_devise\":\"EUR\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 10:20:18'),
(44, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Utilisateurs/submit_utilisateur_connexion.php', 'CONNEXION', 'dognimin.koulibali@gmail.com', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 13:47:44'),
(45, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_region.php', 'EDITION', '{\"code_pays\":\"CIV\",\"code\":\"001\",\"nom\":\"district d\'abidjan\",\"latitude\":\"1234567\",\"longitude\":\"1234567\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 14:06:19'),
(46, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_region.php', 'EDITION', '{\"code_pays\":\"CIV\",\"code\":\"002\",\"nom\":\"REGION DU PORO\",\"latitude\":\"12345678\",\"longitude\":\"8765432\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 14:06:58'),
(47, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_region.php', 'EDITION', '{\"code_pays\":\"FRA\",\"code\":\"003\",\"nom\":\"REGION DU RHONES\",\"latitude\":\"876543456\",\"longitude\":\"3456787654\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 14:07:31'),
(48, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_departement.php', 'EDITION', '{\"code_region\":\"001\",\"code\":\"00001\",\"nom\":\"Abidjan\",\"latitude\":\"234567\",\"longitude\":\"256789\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 14:26:13'),
(49, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_pays.php', 'EDITION', '{\"code\":\"BFA\",\"nom\":\"Burkina Faso\",\"gentile\":\"Burkinabe\",\"indicatif\":\"226\",\"latitude\":\"134567654\",\"longitude\":\"23456787654\",\"code_devise\":\"XOF\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 14:48:17'),
(50, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_region.php', 'EDITION', '{\"code_pays\":\"BFA\",\"code\":\"0005\",\"nom\":\"REGION XXXX\",\"latitude\":\"12345678\",\"longitude\":\"234567\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 14:48:48'),
(51, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_departement.php', 'EDITION', '{\"code_region\":\"0005\",\"code\":\"00023\",\"nom\":\"DEpartement XXXX\",\"latitude\":\"123454\",\"longitude\":\"234567\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 14:49:23'),
(52, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_geo_commune.php', 'EDITION', '{\"code_departement\":\"00001\",\"code\":\"00001\",\"nom\":\"Cocody\",\"latitude\":\"1234567\",\"longitude\":\"123456\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 17:44:12'),
(53, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profil_utilisateur.php', 'EDITION', '{\"code\":\"ADMIN\",\"libelle\":\"ADMINISTRATEUR\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 17:48:44'),
(54, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_profession.php', 'EDITION', '{\"code\":\"0001\",\"libelle\":\"CADRE\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:01:15'),
(55, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/sumit_qualite_civilite.php', 'EDITION', '{\"code\":\"PAY\",\"libelle\":\"Payeur\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:02:09'),
(56, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_secteur_activite.php', 'EDITION', '{\"code\":\"PRV\",\"libelle\":\"Priv\\u00e9\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:03:43'),
(57, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_sexe.php', 'EDITION', '{\"code\":\"F\",\"libelle\":\"F\\u00e9minin\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:04:17'),
(58, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_situation_familiale.php', 'EDITION', '{\"code\":\"CEL\",\"libelle\":\"Celibataire\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:05:01'),
(59, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_type_coordonnee.php', 'EDITION', '{\"code\":\"MOBPER\",\"libelle\":\"MOBILE PERSONNEL\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:05:46'),
(60, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_types_pieces.php', 'EDITION', '{\"code\":\"CNI\",\"libelle\":\"Carte nationale d\'identit\\u00e9\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:06:34'),
(61, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_categorie_socio_professionnelle.php', 'EDITION', '{\"code\":\"SAL\",\"libelle\":\"Salari\\u00e9\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:06:54'),
(62, '127.0.0.1', 'http://localhost/ouagolo/_CONFIGS/Includes/Submits/Parametres/submit_civilite.php', 'EDITION', '{\"code\":\"M\",\"libelle\":\"Monsieur\"}', '12700120210407115351606d9d4f06abd699448198', '2021-04-08 18:07:55');

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_categories_socio_professionnelles`
--

DROP TABLE IF EXISTS `tb_ref_categories_socio_professionnelles`;
CREATE TABLE IF NOT EXISTS `tb_ref_categories_socio_professionnelles` (
  `categorie_socio_professionnelle_code` varchar(3) NOT NULL,
  `categorie_socio_professionnelle_libelle` varchar(45) NOT NULL,
  `categorie_socio_professionnelle_date_debut` date NOT NULL,
  `categorie_socio_professionnelle_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`categorie_socio_professionnelle_code`,`categorie_socio_professionnelle_date_debut`),
  UNIQUE KEY `categorie_libelle_UNIQUE` (`categorie_socio_professionnelle_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_categories_socio_professionnelles`
--

INSERT INTO `tb_ref_categories_socio_professionnelles` (`categorie_socio_professionnelle_code`, `categorie_socio_professionnelle_libelle`, `categorie_socio_professionnelle_date_debut`, `categorie_socio_professionnelle_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('SAL', 'SALARIE', '2021-04-08', NULL, '2021-04-08 18:06:54', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_civilites`
--

DROP TABLE IF EXISTS `tb_ref_civilites`;
CREATE TABLE IF NOT EXISTS `tb_ref_civilites` (
  `civilite_code` varchar(4) NOT NULL,
  `civilite_libelle` varchar(45) NOT NULL,
  `civilite_date_debut` date NOT NULL,
  `civilite_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`civilite_code`,`civilite_date_debut`),
  UNIQUE KEY `civilite_libelle_UNIQUE` (`civilite_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_civilites`
--

INSERT INTO `tb_ref_civilites` (`civilite_code`, `civilite_libelle`, `civilite_date_debut`, `civilite_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('M', 'MONSIEUR', '2021-04-08', NULL, '2021-04-08 18:07:55', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_geo_communes`
--

DROP TABLE IF EXISTS `tb_ref_geo_communes`;
CREATE TABLE IF NOT EXISTS `tb_ref_geo_communes` (
  `departement_code` varchar(5) NOT NULL,
  `commune_code` varchar(5) NOT NULL,
  `commune_nom` varchar(45) NOT NULL,
  `commune_latitude` varchar(15) DEFAULT NULL,
  `commune_longitude` varchar(15) DEFAULT NULL,
  `commune_date_debut` date NOT NULL,
  `commune_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`commune_code`,`commune_date_debut`),
  KEY `departement_code` (`departement_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_geo_communes`
--

INSERT INTO `tb_ref_geo_communes` (`departement_code`, `commune_code`, `commune_nom`, `commune_latitude`, `commune_longitude`, `commune_date_debut`, `commune_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('00001', '00001', 'COCODY', '1234567', '123456', '2021-04-08', NULL, '2021-04-08 17:44:12', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_geo_departements`
--

DROP TABLE IF EXISTS `tb_ref_geo_departements`;
CREATE TABLE IF NOT EXISTS `tb_ref_geo_departements` (
  `region_code` varchar(4) NOT NULL,
  `departement_code` varchar(5) NOT NULL,
  `departement_nom` varchar(45) NOT NULL,
  `departement_latitude` varchar(15) DEFAULT NULL,
  `departement_longitude` varchar(15) DEFAULT NULL,
  `departement_date_debut` date NOT NULL,
  `departement_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`departement_code`,`departement_date_debut`),
  KEY `departement_region_FK_idx` (`region_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_geo_departements`
--

INSERT INTO `tb_ref_geo_departements` (`region_code`, `departement_code`, `departement_nom`, `departement_latitude`, `departement_longitude`, `departement_date_debut`, `departement_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('001', '00001', 'ABIDJAN', '234567', '256789', '2021-04-08', NULL, '2021-04-08 14:26:13', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('0005', '00023', 'DEPARTEMENT XXXX', '123454', '234567', '2021-04-08', NULL, '2021-04-08 14:49:23', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_geo_pays`
--

DROP TABLE IF EXISTS `tb_ref_geo_pays`;
CREATE TABLE IF NOT EXISTS `tb_ref_geo_pays` (
  `pays_code` varchar(3) NOT NULL,
  `pays_nom` varchar(45) NOT NULL,
  `pays_gentile` varchar(45) DEFAULT NULL COMMENT 'Gentilé: Dénomination des habitants d''un lieu',
  `pays_indicatif_telephonique` int(3) DEFAULT NULL,
  `pays_latitude` varchar(15) DEFAULT NULL,
  `pays_longitude` varchar(15) DEFAULT NULL,
  `pays_drapeau_image` varchar(45) DEFAULT NULL,
  `monnaie_code` varchar(3) DEFAULT NULL,
  `pays_date_debut` date NOT NULL,
  `pays_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`pays_code`,`pays_date_debut`),
  UNIQUE KEY `pays_nom_UNIQUE` (`pays_nom`),
  KEY `monnaie_code` (`monnaie_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_geo_pays`
--

INSERT INTO `tb_ref_geo_pays` (`pays_code`, `pays_nom`, `pays_gentile`, `pays_indicatif_telephonique`, `pays_latitude`, `pays_longitude`, `pays_drapeau_image`, `monnaie_code`, `pays_date_debut`, `pays_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('BFA', 'BURKINA FASO', 'BURKINABE', 226, '134567654', '23456787654', NULL, 'XOF', '2021-04-08', NULL, '2021-04-08 14:48:17', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('CIV', 'COTE D\'IVOIRE', 'IVOIRIEN', 225, '5° 18\' 34 N', '-4° 0\' 45 O', NULL, 'XOF', '2021-04-08', NULL, '2021-04-08 10:05:50', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('FRA', 'FRANCE', 'FRANCAIS', 33, '46.227638', '2.213749', NULL, 'EUR', '2021-04-08', NULL, '2021-04-08 10:20:18', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_geo_regions`
--

DROP TABLE IF EXISTS `tb_ref_geo_regions`;
CREATE TABLE IF NOT EXISTS `tb_ref_geo_regions` (
  `pays_code` varchar(3) NOT NULL,
  `region_code` varchar(4) NOT NULL,
  `region_nom` varchar(45) NOT NULL,
  `region_latitude` varchar(15) DEFAULT NULL,
  `region_longitude` varchar(15) DEFAULT NULL,
  `region_date_debut` date NOT NULL,
  `region_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`region_code`,`region_date_debut`),
  KEY `region_pays_FK_idx` (`pays_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_geo_regions`
--

INSERT INTO `tb_ref_geo_regions` (`pays_code`, `region_code`, `region_nom`, `region_latitude`, `region_longitude`, `region_date_debut`, `region_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('BFA', '0005', 'REGION XXXX', '12345678', '234567', '2021-04-08', NULL, '2021-04-08 14:48:48', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('CIV', '001', 'DISTRICT D\'ABIDJAN', '1234567', '1234567', '2021-04-08', NULL, '2021-04-08 14:06:19', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('CIV', '002', 'REGION DU PORO', '12345678', '8765432', '2021-04-08', NULL, '2021-04-08 14:06:58', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('FRA', '003', 'REGION DU RHONES', '876543456', '3456787654', '2021-04-08', NULL, '2021-04-08 14:07:31', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_groupes_sanguins`
--

DROP TABLE IF EXISTS `tb_ref_groupes_sanguins`;
CREATE TABLE IF NOT EXISTS `tb_ref_groupes_sanguins` (
  `groupe_sanguin_code` varchar(2) NOT NULL,
  `groupe_sanguin_libelle` varchar(45) NOT NULL,
  `groupe_sanguin_date_debut` date NOT NULL,
  `groupe_sanguin_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`groupe_sanguin_code`,`groupe_sanguin_date_debut`),
  UNIQUE KEY `profession_libelle` (`groupe_sanguin_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_groupes_sanguins`
--

INSERT INTO `tb_ref_groupes_sanguins` (`groupe_sanguin_code`, `groupe_sanguin_libelle`, `groupe_sanguin_date_debut`, `groupe_sanguin_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('A', 'A', '2021-04-07', NULL, '2021-04-07 19:56:41', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('AB', 'AB', '2021-04-07', NULL, '2021-04-07 19:57:16', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('B', 'B', '2021-04-07', NULL, '2021-04-07 19:56:55', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('O', 'O', '2021-04-07', NULL, '2021-04-07 19:57:05', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_monnaies`
--

DROP TABLE IF EXISTS `tb_ref_monnaies`;
CREATE TABLE IF NOT EXISTS `tb_ref_monnaies` (
  `monnaie_code` varchar(3) NOT NULL,
  `monnaie_libelle` varchar(45) NOT NULL,
  `monnaie_symbole` varchar(10) DEFAULT NULL,
  `monnaie_logo` varchar(100) DEFAULT NULL,
  `monnaie_date_debut` date NOT NULL,
  `monnaie_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`monnaie_code`,`monnaie_date_debut`),
  UNIQUE KEY `monnaie_libelle_UNIQUE` (`monnaie_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_monnaies`
--

INSERT INTO `tb_ref_monnaies` (`monnaie_code`, `monnaie_libelle`, `monnaie_symbole`, `monnaie_logo`, `monnaie_date_debut`, `monnaie_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('EUR', 'EURO', NULL, NULL, '2021-04-07', NULL, '2021-04-07 20:55:28', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('USD', 'DOLLAR AMERICAIN', NULL, NULL, '2021-04-07', NULL, '2021-04-07 20:55:12', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('XOF', 'FRANC CFA', NULL, NULL, '2021-04-07', NULL, '2021-04-07 20:54:49', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_professions`
--

DROP TABLE IF EXISTS `tb_ref_professions`;
CREATE TABLE IF NOT EXISTS `tb_ref_professions` (
  `profession_code` varchar(4) NOT NULL,
  `profession_libelle` varchar(45) NOT NULL,
  `profession_date_debut` date NOT NULL,
  `profession_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`profession_code`,`profession_date_debut`),
  UNIQUE KEY `profession_libelle` (`profession_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_professions`
--

INSERT INTO `tb_ref_professions` (`profession_code`, `profession_libelle`, `profession_date_debut`, `profession_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('0001', 'CADRE', '2021-04-08', NULL, '2021-04-08 18:01:15', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_profils_utilisateurs`
--

DROP TABLE IF EXISTS `tb_ref_profils_utilisateurs`;
CREATE TABLE IF NOT EXISTS `tb_ref_profils_utilisateurs` (
  `profil_utilisateur_code` varchar(6) NOT NULL,
  `profil_utilisateur_libelle` varchar(45) NOT NULL,
  `profil_utilisateur_date_debut` date NOT NULL,
  `profil_utilisateur_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`profil_utilisateur_code`,`profil_utilisateur_date_debut`),
  UNIQUE KEY `profil_utilisateur_libelle` (`profil_utilisateur_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_profils_utilisateurs`
--

INSERT INTO `tb_ref_profils_utilisateurs` (`profil_utilisateur_code`, `profil_utilisateur_libelle`, `profil_utilisateur_date_debut`, `profil_utilisateur_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('ADMIN', 'ADMINISTRATEUR', '2021-04-08', NULL, '2021-04-08 17:48:44', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_qualites_civiles`
--

DROP TABLE IF EXISTS `tb_ref_qualites_civiles`;
CREATE TABLE IF NOT EXISTS `tb_ref_qualites_civiles` (
  `qualite_civile_code` varchar(3) NOT NULL,
  `qualite_civile_libelle` varchar(45) NOT NULL,
  `qualite_civile_date_debut` date NOT NULL,
  `qualite_civile_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`qualite_civile_code`,`qualite_civile_date_debut`),
  UNIQUE KEY `civilite_libelle_UNIQUE` (`qualite_civile_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_qualites_civiles`
--

INSERT INTO `tb_ref_qualites_civiles` (`qualite_civile_code`, `qualite_civile_libelle`, `qualite_civile_date_debut`, `qualite_civile_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('PAY', 'PAYEUR', '2021-04-08', NULL, '2021-04-08 18:02:09', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_rhesus`
--

DROP TABLE IF EXISTS `tb_ref_rhesus`;
CREATE TABLE IF NOT EXISTS `tb_ref_rhesus` (
  `rhesus_code` varchar(1) NOT NULL,
  `rhesus_libelle` varchar(45) NOT NULL,
  `rhesus_date_debut` date NOT NULL,
  `rhesus_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`rhesus_code`,`rhesus_date_debut`),
  UNIQUE KEY `profession_libelle` (`rhesus_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_rhesus`
--

INSERT INTO `tb_ref_rhesus` (`rhesus_code`, `rhesus_libelle`, `rhesus_date_debut`, `rhesus_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('+', 'POSITIF', '2021-04-07', NULL, '2021-04-07 20:13:13', '12700120210407115351606d9d4f06abd699448198', NULL, NULL),
('-', 'NEGATIF', '2021-04-07', NULL, '2021-04-07 20:12:54', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_secteurs_activites`
--

DROP TABLE IF EXISTS `tb_ref_secteurs_activites`;
CREATE TABLE IF NOT EXISTS `tb_ref_secteurs_activites` (
  `secteur_activite_code` varchar(3) NOT NULL,
  `secteur_activite_libelle` varchar(45) NOT NULL,
  `secteur_activite_date_debut` date NOT NULL,
  `secteur_activite_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`secteur_activite_code`,`secteur_activite_date_debut`),
  UNIQUE KEY `type_identifiant_libelle` (`secteur_activite_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_secteurs_activites`
--

INSERT INTO `tb_ref_secteurs_activites` (`secteur_activite_code`, `secteur_activite_libelle`, `secteur_activite_date_debut`, `secteur_activite_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('PRV', 'PRIVE', '2021-04-08', NULL, '2021-04-08 18:03:43', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_sexes`
--

DROP TABLE IF EXISTS `tb_ref_sexes`;
CREATE TABLE IF NOT EXISTS `tb_ref_sexes` (
  `sexe_code` varchar(1) NOT NULL,
  `sexe_libelle` varchar(45) NOT NULL,
  `sexe_date_debut` date NOT NULL,
  `sexe_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sexe_code`,`sexe_date_debut`),
  UNIQUE KEY `sexe_libelle` (`sexe_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_sexes`
--

INSERT INTO `tb_ref_sexes` (`sexe_code`, `sexe_libelle`, `sexe_date_debut`, `sexe_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('F', 'FEMININ', '2021-04-08', NULL, '2021-04-08 18:04:17', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_situations_familiales`
--

DROP TABLE IF EXISTS `tb_ref_situations_familiales`;
CREATE TABLE IF NOT EXISTS `tb_ref_situations_familiales` (
  `situation_familiale_code` varchar(3) NOT NULL,
  `situation_familiale_libelle` varchar(45) NOT NULL,
  `situation_familiale_date_debut` date NOT NULL,
  `situation_familiale_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`situation_familiale_code`,`situation_familiale_date_debut`),
  UNIQUE KEY `situation_familiale_libelle` (`situation_familiale_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_situations_familiales`
--

INSERT INTO `tb_ref_situations_familiales` (`situation_familiale_code`, `situation_familiale_libelle`, `situation_familiale_date_debut`, `situation_familiale_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('CEL', 'CELIBATAIRE', '2021-04-08', NULL, '2021-04-08 18:05:01', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_types_coordonnees`
--

DROP TABLE IF EXISTS `tb_ref_types_coordonnees`;
CREATE TABLE IF NOT EXISTS `tb_ref_types_coordonnees` (
  `type_coordonnee_code` varchar(6) NOT NULL,
  `type_coordonnee_libelle` varchar(45) NOT NULL,
  `type_coordonnee_date_debut` date NOT NULL,
  `type_coordonnee_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`type_coordonnee_code`,`type_coordonnee_date_debut`),
  UNIQUE KEY `type_coordonnee_libelle` (`type_coordonnee_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_types_coordonnees`
--

INSERT INTO `tb_ref_types_coordonnees` (`type_coordonnee_code`, `type_coordonnee_libelle`, `type_coordonnee_date_debut`, `type_coordonnee_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('MOBPER', 'MOBILE PERSONNEL', '2021-04-08', NULL, '2021-04-08 18:05:46', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_ref_types_pieces_identites`
--

DROP TABLE IF EXISTS `tb_ref_types_pieces_identites`;
CREATE TABLE IF NOT EXISTS `tb_ref_types_pieces_identites` (
  `type_piece_identite_code` varchar(6) NOT NULL,
  `type_piece_identite_libelle` varchar(45) NOT NULL,
  `type_piece_identite_date_debut` date NOT NULL,
  `type_piece_identite_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) DEFAULT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`type_piece_identite_code`,`type_piece_identite_date_debut`),
  UNIQUE KEY `type_piece_identite_libelle` (`type_piece_identite_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_ref_types_pieces_identites`
--

INSERT INTO `tb_ref_types_pieces_identites` (`type_piece_identite_code`, `type_piece_identite_libelle`, `type_piece_identite_date_debut`, `type_piece_identite_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('CNI', 'CARTE NATIONALE D\'IDENTITE', '2021-04-08', NULL, '2021-04-08 18:06:34', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs`
--

DROP TABLE IF EXISTS `tb_utilisateurs`;
CREATE TABLE IF NOT EXISTS `tb_utilisateurs` (
  `utilisateur_id` varchar(45) NOT NULL,
  `utilisateur_email` varchar(100) NOT NULL,
  `utilisateur_num_secu` varchar(20) DEFAULT NULL,
  `utilisateur_num_matricule` varchar(20) DEFAULT NULL,
  `utilisateur_pseudo` varchar(30) NOT NULL,
  `civilite_code` varchar(4) DEFAULT NULL,
  `utilisateur_prenoms` varchar(50) NOT NULL,
  `utilisateur_nom` varchar(30) NOT NULL,
  `utilisateur_nom_patronymique` varchar(30) DEFAULT NULL,
  `utilisateur_date_naissance` date DEFAULT NULL,
  `profil_utilisateur_code` varchar(6) DEFAULT NULL,
  `sexe_code` varchar(1) DEFAULT NULL,
  `situation_familiale_code` varchar(3) DEFAULT NULL,
  `categorie_socio_professionnelle_code` varchar(3) DEFAULT NULL,
  `profession_code` varchar(4) DEFAULT NULL,
  `secteur_activite_code` varchar(3) DEFAULT NULL,
  `groupe_sanguin_code` varchar(2) DEFAULT NULL,
  `rhesus_code` varchar(1) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`utilisateur_id`),
  UNIQUE KEY `utilisateur_email` (`utilisateur_email`,`utilisateur_pseudo`),
  KEY `type_utilisateur_code` (`profil_utilisateur_code`),
  KEY `sexe_code` (`sexe_code`),
  KEY `civilite_code` (`civilite_code`),
  KEY `situation_familiale_code` (`situation_familiale_code`),
  KEY `categorie_socio_professionnelle_code` (`categorie_socio_professionnelle_code`),
  KEY `profession_code` (`profession_code`),
  KEY `secteur_activite_code` (`secteur_activite_code`),
  KEY `groupe_sanguin_code` (`groupe_sanguin_code`),
  KEY `rhesus_code` (`rhesus_code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_utilisateurs`
--

INSERT INTO `tb_utilisateurs` (`utilisateur_id`, `utilisateur_email`, `utilisateur_num_secu`, `utilisateur_num_matricule`, `utilisateur_pseudo`, `civilite_code`, `utilisateur_prenoms`, `utilisateur_nom`, `utilisateur_nom_patronymique`, `utilisateur_date_naissance`, `profil_utilisateur_code`, `sexe_code`, `situation_familiale_code`, `categorie_socio_professionnelle_code`, `profession_code`, `secteur_activite_code`, `groupe_sanguin_code`, `rhesus_code`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('12700120210407115351606d9d4f06abd699448198', 'dognimin.koulibali@gmail.com', '3841443513209', '', 'dognimin.koulibali', NULL, 'DOGNIMIN', 'KOULIBALI', '', '1988-06-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-07 11:53:51', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs_mots_de_passe`
--

DROP TABLE IF EXISTS `tb_utilisateurs_mots_de_passe`;
CREATE TABLE IF NOT EXISTS `tb_utilisateurs_mots_de_passe` (
  `utilisateur_id` varchar(45) NOT NULL,
  `mot_de_passe` text NOT NULL,
  `user_mot_de_passe_statut` tinyint(1) NOT NULL,
  `mot_de_passe_date_debut` date NOT NULL,
  `mot_de_passe_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`utilisateur_id`,`user_mot_de_passe_statut`,`mot_de_passe_date_debut`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_utilisateurs_mots_de_passe`
--

INSERT INTO `tb_utilisateurs_mots_de_passe` (`utilisateur_id`, `mot_de_passe`, `user_mot_de_passe_statut`, `mot_de_passe_date_debut`, `mot_de_passe_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('12700120210407115351606d9d4f06abd699448198', '$2y$11$gGkpzHSAvFCnr9rPEHnz0ulHwcQ/0vDEn.4FSxyAn0ckcqfQl.TU.', 0, '2021-04-07', '2021-04-06', '2021-04-07 11:53:51', '1', '2021-04-07 11:55:44', '12700120210407115351606d9d4f06abd699448198'),
('12700120210407115351606d9d4f06abd699448198', '$2y$11$kqe5pstiSculPoYE5P6Luevyi5QkSxbwHPAROM5Sy58y2KbIAGo5W', 1, '2021-04-07', NULL, '2021-04-07 11:55:45', '12700120210407115351606d9d4f06abd699448198', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tb_utilisateurs_statuts`
--

DROP TABLE IF EXISTS `tb_utilisateurs_statuts`;
CREATE TABLE IF NOT EXISTS `tb_utilisateurs_statuts` (
  `utilisateur_id` varchar(45) NOT NULL,
  `statut` tinyint(1) NOT NULL,
  `statut_date_debut` date NOT NULL,
  `statut_passe_date_fin` date DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id_creation` varchar(45) NOT NULL,
  `date_edition` datetime DEFAULT NULL,
  `utilisateur_id_edition` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`utilisateur_id`,`statut`,`statut_date_debut`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tb_utilisateurs_statuts`
--

INSERT INTO `tb_utilisateurs_statuts` (`utilisateur_id`, `statut`, `statut_date_debut`, `statut_passe_date_fin`, `date_creation`, `utilisateur_id_creation`, `date_edition`, `utilisateur_id_edition`) VALUES
('12700120210407115351606d9d4f06abd699448198', 1, '2021-04-07', NULL, '2021-04-07 11:53:51', '1', NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tb_log_historique_connexions`
--
ALTER TABLE `tb_log_historique_connexions`
  ADD CONSTRAINT `tb_log_historique_connexions_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_geo_communes`
--
ALTER TABLE `tb_ref_geo_communes`
  ADD CONSTRAINT `tb_ref_geo_communes_ibfk_1` FOREIGN KEY (`departement_code`) REFERENCES `tb_ref_geo_departements` (`departement_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_geo_departements`
--
ALTER TABLE `tb_ref_geo_departements`
  ADD CONSTRAINT `departement_region_FK` FOREIGN KEY (`region_code`) REFERENCES `tb_ref_geo_regions` (`region_code`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_geo_pays`
--
ALTER TABLE `tb_ref_geo_pays`
  ADD CONSTRAINT `tb_ref_geo_pays_ibfk_1` FOREIGN KEY (`monnaie_code`) REFERENCES `tb_ref_monnaies` (`monnaie_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_ref_geo_regions`
--
ALTER TABLE `tb_ref_geo_regions`
  ADD CONSTRAINT `region_pays_FK` FOREIGN KEY (`pays_code`) REFERENCES `tb_ref_geo_pays` (`pays_code`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs`
--
ALTER TABLE `tb_utilisateurs`
  ADD CONSTRAINT `tb_utilisateurs_ibfk_1` FOREIGN KEY (`categorie_socio_professionnelle_code`) REFERENCES `tb_ref_categories_socio_professionnelles` (`categorie_socio_professionnelle_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_2` FOREIGN KEY (`civilite_code`) REFERENCES `tb_ref_civilites` (`civilite_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_3` FOREIGN KEY (`profession_code`) REFERENCES `tb_ref_professions` (`profession_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_4` FOREIGN KEY (`secteur_activite_code`) REFERENCES `tb_ref_secteurs_activites` (`secteur_activite_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_5` FOREIGN KEY (`sexe_code`) REFERENCES `tb_ref_sexes` (`sexe_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_6` FOREIGN KEY (`situation_familiale_code`) REFERENCES `tb_ref_situations_familiales` (`situation_familiale_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_7` FOREIGN KEY (`profil_utilisateur_code`) REFERENCES `tb_ref_profils_utilisateurs` (`profil_utilisateur_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_8` FOREIGN KEY (`groupe_sanguin_code`) REFERENCES `tb_ref_groupes_sanguins` (`groupe_sanguin_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_utilisateurs_ibfk_9` FOREIGN KEY (`rhesus_code`) REFERENCES `tb_ref_rhesus` (`rhesus_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs_mots_de_passe`
--
ALTER TABLE `tb_utilisateurs_mots_de_passe`
  ADD CONSTRAINT `tb_utilisateurs_mots_de_passe_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tb_utilisateurs_statuts`
--
ALTER TABLE `tb_utilisateurs_statuts`
  ADD CONSTRAINT `tb_utilisateurs_statuts_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `tb_utilisateurs` (`utilisateur_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
