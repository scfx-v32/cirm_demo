-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 03:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contrevenants`
--

CREATE TABLE `contrevenants` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `cin` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contrevenants`
--

INSERT INTO `contrevenants` (`id`, `nom`, `prenom`, `cin`, `telephone`, `adresse`) VALUES
(1, 'Lme3ti', 'Benkiran', '', '0649445673', 'Projet BIRANZARAN IMM AS ETAGE3'),
(5, '', '', '', '', ''),
(6, 'Al ', 'Akhawayn', '', '0699887766', 'CAFE AL AKHAWAYN'),
(7, 'Al ', 'Akhawayn', '', '0649445673', 'Projet BIRANZARAN IMM AS ETAGE3'),
(8, 'Contrevenant', '1', '', '', 'rue moulay abdellah'),
(9, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `entites`
--

CREATE TABLE `entites` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entites`
--

INSERT INTO `entites` (`id`, `nom`) VALUES
(1, 'A-AN1'),
(2, 'A-AN2'),
(3, 'A-AN3'),
(4, 'A-Bureau d\'Acceuil et Renseignements'),
(5, 'A-Bureau de Communication et Relations Générales'),
(6, 'A-Bureau d\'Informatique, Documentation et Archive'),
(7, 'A-Bureau d\'Ordre Central'),
(8, 'AC-AC1'),
(9, 'AC-AC2'),
(10, 'AC-AC3'),
(11, 'AC-Bureau d\'Acceuil et Renseignements'),
(12, 'AC-Bureau de Communication et Relations Générales'),
(13, 'AC-Bureau d\'Informatique, Documentation et Archive'),
(14, 'AC-Directeur de l\'Arrondissement'),
(15, 'AC-Groupe Superviseur'),
(16, 'AC-Secrétatiat de Président'),
(17, 'AC-Service de Secrétariat du Conseil et Affaires Juridiques'),
(18, 'AC-Service des Fêtes et Parc Auto'),
(19, 'AC-Service des Marchés et Affaires Financières'),
(20, 'AC-Service des Réclamations et Griefs'),
(21, 'AC-Service des Ressouces Humaines'),
(22, 'AC-Service du Magasin Général'),
(23, 'AC-Service régie'),
(24, 'AF-AF1'),
(25, 'AF-AF2'),
(26, 'AF-AF3'),
(27, 'AF-Bureau d\'Acceuil et Renseignements'),
(28, 'AF-Bureau de Communication et Relations Générales'),
(29, 'AF-Bureau d\'Informatique, Documentation et Archive'),
(30, 'AF-Bureau d\'Ordre Central'),
(31, 'AF-Directeur de l\'Arrondissement'),
(32, 'AF-Groupe Superviseur'),
(33, 'AF-Président de l\'Arrondissement'),
(34, 'AF-Secrétatiat de Président'),
(35, 'AF-Service d\'Audit Interne'),
(36, 'AF-Service de Secrétariat du Conseil et Affaires Juridiques'),
(37, 'AF-Service de Suivi la Gestion Déléguée'),
(38, 'AF-Service des Affaires Culturelles et Sportives'),
(39, 'AF-Service des Affaires Economiques'),
(40, 'AF-Service des Affaires Sociales et Hygiènes'),
(41, 'AF-Service des Affaires Techniques'),
(42, 'AF-Service des Espaces Verts et Environnement'),
(43, 'AF-Service des Fêtes et Parc Auto'),
(44, 'AF-Service des Marchés et Affaires Financières'),
(45, 'AF-Service des Réclamations et Griefs'),
(46, 'AF-Service des Ressouces Humaines'),
(47, 'AF-Service d\'Etat Civil et de Légalisation'),
(48, 'AF-Service du Magasin Général'),
(49, 'AF-Service d\'Urbanisme et Patrimoine'),
(50, 'AF-Service régie'),
(51, 'A-Groupe Superviseur'),
(52, 'A-Président de l\'Arrondissement'),
(53, 'AS-AS1'),
(54, 'AS-AS2'),
(55, 'AS-AS3'),
(56, 'AS-Bureau d\'Acceuil et Renseignements'),
(57, 'AS-Bureau de Communication et Relations Générales'),
(58, 'AS-Bureau d\'Informatique, Documentation et Archive'),
(59, 'AS-Bureau d\'Ordre Central'),
(60, 'AS-Directeur de l\'Arrondissement'),
(61, 'A-Secrétatiat de Président'),
(62, 'A-Service d\'Audit Interne'),
(63, 'A-Service de Secrétariat du Conseil et Affaires Juridiques'),
(64, 'A-Service de Suivi la Gestion Déléguée'),
(65, 'A-Service des Affaires Culturelles et Sportives'),
(66, 'A-Service des Affaires Economiques'),
(67, 'A-Service des Affaires Sociales et Hygiènes'),
(68, 'A-Service des Affaires Techniques'),
(69, 'A-Service des Espaces Verts et Environnement'),
(70, 'A-Service des Fêtes et Parc Auto'),
(71, 'A-Service des Marchés et Affaires Financières'),
(72, 'A-Service des Réclamations et Griefs'),
(73, 'A-Service d\'Etat Civil et de Légalisation'),
(74, 'A-Service du Magasin Général'),
(75, 'A-Service d\'Urbanisme et Patrimoine'),
(76, 'A-Service régie'),
(77, 'AS-Groupe Superviseur'),
(78, 'AS-Président de l\'Arrondissement'),
(79, 'AS-Secrétatiat de Président'),
(80, 'AS-Service d\'Audit Interne'),
(81, 'AS-Service de Secrétariat du Conseil et Affaires Juridiques'),
(82, 'AS-Service de Suivi la Gestion Déléguée'),
(83, 'AS-Service des Affaires Culturelles et Sportives'),
(84, 'AS-Service des Affaires Economiques'),
(85, 'AS-Service des Affaires Sociales et Hygiènes'),
(86, 'AS-Service des Affaires Techniques'),
(87, 'AS-Service des Espaces Verts et Environnement'),
(88, 'AS-Service des Fêtes et Parc Auto'),
(89, 'AS-Service des Marchés et Affaires Financières'),
(90, 'AS-Service des Réclamations et Griefs'),
(91, 'AS-Service des Ressouces Humaines'),
(92, 'AS-Service d\'Etat Civil et de Légalisation'),
(93, 'AS-Service du Magasin Général'),
(94, 'AS-Service d\'Urbanisme et Patrimoine'),
(95, 'AS-Service régie'),
(96, 'Baia-Casablanca baia'),
(97, 'BM-BM1'),
(98, 'BM-BM2'),
(99, 'BM-Bureau d\'Acceuil et Renseignements'),
(100, 'BM-Bureau de Communication et Relations Générales'),
(101, 'BM-Bureau d\'Informatique, Documentation et Archive'),
(102, 'BM-Bureau d\'Ordre Central'),
(103, 'BM-Directeur de l\'Arrondissement'),
(104, 'BM-Groupe Superviseur'),
(105, 'BM-Président de l\'Arrondissement'),
(106, 'BM-Secrétatiat de Président'),
(107, 'BM-Service d\'Audit Interne'),
(108, 'BM-Service de Secrétariat du Conseil et Affaires Juridiques'),
(109, 'BM-Service de Suivi la Gestion Déléguée'),
(110, 'BM-Service des Affaires Culturelles et Sportives'),
(111, 'BM-Service des Affaires Economiques'),
(112, 'BM-Service des Affaires Sociales et Hygiènes'),
(113, 'BM-Service des Affaires Techniques'),
(114, 'BM-Service des Espaces Verts et Environnement'),
(115, 'BM-Service des Fêtes et Parc Auto'),
(116, 'BM-Service des Marchés et Affaires Financières'),
(117, 'BM-Service des Réclamations et Griefs'),
(118, 'BM-Service d\'Etat Civil et de Légalisation'),
(119, 'BM-Service du Magasin Général'),
(120, 'BM-Service d\'Urbanisme et Patrimoine'),
(121, 'BM-Service régie'),
(122, 'CO - CC1'),
(123, 'CO - CC2'),
(124, 'CO - CC3'),
(125, 'CO- Direction Support et Développement des Ressources'),
(126, 'CO- Division Affaires du Conseil et Relations avec les Conseils des Arrondissements'),
(127, 'CO- Division urbanisme et habitat et patrimoine'),
(128, 'CO- Divison Développement Social, Culturel et Sportif'),
(129, 'CO- Service Affaires du Conseil'),
(130, 'CO- Service Approbation des Marchés'),
(131, 'CO- Service Audit Interne et Contrôle de Gestion'),
(132, 'CO- Service Bureau d\'Ordre'),
(133, 'CO- Service communication et coopération'),
(134, 'CO- Service Comptabilité'),
(135, 'CO- Service Contrôle'),
(136, 'CO- Service convention et contrat'),
(137, 'CO- Service développement culturel et sportif'),
(138, 'CO- Service Développement Sportif'),
(139, 'CO- Service entretien général des bâtiments'),
(140, 'CO- Service Réclamations'),
(141, 'CO- Service Recouvrement'),
(142, 'CO- Service Relations avec les Conseils des Arrondissements'),
(143, 'CO- Service Relations avec les Sociétés de Développement Local (SDL)'),
(144, 'CO- Service Suivi des Programmes'),
(145, 'CO-Budget'),
(146, 'CO-Cabinet'),
(147, 'CO-Groupe Superviseur Spéciale'),
(148, 'CO-Secrétariat Particulier'),
(149, 'CO-Service Vétérinaire'),
(150, 'HH- HH1'),
(151, 'HH- HH2'),
(152, 'HH- HH3'),
(153, 'HH-Bureau d\'Acceuil et Renseignements'),
(154, 'HH-Bureau de Communication et Relations Générales'),
(155, 'HH-Bureau d\'Informatique, Documentation et Archive'),
(156, 'HH-Bureau d\'Ordre Central'),
(157, 'HH-Directeur de l\'Arrondissement'),
(158, 'HH-Groupe Superviseur'),
(159, 'HH-Président de l\'Arrondissement'),
(160, 'HH-Secrétatiat de Président'),
(161, 'HH-Service d\'Audit Interne'),
(162, 'HH-Service de Secrétariat du Conseil et Affaires Juridiques'),
(163, 'HH-Service de Suivi la Gestion Déléguée'),
(164, 'HH-Service des Affaires Culturelles et Sportives'),
(165, 'HH-Service des Affaires Economiques'),
(166, 'HH-Service des Affaires Sociales et Hygiènes'),
(167, 'HH-Service des Affaires Techniques'),
(168, 'HH-Service des Espaces Verts et Environnement'),
(169, 'HH-Service des Fêtes et Parc Auto'),
(170, 'HH-Service des Marchés et Affaires Financières'),
(171, 'HH-Service des Réclamations et Griefs'),
(172, 'HH-Service des Ressouces Humaines'),
(173, 'HH-Service d\'Etat Civil et de Légalisation'),
(174, 'HH-Service du Magasin Général'),
(175, 'HH-Service d\'Urbanisme et Patrimoine'),
(176, 'HH-Service régie'),
(177, 'HM-Bureau d\'Acceuil et Renseignements'),
(178, 'HM-Bureau de Communication et Relations Générales'),
(179, 'HM-Bureau d\'Informatique, Documentation et Archive'),
(180, 'HM-Bureau d\'Ordre Central'),
(181, 'HM-Directeur de l\'Arrondissement'),
(182, 'HM-Groupe Superviseur'),
(183, 'HM-HM1'),
(184, 'HM-HM2'),
(185, 'HM-HM3'),
(186, 'HM-Président de l\'Arrondissement'),
(187, 'HM-Secrétatiat de Président'),
(188, 'HM-Service d\'Audit Interne'),
(189, 'HM-Service de Secrétariat du Conseil et Affaires Juridiques'),
(190, 'HM-Service de Suivi la Gestion Déléguée'),
(191, 'HM-Service des Affaires Culturelles et Sportives'),
(192, 'HM-Service des Affaires Economiques'),
(193, 'HM-Service des Affaires Sociales et Hygiènes'),
(194, 'HM-Service des Affaires Techniques'),
(195, 'HM-Service des Espaces Verts et Environnement'),
(196, 'HM-Service des Fêtes et Parc Auto'),
(197, 'HM-Service des Marchés et Affaires Financières'),
(198, 'HM-Service des Réclamations et Griefs'),
(199, 'HM-Service des Ressouces Humaines'),
(200, 'HM-Service d\'Etat Civil et de Légalisation'),
(201, 'HM-Service du Magasin Général'),
(202, 'HM-Service d\'Urbanisme et Patrimoine'),
(203, 'HM-Service régie'),
(204, 'M-Bureau d\'Acceuil et Renseignements'),
(205, 'M-Bureau de Communication et Relations Générales'),
(206, 'M-Bureau d\'Informatique, Documentation et Archive'),
(207, 'M-Bureau d\'Ordre Central'),
(208, 'M-Directeur de l\'Arrondissement'),
(209, 'M-Groupe Superviseur'),
(210, 'M-MA1'),
(211, 'M-MA2'),
(212, 'M-MA3'),
(213, 'M-Président de l\'Arrondissement'),
(214, 'MR-Bureau d\'Acceuil et Renseignements'),
(215, 'MR-Bureau de Communication et Relations Générales'),
(216, 'MR-Bureau d\'Informatique, Documentation et Archive'),
(217, 'MR-Bureau d\'Ordre Central'),
(218, 'MR-Directeur de l\'Arrondissement'),
(219, 'MR-Groupe Superviseur'),
(220, 'MR-MR1'),
(221, 'MR-MR2'),
(222, 'MR-MR3'),
(223, 'MR-MR4'),
(224, 'MR-Président de l\'Arrondissement'),
(225, 'MR-Secrétatiat de Président'),
(226, 'MR-Service d\'Audit Interne'),
(227, 'MR-Service de Secrétariat du Conseil et Affaires Juridiques'),
(228, 'MR-Service de Suivi la Gestion Déléguée'),
(229, 'MR-Service des Affaires Culturelles et Sportives'),
(230, 'MR-Service des Affaires Economiques'),
(231, 'MR-Service des Affaires Sociales et Hygiènes'),
(232, 'MR-Service des Affaires Techniques'),
(233, 'MR-Service des Espaces Verts et Environnement'),
(234, 'MR-Service des Fêtes et Parc Auto'),
(235, 'MR-Service des Marchés et Affaires Financières'),
(236, 'MR-Service des Réclamations et Griefs'),
(237, 'MR-Service des Ressouces Humaines'),
(238, 'MR-Service d\'Etat Civil et de Légalisation'),
(239, 'MR-Service du Magasin Général'),
(240, 'MR-Service d\'Urbanisme et Patrimoine'),
(241, 'MR-Service régie'),
(242, 'MS-Bureau d\'Acceuil et Renseignements'),
(243, 'MS-Bureau de Communication et Relations Générales'),
(244, 'MS-Bureau d\'Informatique, Documentation et Archive'),
(245, 'MS-Bureau d\'Ordre Central'),
(246, 'MS-Directeur de l\'Arrondissement'),
(247, 'M-Secrétatiat de Président'),
(248, 'M-Service d\'Audit Interne'),
(249, 'M-Service de Secrétariat du Conseil et Affaires Juridiques'),
(250, 'M-Service de Suivi la Gestion Déléguée'),
(251, 'M-Service des Affaires Culturelles et Sportives'),
(252, 'M-Service des Affaires Economiques'),
(253, 'M-Service des Affaires Sociales et Hygiènes'),
(254, 'M-Service des Affaires Techniques'),
(255, 'M-Service des Espaces Verts et Environnement'),
(256, 'M-Service des Fêtes et Parc Auto'),
(257, 'M-Service des Marchés et Affaires Financières'),
(258, 'M-Service des Réclamations et Griefs'),
(259, 'M-Service des Ressouces Humaines'),
(260, 'M-Service d\'Etat Civil et de Légalisation'),
(261, 'M-Service du Magasin Général'),
(262, 'M-Service d\'Urbanisme et Patrimoine'),
(263, 'M-Service régie'),
(264, 'MS-Groupe Superviseur'),
(265, 'MS-MS1'),
(266, 'MS-MS2'),
(267, 'MS-MS3'),
(268, 'MS-Président de l\'Arrondissement'),
(269, 'MS-Secrétatiat de Président'),
(270, 'MS-Service d\'Audit Interne'),
(271, 'MS-Service de Secrétariat du Conseil et Affaires Juridiques'),
(272, 'MS-Service de Suivi la Gestion Déléguée'),
(273, 'MS-Service des Affaires Culturelles et Sportives'),
(274, 'MS-Service des Affaires Economiques'),
(275, 'MS-Service des Affaires Sociales et Hygiènes'),
(276, 'MS-Service des Affaires Techniques'),
(277, 'MS-Service des Espaces Verts et Environnement'),
(278, 'MS-Service des Fêtes et Parc Auto'),
(279, 'MS-Service des Marchés et Affaires Financières'),
(280, 'MS-Service des Réclamations et Griefs'),
(281, 'MS-Service des Ressouces Humaines'),
(282, 'MS-Service d\'Etat Civil et de Légalisation'),
(283, 'MS-Service du Magasin Général'),
(284, 'MS-Service d\'Urbanisme et Patrimoine'),
(285, 'MS-Service régie'),
(286, 'PAC-Bureau d\'ordre'),
(287, 'PAC-Département des opérations et du suivi'),
(288, 'PAC-Département Hygiène'),
(289, 'PAC-Département support'),
(290, 'PAC-Directeur de l\'UPAC'),
(291, 'PAC-Inspection'),
(292, 'PAC-Service de coordination et du suivi des opérations de propreté et de salubrité publique'),
(293, 'PAC-Service de la collecte des statistiques et du traitement des PVs'),
(294, 'PAC-Service de planification et de programmation'),
(295, 'PAC-Service ressources humaines et logistiques'),
(296, 'PAC-Service systèmes Information et veille'),
(297, 'RN - RN1'),
(298, 'RN - RN2'),
(299, 'RN - RN3'),
(300, 'RN-Bureau d\'Acceuil et Renseignements'),
(301, 'RN-Bureau de Communication et Relations Générales'),
(302, 'RN-Bureau d\'Informatique, Documentation et Archive'),
(303, 'RN-Bureau d\'Ordre Central'),
(304, 'RN-Directeur de l\'Arrondissement'),
(305, 'RN-Groupe Superviseur'),
(306, 'RN-Président de l\'Arrondissement'),
(307, 'RN-Secrétatiat de Président'),
(308, 'RN-Service d\'Audit Interne'),
(309, 'RN-Service de Secrétariat du Conseil et Affaires Juridiques'),
(310, 'RN-Service de Suivi la Gestion Déléguée'),
(311, 'RN-Service des Affaires Culturelles et Sportives'),
(312, 'RN-Service des Affaires Economiques'),
(313, 'RN-Service des Affaires Sociales et Hygiènes'),
(314, 'RN-Service des Affaires Techniques'),
(315, 'RN-Service des Espaces Verts et Environnement'),
(316, 'RN-Service des Fêtes et Parc Auto'),
(317, 'RN-Service des Marchés et Affaires Financières'),
(318, 'RN-Service des Réclamations et Griefs'),
(319, 'RN-Service des Ressouces Humaines'),
(320, 'RN-Service d\'Etat Civil et de Légalisation'),
(321, 'RN-Service du Magasin Général'),
(322, 'RN-Service d\'Urbanisme et Patrimoine'),
(323, 'RN-Service régie'),
(324, 'SBEL -Service autorisations commerciales'),
(325, 'SBEL_Service marché et achats'),
(326, 'SBEL-Bureau d\'Acceuil et Renseignements'),
(327, 'SBEL-Bureau de Communication et Relations Générales'),
(328, 'SBEL-Bureau d\'Informatique, Documentation et Archive'),
(329, 'SBEL-Bureau domaine public'),
(330, 'SBEL-Bureau d\'Ordre Central'),
(331, 'SBEL-Directeur de l\'Arrondissement'),
(332, 'SBEL-Groupe Superviseur'),
(333, 'SBEL-Président de l\'Arrondissement'),
(334, 'SBEL-SB1'),
(335, 'SBEL-SB2'),
(336, 'SBEL-SB3'),
(337, 'SBEL-SB4'),
(338, 'SBEL-Secrétatiat de Président'),
(339, 'SBEL-Service d\'Audit Interne'),
(340, 'SBEL-Service de Secrétariat du Conseil et Affaires Juridiques'),
(341, 'SBEL-Service de Suivi la Gestion Déléguée'),
(342, 'SBEL-Service des Affaires Culturelles et Sportives'),
(343, 'SBEL-Service des Affaires Economiques'),
(344, 'SBEL-Service des Affaires Sociales et Hygiènes'),
(345, 'SBEL-Service des Affaires Techniques'),
(346, 'SBEL-Service des Espaces Verts et Environnement'),
(347, 'SBEL-Service des Fêtes et Parc Auto'),
(348, 'SBEL-Service des Marchés et Affaires Financières'),
(349, 'SBEL-Service des Réclamations et Griefs'),
(350, 'SBEL-Service des Ressouces Humaines'),
(351, 'SBEL-Service d\'Etat Civil et de Légalisation'),
(352, 'SBEL-Service du Magasin Général'),
(353, 'SBEL-Service d\'Urbanisme et Patrimoine'),
(354, 'SBEL-Service régie'),
(355, 'SBER-Bureau d\'Acceuil et Renseignements'),
(356, 'SBER-Bureau de Communication et Relations Générales'),
(357, 'SBER-Bureau d\'Informatique, Documentation et Archive'),
(358, 'SBER-Bureau d\'Ordre Central'),
(359, 'SBER-Directeur de l\'Arrondissement'),
(360, 'SBER-Groupe Superviseur'),
(361, 'SBER-Président de l\'Arrondissement'),
(362, 'SBER-SBER1'),
(363, 'SBER-SBER2'),
(364, 'SBER-SBER3'),
(365, 'SBER-Secrétatiat de Président'),
(366, 'SBER-Service d\'Audit Interne'),
(367, 'SBER-Service de Secrétariat du Conseil et Affaires Juridiques'),
(368, 'SBER-Service de Suivi la Gestion Déléguée'),
(369, 'SBER-Service des Affaires Culturelles et Sportives'),
(370, 'SBER-Service des Affaires Economiques'),
(371, 'SBER-Service des Affaires Sociales et Hygiènes'),
(372, 'SBER-Service des Affaires Techniques'),
(373, 'SBER-Service des Espaces Verts et Environnement'),
(374, 'SBER-Service des Fêtes et Parc Auto'),
(375, 'SBER-Service des Marchés et Affaires Financières'),
(376, 'SBER-Service des Réclamations et Griefs'),
(377, 'SBER-Service des Ressouces Humaines'),
(378, 'SBER-Service d\'Etat Civil et de Légalisation'),
(379, 'SBER-Service du Magasin Général'),
(380, 'SBER-Service d\'Urbanisme et Patrimoine'),
(381, 'SBER-Service régie'),
(382, 'S-Bureau d\'Acceuil et Renseignements'),
(383, 'S-Bureau de Communication et Relations Générales'),
(384, 'S-Bureau d\'Informatique, Documentation et Archive'),
(385, 'S-Bureau d\'Ordre Central'),
(386, 'S-Directeur de l\'Arrondissement'),
(387, 'S-Groupe Superviseur'),
(388, 'SM-Bureau d\'Acceuil et Renseignements'),
(389, 'SM-Bureau de Communication et Relations Générales'),
(390, 'SM-Bureau d\'Informatique, Documentation et Archive'),
(391, 'SM-Bureau d\'Ordre Central'),
(392, 'SM-Directeur de l\'Arrondissement'),
(393, 'SM-Groupe Superviseur'),
(394, 'SM-Président de l\'Arrondissement'),
(395, 'SM-Secrétatiat de Président'),
(396, 'SM-Service d\'Audit Interne'),
(397, 'SM-Service de Secrétariat du Conseil et Affaires Juridiques'),
(398, 'SM-Service de Suivi la Gestion Déléguée'),
(399, 'SM-Service des Affaires Culturelles et Sportives'),
(400, 'SM-Service des Affaires Economiques'),
(401, 'SM-Service des Affaires Sociales et Hygiènes'),
(402, 'SM-Service des Affaires Techniques'),
(403, 'SM-Service des Espaces Verts et Environnement'),
(404, 'SM-Service des Fêtes et Parc Auto'),
(405, 'SM-Service des Marchés et Affaires Financières'),
(406, 'SM-Service des Réclamations et Griefs'),
(407, 'SM-Service des Ressouces Humaines'),
(408, 'SM-Service d\'Etat Civil et de Légalisation'),
(409, 'SM-Service du Magasin Général'),
(410, 'SM-Service d\'Urbanisme et Patrimoine'),
(411, 'SM-Service régie'),
(412, 'SM-Sidi Moumen'),
(413, 'SM-SM1'),
(414, 'SM-SM2'),
(415, 'SM-SM3'),
(416, 'SO-Bureau d\'Acceuil et Renseignements'),
(417, 'SO-Bureau de Communication et Relations Générales'),
(418, 'SO-Bureau d\'Informatique, Documentation et Archive'),
(419, 'SO-Bureau d\'Ordre Central'),
(420, 'SO-Directeur de l\'Arrondissement'),
(421, 'SO-Groupe Superviseur'),
(422, 'SO-Président de l\'Arrondissement'),
(423, 'SO-Secrétatiat de Président'),
(424, 'SO-Service d\'Audit Interne'),
(425, 'SO-Service de Secrétariat du Conseil et Affaires Juridiques'),
(426, 'SO-Service de Suivi la Gestion Déléguée'),
(427, 'SO-Service des Affaires Culturelles et Sportives'),
(428, 'SO-Service des Affaires Economiques'),
(429, 'SO-Service des Affaires Sociales et Hygiènes'),
(430, 'SO-Service des Affaires Techniques'),
(431, 'SO-Service des Espaces Verts et Environnement'),
(432, 'SO-Service des Fêtes et Parc Auto'),
(433, 'SO-Service des Marchés et Affaires Financières'),
(434, 'SO-Service des Réclamations et Griefs'),
(435, 'SO-Service des Ressouces Humaines'),
(436, 'SO-Service d\'Etat Civil et de Légalisation'),
(437, 'SO-Service du Magasin Général'),
(438, 'SO-Service d\'Urbanisme et Patrimoine'),
(439, 'SO-Service régie'),
(440, 'SO-SO1'),
(441, 'SO-SO2'),
(442, 'SO-SO3'),
(443, 'SO-SO4'),
(444, 'S-Président de l\'Arrondissement'),
(445, 'S-SBT1'),
(446, 'S-SBT2'),
(447, 'S-SBT3'),
(448, 'S-Secrétatiat de Président'),
(449, 'S-Service d\'Audit Interne'),
(450, 'S-Service de Secrétariat du Conseil et Affaires Juridiques'),
(451, 'S-Service de Suivi la Gestion Déléguée'),
(452, 'S-Service des Affaires Culturelles et Sportives'),
(453, 'S-Service des Affaires Economiques'),
(454, 'S-Service des Affaires Sociales et Hygiènes'),
(455, 'S-Service des Affaires Techniques'),
(456, 'S-Service des Espaces Verts et Environnement'),
(457, 'S-Service des Fêtes et Parc Auto'),
(458, 'S-Service des Marchés et Affaires Financières'),
(459, 'S-Service des Réclamations et Griefs'),
(460, 'S-Service des Ressouces Humaines'),
(461, 'S-Service d\'Etat Civil et de Légalisation'),
(462, 'S-Service du Magasin Général'),
(463, 'S-Service d\'Urbanisme et Patrimoine'),
(464, 'S-Service régie'),
(465, 'AC-Président de l\'Arrondissement'),
(466, 'CO-LE PRÉSIDENT'),
(467, 'AC-Service d\'Audit Interne'),
(468, 'AC-Service de Suivi la Gestion Déléguée'),
(469, 'CO- Service Relations avec les Sociétés de la Gestion Déléguée'),
(470, 'AC-Service des Affaires Culturelles et Sportives'),
(471, 'CO-Le Directeur Général des Services'),
(472, 'AC-Service des Affaires Economiques'),
(473, 'AC-Service des Affaires Sociales et Hygiènes'),
(474, 'AC-Service des Affaires Techniques'),
(475, 'AC-Service des Espaces Verts et Environnement'),
(476, 'CO- Service Réclamations'),
(477, 'CO- Direction Développement Durable et Vie Urbaine'),
(478, 'CO- Service transport et déplacement et signalétique et éclairage public'),
(479, 'AC-Service des Réclamations et Griefs'),
(480, 'CO- Division de vie urbaine'),
(481, 'CO- Service Environnement et Développement Durable et eau'),
(482, 'AC-Service d\'Etat Civil et de Légalisation'),
(483, 'CO- Service de prévention et hygiène'),
(484, 'AC-Service d\'Urbanisme et Patrimoine'),
(485, 'CO- Direction d\'urbanisme, de patrimoine et affaires juridiques'),
(486, 'CO- Service Urbanisme'),
(487, 'CO- Service Habitat et patrimoine'),
(488, 'CO- Direction Affaires Economiques et vie urbaine'),
(489, 'AC-Bureau d\'Ordre Central'),
(490, 'CO- Division Affaires Economiques'),
(491, 'CO- Service Autorisations Commerciales'),
(492, 'CO- Service Annonces Publicitaires'),
(493, 'CO- Service Occupation du Domaine Public'),
(494, 'CO- Service Développement Social'),
(495, 'CO-Service Développement Culturel'),
(496, 'CO- Direction Infrastructure de Base et Services Techniques'),
(497, 'CO- Division Bâtiments et Voiries'),
(498, 'CO- Service des grands projets'),
(499, 'CO- Service Voiries et Réseaux Divers'),
(500, 'CO- Division Les Espaces Verts'),
(501, 'CO- Service Entretien et Pépinières'),
(502, 'CO- Service Travaux Neufs'),
(503, 'CO- Division Ressources Humaines'),
(504, 'CO- Service Administration des Ressources Humaines'),
(505, 'CO- Service Développement des Ressources Humaines et Formation'),
(506, 'CO- Service Affaires et Relations Sociales'),
(507, 'CO- Service Paie'),
(508, 'CO- Division Budget et Moyens Généraux'),
(509, 'CO- Service Moyens Généraux et Equipements'),
(510, 'CO- Service Achats et Marchés Publics'),
(511, 'CO- Division Fiscalité'),
(512, 'CO- Service Assiette Fiscale'),
(513, 'CO- Division affaires juridiques'),
(514, 'CO- Service contentieux et négociation'),
(515, 'CO- Service Etat Civil'),
(516, 'CO- Service Gestion des Archives'),
(517, 'CO- service gestion du patrimoine et opérations immobilières');

-- --------------------------------------------------------

--
-- Table structure for table `requerants`
--

CREATE TABLE `requerants` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `cin` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requerants`
--

INSERT INTO `requerants` (`id`, `nom`, `prenom`, `cin`, `telephone`, `adresse`) VALUES
(1, 'monsieur ', 'lamine', 'bx334455', '0678985432', 'Projet BIRANZARAN IMM AS ETAGE3\r\nAPP 6 BD MOUDIBOUKEITA CASABLANCA'),
(4, 'Tati', 'Aicha', 'cv123456', '0654565438', 'RESIDENCE SARA AVENUE 2 mars'),
(6, 'Amrani', 'Yacine', 'fd345678', '0567876534', 'dar bouazza yacine 20250'),
(7, 'Allali', 'Mohamed', 'BL123456', '0987654321', 'DERB MILA AIN BERJA '),
(8, 'sidi', 'ali', 'BL000000', '0800990088', 'DAR FLAN LFLANI RUE X'),
(9, 'MARWA', 'BASSISSA', 'BE457698', '0702090822', 'DARHOM'),
(10, 'ZAKI', 'AMINA', 'BL909000', '0309876535', '46 RUE JAMAL EDDINE ALAFGHANI '),
(11, 'Mohammed', 'Zaki', 'HH445363', '0678965432', '46 RUE JAMAL EDDINE ALAFGHANI'),
(12, 'bennani', 'abdelkader', 'AL001962', '+213600196200', 'Ouran, abdelkader wel 3alamia rue vandamme 36'),
(13, 'RAJANY', 'AYA', 'BL000000', '0698098976', 'Projet BIRANZARAN IMM AS ETAGE3\r\nAPP 6 BD MOUDIBOUKEITA CASABLANCA');

-- --------------------------------------------------------

--
-- Table structure for table `requetes`
--

CREATE TABLE `requetes` (
  `id` int(11) NOT NULL,
  `objet` text NOT NULL,
  `detail` text DEFAULT NULL,
  `canal` varchar(50) DEFAULT NULL,
  `date_reception` date DEFAULT NULL,
  `urgence` varchar(50) DEFAULT NULL,
  `id_requerant` int(11) DEFAULT NULL,
  `id_contrevenant` int(11) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `arrondissement` varchar(100) DEFAULT 'Mers Sultan',
  `id_type` int(11) DEFAULT NULL,
  `id_entite` int(11) DEFAULT NULL,
  `id_statut` int(11) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `date_cloture` date DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requetes`
--

INSERT INTO `requetes` (`id`, `objet`, `detail`, `canal`, `date_reception`, `urgence`, `id_requerant`, `id_contrevenant`, `adresse`, `arrondissement`, `id_type`, `id_entite`, `id_statut`, `created_by`, `closed_by`, `date_cloture`, `document_path`) VALUES
(1, 'ihtilal lmilk l3amm', 'Oh nonono look at this bruh, trotoire tahouwa cheddouh, milk 3am bro they shouldn\'t lol', 'Présentiel', '2025-05-09', 'Normale', 12, 6, 'CAFE AL AKHAWAYN', 'Mers Sultan', 18, 75, 1, 8, NULL, NULL, 'uploads/1746750414_may.jpg'),
(2, 'tati aicha jat', '$$$$$$$zertyuiopmlkjhgfdswxytdiytdtr', 'Courrier', '2025-05-09', 'Normale', 4, 7, 'APP 6 BD MOUDIBOUKEITA CASABLANCA', 'Mers Sultan', 45, 18, 1, 8, NULL, NULL, 'uploads/1746753495_Screenshot 2025-03-13 170114.png'),
(3, 'chihaja', '1234567890/??????', 'Courrier', '2025-05-10', 'Normale', 13, 8, 'rue moulay abdellah', 'Mers Sultan', 7, 40, 3, 8, NULL, NULL, 'uploads/1746834343_TP2 Manipulation des Middlewares.pdf'),
(4, 'AAAAAAAAAAAA', 'AZERTYUIOPQSDFGHJKLMWXCVBN?./§1234567890°+£¨%µ§/.', 'Téléphone', '2025-05-09', 'Normale', 4, 9, 'RUE JAMAL EDDINE ALAFGHANI', 'Mers Sultan', 7, 40, 3, 8, NULL, NULL, 'uploads/1746837270_Pièces_à_fournir_inscription_licence_professionnelle_2021.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `statuts`
--

CREATE TABLE `statuts` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statuts`
--

INSERT INTO `statuts` (`id`, `libelle`) VALUES
(1, 'Requête Envoyée'),
(2, 'Prise En Charge'),
(3, 'Clôturée');

-- --------------------------------------------------------

--
-- Table structure for table `types_reclamation`
--

CREATE TABLE `types_reclamation` (
  `id` int(11) NOT NULL,
  `entite_id` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types_reclamation`
--

INSERT INTO `types_reclamation` (`id`, `entite_id`, `libelle`) VALUES
(1, 49, 'Construction illégale'),
(2, 75, 'Problème de permis de construire'),
(3, 94, 'Dégradation de patrimoine'),
(4, 175, 'Occupation illégale d\'espace public'),
(5, 240, 'Modification non autorisée de façade'),
(6, 353, 'Publicité non autorisée'),
(7, 40, 'Déchets non collectés'),
(8, 67, 'Nuisances olfactives'),
(9, 85, 'Animaux errants'),
(10, 166, 'Eaux stagnantes'),
(11, 292, 'Propreté des rues'),
(12, 344, 'Restaurants insalubres'),
(13, 42, 'Nids-de-poule'),
(14, 69, 'Éclairage public défectueux'),
(15, 87, 'Arbres à élaguer'),
(16, 168, 'Mobilier urbain endommagé'),
(17, 233, 'Espaces verts non entretenus'),
(18, 500, 'Trottoirs endommagés'),
(19, 43, 'Stationnement gênant'),
(20, 70, 'Signalisation manquante'),
(21, 115, 'Véhicules abandonnés'),
(22, 196, 'Problème de parking municipal'),
(23, 478, 'Problème de circulation'),
(24, 481, 'Fuites d\'eau'),
(25, 483, 'Problème d\'assainissement'),
(26, 167, 'Évacuation des eaux pluviales'),
(27, 478, 'Panne d\'éclairage public'),
(28, 69, 'Horloge publique défectueuse'),
(29, 324, 'Commerce non autorisé'),
(30, 325, 'Problème dans les marchés publics'),
(31, 491, 'Enseigne non conforme'),
(32, 8, 'Information générale'),
(33, 8, 'Orientation des citoyens'),
(34, 8, 'Réception des plaintes'),
(35, 9, 'Communication publique'),
(36, 9, 'Relations avec les médias'),
(37, 9, 'Gestion des événements'),
(38, 10, 'Gestion des archives'),
(39, 10, 'Support informatique'),
(40, 10, 'Accès à l\'information'),
(41, 17, 'Affaires juridiques'),
(42, 17, 'Secrétariat du conseil'),
(43, 17, 'Gestion des documents officiels'),
(44, 18, 'Organisation des fêtes'),
(45, 18, 'Gestion du parc auto'),
(46, 18, 'Logistique des événements'),
(47, 19, 'Gestion des marchés publics'),
(48, 19, 'Affaires financières'),
(49, 19, 'Suivi des contrats'),
(50, 20, 'Recrutement'),
(51, 20, 'Formation du personnel'),
(52, 20, 'Gestion des carrières'),
(53, 21, 'Gestion des stocks'),
(54, 21, 'Approvisionnement'),
(55, 21, 'Distribution des fournitures'),
(56, 22, 'Gestion des régies'),
(57, 22, 'Suivi des recettes'),
(58, 22, 'Contrôle des dépenses'),
(59, 25, 'Problème de propreté'),
(60, 25, 'Gestion des déchets'),
(61, 25, 'Nuisances sonores'),
(62, 26, 'Entretien des espaces verts'),
(63, 26, 'Gestion des aires de jeux'),
(64, 26, 'Protection de l\'environnement'),
(65, 27, 'Réparation des équipements publics'),
(66, 27, 'Amélioration des infrastructures'),
(67, 27, 'Gestion des travaux publics'),
(68, 28, 'Réclamation de service'),
(69, 28, 'Signalement de dysfonctionnement'),
(70, 28, 'Demande de suivi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dispatcher','agent') NOT NULL,
  `entite_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `username`, `type_id`, `password`, `role`, `entite_id`, `created_at`) VALUES
(2, 'mr', 'dispatcher', 'dispatcher_user', NULL, '482c811da5d5b4bc6d497ffa98491e38', 'dispatcher', 459, '2025-04-28 14:29:35'),
(6, 'Flan', 'Foulani', 'mr_flan1', 9, '$2y$10$REbVzCT/t1LkboXxst4lHuZNdxa2ICqssSRYZh.o1Jad9s37V7SdO', 'agent', 85, '2025-04-29 12:11:57'),
(8, 'Lefhal', 'Latifa', 'LLEFHAL', NULL, '$2y$10$OZzACBt9HHyaUUGKIHcsT.IsPlF2zlq5DiRpJE1rmsWKjOd6JwjnO', 'dispatcher', 20, '2025-04-29 13:05:53'),
(10, 'Z', 'XY', 'scfxv32', NULL, '$2y$10$kT66ZSQIN/Kx8GMoODdR7evwz8sF1HRr6pd8YstE9rqgtd.DLyrn6', 'admin', 6, '2025-05-02 07:59:26'),
(13, 'Zaki', 'Amina', 'zaki123', 45, '$2y$10$XCBzhDtAXkqY37LL7sUHluFDR6LQPjP6rZBl5O5BKvPT3uU3UCPGS', 'agent', 18, '2025-05-09 18:42:00'),
(14, 'Rajany', 'Diyae', 'diyae123', NULL, '$2y$10$Zd0AT.6o3G.PQOkATfaPBuDJsEzBtt3P.93Pjo7an9ZKicZsWxEl.', 'admin', 13, '2025-05-09 20:09:14'),
(26, 'AGENT', '1', 'agent1', 7, '$2y$10$TC4psxN18F0BGS1AIujmDO/e6qHx6OqQSuDAQM.7HYCWnwoyk4JLm', 'agent', 40, '2025-05-09 23:48:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contrevenants`
--
ALTER TABLE `contrevenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entites`
--
ALTER TABLE `entites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requerants`
--
ALTER TABLE `requerants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requetes`
--
ALTER TABLE `requetes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `closed_by` (`closed_by`),
  ADD KEY `fk_requerant` (`id_requerant`),
  ADD KEY `fk_contrevenant` (`id_contrevenant`),
  ADD KEY `fk_type` (`id_type`),
  ADD KEY `fk_entite` (`id_entite`),
  ADD KEY `fk_statut` (`id_statut`);

--
-- Indexes for table `statuts`
--
ALTER TABLE `statuts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types_reclamation`
--
ALTER TABLE `types_reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entite_id` (`entite_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `entite_id` (`entite_id`),
  ADD KEY `fk_type_id` (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contrevenants`
--
ALTER TABLE `contrevenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `entites`
--
ALTER TABLE `entites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=518;

--
-- AUTO_INCREMENT for table `requerants`
--
ALTER TABLE `requerants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `requetes`
--
ALTER TABLE `requetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuts`
--
ALTER TABLE `statuts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `types_reclamation`
--
ALTER TABLE `types_reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `requetes`
--
ALTER TABLE `requetes`
  ADD CONSTRAINT `fk_contrevenant` FOREIGN KEY (`id_contrevenant`) REFERENCES `contrevenants` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_entite` FOREIGN KEY (`id_entite`) REFERENCES `entites` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_requerant` FOREIGN KEY (`id_requerant`) REFERENCES `requerants` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_statut` FOREIGN KEY (`id_statut`) REFERENCES `statuts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_type` FOREIGN KEY (`id_type`) REFERENCES `types_reclamation` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `requetes_ibfk_1` FOREIGN KEY (`id_requerant`) REFERENCES `requerants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requetes_ibfk_2` FOREIGN KEY (`id_contrevenant`) REFERENCES `contrevenants` (`id`),
  ADD CONSTRAINT `requetes_ibfk_3` FOREIGN KEY (`id_type`) REFERENCES `types_reclamation` (`id`),
  ADD CONSTRAINT `requetes_ibfk_5` FOREIGN KEY (`id_entite`) REFERENCES `entites` (`id`),
  ADD CONSTRAINT `requetes_ibfk_6` FOREIGN KEY (`id_statut`) REFERENCES `statuts` (`id`),
  ADD CONSTRAINT `requetes_ibfk_7` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requetes_ibfk_8` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `types_reclamation`
--
ALTER TABLE `types_reclamation`
  ADD CONSTRAINT `fk_entite_id` FOREIGN KEY (`entite_id`) REFERENCES `entites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_type_id` FOREIGN KEY (`type_id`) REFERENCES `types_reclamation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`entite_id`) REFERENCES `entites` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
