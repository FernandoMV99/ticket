-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-07-2021 a las 22:47:34
-- Versión del servidor: 10.4.12-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jypsac_ticket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_indentificacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documento_identificacion` bigint(20) UNSIGNED DEFAULT NULL,
  `numero_identificacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_confirmacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_confirmado` bigint(20) UNSIGNED DEFAULT NULL,
  `roles_id` bigint(20) UNSIGNED NOT NULL,
  `estado_activo` bigint(20) UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_registrado` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `num_indentificacion`, `empresa`, `documento_identificacion`, `numero_identificacion`, `celular`, `pais`, `departamento`, `direccion`, `email`, `email2`, `password`, `codigo_confirmacion`, `estado_confirmado`, `roles_id`, `estado_activo`, `foto`, `user_registrado`, `created_at`, `updated_at`) VALUES
(1, 'Luis Fernando', 'Miranda Valdez', NULL, 'JYP PERIFERICOS S.A.C', 2, '72857654', '98565465', 'Perú', NULL, NULL, 'fernandomv.0102@gmail.com', NULL, '$2y$10$PMSZ.GWeENb40tzr6qUcfuOOTCsbm2povkA9umPqvXTq2mWPFaN8C', '123', 1, 1, 1, '1627682005116592325_3604264723191643_1263019371493196913_n.jpg', 1, '2021-01-01 16:36:57', '2021-07-31 01:53:25'),
(2, 'Carlos Daniel', 'Roman Berru', NULL, 'J&P PERIFERICOS SAC', 2, '73588510', '936292675', 'Perú', NULL, NULL, 'danielrberru@gmail.com', NULL, '$2y$10$qpEKv2qWsM0K9TzwfoHP2uf3Ce0Y/Dvvwu3l7S8Cm1aKcD/M6q7Gu', NULL, 1, 1, 1, '1627681978que-necesita-un-gato.jpg', 1, '2021-07-31 01:52:58', '2021-07-31 01:52:58');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`) USING HASH,
  ADD KEY `users_documento_identificacion_foreign` (`documento_identificacion`),
  ADD KEY `users_estado_confirmado_foreign` (`estado_confirmado`),
  ADD KEY `users_roles_id_foreign` (`roles_id`),
  ADD KEY `users_estado_activo_foreign` (`estado_activo`),
  ADD KEY `users_user_registrado_foreign` (`user_registrado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
