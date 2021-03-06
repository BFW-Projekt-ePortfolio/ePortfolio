-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Mai 2020 um 14:13
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
(1, 1, 'defaultContent', '<h1 id=\"defaultContent\">Willkommen asdfg</h1><h3>Diese Seite wird automatisch all Ihren Gästen zur Begrüßung angezeigt.<br>Sie sollten also zuallererst diese Seite bearbeiten und nach Ihren Wünschen gestalten.<br>Wenn Sie danach weitere Seiten eingerichtet haben, so können Sie diese für ausgewählte Gäste freigeben. Dieser Gast hat dann über die Navigationsleiste die möglichkeit diese Seite(n) zu öffnen.<br>Sie haben neben der Möglichkeit Texte zu schreiben auch die Option Bilder zur Dekoration einzufügen und Pdf-Dateien, sowie links auf all Ihren Seiten zu hinterlegen.Wir wünschen Ihnen viel Spaß beim erstellen Ihres Portfolios</h3>', 'test'),
(2, 2, 'Tree1.jpg', 'Baum', 'test'),
(3, 1, 'p', '<p id=\"test2\">Das ist ein p Element</p>', 'test'),
(7, 6, 'defaultContent', '<h1 id=\"defaultContent\">Willkommen Moritz Mandler</h1><h3>Diese Seite wird automatisch all Ihren Gästen zur Begrüßung angezeigt.<br>Sie sollten also zuallererst diese Seite bearbeiten und nach Ihren Wünschen gestalten.<br>Wenn Sie danach weitere Seiten eingerichtet haben, so können Sie diese für ausgewählte Gäste freigeben. Dieser Gast hat dann über die Navigationsleiste die möglichkeit diese Seite(n) zu öffnen.<br>Sie haben neben der Möglichkeit Texte zu schreiben auch die Option Bilder zur Dekoration einzufügen und Pdf-Dateien, sowie links auf all Ihren Seiten zu hinterlegen.Wir wünschen Ihnen viel Spaß beim erstellen Ihres Portfolios</h3>', 'defaultContent'),
(9, 8, 'ePortfolio-Lastenheft.pdf', 'ePortfolio-Lastenheft', 'test'),
(10, 7, 'Eltz-Castle.jpg', 'Castle', 'test');

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
(2, 12, 'der Baum'),
(6, 28, 'Home'),
(7, 12, 'die Burg'),
(8, 12, 'dieser Eportfolio Auftrag'),
(15, 28, 'test');

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
(18, 28, 6),
(19, 29, 6),
(20, 30, 6),
(22, 12, 7),
(23, 12, 8),
(27, 33, 1),
(29, 33, 8),
(30, 34, 1),
(38, 33, 2),
(41, 35, 1),
(42, 35, 2),
(46, 34, 7),
(47, 35, 8),
(48, 33, 7),
(59, 28, 15);

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
(12, 'Viel', 'getestet', 'asdfg', '$2y$10$AvkyFWf4k0cw3gM1h5QNaOiZ7J/vqHThcBX6MRlBiV3d4tUhGbjjO', 0, 'Viel getestet', 'user'),
(28, 'Moritz', 'Mandler', 'Morre', '$2y$10$MPnKKmol4095axOon622TOo7xTncmpdQNSwH61ftGZEpqYo5ok32G', 0, 'Moritz Mandler', 'user'),
(29, '', '', 'asdf', '$2y$10$JFix5OerpGVQ7IETcuOFiuemqjzNsQa0merKnIUn9vTT2jz.1/RX.', 0, '', 'guest'),
(30, '', '', 'sudo', '$2y$10$.P.mhxYAUtqaowlPY/7hJeQK.AXn/Jq.w.8MQMRS5DGKPRskPlhN.', 0, '', 'guest'),
(33, '', '', 'sudo', '$2y$10$8O9fR78EIYUbqwnWjt.yEeR7pqBgVfB.xQA16GXlxRQF.sllTduiq', 0, '', 'guest'),
(34, '', '', 'asdf', '$2y$10$WnRVWI80HOcTcXHEj0cqMeBYLcSRNXm0s8odOxQfrV1NHVkHQ5Ery', 0, '', 'guest'),
(35, '', '', 'Tito', '$2y$10$3kv022Uw7QniMWYtpMfw0uXSg1Nrlno231VbDfoudjkG0wpasFYuW', 0, '', 'guest');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT für Tabelle `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
