-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 06:51 PM
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
-- Database: `recrutement`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `diploma` varchar(100) DEFAULT NULL,
  `institution` varchar(100) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `domaine` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `description` varchar(700) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `first_name`, `last_name`, `phone`, `email`, `country`, `city`, `diploma`, `institution`, `experience`, `domaine`, `image_path`, `mdp`, `description`) VALUES
(1, 'asihaioh', 'iohasoihaoi', 'ioshaios', 'diosa@gmail.com', 'OIHSOA', 'OISHOI', 'Bac', '0', 21, 'Dihihs', 'uploads/alexander-leading-a-tremendous-army-ntq2stu2twmr6hrn.jpg', 'diosa', 'oisihaoihso');

-- --------------------------------------------------------

--
-- Table structure for table `candidatures`
--

CREATE TABLE `candidatures` (
  `candidat` varchar(255) DEFAULT NULL,
  `recruteur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidatures`
--

INSERT INTO `candidatures` (`candidat`, `recruteur`) VALUES
('diosa@gmail.com', 'idriss@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `emplois`
--

CREATE TABLE `emplois` (
  `id` int(11) NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `email_recruteur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emplois`
--

INSERT INTO `emplois` (`id`, `domain`, `city`, `level`, `pic`, `titre`, `description`, `email_recruteur`) VALUES
(1, 'informatique', 'Casablanca', 'deust', 'pic', 'emploi 1', 'description 1', NULL),
(2, 'ihsi', 'hihih', 'hi', 'ihihi', 'EMPLOI 2', 'DES 2', NULL),
(3, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL),
(4, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL),
(5, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL),
(6, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL),
(7, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL),
(8, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL),
(9, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL),
(10, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL),
(11, 'ih', 'ohio', 'oihoih', 'hih', 'oihoih', 'iohioh', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etat`
--

CREATE TABLE `etat` (
  `candidat` int(11) DEFAULT NULL,
  `recruteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `sender_mail` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `receiver_email` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recruteurs`
--

CREATE TABLE `recruteurs` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temporary_candidats`
--

CREATE TABLE `temporary_candidats` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temporary_candidats`
--

INSERT INTO `temporary_candidats` (`id`, `first_name`, `last_name`, `phone`, `email`, `country`, `city`, `mdp`) VALUES
(2, 'asihaioh', 'iohasoihaoi', 'ioshaios', 'diosa@gmail.com', 'OIHSOA', 'OISHOI', 'diosa');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_recruters`
--

CREATE TABLE `temporary_recruters` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `emplois`
--
ALTER TABLE `emplois`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recruteurs`
--
ALTER TABLE `recruteurs`
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `temporary_candidats`
--
ALTER TABLE `temporary_candidats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `temporary_recruters`
--
ALTER TABLE `temporary_recruters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `emplois`
--
ALTER TABLE `emplois`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temporary_candidats`
--
ALTER TABLE `temporary_candidats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `temporary_recruters`
--
ALTER TABLE `temporary_recruters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
