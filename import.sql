-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 nov 2024 om 18:58
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gofundme`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `family` varchar(50) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `link` varchar(250) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `campaigns`
--

INSERT INTO `campaigns` (`id`, `family`, `description`, `link`, `image`) VALUES
(1, 'Abdi Hussein.', 'In recent weeks, families in Gaza have faced unprecedented challenges due to ongoing conflicts, leading to a humanitarian crisis marked by loss, displacement, and urgent needs. To support those affected, various GoFundMe campaigns have emerged, aiming to raise funds for essential supplies, medical care, and shelter.', 'https://www.gofundme.com/nl-nl', 'opgeslagen-img/672b4c24ed780.jpg'),
(2, 'Fartum.', 'test new campain... ', 'https://www.gofundme.com/nl-nl', 'opgeslagen-img/672b4d4b69ab8.jpg'),
(12, 'imagetestcampaine', 'hbdfivbdfv', 'https://www.gofundme.com/nl-nl', 'opgeslagen-img/672b4c56e8702.jpg'),
(13, 'mouesa', 'nee', 'https://www.gofundme.com', 'opgeslagen-img/672b4e4e2d423.jpg'),
(16, 'testagan', 'feve', 'https://www.gofundme.com', 'opgeslagen-img/672b4ff153937.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(3, 'nick', '$2y$10$gRrquMLA1hKPaytkoarQN.y/tQ2HMAk.619sr7zc/6R/0XdqK66VC', 'user'),
(4, 'bobby', '$2y$10$rCdDyK2SPff6tYDlM6vp4uNDo8XTZqTj9R7chzWrZY.lLBG84YLY6', 'user'),
(5, 'test1', '$2y$10$vxk8d/2vCrv0b4wr8TGCkutO5JaOSN7/eVxNYDIMY9zuuNIXmzF2.', 'admin');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
