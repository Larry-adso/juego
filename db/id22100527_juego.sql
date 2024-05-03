-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-05-2024 a las 21:39:03
-- Versión del servidor: 10.5.21-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id22100527_juego`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `armas`
--

CREATE TABLE `armas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `da_body` int(50) NOT NULL,
  `da_head` int(20) NOT NULL,
  `balas` varchar(50) NOT NULL,
  `recamara` varchar(20) NOT NULL,
  `id_tip_arma` int(11) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `armas`
--

INSERT INTO `armas` (`id`, `nombre`, `da_body`, `da_head`, `balas`, `recamara`, `id_tip_arma`, `ruta`, `nivel`) VALUES
(14, 'Vandal', 10, 75, '60', '25', 1, 'vandal.webp', 2),
(19, 'Phanton', 10, 75, '90', '30', 1, 'phanton.png', 3),
(21, 'clasic', 2, 75, '12', '12', 2, 'classic.png', 1),
(22, 'Puño', 1, 45, '0', '0', 5, 'puño.png', 1),
(23, 'Operator', 60, 100, '5', '12', 3, 'operator.png', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE `avatar` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `ruta` varchar(200) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `ruta_animacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `avatar`
--

INSERT INTO `avatar` (`id`, `nombre`, `ruta`, `Descripcion`, `ruta_animacion`) VALUES
(16, 'Cypher', '../../img/avatar/cypher.png', 'Cypher es un experto en información de Marruecos que se especializa en redes de vigilancia y es capaz de seguirle la pista al enemigo constantemente.', ''),
(18, 'Phoenix', '../../img/avatar/phoenix.png', 'Phoenix proviene del Reino Unido y sus poderes estelares salen a relucir con su estilo de combate, que prende fuego al campo de batalla de forma deslumbrante. ', ''),
(19, 'Fade', '../../img/avatar/fade.png', 'Fade, la cazarrecompensas turca, controla el poder de las pesadillas para poner al descubierto los secretos de los enemigos.', ''),
(20, 'Omen', '../../img/avatar/omen.png', 'Omen es un fantasma de tiempos pasados que acecha en las sombras. Es capaz de cegar al enemigo, teleportarse a través del campo de batalla', ''),
(22, 'Jett', '../../img/avatar/jett.png', 'Jett viene de Corea del Sur, y su estilo de lucha ágil y evasivo le permite asumir grandes riesgos.', ''),
(23, 'reyna', '../../img/avatar/reyna.png', 'Desde el corazón de México, Reyna llega para dominar los combates uno contra uno y cada asesinato que consigue la hace más fuerte. ', '../../img/avatar/REYNAS.mp4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `estado`) VALUES
(1, 'activo'),
(2, 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapas`
--

CREATE TABLE `mapas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ruta` varchar(200) NOT NULL,
  `nivel_m` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mapas`
--

INSERT INTO `mapas` (`id`, `nombre`, `ruta`, `nivel_m`) VALUES
(11, 'BR-Clasificatoria ', '../../../img/mapas/mapa3.jpg', 2),
(12, 'Lotus', '../../../img/mapas/lotus.jpg', 1),
(13, 'DE-Clasificatoria', '../../../img/mapas/maxresdefault.jpg', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rangos`
--

CREATE TABLE `rangos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `ruta_rango` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rangos`
--

INSERT INTO `rangos` (`id`, `nombre`, `ruta_rango`) VALUES
(1, 'ORO', 'oro.webp'),
(2, 'Platino', 'platino.png'),
(3, 'Diamante', 'diamante.webp'),
(4, 'Heroico', 'inmortal.webp'),
(5, 'Maestro', 'radiantes.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `id` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `id_mapa` int(11) DEFAULT NULL,
  `id_arma` int(11) DEFAULT NULL,
  `id_avatar` int(11) NOT NULL,
  `resumen` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `sala`
--
DELIMITER $$
CREATE TRIGGER `guardar_eliminar_sala` AFTER DELETE ON `sala` FOR EACH ROW BEGIN
    INSERT INTO trigg (deleted_id, deleted_nickname, deleted_id_mapa, deleted_id_arma, deleted_id_avatar,deleted_resumen)
    VALUES (OLD.id, OLD.nickname, OLD.id_mapa, OLD.id_arma, OLD.id_avatar, OLD.resumen);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tp_armas`
--

CREATE TABLE `tp_armas` (
  `id` int(11) NOT NULL,
  `tipo_arma` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tp_armas`
--

INSERT INTO `tp_armas` (`id`, `tipo_arma`) VALUES
(1, 'ametralladora'),
(2, 'pistola'),
(3, 'snipper'),
(4, 'escopeta'),
(5, 'puño');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tp_usuario`
--

CREATE TABLE `tp_usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tp_usuario`
--

INSERT INTO `tp_usuario` (`id`, `usuario`) VALUES
(1, 'admin'),
(2, 'player');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trigg`
--

CREATE TABLE `trigg` (
  `id` int(11) NOT NULL,
  `deleted_id` int(11) NOT NULL,
  `deleted_nickname` varchar(50) NOT NULL,
  `deleted_id_mapa` int(11) DEFAULT NULL,
  `deleted_id_arma` int(11) DEFAULT NULL,
  `deleted_id_avatar` int(11) NOT NULL,
  `deleted_resumen` varchar(30) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trigg`
--

INSERT INTO `trigg` (`id`, `deleted_id`, `deleted_nickname`, `deleted_id_mapa`, `deleted_id_arma`, `deleted_id_avatar`, `deleted_resumen`, `deleted_at`) VALUES
(266, 288, 'edwar gomez', 12, NULL, 20, 'perdedor', '2024-04-29 13:55:48'),
(267, 287, 'penetreitor3000', 12, 21, 16, 'perdedor', '2024-04-29 13:56:20'),
(268, 289, 'edwar gomez', 12, NULL, 20, 'perdedor', '2024-04-29 13:56:31'),
(269, 285, 'gargola ', 12, 22, 23, 'perdedor', '2024-04-29 13:56:39'),
(270, 286, 'jeerks20', 12, 21, 16, 'ganador', '2024-04-29 13:56:45'),
(271, 292, 'gargola ', 12, NULL, 20, 'perdedor', '2024-04-29 13:59:01'),
(272, 291, 'jeerks20', 11, 19, 16, NULL, '2024-04-29 14:00:12'),
(273, 293, 'jeerks20', 13, 19, 16, NULL, '2024-04-29 14:04:42'),
(274, 290, 'edwar gomez', 12, 21, 22, NULL, '2024-04-29 14:04:58'),
(275, 295, 'edwar gomez', 11, 14, 20, NULL, '2024-04-29 14:10:44'),
(276, 298, 'penetreitor3000', 12, 21, 23, 'perdedor', '2024-04-29 14:13:26'),
(277, 299, 'penetreitor3000', 12, NULL, 16, 'perdedor', '2024-04-29 14:14:30'),
(278, 294, 'jeerks20', 11, 19, 16, NULL, '2024-04-29 14:15:05'),
(279, 300, 'penetreitor3000', 12, 21, 16, 'perdedor', '2024-04-29 14:15:17'),
(280, 297, 'edwar gomez', NULL, NULL, 20, NULL, '2024-04-29 14:16:12'),
(281, 302, 'edwar gomez', NULL, NULL, 20, NULL, '2024-04-29 14:16:35'),
(282, 304, 'penetreitor3000', 12, NULL, 16, 'perdedor', '2024-04-29 14:17:24'),
(283, 303, 'edwar gomez', NULL, NULL, 16, NULL, '2024-04-29 14:17:46'),
(284, 305, 'penetreitor3000', 12, NULL, 16, 'perdedor', '2024-04-29 14:17:50'),
(285, 301, 'jeerks20', 11, 19, 18, NULL, '2024-04-29 14:18:27'),
(286, 307, 'penetreitor3000', 12, NULL, 16, 'perdedor', '2024-04-29 14:18:33'),
(287, 306, 'edwar gomez', NULL, NULL, 16, NULL, '2024-04-29 14:18:50'),
(288, 296, 'gargola ', 12, 21, 22, NULL, '2024-04-29 14:28:10'),
(289, 308, 'jeerks20', NULL, NULL, 23, NULL, '2024-04-29 14:28:10'),
(290, 309, 'edwar gomez', NULL, NULL, 23, NULL, '2024-04-29 14:28:10'),
(291, 310, 'laxky0338c', 12, 21, 16, 'perdedor', '2024-05-02 13:47:57'),
(292, 311, 'leviantares', 12, 21, 16, 'ganador', '2024-05-02 13:47:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(15) NOT NULL,
  `nombres` varchar(20) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `nickname` varchar(15) NOT NULL,
  `password` varchar(3250) NOT NULL,
  `vida` int(20) NOT NULL,
  `nivel` int(13) NOT NULL,
  `puntaje` varchar(50) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `tp_user` int(11) NOT NULL,
  `token` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `correo`, `nickname`, `password`, `vida`, `nivel`, `puntaje`, `id_estado`, `tp_user`, `token`) VALUES
(107428013, 'Angie', 'gutierrez@gmail.com', 'leviantares', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 98, 1, '165', 1, 2, NULL),
(110094692, 'edwar ', 'edwardfaridg@gmail.com', 'edwar gomez', '186e37b08272a73afe88ff4e0e893cec087589df5e5b44ec85fabb5fa684550a55d15c41409bc50c60cc780040098f8c1adeb36b051337fb5149375164a4db7e', 100, 2, '551', 2, 2, NULL),
(1005717713, 'aura', 'olayacristina01@gmail.com', 'cris1', '6dc7051280bc37a2a55b90c612c31ae4c82fe8b0288da72e29fadee222179400d883383e45ed44f1cd26104554b761a0750977826794ffc1e77c75f94f7baa7b', 100, 1, '0', 2, 1, '0'),
(1021513259, '._.XD', 'jairoestebanviverosvasquezz@gmail.com', '._.XD', 'bcc41a0f908be5fba423d7ee37bc424e7ec035ce3b81a8a02723be724eb165018afdb6adb869825e595a575a3a3a635d9231a8e593833d0034c7576278c7511e', 100, 0, '0', 2, 2, NULL),
(1105463910, 'Daniel ', 'danielfelipe1105@gmail.com', 'Kira_666', '01d6c263e31e33fe0cb34ed1c1f1758c8ff26817136ae347dc41bacbcf1bf01560ff53d745ccbf45f3fc7e55820de62960cef7c65bf6311ee7c0409f0ae3fb3e', 100, 0, '0', 2, 2, NULL),
(1106228399, 'jose', 'josesss88@gmail.com', 'penetreitor3000', 'd9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85', -206, 1, '308', 2, 2, NULL),
(1109000445, 'Siempre', 'soyleyenda@gmail.com', 'prueba01', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 100, 1, '0', 2, 2, NULL),
(1109000999, 'Larry', 'larry@gmail.com', 'laxky0338c', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', -65, 1, '2', 1, 1, '0'),
(1109492110, 'Sebastian', 'jsebaslozano2006@gmail.com', 'jeerks20', 'ea1c780c4e311f4303861244f75ea8202d3c146012490b90192603bea20243d929db5d1e7d5b260717fb646cb512e3d993b1443a4c3da751f8da58999e9791d0', 100, 4, '1159', 2, 2, NULL),
(1112364897, 'jose moya', 'jkbgff@gmail.com', 'josem', 'd9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85', 100, 0, '0', 2, 2, NULL),
(1435769873, 'Juan', 'junito@gmail.com', 'gargola ', 'af62f843459a58e1c43f2b0da92f7bad7edc6069d5b8f06d8619ece54f799dbdec87f7b47e119f20438a7c08b110061b61c6394311e5102a5c8de453bfeeedbb', 23, 1, '2235', 2, 2, NULL),
(112424242223, 'brian', 'brianstenverochapoveda@gmail.com', 'trigres ', 'f98f3a506e4390a6d20c48b522f81178b124d40591ed1470a482fa5d6242c8977944e1e9819f5e5271a70b55cfea8966bf2ca318ab93356e652e5c01eda9d532', 100, 0, '0', 2, 2, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mapas`
--
ALTER TABLE `mapas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rangos`
--
ALTER TABLE `rangos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mapa` (`id_mapa`),
  ADD KEY `id_arma` (`id_arma`),
  ADD KEY `id_avatar` (`id_avatar`);

--
-- Indices de la tabla `tp_armas`
--
ALTER TABLE `tp_armas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tp_usuario`
--
ALTER TABLE `tp_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trigg`
--
ALTER TABLE `trigg`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `nivel` (`nivel`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `armas`
--
ALTER TABLE `armas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mapas`
--
ALTER TABLE `mapas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT de la tabla `tp_armas`
--
ALTER TABLE `tp_armas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tp_usuario`
--
ALTER TABLE `tp_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `trigg`
--
ALTER TABLE `trigg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
