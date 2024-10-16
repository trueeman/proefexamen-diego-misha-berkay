-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 16, 2024 at 10:02 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proefexamen`
--

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gebruikersnaam` varchar(255) DEFAULT NULL,
  `wachtwoord` varchar(255) DEFAULT NULL,
  `registratiedatum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verkiesbaar` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `email`, `gebruikersnaam`, `wachtwoord`, `registratiedatum`, `is_verkiesbaar`) VALUES
(1, NULL, 'misha', '123456', '2024-10-11 11:26:18', 0),
(2, NULL, 'newuser', '12312321', '2024-10-11 11:55:51', 0),
(3, NULL, 'b.onal', '123123', '2024-10-11 12:25:53', 0),
(4, NULL, 'b010', '123123', '2024-10-16 09:10:25', 0),
(5, NULL, '1231233', '123123', '2024-10-16 09:33:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `partijen`
--

CREATE TABLE `partijen` (
  `id` int(11) NOT NULL,
  `partijnaam` varchar(255) NOT NULL,
  `datum_oprichting` date NOT NULL,
  `is_actief` tinyint(1) DEFAULT '1',
  `leider` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `partijen`
--

INSERT INTO `partijen` (`id`, `partijnaam`, `datum_oprichting`, `is_actief`, `leider`) VALUES
(1, 'DENKssss', '2024-05-02', 1, '1231312212'),
(3, 'DENK', '2005-01-01', 1, '123'),
(4, 'DENK', '2005-09-09', 1, '123'),
(5, 'berky', '2004-09-09', 1, 'berky');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partijen`
--
ALTER TABLE `partijen`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `partijen`
--
ALTER TABLE `partijen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
