-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-09-2021 a las 17:19:35
-- Versión del servidor: 5.6.41-84.1
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `zf2xzpil_TG_eES_TOSn2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `idUbicacion` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `idCerradura` int(11) NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`idUbicacion`, `idGrupo`, `descripcion`, `idSucursal`, `idCerradura`, `estado`) VALUES
(3, 1, 'FLOOR TOOL RM', 1, 0, 'Activo'),
(2, 1, 'DBL TOOL TOTE', 1, 0, 'Activo'),
(1, 1, 'BT & KIT/SHELF1D', 1, 0, 'Activo'),
(4, 1, 'FLOOR/TOOL ROOM', 1, 0, 'Activo'),
(5, 1, 'HEV TOTE/SHELF 6', 1, 0, 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`idUbicacion`),
  ADD KEY `idGrupo` (`idGrupo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `idUbicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
