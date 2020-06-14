-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13 Jun 2020 pada 20.17
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_raion`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `blog_user` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `blog`
--

INSERT INTO `blog` (`id`, `blog_user`, `title`, `img`, `content`, `created_at`) VALUES
(1, 2, 'Membuat Kue Kukus Pertmakali', 'https://i.imgur.com/vZ20pFo.jpeg', 'Halo, pertama saya begini lalu begitu\r<br/>\r<br/>Kemudian selesai haha', '2020-06-13 14:29:38'),
(3, 6, 'Judul Tes', '', 'aojfaeofj aeof jaepof aepof aepofka e', '2020-06-13 15:23:39'),
(5, 6, 'awdawd', '', 'awdawdawdadawa', '2020-06-13 15:24:19'),
(9, 2, '\'\";poaejf\\aeiofea', '', 'aoe apof\\\'\";aofj:aioefa`', '2020-06-13 18:10:47'),
(10, 2, 'aeafae\' aeoif;', 'https://image.shutterstock.com/image-photo/colorful-hot-air-balloons-flying-260nw-1033306540.jpg', 'awfaaf\n<br/>aefae\n<br/>aefa;', '2020-06-13 18:13:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog_like`
--

CREATE TABLE `blog_like` (
  `id` int(11) NOT NULL,
  `blog_user` int(11) DEFAULT NULL,
  `blog` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `blog_like`
--

INSERT INTO `blog_like` (`id`, `blog_user`, `blog`) VALUES
(1, 6, 1),
(2, 6, 5),
(4, 1, NULL),
(6, 2, 5),
(9, 2, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog_user`
--

CREATE TABLE `blog_user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `blog_user`
--

INSERT INTO `blog_user` (`id`, `username`, `password`, `is_admin`, `name`) VALUES
(1, 'admin', '$2y$10$rgbzRd4LpMOeDo6Dkzw4LeDquL/qW6X2Cbq6lzsTcHu8bgdWH9M66', 1, 'Admin'),
(2, 'wildanzq', '$2y$10$wCOOKjFdyPwABR5T/LtAjewnFvX8Wm9IB7s/MEL32qoztb6beF452', 1, 'Wildan Ziaulhaq'),
(6, 'user', '$2y$10$TnI5y2mDP7rkBHibZl4YXegtxHPA0oMzRaDp4mpJ5yMm8dw7rvBxG', 0, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_user` (`blog_user`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `blog_like`
--
ALTER TABLE `blog_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_user` (`blog_user`),
  ADD KEY `blog` (`blog`);

--
-- Indexes for table `blog_user`
--
ALTER TABLE `blog_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `blog_like`
--
ALTER TABLE `blog_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `blog_user`
--
ALTER TABLE `blog_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`blog_user`) REFERENCES `blog_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `blog_like`
--
ALTER TABLE `blog_like`
  ADD CONSTRAINT `blog_like_ibfk_1` FOREIGN KEY (`blog`) REFERENCES `blog` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_like_ibfk_2` FOREIGN KEY (`blog_user`) REFERENCES `blog_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
