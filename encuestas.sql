-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 16-11-2017 a las 13:05:15
-- Versión del servidor: 5.6.28
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `curso_symfony`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `n_expediente` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` tinyint(1) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `n_expediente`, `nombre`, `apellidos`, `fecha_nacimiento`, `sexo`, `email`, `telefono`, `grado_id`) VALUES
(1, 13472, 'Carlos ', 'Herrera Conejero', '2017-10-10', 0, 'carherco@gmail.com', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_asignaturas`
--

CREATE TABLE `alumnos_asignaturas` (
  `asignatura_id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `app_users`
--

INSERT INTO `app_users` (`id`, `username`, `password`, `email`, `is_active`) VALUES
(1, 'carlos', '$2y$12$EhCZdh6fxY85zP8W55uONOeckJFv5i26Tvv.BFZ3flPKmwCJ8hwFq', 'carherco@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_ingles` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `credects` int(11) DEFAULT NULL,
  `grado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`id`, `codigo`, `nombre`, `nombre_ingles`, `credects`, `grado_id`) VALUES
(3, 1343, 'Física I', 'Physics I', 6, 1),
(4, 4231, 'Física II', 'Physics II', 6, 1),
(5, 435354, 'vasasdf', 'sdadfdfs', 3, 1),
(6, 5565, 'vasfas', 'asdadsf', 5, 2),
(7, 334, 'Programación', 'Programación', 8, 1),
(8, 24124, 'Geografía', 'Geografía', 4, 2),
(9, 765432, 'afasf', 'asdfads', 6, 1),
(10, 2147483647, 'otra', 'other', 6, 2),
(11, 542552345, 'montes', 'montes', 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloque`
--

CREATE TABLE `bloque` (
  `id` bigint(20) NOT NULL,
  `idencuesta` int(11) DEFAULT NULL,
  `descripcion` varchar(254) DEFAULT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE `concepto` (
  `id` bigint(20) NOT NULL,
  `idencuesta` int(11) NOT NULL,
  `codigo` varchar(32) NOT NULL,
  `descripcion` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` bigint(20) NOT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  `curso_academico` smallint(6) DEFAULT NULL,
  `fecha_ini` varchar(12) DEFAULT NULL,
  `fecha_fin` varchar(12) DEFAULT NULL,
  `fecha_cierre` varchar(12) DEFAULT NULL,
  `gestor` varchar(15) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL,
  `modificable` tinyint(1) DEFAULT NULL,
  `anonima` tinyint(1) DEFAULT NULL,
  `multiconcepto` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` bigint(20) NOT NULL,
  `descripcion` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado`
--

CREATE TABLE `grado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `grado`
--

INSERT INTO `grado` (`id`, `nombre`) VALUES
(1, 'Ingeniería de montes'),
(2, 'Ingeniería de montes 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota`
--

CREATE TABLE `nota` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `n_convocatoria` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nota` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `nota`
--

INSERT INTO `nota` (`id`, `alumno_id`, `asignatura_id`, `n_convocatoria`, `fecha`, `nota`) VALUES
(1, 1, 3, 1, '2016-06-10', 3.7),
(2, 1, 3, 2, '2017-10-24', 6.2),
(3, 1, 4, 1, '2017-10-27', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` bigint(20) NOT NULL,
  `idencuesta` int(11) NOT NULL,
  `idbloque` smallint(6) DEFAULT NULL,
  `idtipo` int(11) NOT NULL,
  `orden` smallint(6) NOT NULL,
  `descripcion` varchar(254) DEFAULT NULL,
  `pie` varchar(254) DEFAULT NULL,
  `salida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` bigint(20) NOT NULL,
  `idpregunta` int(11) NOT NULL,
  `orden` smallint(6) NOT NULL,
  `descripcion` varchar(254) NOT NULL,
  `valor` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado`
--

CREATE TABLE `resultado` (
  `id` bigint(20) NOT NULL,
  `idencuesta` int(11) NOT NULL,
  `idconcepto` varchar(255) NOT NULL,
  `idpregunta` int(11) NOT NULL,
  `idrespuesta` smallint(6) NOT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `valor` text,
  `fecha_auto` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pregunta`
--

CREATE TABLE `tipo_pregunta` (
  `id` bigint(20) NOT NULL,
  `descripcion` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1435D52D67E69CFE` (`n_expediente`),
  ADD UNIQUE KEY `UNIQ_1435D52DE7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_1435D52DC1E70A7F` (`telefono`),
  ADD KEY `IDX_1435D52D91A441CC` (`grado_id`);

--
-- Indices de la tabla `alumnos_asignaturas`
--
ALTER TABLE `alumnos_asignaturas`
  ADD PRIMARY KEY (`asignatura_id`,`alumno_id`),
  ADD KEY `IDX_D57EE88C5C70C5B` (`asignatura_id`),
  ADD KEY `IDX_D57EE88FC28E5EE` (`alumno_id`);

--
-- Indices de la tabla `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_C2502824E7927C74` (`email`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9243D6CE20332D99` (`codigo`),
  ADD KEY `IDX_9243D6CE91A441CC` (`grado_id`);

--
-- Indices de la tabla `bloque`
--
ALTER TABLE `bloque`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `grado`
--
ALTER TABLE `grado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B98F472A3A909126` (`nombre`);

--
-- Indices de la tabla `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C8D03E0DFC28E5EE` (`alumno_id`),
  ADD KEY `IDX_C8D03E0DC5C70C5B` (`asignatura_id`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `resultado`
--
ALTER TABLE `resultado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `tipo_pregunta`
--
ALTER TABLE `tipo_pregunta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05D92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_2265B05DA0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_2265B05DC05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `bloque`
--
ALTER TABLE `bloque`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `concepto`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `grado`
--
ALTER TABLE `grado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `resultado`
--
ALTER TABLE `resultado`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_pregunta`
--
ALTER TABLE `tipo_pregunta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `FK_1435D52D91A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`);

--
-- Filtros para la tabla `alumnos_asignaturas`
--
ALTER TABLE `alumnos_asignaturas`
  ADD CONSTRAINT `FK_D57EE88C5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`),
  ADD CONSTRAINT `FK_D57EE88FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `FK_9243D6CE91A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`);

--
-- Filtros para la tabla `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `FK_C8D03E0DC5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`),
  ADD CONSTRAINT `FK_C8D03E0DFC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);
