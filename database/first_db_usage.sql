-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Dic 11, 2025 alle 01:13
-- Versione del server: 5.7.44
-- Versione PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `first_db_usage`
--
DROP DATABASE IF EXISTS `first_db_usage`;
CREATE DATABASE IF NOT EXISTS `first_db_usage` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `first_db_usage`;

-- --------------------------------------------------------

--
-- Struttura della tabella `gruppo`
--

CREATE TABLE `gruppo` (
  `idGruppo` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `gruppo`
--

INSERT INTO `gruppo` (`idGruppo`, `nome`, `descrizione`) VALUES
(1, 'Amministratori', 'Accesso completo: gestione utenti, modifica e cancellazione'),
(2, 'Standard', 'Accesso limitato: sola visualizzazione');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `idUtente` bigint(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `genere` varchar(15) NOT NULL,
  `dataNascita` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`idUtente`, `nome`, `email`, `genere`, `dataNascita`) VALUES
(2, 'Emanuele', 'gnoni@istitutolevi.edu.it', 'uomo', '1975-04-10'),
(3, 'Natascia', 'natascia@istitutolevi.edu.it', 'donna', '1975-06-18'),
(4, 'Leonardo', 'leonardo@istitutolevi.edu.it', 'uomo', '1999-11-11'),
(5, 'Giovanna', 'giovanna@istitutolevi.edu.it', 'donna', '1975-04-10'),
(6, 'Pippo', 'pippo@disneyland.net', 'uomo', '2025-12-08');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti_sistema`
--

CREATE TABLE `utenti_sistema` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `idGruppo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utenti_sistema`
--

INSERT INTO `utenti_sistema` (`id`, `username`, `password`, `idGruppo`) VALUES
(1, 'admin', '$2y$12$efKuOAY7U/m.zY8e7JOu9eNQgzQc9dU/87n1wyWCC68sVQhcsTfrm', 1),
(2, 'user', '$2y$12$qKKNeNHhOIpqDafRBDytFeI//soCLPk8zZ2.E41qNY/7EbGU/LVsS', 2);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `gruppo`
--
ALTER TABLE `gruppo`
  ADD PRIMARY KEY (`idGruppo`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`idUtente`);

--
-- Indici per le tabelle `utenti_sistema`
--
ALTER TABLE `utenti_sistema`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_gruppo` (`idGruppo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `gruppo`
--
ALTER TABLE `gruppo`
  MODIFY `idGruppo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `idUtente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `utenti_sistema`
--
ALTER TABLE `utenti_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `utenti_sistema`
--
ALTER TABLE `utenti_sistema`
  ADD CONSTRAINT `fk_gruppo` FOREIGN KEY (`idGruppo`) REFERENCES `gruppo` (`idGruppo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
