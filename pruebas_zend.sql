-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-07-2017 a las 17:19:03
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pruebas_zend`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alternative` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `name`, `surname`, `description`, `email`, `password`, `image`, `alternative`) VALUES
(1, 'Diego', 'Abanto', 'Soy programador web desde hace 5 años', 'dabanto@gmail.com', 'admin', 'null', 'null'),
(3, 'Bruce', 'Wayne', 'Soy Batman', 'batman@gmail.com', 'batman', NULL, NULL),
(4, 'LuisE', 'Abanto', 'Soy Luis Abanto', 'labanto@gmail.com', 'labanto', NULL, NULL),
(5, 'Victor', 'Robles', 'Profesor Zend 2', 'vrobles@gmail.com', 'vrobles', NULL, NULL),
(7, 'Feliciano', 'Abanto', 'Papa', 'fabanto@gmail.com', '$2y$06$Y3Vyc29femVuZF9mcmFtZO/jxFeslHCnZnn6/YMNOWXymsIQ5iptm', NULL, NULL),
(8, 'Olgaa', 'Arroyo', 'Mama de Diego', 'olga@gmail.com', '$2y$06$Y3Vyc29femVuZF9mcmFtZO/jxFeslHCnZnn6/YMNOWXymsIQ5iptm', NULL, NULL),
(10, 'Jorge', 'Arroyo', 'Tio Jorge', 'jarroyo@gmail.com', '$2y$06$Y3Vyc29femVuZF9mcmFtZOWe9ObfcXw903LrQtkdq2gEkCVrtg3dq', NULL, NULL),
(11, 'Eduardo', 'Arroyo', 'Primo Edu', 'earroyo@gmail.com', '$2y$06$Y3Vyc29femVuZF9mcmFtZOWe9ObfcXw903LrQtkdq2gEkCVrtg3dq', NULL, NULL),
(12, 'LuisGabriel', 'Arroyo', 'Primo Luis Gabriel', 'lgarroyo@gmail.com', '$2y$06$Y3Vyc29femVuZF9mcmFtZOWe9ObfcXw903LrQtkdq2gEkCVrtg3dq', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
