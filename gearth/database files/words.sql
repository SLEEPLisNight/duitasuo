-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 07, 2011 at 11:38 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gearth`
--

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE IF NOT EXISTS `words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `descr` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(100) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=118 ;

--
-- Dumping data for table `words`
--

INSERT INTO `words` (`id`, `userid`, `title`, `descr`, `latitude`, `longitude`, `time`, `priority`) VALUES
(116, 0, 'aa', 'aa', '32.27128588705901', '4.136633200979267', 1317942550, 1),
(115, 0, 'ddd', 'bbbbbb', '39.98612360918618', '-93.65264357409409', 1317940703, 9),
(113, 0, '', '', '39.98265313043726', '-93.65033527543301', 1317939249, 1),
(114, 0, 'aa', 'cccccc', '39.98615392116324', '-93.65188795107265', 1317940690, 1),
(112, 0, 'zoo', 'I went to the zoon today', '-3.608871560507926', '-60.05559368208453', 1317937057, 3),
(111, 0, '333', '33344\n\n5555', '36.63335962484253', '-96.76324726085005', 1317935521, 3),
(109, 0, 'bbb', 'ddd', '40.52778749691908', '-106.59416109887778', 1317935140, 1),
(110, 0, 'cc', 'cc\nddd', '42.33193641268132', '-96.07678887776467', 1317935492, 1),
(108, 0, '', '', '39.14087962477517', '-107.80716652483795', 1317933451, 1),
(117, 0, 'callaway', 'callaway is found in google earth in firefox!!!!!!!', '37.01546714013959', '-80.0000121390368', 1318030381, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
