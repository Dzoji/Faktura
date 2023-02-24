-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2023 at 11:04 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lanaco`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikal`
--

CREATE TABLE `artikal` (
  `ArtikalId` int(11) NOT NULL,
  `Sifra` varchar(50) DEFAULT NULL,
  `Naziv` varchar(50) DEFAULT NULL,
  `JedinicaMjere` char(3) DEFAULT NULL,
  `Barkod` varchar(50) DEFAULT NULL,
  `PLU_KOD` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikal`
--

INSERT INTO `artikal` (`ArtikalId`, `Sifra`, `Naziv`, `JedinicaMjere`, `Barkod`, `PLU_KOD`) VALUES
(1, 'A1', 'Pivo', 'l', 'BK1', 'PK1'),
(2, 'A2', 'Vino', 'l', 'BK2', 'PK2'),
(3, 'A3', 'Voda', 'l', 'BK3', 'PK3');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `KorisnikId` int(11) NOT NULL,
  `KorisnickoIme` varchar(50) DEFAULT NULL,
  `Sifra` varbinary(10000) DEFAULT NULL,
  `RolaId` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`KorisnikId`, `KorisnickoIme`, `Sifra`, `RolaId`) VALUES
(1, 'admin', 0x24327924313024706b44426a486343725a4266632e4b6e525a2f4f4c4f78654247746762784443392f476c4a34356b5176454932735263684d474343, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lager`
--

CREATE TABLE `lager` (
  `LagerId` int(11) NOT NULL,
  `ArtikalId` int(11) DEFAULT NULL,
  `RaspolozivaKolicina` decimal(18,2) DEFAULT NULL,
  `Lokacija` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lager`
--

INSERT INTO `lager` (`LagerId`, `ArtikalId`, `RaspolozivaKolicina`, `Lokacija`) VALUES
(1, 1, '1000.00', 'Banjaluka'),
(2, 2, '8000.00', 'Trebinje'),
(3, 3, '12000.00', 'Prijedor');

-- --------------------------------------------------------

--
-- Table structure for table `racun`
--

CREATE TABLE `racun` (
  `RacunId` int(11) NOT NULL,
  `RadnikIdIzdao` int(11) NOT NULL,
  `DatumRacuna` datetime NOT NULL,
  `BrojRacuna` varchar(30) DEFAULT NULL,
  `UkupniIznos` decimal(18,2) DEFAULT NULL,
  `IznosPDV` decimal(18,2) DEFAULT NULL,
  `IznosBezPDV` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `racun`
--

INSERT INTO `racun` (`RacunId`, `RadnikIdIzdao`, `DatumRacuna`, `BrojRacuna`, `UkupniIznos`, `IznosPDV`, `IznosBezPDV`) VALUES
(1, 1, '2023-02-24 00:00:00', '1', '15.50', '2.64', '12.87');

-- --------------------------------------------------------

--
-- Table structure for table `racunstavka`
--

CREATE TABLE `racunstavka` (
  `RacunId` int(11) NOT NULL,
  `StavkaId` int(11) NOT NULL,
  `ArtikalId` int(11) DEFAULT NULL,
  `Kolicina` decimal(18,2) DEFAULT NULL,
  `Cijena` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `racunstavka`
--

INSERT INTO `racunstavka` (`RacunId`, `StavkaId`, `ArtikalId`, `Kolicina`, `Cijena`) VALUES
(1, 1, 1, '2.00', '2.50'),
(1, 2, 2, '3.00', '3.00'),
(1, 3, 3, '1.00', '1.50');

-- --------------------------------------------------------

--
-- Table structure for table `radnik`
--

CREATE TABLE `radnik` (
  `RadnikId` int(11) NOT NULL,
  `Ime` varchar(50) DEFAULT NULL,
  `Prezime` varchar(50) DEFAULT NULL,
  `BrojTelefona` varchar(50) DEFAULT NULL,
  `Adresa` varchar(100) DEFAULT NULL,
  `Grad` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `JMBG` char(13) DEFAULT NULL,
  `KorisnikId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `radnik`
--

INSERT INTO `radnik` (`RadnikId`, `Ime`, `Prezime`, `BrojTelefona`, `Adresa`, `Grad`, `Email`, `JMBG`, `KorisnikId`) VALUES
(1, 'Marko', 'Markovic', '123456', 'Stepe Stepanovica 8', 'Banjaluka', 'marko.m@gmail.com', '1234567890987', NULL),
(2, 'Ivan', 'Ivanovic', '112233', 'Vukana bb', 'Laktasi', 'ivan@gmail.com', '1122334455667', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rola`
--

CREATE TABLE `rola` (
  `RolaId` int(11) NOT NULL,
  `NazivRole` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rola`
--

INSERT INTO `rola` (`RolaId`, `NazivRole`) VALUES
(1, 'admin'),
(2, 'radnik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikal`
--
ALTER TABLE `artikal`
  ADD PRIMARY KEY (`ArtikalId`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`KorisnikId`),
  ADD KEY `RolaId` (`RolaId`);

--
-- Indexes for table `lager`
--
ALTER TABLE `lager`
  ADD PRIMARY KEY (`LagerId`),
  ADD KEY `ArtikalId` (`ArtikalId`);

--
-- Indexes for table `racun`
--
ALTER TABLE `racun`
  ADD PRIMARY KEY (`RacunId`),
  ADD KEY `RadnikIdIzdao` (`RadnikIdIzdao`);

--
-- Indexes for table `racunstavka`
--
ALTER TABLE `racunstavka`
  ADD PRIMARY KEY (`StavkaId`),
  ADD KEY `RacunId` (`RacunId`),
  ADD KEY `racunstavka_ibfk_1` (`ArtikalId`);

--
-- Indexes for table `radnik`
--
ALTER TABLE `radnik`
  ADD PRIMARY KEY (`RadnikId`),
  ADD KEY `KorisnikId` (`KorisnikId`);

--
-- Indexes for table `rola`
--
ALTER TABLE `rola`
  ADD PRIMARY KEY (`RolaId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikal`
--
ALTER TABLE `artikal`
  MODIFY `ArtikalId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `KorisnikId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lager`
--
ALTER TABLE `lager`
  MODIFY `LagerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `racun`
--
ALTER TABLE `racun`
  MODIFY `RacunId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `racunstavka`
--
ALTER TABLE `racunstavka`
  MODIFY `StavkaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `radnik`
--
ALTER TABLE `radnik`
  MODIFY `RadnikId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rola`
--
ALTER TABLE `rola`
  MODIFY `RolaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `korisnik_ibfk_1` FOREIGN KEY (`RolaId`) REFERENCES `rola` (`RolaId`);

--
-- Constraints for table `lager`
--
ALTER TABLE `lager`
  ADD CONSTRAINT `lager_ibfk_1` FOREIGN KEY (`ArtikalId`) REFERENCES `artikal` (`ArtikalId`);

--
-- Constraints for table `racun`
--
ALTER TABLE `racun`
  ADD CONSTRAINT `racun_ibfk_1` FOREIGN KEY (`RadnikIdIzdao`) REFERENCES `radnik` (`RadnikId`);

--
-- Constraints for table `racunstavka`
--
ALTER TABLE `racunstavka`
  ADD CONSTRAINT `racunstavka_ibfk_1` FOREIGN KEY (`ArtikalId`) REFERENCES `artikal` (`ArtikalId`),
  ADD CONSTRAINT `racunstavka_ibfk_2` FOREIGN KEY (`RacunId`) REFERENCES `racun` (`RacunId`);

--
-- Constraints for table `radnik`
--
ALTER TABLE `radnik`
  ADD CONSTRAINT `radnik_ibfk_1` FOREIGN KEY (`KorisnikId`) REFERENCES `korisnik` (`KorisnikId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
