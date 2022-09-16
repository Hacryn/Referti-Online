-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Set 16, 2022 alle 19:13
-- Versione del server: 5.6.33-log
-- Versione PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_enricociciriello`
--
CREATE DATABASE IF NOT EXISTS `my_enricociciriello` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `my_enricociciriello`;

-- --------------------------------------------------------

--
-- Struttura della tabella `lettura_paziente`
--

CREATE TABLE `lettura_paziente` (
  `PID` int(11) NOT NULL COMMENT 'Patient ID',
  `OID` int(11) NOT NULL COMMENT 'Operartor ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `lettura_referto`
--

CREATE TABLE `lettura_referto` (
  `RID` int(11) NOT NULL COMMENT 'Report ID',
  `OID` int(11) NOT NULL COMMENT 'Operator ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `lettura_referto`
--

INSERT INTO `lettura_referto` (`RID`, `OID`) VALUES
(1, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `Operatore`
--

CREATE TABLE `Operatore` (
  `ID` int(11) NOT NULL COMMENT 'Operator ID (OID)',
  `CF` char(16) COLLATE utf8_bin NOT NULL COMMENT 'Codice Fiscale',
  `PW` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'Password',
  `Nome` varchar(64) COLLATE utf8_bin NOT NULL,
  `Cognome` varchar(64) COLLATE utf8_bin NOT NULL,
  `FID` int(11) NOT NULL COMMENT 'Facility ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `Operatore`
--

INSERT INTO `Operatore` (`ID`, `CF`, `PW`, `Nome`, `Cognome`, `FID`) VALUES
(1, 'BNCMRC80A01H501C', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Marco', 'Bianchi', 1),
(2, 'VLIMRA80A01H501W', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Maria', 'Viola', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Paziente`
--

