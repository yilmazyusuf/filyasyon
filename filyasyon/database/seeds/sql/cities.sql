-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 06, 2019 at 12:47 AM
-- Server version: 5.7.25-0ubuntu0.16.04.2
-- PHP Version: 7.2.14-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `il_ilce`
--

-- --------------------------------------------------------

--
-- Table structure for table `il`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(65) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `il`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(15, 'BURDUR'),
(26, 'ESKİŞEHİR'),
(18, 'ÇANKIRI'),
(80, 'OSMANİYE'),
(41, 'KOCAELİ'),
(27, 'GAZİANTEP'),
(31, 'HATAY'),
(38, 'KAYSERİ'),
(29, 'GÜMÜŞHANE'),
(54, 'SAKARYA'),
(16, 'BURSA'),
(69, 'BAYBURT'),
(17, 'ÇANAKKALE'),
(57, 'SİNOP'),
(74, 'BARTIN'),
(503, 'MAĞUSA (KIBRIS)'),
(33, 'MERSİN'),
(51, 'NİĞDE'),
(42, 'KONYA'),
(60, 'TOKAT'),
(2, 'ADIYAMAN'),
(6, 'ANKARA'),
(66, 'YOZGAT'),
(52, 'ORDU'),
(53, 'RİZE'),
(1, 'ADANA'),
(40, 'KIRŞEHİR'),
(76, 'IĞDIR'),
(45, 'MANİSA'),
(21, 'DİYARBAKIR'),
(64, 'UŞAK'),
(501, 'LEFKOŞE (KIBRIS)'),
(5, 'AMASYA'),
(24, 'ERZİNCAN'),
(32, 'ISPARTA'),
(502, 'GİRNE (KIBRIS)'),
(23, 'ELAZIĞ'),
(78, 'KARABÜK'),
(30, 'HAKKARİ'),
(36, 'KARS'),
(67, 'ZONGULDAK'),
(68, 'AKSARAY'),
(44, 'MALATYA'),
(10, 'BALIKESİR'),
(20, 'DENİZLİ'),
(49, 'MUŞ'),
(73, 'ŞIRNAK'),
(48, 'MUĞLA'),
(59, 'TEKİRDAĞ'),
(39, 'KIRKLARELİ'),
(56, 'SİİRT'),
(28, 'GİRESUN'),
(63, 'ŞANLIURFA'),
(9, 'AYDIN'),
(72, 'BATMAN'),
(13, 'BİTLİS'),
(3, 'AFYONKARAHİSAR'),
(8, 'ARTVİN'),
(4, 'AĞRI'),
(77, 'YALOVA'),
(50, 'NEVŞEHİR'),
(61, 'TRABZON'),
(58, 'SİVAS'),
(7, 'ANTALYA'),
(37, 'KASTAMONU'),
(47, 'MARDİN'),
(46, 'KAHRAMANMARAŞ'),
(25, 'ERZURUM'),
(75, 'ARDAHAN'),
(81, 'DÜZCE'),
(55, 'SAMSUN'),
(19, 'ÇORUM'),
(65, 'VAN'),
(14, 'BOLU'),
(43, 'KÜTAHYA'),
(11, 'BİLECİK'),
(34, 'İSTANBUL'),
(79, 'KİLİS'),
(62, 'TUNCELİ'),
(12, 'BİNGÖL'),
(22, 'EDİRNE'),
(71, 'KIRIKKALE'),
(70, 'KARAMAN'),
(35, 'İZMİR');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
