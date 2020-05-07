-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Mai 2020 um 18:25
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
  `content` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `html_id` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `content`
--

INSERT INTO `content` (`id`, `page`, `content`, `description`, `html_id`) VALUES
(1, 1, '<h1 id=\"test\">Hello World</h1>', 'h1', 'test'),
(2, 2, '<h1 id=\"test\">Hello World</h1>', 'h1', 'test'),
(3, 1, '<p id=\"test2\">Das ist ein p Element</p>', 'h1', 'test'),
(7, 6, 'defaultContent', '<h1 id=\"defaultContent\">Willkommen Moritz Mandler</h1><h3>Diese Seite wird automatisch all Ihren Gästen zur Begrüßung angezeigt.<br>Sie sollten also zuallererst diese Seite bearbeiten und nach Ihren Wünschen gestalten.<br>Wenn Sie danach weitere Seiten eingerichtet haben, so können Sie diese für ausgewählte Gäste freigeben. Dieser Gast hat dann über die Navigationsleiste die möglichkeit diese Seite(n) zu öffnen.<br>Sie haben neben der Möglichkeit Texte zu schreiben auch die Option Bilder zur Dekoration einzufügen und Pdf-Dateien, sowie links auf all Ihren Seiten zu hinterlegen.Wir wünschen Ihnen viel Spaß beim erstellen Ihres Portfolios</h3>', 'defaultContent');

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
(1, 12, 'MyHome'),
(2, 12, 'TestPage2'),
(6, 28, 'Home');

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
(4, 13, 2),
(16, 27, 1),
(17, 27, 2),
(18, 28, 6),
(19, 29, 6),
(20, 30, 6);

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
(3, 'hallo', 'Welt', 'Morre535@gmx.de', '$2y$10$lgfPB.pfniFW9PcD..QvROsr3zF6DEQQrRIYuL/hxVAM2HX3akuEi', 0, 'Acidphreck', 'admin'),
(12, 'Test', 'versuch', 'asdfg', '$2y$10$sa9GeQcIJQ45lNDX0ApOi.4hknK96ZoegyQ/puS/3scLTbVFESNNi', 0, 'Test versuch', 'user'),
(13, 'Test1', 'versuch1', 'asdf', '$2y$10$lgfPB.pfniFW9PcD..QvROsr3zF6DEQQrRIYuL/hxVAM2HX3akuEi', 0, 'Test versuch', 'guest'),
(27, '', '', 'sudo', '$2y$10$GplS7QL4kpLcD/LctN3YU.wSxz/7a6gNJ13Yhfl3ZH9AqkwaOeNhu', 0, '', 'guest'),
(28, 'Moritz', 'Mandler', 'Morre', '$2y$10$MPnKKmol4095axOon622TOo7xTncmpdQNSwH61ftGZEpqYo5ok32G', 0, 'Moritz Mandler', 'user'),
(29, '', '', 'asdf', '$2y$10$JFix5OerpGVQ7IETcuOFiuemqjzNsQa0merKnIUn9vTT2jz.1/RX.', 0, '', 'guest'),
(30, '', '', 'sudo', '$2y$10$.P.mhxYAUtqaowlPY/7hJeQK.AXn/Jq.w.8MQMRS5DGKPRskPlhN.', 0, '', 'guest');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