CREATE TABLE `Paziente` (
  `ID` int(11) NOT NULL COMMENT 'Patient ID (PID)',
  `CF` char(16) COLLATE utf8_bin NOT NULL COMMENT 'Codice Fiscale',
  `PW` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'Patient Password',
  `Nome` varchar(64) COLLATE utf8_bin NOT NULL,
  `Cognome` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `Paziente`
--

INSERT INTO `Paziente` (`ID`, `CF`, `PW`, `Nome`, `Cognome`) VALUES
(0, '0000000000000000', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Paziente', 'non registrato'),
(1, 'RSSMRA80A01H501U', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Mario', 'Rossi'),
(3, 'VLIMRA80A01H501W', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Maria', 'Viola'),
(5, '0000000000000001', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Test', 'Tester');

-- --------------------------------------------------------

--
-- Struttura della tabella `Referto`
--

CREATE TABLE `Referto` (
  `ID` int(11) NOT NULL COMMENT 'Report ID (RID)',
  `OID` int(11) NOT NULL COMMENT 'Operator ID that created the report',
  `PID` int(11) NOT NULL COMMENT 'Patient ID linked to the report',
  `CF` char(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'Codice Fiscale Patient',
  `Titolo` varchar(128) COLLATE utf8_bin NOT NULL,
  `Filepath` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `Creazione` date NOT NULL COMMENT 'Date of the examination',
  `Caricamento` date DEFAULT NULL COMMENT 'Date of the upload of the report',
  `Codice` char(12) COLLATE utf8_bin DEFAULT NULL COMMENT 'Access code for non user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `Referto`
--

INSERT INTO `Referto` (`ID`, `OID`, `PID`, `CF`, `Titolo`, `Filepath`, `Creazione`, `Caricamento`, `Codice`) VALUES
(1, 1, 1, 'RSSMRA80A01H501U', 'Test Referto', 'files/1/920e0fb71f2cf351bd0da7c051b074587650f36cfe2eea1f44453691dfae34fb.pdf', '2022-09-12', '2022-09-14', NULL),
(4, 1, 1, 'RSSMRA80A01H501U', 'Test caricamento', 'files/1/4fb646051b8e9381b32aa1febe5ccb3d15d16e5ef9c5b7f4cb7c2f4fb7814326.pdf', '2022-09-13', '2022-09-13', NULL),
(14, 1, 1, 'RSSMRA80A01H501U', 'Test modifica', 'files/1/25d7b00ab18a425f2fbd370ca3608636215b37081004391482dbd40b2c8bb04c.pdf', '2022-09-14', '2022-09-16', NULL),
(15, 1, 1, 'RSSMRA80A01H501U', 'Test esame con cf registrato', '', '2022-09-14', NULL, NULL),
(18, 1, 0, 'CAITZI80A01H501K', 'Test esame con cf non registrato', 'files/0/920e0fb71f2cf351bd0da7c051b074587650f36cfe2eea1f44453691dfae34fb.pdf', '2022-09-14', '2022-09-14', '000000000000'),
(19, 1, 0, 'CAITZI80A01H501K', 'Test creazione esame cf non registrato', '', '2022-09-14', NULL, 'uzlhHsksK86C'),
(20, 1, 1, 'RSSMRA80A01H501U', 'Test altervista', 'files/1/920e0fb71f2cf351bd0da7c051b074587650f36cfe2eea1f44453691dfae34fb.pdf', '2022-09-14', '2022-09-14', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `Struttura`
--

CREATE TABLE `Struttura` (
  `ID` int(11) NOT NULL COMMENT 'Facility ID (FID)',
  `CF` char(11) COLLATE utf8_bin NOT NULL COMMENT 'Codice Fiscale',
  `PW` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'Password',
  `Denominazione` varchar(128) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `Struttura`
--

INSERT INTO `Struttura` (`ID`, `CF`, `PW`, `Denominazione`) VALUES
(1, '80242250589', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Palma Clinics'),
(2, '00000000001', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Test');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `lettura_paziente`
--
ALTER TABLE `lettura_paziente`
  ADD KEY `Appartenenza Paziente` (`PID`),
  ADD KEY `Accesso Operatore Paziente` (`OID`);

--
-- Indici per le tabelle `lettura_referto`
--
ALTER TABLE `lettura_referto`
  ADD KEY `Accesso Operatore` (`OID`),
  ADD KEY `Appartenenza Referto` (`RID`);

--
-- Indici per le tabelle `Operatore`
--
ALTER TABLE `Operatore`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FID` (`FID`);

--
-- Indici per le tabelle `Paziente`
--
ALTER TABLE `Paziente`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `Referto`
--
ALTER TABLE `Referto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `OID` (`OID`),
  ADD KEY `PID` (`PID`);

--
-- Indici per le tabelle `Struttura`
--
ALTER TABLE `Struttura`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Operatore`
--
ALTER TABLE `Operatore`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Operator ID (OID)', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `Paziente`
--
ALTER TABLE `Paziente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Patient ID (PID)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `Referto`
--
ALTER TABLE `Referto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Report ID (RID)', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `Struttura`
--
ALTER TABLE `Struttura`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Facility ID (FID)', AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `lettura_paziente`
--
ALTER TABLE `lettura_paziente`
  ADD CONSTRAINT `Accesso Operatore Paziente` FOREIGN KEY (`OID`) REFERENCES `Operatore` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Appartenenza Paziente` FOREIGN KEY (`PID`) REFERENCES `Paziente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `lettura_referto`
--
ALTER TABLE `lettura_referto`
  ADD CONSTRAINT `Accesso Operatore` FOREIGN KEY (`OID`) REFERENCES `Operatore` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Appartenenza Referto` FOREIGN KEY (`RID`) REFERENCES `Referto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Operatore`
--
ALTER TABLE `Operatore`
  ADD CONSTRAINT `Appartenenza Operatore` FOREIGN KEY (`FID`) REFERENCES `Struttura` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Referto`
--
ALTER TABLE `Referto`
  ADD CONSTRAINT `Operatore Referto` FOREIGN KEY (`OID`) REFERENCES `Operatore` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Paziente Referto` FOREIGN KEY (`PID`) REFERENCES `Paziente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
