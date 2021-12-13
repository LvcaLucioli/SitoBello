-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 28 gen, 2020 at 01:15 PM
-- Versione MySQL: 5.1.33
-- Versione PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_giorgio_fantilli`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `amministratori`
--

CREATE TABLE IF NOT EXISTS `amministratori` (
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `amministratori`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `monopattini`
--

CREATE TABLE IF NOT EXISTS `monopattini` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `modello` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `v_max` int(11) NOT NULL,
  `path_img` varchar(50) NOT NULL,
  `autonomia` int(11) NOT NULL,
  `peso` float NOT NULL,
  `carico_max` float NOT NULL,
  `a-b` varchar(7) NOT NULL,
  `prezzo_orario` float NOT NULL,
  `watt` int(11) NOT NULL,
  `dimensioni` varchar(50) NOT NULL,
  `caratteristiche` varchar(256) NOT NULL,
  PRIMARY KEY (`codice`),
  UNIQUE KEY `modello` (`modello`),
  UNIQUE KEY `path_img` (`path_img`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `monopattini`
--

INSERT INTO `monopattini` (`codice`, `modello`, `marca`, `v_max`, `path_img`, `autonomia`, `peso`, `carico_max`, `a-b`, `prezzo_orario`, `watt`, `dimensioni`, `caratteristiche`) VALUES
(1, 'Ninebot', 'Hudora', 20, 'img\\monopattinoNinebot.jpeg', 4, 4, 100, 'adulti', 10, 250, '30 x 50 x 20 cm', 'manubrio pieghevole e regolabile in altezza');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `username` varchar(16) NOT NULL,
  `nome` varchar(256) NOT NULL,
  `cognome` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `codice_fiscale` varchar(16) NOT NULL,
  `indirizzo` varchar(256) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `codice_fiscale` (`codice_fiscale`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`username`, `nome`, `cognome`, `email`, `password`, `codice_fiscale`, `indirizzo`) VALUES
('giorgio', 'giorgiof', 'fantilli', 'kfdid@fbud.com', 'a', 'FNTGRG01R05E783P', ''),
('prova', 'prova', 'fiddn', 'g@gmail.com', 'vfdgfdgdfg', 'dsfgdfsfddfg', 'gdsfdg'),
('provaaaa', 'luca', 'lucioli', 'fihihff@fdb.com', 'hhhhhhhhH7', 'LCLLCU01R03I324L', ''),
('luca', 'luca', 'mariani', 'lucamariani@gmail.com', 'hhhhhhH6', 'VGPDGM37R23F347J', '');
