-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-10-2023 a las 20:24:37
-- Versión del servidor: 8.0.34-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `segur1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `erabiltzaileak`
--

CREATE TABLE `erabiltzaileak` (
  `erabiltzaileId` int NOT NULL,
  `erabiltzaileIzena` varchar(128) NOT NULL,
  `erabiltzaileNAN` varchar(10) NOT NULL,
  `erabiltzaileTlfn` int NOT NULL,
  `erabiltzaileJaiotzedata` date NOT NULL,
  `erabiltzaileEmail` varchar(255) NOT NULL,
  `erabiltzailePasahitza` varchar(255) NOT NULL,
  `erabiltzaile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `erabiltzaileak`
--

INSERT INTO `erabiltzaileak` (`erabiltzaileId`, `erabiltzaileIzena`, `erabiltzaileNAN`, `erabiltzaileTlfn`, `erabiltzaileJaiotzedata`, `erabiltzaileEmail`, `erabiltzailePasahitza`, `erabiltzaile`) VALUES
(3, 'Alvaro Dono', '12345678Y', 634456895, '2019-02-07', 'alvarodono@gmail.com', '$2y$10$MsKsT9yzhKrR61Fq9VAQ6.H2uv2PALYQ07h14XNryP4lxVg1wsT/u', 'alvarodg'),
(4, 'Alvar', '16092485Y', 634432730, '2023-10-18', 'dfdfgdfg@dfsfksg.com', '$2y$10$zgP9nIylff/kfUgoolFktuN1LSHNlUaZ8BCwgTcnSRbN9AGVwzpCW', 'dgalvaro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Zapatilak`
--

CREATE TABLE `Zapatilak` (
  `IdProduktua` int NOT NULL,
  `Izena` varchar(30) NOT NULL,
  `Marka` varchar(30) NOT NULL,
  `Kolorea` varchar(30) NOT NULL,
  `Mota` varchar(30) NOT NULL,
  `Prezioa` varchar(10) NOT NULL,
  `Neurria` varchar(30) NOT NULL,
  `erabiltzaileId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `Zapatilak`
--

INSERT INTO `Zapatilak` (`IdProduktua`, `Izena`, `Marka`, `Kolorea`, `Mota`, `Prezioa`, `Neurria`, `erabiltzaileId`) VALUES
(1, 'Samba', 'Adidas', 'Zuria', 'Urban', '120.99€', '42', 3),
(2, 'Air Force 1', 'Nike', 'Beltza', 'Urban', '110€', '44', 3),
(3, 'New Balance 550', 'New Balance', 'Zuria', 'Urban', '120€', '43', 3),
(4, 'Samba', 'Adidas', 'Berdea', 'Urban', '130€', '41.5', 3),
(5, 'Samba', 'Adidas', 'Berdea', 'Urban', '130€', '44', 3),
(8, 'cxv', 'xcv', 'xvxv', 'xvxcv', 'xvcv', 'xcvxcv', 3),
(9, 'fghfghf', 'hd', 'ghfgh', 'fghfgh', 'fghfhg', 'fghfgh', 3);

-- Índices para tablas volcadas
--

--
-- Indices de la tabla `erabiltzaileak`
--
ALTER TABLE `erabiltzaileak`
  ADD PRIMARY KEY (`erabiltzaileId`);

--
-- Indices de la tabla `Zapatilak`
--
ALTER TABLE `Zapatilak`
  ADD PRIMARY KEY (`IdProduktua`),
  ADD KEY `erabiltzaileId` (`erabiltzaileId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `erabiltzaileak`
--
ALTER TABLE `erabiltzaileak`
  MODIFY `erabiltzaileId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `Zapatilak`
--
ALTER TABLE `Zapatilak`
  MODIFY `IdProduktua` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Zapatilak`
--
ALTER TABLE `Zapatilak`
  ADD CONSTRAINT `Zapatilak_ibfk_1` FOREIGN KEY (`erabiltzaileId`) REFERENCES `erabiltzaileak` (`erabiltzaileId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
