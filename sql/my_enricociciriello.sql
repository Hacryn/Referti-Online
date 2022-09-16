-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 14, 2022 alle 20:39
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.12

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
-- Struttura della tabella `operatore`
--

CREATE TABLE `operatore` (
  `ID` int(11) NOT NULL COMMENT 'Operator ID (OID)',
  `CF` char(16) COLLATE utf8_bin NOT NULL COMMENT 'Codice Fiscale',
  `PW` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'Password',
  `Nome` varchar(64) COLLATE utf8_bin NOT NULL,
  `Cognome` varchar(64) COLLATE utf8_bin NOT NULL,
  `FID` int(11) NOT NULL COMMENT 'Facility ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `operatore`
--

INSERT INTO `operatore` (`ID`, `CF`, `PW`, `Nome`, `Cognome`, `FID`) VALUES
(1, 'BNCMRC80A01H501C', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Marco', 'Bianchi', 1),
(2, 'VLIMRA80A01H501W', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Maria', 'Viola', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `paziente`
--

CREATE TABLE `paziente` (
  `ID` int(11) NOT NULL COMMENT 'Patient ID (PID)',
  `CF` char(16) COLLATE utf8_bin NOT NULL COMMENT 'Codice Fiscale',
  `PW` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'Patient Password',
  `Nome` varchar(64) COLLATE utf8_bin NOT NULL,
  `Cognome` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `paziente`
--

INSERT INTO `paziente` (`ID`, `CF`, `PW`, `Nome`, `Cognome`) VALUES
(0, '0000000000000000', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Paziente', 'non registrato'),
(1, 'RSSMRA80A01H501U', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Mario', 'Rossi'),
(3, 'VLIMRA80A01H501W', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Maria', 'Viola'),
(5, '0000000000000001', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'Test', 'Tester');

-- --------------------------------------------------------

--
-- Struttura della tabella `referto`
--

CREATE TABLE `referto` (
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
-- Dump dei dati per la tabella `referto`
--

INSERT INTO `referto` (`ID`, `OID`, `PID`, `CF`, `Titolo`, `Filepath`, `Creazione`, `Caricamento`, `Codice`) VALUES
(1, 1, 1, 'RSSMRA80A01H501U', 'Test Referto', 'files/1/920e0fb71f2cf351bd0da7c051b074587650f36cfe2eea1f44453691dfae34fb.pdf', '2022-09-12', '2022-09-14', NULL),
(4, 1, 1, 'RSSMRA80A01H501U', 'Test caricamento', 'files/1/4fb646051b8e9381b32aa1febe5ccb3d15d16e5ef9c5b7f4cb7c2f4fb7814326.pdf', '2022-09-13', '2022-09-13', NULL),
(14, 1, 1, 'RSSMRA80A01H501U', 'Test modifica', '', '2022-09-14', NULL, NULL),
(15, 1, 1, 'RSSMRA80A01H501U', 'Test esame con cf registrato', '', '2022-09-14', NULL, NULL),
(18, 1, 0, 'CAITZI80A01H501K', 'Test esame con cf non registrato', 'files/0/920e0fb71f2cf351bd0da7c051b074587650f36cfe2eea1f44453691dfae34fb.pdf', '2022-09-14', '2022-09-14', '000000000000'),
(19, 1, 0, 'CAITZI80A01H501K', 'Test creazione esame cf non registrato', '', '2022-09-14', NULL, 'uzlhHsksK86C');

-- --------------------------------------------------------

--
-- Struttura della tabella `struttura`
--

CREATE TABLE `struttura` (
  `ID` int(11) NOT NULL COMMENT 'Facility ID (FID)',
  `CF` char(11) COLLATE utf8_bin NOT NULL COMMENT 'Codice Fiscale',
  `PW` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'Password',
  `Denominazione` varchar(128) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `struttura`
--

INSERT INTO `struttura` (`ID`, `CF`, `PW`, `Denominazione`) VALUES
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
-- Indici per le tabelle `operatore`
--
ALTER TABLE `operatore`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FID` (`FID`);

--
-- Indici per le tabelle `paziente`
--
ALTER TABLE `paziente`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `referto`
--
ALTER TABLE `referto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `OID` (`OID`),
  ADD KEY `PID` (`PID`);

--
-- Indici per le tabelle `struttura`
--
ALTER TABLE `struttura`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `operatore`
--
ALTER TABLE `operatore`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Operator ID (OID)', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `paziente`
--
ALTER TABLE `paziente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Patient ID (PID)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `referto`
--
ALTER TABLE `referto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Report ID (RID)', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `struttura`
--
ALTER TABLE `struttura`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Facility ID (FID)', AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `lettura_paziente`
--
ALTER TABLE `lettura_paziente`
  ADD CONSTRAINT `Accesso Operatore Paziente` FOREIGN KEY (`OID`) REFERENCES `operatore` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Appartenenza Paziente` FOREIGN KEY (`PID`) REFERENCES `paziente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `lettura_referto`
--
ALTER TABLE `lettura_referto`
  ADD CONSTRAINT `Accesso Operatore` FOREIGN KEY (`OID`) REFERENCES `operatore` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Appartenenza Referto` FOREIGN KEY (`RID`) REFERENCES `referto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `operatore`
--
ALTER TABLE `operatore`
  ADD CONSTRAINT `Appartenenza Operatore` FOREIGN KEY (`FID`) REFERENCES `struttura` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `referto`
--
ALTER TABLE `referto`
  ADD CONSTRAINT `Operatore Referto` FOREIGN KEY (`OID`) REFERENCES `operatore` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Paziente Referto` FOREIGN KEY (`PID`) REFERENCES `paziente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
