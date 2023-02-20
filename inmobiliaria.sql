-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-02-2023 a las 09:59:14
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inmobiliaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprados`
--

CREATE TABLE `comprados` (
  `usuario_comprador` int(5) DEFAULT NULL,
  `Codigo_piso` int(11) DEFAULT NULL,
  `Precio_final` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comprados`
--

INSERT INTO `comprados` (`usuario_comprador`, `Codigo_piso`, `Precio_final`) VALUES
(14, 125, 50000),
(14, 125, 50000),
(14, 125, 50000),
(19, 127, 1000),
(19, 127, 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pisos`
--

CREATE TABLE `pisos` (
  `Codigo_piso` int(11) NOT NULL,
  `calle` varchar(40) NOT NULL,
  `numero` int(11) NOT NULL,
  `piso` int(11) NOT NULL,
  `puerta` varchar(5) NOT NULL,
  `cp` int(11) NOT NULL,
  `metros` int(11) NOT NULL,
  `zona` varchar(15) DEFAULT NULL,
  `precio` float NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `usuario_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pisos`
--

INSERT INTO `pisos` (`Codigo_piso`, `calle`, `numero`, `piso`, `puerta`, `cp`, `metros`, `zona`, `precio`, `imagen`, `usuario_id`) VALUES
(126, 'tucasa', 1, 1, '1', 1111, 1, 'madrid', 1, '../../pisos/fondo.jpg', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(5) NOT NULL,
  `nombres` varchar(35) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(80) NOT NULL,
  `tipo_usuario` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nombres`, `correo`, `clave`, `tipo_usuario`) VALUES
(14, 'Sandra', 'sandrita@gmail.com', '87e879cd6efe7ea13f443c6957f3b220', 'vendedor'),
(16, 'mario', 'mario@gmail.com', '139b3c68f1c0f759f09fcbbdf42a9e30', 'administrador'),
(17, 'sierra', 'sierra@gmail.com', '139b3c68f1c0f759f09fcbbdf42a9e30', 'vendedor'),
(18, 'josete', 'jose@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'vendedor'),
(19, 'josete', 'josete@gmail.com', '139b3c68f1c0f759f09fcbbdf42a9e30', 'vendedor'),
(20, 'sierra', 'sierrita@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'comprador'),
(21, 'sierra', 'sierritaa@gmail.com', '139b3c68f1c0f759f09fcbbdf42a9e30', 'comprador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pisos`
--
ALTER TABLE `pisos`
  ADD PRIMARY KEY (`Codigo_piso`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pisos`
--
ALTER TABLE `pisos`
  MODIFY `Codigo_piso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
