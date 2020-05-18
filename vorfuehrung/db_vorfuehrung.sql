-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2020 at 10:03 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eportfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `html_id` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `page`, `content`, `description`, `html_id`) VALUES
(42, 34, 'profilbild.jpg', 'Das bin ich.', ''),
(43, 34, '', 'Willkommen auf meinem ePortfolio! Mein Name ist Matthias Schmidt. Auf den folgenden Seiten möchte ich Ihnen meine Arbeiten präsentieren.', ''),
(44, 35, '22VIRUS-PETCATS1-mediumSquareAt3X.jpg', 'Norwegische Waldkatze', ''),
(45, 35, 'Thinking-of-getting-a-cat.png', 'Noch eine Katze', ''),
(46, 35, 'WALN4MAIT4I6VLRIPUMJQAJIME.jpg', 'Eine kahle Katze', ''),
(47, 35, '', 'Katzen sind sehr schöne Tiere, lassen sich aber nicht immer so gut fotografieren.', ''),
(48, 35, '', '<a href=\"//www.google.com/search?q=katzen&client=firefox-b-d&source=lnms&tbm=isch&sa=X&ved=2ahUKEwiV7q249bzpAhXOsKQKHQ6aC8UQ_AUoAXoECBoQAw&biw=1920&bih=914\" target=\"_blank\">Noch mehr Katzenbilder</a>', ''),
(49, 36, 'Essay.pdf', 'Bei diesem Essay habe ich mir sehr viel Mühe gegeben.', ''),
(50, 36, 'Essay.odt', 'Das Essay nochmal in einem anderen Format.', ''),
(51, 37, 'sinus50hz-10db.zip', 'Gezipped', ''),
(52, 37, 'sinus50hz-10db.mp3', 'Testdatei im mp3-Format', ''),
(53, 37, 'LRMonoPhase4.wav', 'Eine WAV-Datei', ''),
(55, 38, 'small.mp4', 'Ein MP4-Video', ''),
(56, 38, 'small.ogv', 'Ein OGV-Video', ''),
(57, 39, 'defaultContent', '<div><h1 id=\"defaultContent\" style=\"text-align: center;\">Herzlich willkommen Anton von Knackerbach</h1><div style=\"font-size: 1.2rem;\"><strong>Diese Seite wird automatisch all Ihren Gästen zur Begrüßung angezeigt ❗ </strong></div><div style=\"padding-left: 2rem;\">Sie sollten also zuallererst diese Seite bearbeiten und nach Ihren Wünschen gestalten.</div><div style=\"padding-left: 2rem;\">Wenn Sie weitere Seiten eingerichtet haben, können Sie diese für ausgewählte Gäste freigeben. Dieser Gast hat dann über die Navigationsleiste die möglichkeit diese Seite(n) zu öffnen.</div><div style=\"padding-left: 2rem;\">Sie haben neben der Möglichkeit Texte zu schreiben auch die Option Bilder zur Dekoration einzufügen und Pdf-Dateien, sowie links auf all Ihren Seiten zu hinterlegen.</div><br><div style=\"font-size: 1.2rem;\"><strong>Wenn Sie Ihrer Seite Inhalt hinzufügen, können Sie in den Textfeldern auch html verwenden.</strong></div><div style=\"padding-left: 2rem;\">Wir empfehlen zur bestmöglichen Gestaltungsfreiheit das Nutzen von internen Style-sheets (&lt;style&gt;&lt;/style&gt;) oder Inline Styles.</div><div style=\"padding-left: 2rem;\">Hier eine gute Quelle zu html/css: <a href=\"https://wiki.selfhtml.org/wiki/Startseite\" target=\"_blank\">selfhtml</a></div><div style=\"padding-left: 2rem;\">Sie haben 65,535 Zeichen pro Inhalt zur verfügung.</div><br><div style=\"font-size: 1.2rem;\"><strong>Bei jedem neuen Konto empfehlen wir dringend Ihr Kennwort zu ändern!</strong></div><div style=\"padding-left: 2rem;\">Der Administrator der Ihr Konto angelegt hat, könnte Ihr Passwort nicht sicher gewählt, bzw es sich gemerkt haben.</div><div style=\"padding-left: 2rem;\">Sie finden die Option zum Passwort-ändern in den Einstellungen unter Profil bearbeiten</div><h3>Wir wünschen Ihnen viel Spaß beim erstellen Ihres Portfolios</h3></div>', 'defaultContent');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `owner`, `title`) VALUES
(34, 56, 'Home'),
(35, 56, 'Katzenfotografie'),
(36, 56, 'Essays'),
(37, 56, 'Audio'),
(38, 56, 'Video'),
(39, 58, 'Home');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `user_id`, `page`) VALUES
(87, 56, 34),
(88, 56, 35),
(89, 56, 36),
(90, 56, 37),
(91, 57, 34),
(92, 57, 35),
(93, 56, 38),
(94, 58, 39),
(95, 59, 39);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `validation` varchar(20) NOT NULL,
  `displayname` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `passwd`, `validation`, `displayname`, `status`) VALUES
(3, 'hallo', 'Welt', 'Morre535@gmx.de', '$2y$10$lgfPB.pfniFW9PcD..QvROsr3zF6DEQQrRIYuL/hxVAM2HX3akuEi', '0', 'Acidphreck', 'admin'),
(56, 'Matthias', 'Schmidt', 'matze@cooleseite.de', '$2y$10$.QrlhV08M0Hq2M4XT6tV4.EKYtYNwayWGbbWOS.7UBMXqP/3S5hCy', '0', 'Matthias Schmidt', 'user'),
(57, '', '', 'marcel.davis@2mal2.eu', '$2y$10$rV7r4zCI27tIzOZ.MNxDnu3ig283wkwUt8wOeHPUnFbDrGJPg4.YC', '', '', 'guest'),
(58, 'Anton', 'von Knackerbach', 'a.knack@cooleseite.de', '$2y$10$U.N62gDRa9HH1vU6yr4/kuZff6IWtad8.nDAWMWkakKHhQUZ.um5G', '0', 'Anton von Knackerbach', 'user'),
(59, '', '', 'marcel.davis@2mal2.eu', '$2y$10$VcmbwvVtLa0izQnMLfRQu.4UAwT4Z4rdWzFu6szvFIti7dBy7HLci', '', '', 'guest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
