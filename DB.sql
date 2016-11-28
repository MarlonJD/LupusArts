-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Kas 2016, 00:42:46
-- Sunucu sürümü: 5.6.24
-- PHP Sürümü: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `lupus`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `coms`
--

CREATE TABLE IF NOT EXISTS `coms` (
  `id` int(5) NOT NULL,
  `name` text NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `coms`
--

INSERT INTO `coms` (`id`, `name`, `text`, `date`, `ip`) VALUES
(33, 'naber', 'iyidir senden\r\n', '2016-04-07 21:32:43', '::1'),
(33, 'naber', 'asfdjadfa', '2016-04-07 21:45:38', '::1'),
(33, 'deneme', 'askfdjal', '2016-04-07 21:53:13', '::1'),
(33, 'safda', 'fasdfa', '2016-04-07 21:59:45', '::1'),
(31, 'Deneafdsasfa', 'fasdfsaf', '2016-06-14 17:22:05', '::1'),
(31, 'asdfa', 'dfsafdsafd', '2016-06-14 21:58:25', '::1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(5) NOT NULL,
  `img` text NOT NULL,
  `title` text,
  `aciklama` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `images`
--

INSERT INTO `images` (`id`, `img`, `title`, `aciklama`, `date`, `category`) VALUES
(1, '4aad39e2be721baed7a22cd277915f95-d52pqtv.jpg', 'sdafadf', 'efakldfjaskl', '2016-02-25 15:29:26', 'qffsda'),
(2, '4aad39e2be721baed7a22cd277915f95-d52pqtv.jpg', 'asfdaklj', 'fasklfd', '2016-02-25 15:29:26', 'Animal'),
(5, '5c95eae7d137d5d4f20b82313b946927.jpg', 'ssdfsfas', 'fas', '2016-02-25 15:29:26', 'asdfa'),
(6, '11328331_381444342051606_609804787_n.jpg', 'asdfa', 'afsda', '2016-02-25 15:29:26', 'Bok Vardi'),
(7, 'lara_croft__tomb_raider_by_pinkadywinkwink-d4qtq7q.jpg', 'afdas', 'afdsf', '2016-02-25 15:29:26', 'Kategori Var'),
(8, '10489719_728919493831956_6129788334009071062_n.jpg', NULL, NULL, '2016-02-25 17:04:09', 'asfda'),
(9, '12728795_193845047645288_6789878970269200405_n.jpg', 'afdafa', NULL, '2016-02-25 17:05:15', 'dfasdfa'),
(11, '12688209_185459918483801_5595431612048705730_n.jpg', 'fasdfa', NULL, '2016-02-25 17:07:55', 'fdaf'),
(12, '12512554_182578365438623_8543056311612923257_n.jpg', 'afsd', NULL, '2016-02-25 17:08:05', 'afsdfa'),
(13, '12512554_182578365438623_8543056311612923257_n.jpg', 'afsd', NULL, '2016-02-25 17:10:29', 'afsdfa'),
(14, '12512554_182578365438623_8543056311612923257_n.jpg', 'asfda', NULL, '2016-02-25 17:10:45', 'fadsfda'),
(15, '12512554_182578365438623_8543056311612923257_n.jpg', 'asfda', NULL, '2016-02-25 17:11:42', 'fadsfda'),
(16, '12512554_182578365438623_8543056311612923257_n.jpg', 'asfda', NULL, '2016-02-25 17:11:49', 'fadsfda'),
(17, '12512554_182578365438623_8543056311612923257_n.jpg', 'asfda', NULL, '2016-02-25 17:12:41', 'fadsfda'),
(18, '12512554_182578365438623_8543056311612923257_n.jpg', 'asfda', NULL, '2016-02-25 17:12:55', 'fadsfda'),
(19, '12688209_185459918483801_5595431612048705730_n.jpg', 'fasdfa', NULL, '2016-02-25 17:13:09', 'fdasdfa'),
(20, '12688209_185459918483801_5595431612048705730_n.jpg', 'fasdfa', 'fads', '2016-02-25 17:14:05', 'fdasdfa'),
(22, '12747922_193254444371015_4676365323654967488_o.jpg', NULL, NULL, '2016-02-25 17:15:10', 'asfdaf'),
(23, '12747922_193254444371015_4676365323654967488_o.jpg', NULL, NULL, '2016-02-25 17:16:11', 'asfdaf'),
(24, '12747922_193254444371015_4676365323654967488_o.jpg', NULL, NULL, '2016-02-25 17:19:25', 'asfdaf'),
(25, '12747922_193254444371015_4676365323654967488_o.jpg', NULL, NULL, '2016-02-25 17:19:42', 'asfdaf'),
(26, '12747922_193254444371015_4676365323654967488_o.jpg', NULL, NULL, '2016-02-25 17:20:14', 'asfdaf'),
(27, '12747922_193254444371015_4676365323654967488_o.jpg', NULL, NULL, '2016-02-25 17:20:34', 'asfdaf'),
(31, '12688209_185459918483801_5595431612048705730_n.jpg', 'Deneme12', 'fasfda', '2016-06-14 21:58:13', 'fdsadfa'),
(33, '12742382_810786389026472_8727268680721838073_n.jpg', 'safda', 'fdafda', '2016-02-25 17:28:51', 'asdfa'),
(34, 'reveal-parallax-1.jpg', 'asfda', 'asdfa', '2016-06-14 23:44:00', 'fasdfa'),
(35, 'reveal-parallax-1.jpg', 'awef', 'asdfadf', '2016-06-14 23:44:11', 'asdfa'),
(36, 'reveal-parallax-1.jpg', 'safd', 'adfa', '2016-06-14 23:46:31', 'fdasdf');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` text NOT NULL,
  `pass` text NOT NULL,
  `rank` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`username`, `pass`, `rank`) VALUES
('admin', 'admin', 78912);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `images`
--
ALTER TABLE `images`
  ADD UNIQUE KEY `id` (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `images`
--
ALTER TABLE `images`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
