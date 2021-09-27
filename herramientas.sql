-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-09-2021 a las 17:18:31
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
-- Estructura de tabla para la tabla `herramientas`
--

CREATE TABLE `herramientas` (
  `idHerramienta` int(11) NOT NULL,
  `codigo` varchar(150) DEFAULT NULL,
  `descripcion` varchar(580) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `idMarca` int(11) NOT NULL,
  `valor` double DEFAULT NULL,
  `valorRecidual` double NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `daniada` tinyint(4) NOT NULL DEFAULT '0',
  `prestada` tinyint(4) NOT NULL DEFAULT '0',
  `observacionesPrestada` text NOT NULL,
  `consumible` tinyint(4) NOT NULL DEFAULT '0',
  `stock` double NOT NULL DEFAULT '0',
  `stockMinimo` double NOT NULL DEFAULT '0',
  `idUnidad` int(11) NOT NULL DEFAULT '1',
  `fechaAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaBaja` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nroSerie` varchar(150) DEFAULT NULL,
  `detalle` text,
  `idSucursal` int(11) NOT NULL,
  `idUbicacion` int(11) DEFAULT NULL,
  `idUbicacionAlternativa` int(11) DEFAULT NULL,
  `imagen` varchar(252) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `herramientas`
--

INSERT INTO `herramientas` (`idHerramienta`, `codigo`, `descripcion`, `idTipo`, `idMarca`, `valor`, `valorRecidual`, `fechaInicio`, `fechaFin`, `estado`, `daniada`, `prestada`, `observacionesPrestada`, `consumible`, `stock`, `stockMinimo`, `idUnidad`, `fechaAlta`, `fechaBaja`, `nroSerie`, `detalle`, `idSucursal`, `idUbicacion`, `idUbicacionAlternativa`, `imagen`) VALUES
(2, '121000 589 01 10 001', 'Torx Set (32 pieces)', 23, 121, 0, 0, '2019-01-30', '2019-01-30', 'Activo', 0, 0, '', 0, 0, 0, 1, '2019-01-30 14:30:07', '2019-01-30 06:00:00', '000 589 01 10 00', '<p>\n	KIT | 589011000 | SG00</p>\n<p>\n	&nbsp;</p>\n', 1, NULL, NULL, '000_589_01_10_00.jpg'),
(3, '121000 589 04 37 001', 'PNEUMATIC LINE PLIERS', 23, 121, 0, 0, '2019-01-30', '2019-01-30', 'Activo', 0, 0, '', 0, 0, 0, 1, '2019-01-30 14:30:42', '2019-01-30 06:00:00', '000 589 04 37 00', '<p>\n	| 589043700 |</p>\n', 1, 42, NULL, '000_589_04_37_00.jpg'),
(4, '121000 589 05 91 001', 'ADAPTER', 23, 121, 0, 0, '2019-01-30', '2019-01-30', 'Inactivo', 0, 0, '', 0, 0, 0, 1, '2019-01-30 14:30:43', '2019-01-30 06:00:00', '000 589 05 91 00', ' | 589059100 | ', 1, 42, NULL, '000_589_05_91_00.jpg'),
(5, '121000 589 10 99 011', 'Torque Wrench, (Bar Type); 14x18mm shank; 75-400 Nm; (1/2\" Drive) ', 23, 121, 0, 0, '2019-01-30', '2019-01-30', 'Inactivo', 0, 0, '', 0, 0, 0, 1, '2019-01-30 14:30:43', '2019-01-30 06:00:00', '000 589 10 99 01', ' | 589109901 | SG00', 1, 42, NULL, '000_589_10_99_01.jpg'),
(6, '121000 589 12 28 001', 'Plastic Lines Cutter (up to 13mm diameter)', 23, 121, 0, 0, '2019-01-30', '2019-01-30', 'Inactivo', 0, 0, '', 0, 0, 0, 1, '2019-01-30 14:30:44', '2019-01-30 06:00:00', '000 589 12 28 00', ' | 589122800 | SG47 SG32', 1, 42, NULL, '000_589_12_28_00.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD PRIMARY KEY (`idHerramienta`),
  ADD KEY `idUbicacion` (`idUbicacion`),
  ADD KEY `idSucursal` (`idSucursal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  MODIFY `idHerramienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1162;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
