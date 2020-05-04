-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Mai 2020 um 01:32
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `eportfolio`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `content` text NOT NULL,
  `description` varchar(50) NOT NULL,
  `html_id` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `content`
--

INSERT INTO `content` (`id`, `page`, `content`, `description`, `html_id`) VALUES
(1, 1, '<h1 id=\"test\">Hello World</h1>', 'h1', 'test'),
(2, 2, '<h1 id=\"test\">Hello World</h1>', 'h1', 'test'),
(3, 1, '<h1 id=\"test\">Hello World</h1>', 'h1', 'test');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `page`
--

INSERT INTO `page` (`id`, `owner`, `title`) VALUES
(1, 12, 'TestPage1'),
(2, 12, 'TestPage2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `permission`
--

INSERT INTO `permission` (`id`, `user_id`, `page`) VALUES
(1, 12, 1),
(2, 12, 2),
(3, 13, 1),
(4, 13, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `validation` tinyint(1) NOT NULL,
  `displayname` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `passwd`, `validation`, `displayname`, `status`) VALUES
(2, 'Gast1', 'TestGast', 'jolo', '', 0, '', 'guest'),
(3, 'hallo', 'Welt', 'Morre535@gmx.de', '$2y$10$lgfPB.pfniFW9PcD..QvROsr3zF6DEQQrRIYuL/hxVAM2HX3akuEi', 0, 'Acidphreck', 'admin'),
(5, 'Test', 'versuch', 'asdf', '$2y$10$sa9GeQcIJQ45lNDX0ApOi.4hknK96ZoegyQ/puS/3scLTbVFESNNi', 0, 'Test versuch', 'user'),
(12, 'Test', 'versuch', 'asdf', '$2y$10$sa9GeQcIJQ45lNDX0ApOi.4hknK96ZoegyQ/puS/3scLTbVFESNNi', 0, 'Test versuch', 'user'),
(13, 'Test', 'versuch', 'asdf', '$2y$10$sa9GeQcIJQ45lNDX0ApOi.4hknK96ZoegyQ/puS/3scLTbVFESNNi', 0, 'Test versuch', 'guest');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
