-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-05-2022 a las 22:22:51
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chicks_challenge`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ccdb_accounts`
--

DROP TABLE IF EXISTS `ccdb_accounts`;
CREATE TABLE IF NOT EXISTS `ccdb_accounts` (
  `ID` int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Category` varchar(20) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Price` float UNSIGNED NOT NULL,
  `Description` text NOT NULL,
  `Status` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ccdb_accounts`
--

INSERT INTO `ccdb_accounts` (`ID`, `Category`, `Title`, `Price`, `Description`, `Status`) VALUES
(1, 'Runescape', 'All weapons upgraded', 50, 'Supplier account', 1),
(2, 'League Of Legends', 'Level 30 ready for ranked', 30, 'Supplier', 1),
(3, 'Fortnite', 'Epic Skins', 25, 'Supplier account', 0),
(4, 'Clash of Clans', 'Town Hall level 11', 80, 'Pre-Owned account', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ccdb_order`
--

DROP TABLE IF EXISTS `ccdb_order`;
CREATE TABLE IF NOT EXISTS `ccdb_order` (
  `ID` int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Total` float UNSIGNED NOT NULL,
  `PaymentMethod` varchar(50) NOT NULL,
  `OrderAccount` int(100) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ccdb_order`
--

INSERT INTO `ccdb_order` (`ID`, `Total`, `PaymentMethod`, `OrderAccount`) VALUES
(1, 30, 'Credit Card', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
