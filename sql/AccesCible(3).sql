-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 11, 2017 at 08:54 PM
-- Server version: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `AccesCible`
--

-- --------------------------------------------------------

--
-- Table structure for table `signalements`
--

CREATE TABLE `signalements` (
  `idS` int(11) NOT NULL,
  `signalPar` varchar(100) NOT NULL,
  `typeS` varchar(30) NOT NULL,
  `descriptionS` varchar(250) NOT NULL,
  `adresseS` varchar(100) NOT NULL,
  `villeS` varchar(50) NOT NULL,
  `cpS` int(11) NOT NULL,
  `regionS` varchar(100) NOT NULL,
  `paysS` varchar(100) NOT NULL,
  `latlng` text NOT NULL,
  `placeId` text NOT NULL,
  `photoS` int(11) NOT NULL,
  `dateS` varchar(10) NOT NULL,
  `resoluS` tinyint(1) NOT NULL,
  `interventionS` varchar(250) NOT NULL COMMENT 'decription d''une intervention',
  `nSoutienS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `signalements`
--

INSERT INTO `signalements` (`idS`, `signalPar`, `typeS`, `descriptionS`, `adresseS`, `villeS`, `cpS`, `regionS`, `paysS`, `latlng`, `placeId`, `photoS`, `dateS`, `resoluS`, `interventionS`, `nSoutienS`) VALUES
(1, 'a@a.fr', 'Pb place parking', 'Pas de place handicapées', '187 chemin de ternis', 'Privas', 7000, '', '', '', '0', 0, '2016-07-26', 0, '', 0),
(6, 'abbadimehdi@hotmail.fr', 'place handicapÃ©e', 'Ã©Ã©Ã©Ã©', '', 'Privas', 7000, 'Auvergne-RhÃ´ne-Alpes', 'France', '', '', 0, '2017-01-11', 0, '0', 0),
(7, 'abbadimehdi@hotmail.fr', 'place handicapÃ©e', 'Ã©Ã©Ã©Ã©', '', 'Privas', 7000, 'Auvergne-RhÃ´ne-Alpes', 'France', '', '', 0, '2017-01-11', 0, '0', 0),
(9, 'abbadimehdi@hotmail.fr', 'signal sonore ou lumineux', '552', ' ', 'Privas', 7000, 'Auvergne-RhÃ´ne-Alpes', 'France', '', '', 0, '2017-01-11', 0, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idU` int(11) NOT NULL,
  `emailU` varchar(100) NOT NULL,
  `mdpU` text NOT NULL,
  `nomU` varchar(50) DEFAULT NULL,
  `prenomU` varchar(30) DEFAULT NULL,
  `adresseU` varchar(100) DEFAULT NULL,
  `villeU` varchar(50) DEFAULT NULL,
  `cpU` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `telU` int(10) DEFAULT NULL,
  `dateU` varchar(11) NOT NULL,
  `signalU` int(11) DEFAULT NULL,
  `valide` tinyint(1) DEFAULT '0',
  `confirmKey` varchar(500) NOT NULL,
  `confirme` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`idU`, `emailU`, `mdpU`, `nomU`, `prenomU`, `adresseU`, `villeU`, `cpU`, `telU`, `dateU`, `signalU`, `valide`, `confirmKey`, `confirme`) VALUES
(2, 'b@b.fr', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98', NULL, NULL, NULL, NULL, NULL, NULL, '2016-07-26', NULL, NULL, '', 0),
(9, 'abbadimehdi@hotmail.fr', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', NULL, NULL, NULL, NULL, NULL, NULL, '2016-10-11', NULL, 0, '', 0),
(22, 'devabbadimehdi@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'Nom', 'Prenom', 'Adresse', 'Ville', 00000, NULL, '2017-01-05', 1, NULL, '057208981625287', 0),
(23, 'f@f.fr', '4a0a19218e082a343a1b17e5333409af9d98f0f5', 'Nom', 'Prenom', 'Adresse', 'Ville', 00000, NULL, '2017-01-11', 1, NULL, '206609286825473', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `signalements`
--
ALTER TABLE `signalements`
  ADD PRIMARY KEY (`idS`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idU`),
  ADD UNIQUE KEY `emailU` (`emailU`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `signalements`
--
ALTER TABLE `signalements`
  MODIFY `idS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
