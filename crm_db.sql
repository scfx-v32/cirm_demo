-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 04:20 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `entites`
--

CREATE TABLE `entites` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historique`
--

CREATE TABLE `historique` (
  `id` int(11) NOT NULL,
  `id_requete` int(11) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `fait_par` int(11) DEFAULT NULL,
  `date_action` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `arrondissement` varchar(100) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `id_sous_type` int(11) DEFAULT NULL,
  `id_entite` int(11) DEFAULT NULL,
  `id_statut` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `date_cloture` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sous_types`
--

CREATE TABLE `sous_types` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `libelle` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statuts`
--

CREATE TABLE `statuts` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types_reclamation`
--

CREATE TABLE `types_reclamation` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dispatcher','agent') NOT NULL,
  `entite_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `entite_id`, `created_at`) VALUES
(1, 'admin', '$2y$10$GcIg2tc.ltPDzyXZE.VOXOHu/viuYcAiEYK30YM200vtuQ1i2x0EW', 'admin', NULL, '2025-04-24 14:18:59');

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
-- Indexes for table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_requete` (`id_requete`),
  ADD KEY `fait_par` (`fait_par`);

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
  ADD KEY `id_requerant` (`id_requerant`),
  ADD KEY `id_contrevenant` (`id_contrevenant`),
  ADD KEY `id_type` (`id_type`),
  ADD KEY `id_sous_type` (`id_sous_type`),
  ADD KEY `id_entite` (`id_entite`),
  ADD KEY `id_statut` (`id_statut`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `closed_by` (`closed_by`);

--
-- Indexes for table `sous_types`
--
ALTER TABLE `sous_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `statuts`
--
ALTER TABLE `statuts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types_reclamation`
--
ALTER TABLE `types_reclamation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `entite_id` (`entite_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contrevenants`
--
ALTER TABLE `contrevenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entites`
--
ALTER TABLE `entites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historique`
--
ALTER TABLE `historique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requerants`
--
ALTER TABLE `requerants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requetes`
--
ALTER TABLE `requetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sous_types`
--
ALTER TABLE `sous_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuts`
--
ALTER TABLE `statuts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types_reclamation`
--
ALTER TABLE `types_reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `historique_ibfk_1` FOREIGN KEY (`id_requete`) REFERENCES `requetes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historique_ibfk_2` FOREIGN KEY (`fait_par`) REFERENCES `users` (`id`);

--
-- Constraints for table `requetes`
--
ALTER TABLE `requetes`
  ADD CONSTRAINT `requetes_ibfk_1` FOREIGN KEY (`id_requerant`) REFERENCES `requerants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requetes_ibfk_2` FOREIGN KEY (`id_contrevenant`) REFERENCES `contrevenants` (`id`),
  ADD CONSTRAINT `requetes_ibfk_3` FOREIGN KEY (`id_type`) REFERENCES `types_reclamation` (`id`),
  ADD CONSTRAINT `requetes_ibfk_4` FOREIGN KEY (`id_sous_type`) REFERENCES `sous_types` (`id`),
  ADD CONSTRAINT `requetes_ibfk_5` FOREIGN KEY (`id_entite`) REFERENCES `entites` (`id`),
  ADD CONSTRAINT `requetes_ibfk_6` FOREIGN KEY (`id_statut`) REFERENCES `statuts` (`id`),
  ADD CONSTRAINT `requetes_ibfk_7` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requetes_ibfk_8` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `sous_types`
--
ALTER TABLE `sous_types`
  ADD CONSTRAINT `sous_types_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types_reclamation` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`entite_id`) REFERENCES `entites` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
