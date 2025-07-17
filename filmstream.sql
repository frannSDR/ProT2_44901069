-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-07-2025 a las 13:19:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `filmstream`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `episodios`
--

CREATE TABLE `episodios` (
  `episodio_id` int(11) NOT NULL,
  `temporada_id` int(11) NOT NULL,
  `numero_episodio` int(11) NOT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `sinopsis` text DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL COMMENT 'Duración en minutos',
  `fecha_emision` date DEFAULT NULL,
  `magnet_link` text DEFAULT NULL,
  `torrent_hash` varchar(40) DEFAULT NULL,
  `archivo_torrent` varchar(255) DEFAULT NULL,
  `calidad` varchar(20) DEFAULT NULL,
  `tamaño_mb` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `favorito_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tipo` enum('pelicula','serie') NOT NULL,
  `contenido_id` int(11) NOT NULL COMMENT 'ID de película o serie',
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos_movies_items`
--

CREATE TABLE `favoritos_movies_items` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos_series_items`
--

CREATE TABLE `favoritos_series_items` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `genero_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `slug` varchar(15) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`genero_id`, `nombre`, `slug`, `descripcion`, `created_at`) VALUES
(1, 'Acción', 'accion', 'Películas y series de acción', '2025-06-25 13:54:30'),
(2, 'Drama', 'drama', 'Contenido dramático', '2025-06-25 13:54:30'),
(3, 'Comedia', 'comedia', 'Contenido de humor', '2025-06-25 13:54:30'),
(4, 'Terror', 'terror', 'Películas y series de miedo', '2025-06-25 13:54:30'),
(5, 'Ciencia Ficción', 'scifi', 'Contenido de ciencia ficción', '2025-06-25 13:54:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies_reviews`
--

CREATE TABLE `movies_reviews` (
  `review_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_title` varchar(200) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 10),
  `review_text` text DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `movie_id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `titulo_original` varchar(200) DEFAULT NULL,
  `acercade` text DEFAULT NULL,
  `sinopsis` text DEFAULT NULL,
  `director` varchar(50) NOT NULL COMMENT 'director de la pelicula',
  `reparto` varchar(255) NOT NULL COMMENT 'actores principales(max 3)',
  `año` int(11) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL COMMENT 'Duración en minutos',
  `poster` varchar(255) DEFAULT NULL COMMENT 'URL de la imagen',
  `banner` varchar(255) DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL COMMENT 'URL del trailer',
  `valoracion` decimal(3,1) DEFAULT NULL COMMENT '0.0 a 10.0',
  `activa` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`movie_id`, `titulo`, `titulo_original`, `acercade`, `sinopsis`, `director`, `reparto`, `año`, `duracion`, `poster`, `banner`, `trailer`, `valoracion`, `activa`, `created_at`, `updated_at`) VALUES
(1, 'Batman: El Caballero de la Noche', 'The Dark Knight', 'Batman enfrenta al Joker, un enemigo caótico que busca destruir el orden en Gótica.', 'Con la ayuda del teniente Gordon y el fiscal Harvey Dent, Batman intensifica su lucha contra el crimen organizado en Ciudad Gótica. Todo parece ir en la dirección correcta hasta que aparece el Joker, un criminal anárquico que desata el caos con un plan maestro impredecible.\r\n\r\nEl Joker no busca dinero ni poder, sino corromper el alma de la ciudad y demostrar que hasta el mejor de los hombres puede caer. Batman deberá tomar decisiones difíciles que pondrán a prueba su código moral y su identidad como héroe.', 'Christpoher Nolan', 'Christian Bale, Heath Ledger, Aaron Eckhart...', 2008, 152, 'https://image.tmdb.org/t/p/original/wsOr8j0xoUwDfcY7k815rEJXgr1.jpg', 'https://image.tmdb.org/t/p/original/6qYxCxggmaUy6C9SaDOq0fVym6S.jpg', 'emYLYfuZAbU?si=IGQQpwZuFHcgkzIc', 9.0, 1, '2025-07-11 21:24:30', '2025-07-16 03:10:04'),
(2, 'El Origen', 'Inception', 'Un ladrón especializado en sueños debe implantar una idea en la mente de un objetivo.', 'Dom Cobb es un ladrón con una habilidad poco común: puede infiltrarse en los sueños ajenos para robar secretos del subconsciente. Esta habilidad lo ha convertido en un fugitivo, pero también en un valioso agente para misiones corporativas de espionaje onírico.\r\n\r\nAhora se le ofrece la oportunidad de redimirse con una tarea aún más compleja: implantar una idea en lugar de extraerla. A medida que el equipo se adentra en sueños dentro de sueños, las líneas entre realidad y fantasía se desdibujan, poniendo en riesgo no solo la misión, sino también la cordura de Cobb.', 'Christpoher Nolan', 'Leonardo DiCaprio, Cillian Murphy, Joseph Gordon-Levy...', 2010, 148, 'https://image.tmdb.org/t/p/original/xgPGDEKkBrXhPaNmwIlf8e2RCMk.jpg', 'https://image.tmdb.org/t/p/original/28kKbSUvUz6P5RE1AuMJMO7IMfK.jpg', 'OCEkhKvm-hU?si=dlRiC_fNcfWkRF4O', 8.4, 1, '2025-07-12 19:35:36', '2025-07-16 03:13:33'),
(3, 'Matrix', 'The Matrix', 'Un joven descubre que el mundo que conoce es una ilusión y debe luchar por la verdad.', 'Thomas Anderson, un programador de día y hacker de noche conocido como Neo, descubre que su realidad es una simulación creada por máquinas para controlar a la humanidad. Guiado por Morfeo y la misteriosa Trinity, comienza a entender la verdad detrás de la \"Matrix\".\r\n\r\nAl ser \"despertado\", Neo debe aceptar su destino como el Elegido, alguien con el poder de liberar a la humanidad. Enfrentará peligrosos agentes y desafíos que lo obligarán a decidir si está dispuesto a sacrificarlo todo por la libertad.', 'Lana Wachowski', 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss...', 1998, 138, 'https://image.tmdb.org/t/p/original/tpW2X2DvxtTHJ61iJ7zNYYrJihs.jpg', 'https://image.tmdb.org/t/p/original/icmmSD4vTTDKOq2vvdulafOGw93.jpg', 'OM0tSTEQCQA?si=TunAQBgIPdHD4ew0', 8.2, 1, '2025-07-12 20:30:56', '2025-07-16 03:16:15'),
(4, 'Terminator 2: El Juicio Final', 'Terminator 2: The Final Judge', 'Un cyborg del futuro es enviado para proteger al joven destinado a salvar a la humanidad.', 'Años después de los eventos de la primera película, un nuevo y avanzado Terminator, el T-1000, es enviado desde el futuro con una misión letal: asesinar a John Connor, el niño que algún día liderará la resistencia humana contra las máquinas. Sin embargo, también ha sido enviado otro Terminator —el mismo modelo que una vez intentó matar a su madre—, pero esta vez reprogramado para proteger a John.\r\n\r\nSarah Connor, ahora una guerrera endurecida por la experiencia, une fuerzas con el Terminator protector para evitar el inminente apocalipsis causado por la inteligencia artificial Skynet. Juntos, emprenden una lucha contrarreloj para evitar el \"Día del Juicio\" y cambiar el destino de la humanidad, enfrentándose a un enemigo que parece imposible de destruir.', 'James Cameron', 'Arnold Schwarzenegger, Linda Hamilton, Edward Furlong...', 1991, 137, 'https://image.tmdb.org/t/p/original/bfdPTjdP2JGRAajIoi25Gh2Elmz.jpg', 'https://image.tmdb.org/t/p/original/nQAN90OL4shNsyIZykm8B1u4KiY.jpg', 'h4ThFNL_2tI?si=QIuaFZK63sPGI6AS', 8.1, 1, '2025-07-12 20:30:56', '2025-07-16 03:17:53'),
(5, 'Gladiador', 'Gladiator', 'Un general romano cae en desgracia y se convierte en gladiador para vengar la muerte de su familia.', 'Máximo Décimo Meridio, un leal general del ejército romano, es traicionado por Cómodo, el hijo del emperador, quien asesina a su padre y toma el trono. Tras ser condenado a muerte, Máximo escapa, pero encuentra a su familia asesinada y es capturado como esclavo.\r\n\r\nConvertido en gladiador, Máximo gana fama y el favor del pueblo romano mientras planea su venganza. Su lucha no es solo por justicia personal, sino también por restaurar el honor de Roma y cumplir el legado de un imperio corrompido.', 'Riddley Scott', 'Russell Crowe, Joaquin Phoenix, Connie Nielsen...', 2000, 155, 'https://image.tmdb.org/t/p/original/3ioy4m1Zq84tgYRAv5QTKs6D44t.jpg', 'https://image.tmdb.org/t/p/original/jhk6D8pim3yaByu1801kMoxXFaX.jpg', 'aIdTby5nxvI?si=UKQnXYHPYUSAj-Iy', 8.2, 1, '2025-07-12 20:30:56', '2025-07-16 03:15:12'),
(6, 'Old Boy', '올드보이', 'Un hombre es secuestrado durante 15 años sin explicación, y al ser liberado busca venganza.', 'Oh Dae-su es secuestrado sin motivo aparente y confinado en una habitación durante 15 años. Sin saber quién lo retuvo ni por qué, un día es liberado repentinamente, con dinero, ropa y un celular, y la consigna de encontrar la verdad en cinco días.\r\n\r\nA medida que desentraña el misterio, descubre que su captor lo manipuló en cada paso de su vida. Su búsqueda de venganza se transforma en una tragedia oscura y retorcida, donde los límites de la moral y la redención se desdibujan por completo.', 'Park Chan-wook', 'Choi Min-sik, Yoo Ji-tae, Kang Hye-jung, ...', 2003, 119, 'https://image.tmdb.org/t/p/original/pWDtjs568ZfOTMbURQBYuT4Qxka.jpg', 'https://image.tmdb.org/t/p/original/sdwjQEM869JFwMytTmvr6ggvaUl.jpg', 'od4x6HyKGik?si=fvm-j7ZE5j4bh2bL', 8.3, 1, '2025-07-12 20:30:56', '2025-07-16 03:17:06'),
(7, 'Batman: el caballero de la noche asciende', 'Batman: The Dark Knight Rises', 'Ocho años después, Batman debe regresar para enfrentar a un enemigo que amenaza con destruir Ciudad Gótica.', 'Ciudad Gótica ha vivido en paz tras la caída del fiscal Harvey Dent, pero todo cambia con la llegada de Bane, un terrorista implacable que planea sumir a la ciudad en el caos. Bruce Wayne, retirado y quebrado tanto física como emocionalmente, se ve obligado a volver como Batman para detener la amenaza.\r\n\r\nSin embargo, Bane no es solo fuerza bruta: también posee un plan complejo que involucra al alma de la ciudad. Con la ayuda de nuevos aliados como Selina Kyle (Gatúbela), Batman enfrentará su mayor desafío y descubrirá que, a veces, el verdadero héroe debe renacer desde las sombras.\r\n\r\n', 'Christpoher Nolan', 'Christian Bale, Gary Oldman, Tom Hardy...', 2012, 165, 'https://image.tmdb.org/t/p/original/pi6mwFCtTDIAHOHWan4AQ36Tdh2.jpg', 'https://image.tmdb.org/t/p/original/y2DB71C4nyIdMrANijz8mzvQtk6.jpg', 'GPl-N0KYMog?si=9Bm_2fJjtt0acbdJ', 7.8, 1, '2025-07-12 20:30:56', '2025-07-16 03:12:25'),
(8, 'Django: Sin Cadenas', 'Django: Unchained', 'Un esclavo liberado se convierte en cazarrecompensas para rescatar a su esposa.', 'Django, un esclavo liberado por el excéntrico Dr. King Schultz, se convierte en su compañero cazador de recompensas. Juntos recorren el sur de Estados Unidos cazando criminales y formando una alianza inesperada basada en el respeto mutuo y la venganza.\r\n\r\nCuando Django revela que su esposa Broomhilda fue vendida a un cruel terrateniente llamado Calvin Candie, ambos se embarcan en una misión peligrosa para rescatarla. Enfrentando la brutalidad de la esclavitud y el racismo, Django demuestra que la libertad y el amor bien valen el precio de la sangre.', 'Quentin Tarantino', 'Jamie Foxx, Christoph Waltz, Leonardo DiCaprio...', 2012, 165, 'https://image.tmdb.org/t/p/original/jhuwS5KzaB7jrX74YCm1iHTDntq.jpg', 'https://image.tmdb.org/t/p/original/2oZklIzUbvZXXzIFzv7Hi68d6xf.jpg', 'cakdKJcLVjw?si=pt-VXrjFwogpHCM4', 8.4, 1, '2025-07-12 20:30:56', '2025-07-16 03:12:58'),
(9, 'Kill Bill: Volumen 1', '', NULL, 'Uma Thurman es una asesina que, el día de su boda, es atacada por los miembros de la banda de su jefe, Bill (David Carradine). Logra sobrevivir al ataque, aunque queda en coma. Cinco años después despierta con un trozo de metal en la cabeza y un gran deseo de venganza en su corazón.', 'Quentin Tarantino', 'Uma Thurman, Lucy Liu, Vivica A. Fox, ...', 2003, 111, 'https://media.themoviedb.org/t/p/w220_and_h330_face/lfj709InbmljVqAXgUk2qjnujNN.jpg', 'https://media.themoviedb.org/t/p/w500_and_h282_face/lVy5Zqcty2NfemqKYbVJfdg44rK.jpg', '7kSuas6mRpk?si=sE_EH3QtycIxAyPJ', 8.0, 1, '2025-07-12 20:30:56', '2025-07-12 23:18:21'),
(10, 'Bastardos sin Gloria', 'Inglorious Bastards', NULL, 'Segunda Guerra Mundial. Durante la ocupación de Francia por los alemanes, Shosanna Dreyfus presencia la ejecución de su familia por orden del coronel nazi Hans Landa. Ella consigue huir a París, donde adopta una nueva identidad como propietaria de un cine. En otro lugar de Europa, el teniente Aldo Raine adiestra a un grupo de soldados judíos \"Los bastardos\" para atacar objetivos concretos. Los hombres de Raine y una actriz alemana, que trabaja para los aliados, deben llevar a cabo una misión que hará caer a los jefes del Tercer Reich. El destino quiere que todos se encuentren bajo la marquesina de un cine donde Shosanna espera para vengarse.', 'Quentin Tarantino', 'Brad Pitt, Melanie Laurent, Christoph Waltz, ...', 2009, 146, 'https://image.tmdb.org/t/p/original/zO4RPoYUv8S0na2K1Sff9wU3Sg2.jpg', 'https://image.tmdb.org/t/p/original/hwNtEmmugU5Yd7hpfprNWI0DGIn.jpg', 'b8J_kP8Mses?si=r-2RnOha04qlQzbU', 8.5, 1, '2025-07-12 20:30:56', '2025-07-12 23:52:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula_generos`
--

CREATE TABLE `pelicula_generos` (
  `movie_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula_generos`
--

INSERT INTO `pelicula_generos` (`movie_id`, `genero_id`) VALUES
(1, 2),
(2, 2),
(2, 5),
(3, 1),
(4, 1),
(5, 2),
(6, 1),
(7, 1),
(7, 2),
(8, 1),
(9, 1),
(10, 1),
(10, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review_helpful`
--

CREATE TABLE `review_helpful` (
  `helpful_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_helpful` tinyint(1) NOT NULL COMMENT 'TRUE = útil, FALSE = no útil',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--

CREATE TABLE `series` (
  `serie_id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `titulo_original` varchar(200) DEFAULT NULL,
  `sinopsis` text DEFAULT NULL,
  `año_inicio` int(11) DEFAULT NULL,
  `año_fin` int(11) DEFAULT NULL,
  `temporadas` int(11) DEFAULT NULL,
  `episodios_total` int(11) DEFAULT NULL,
  `clasificacion` varchar(10) DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL,
  `valoracion` decimal(3,1) DEFAULT NULL,
  `estado` enum('En emisión','Finalizada','Cancelada') DEFAULT 'En emisión',
  `activa` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series_reviews`
--

CREATE TABLE `series_reviews` (
  `review_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_title` varchar(200) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 10),
  `review_text` text DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serie_generos`
--

CREATE TABLE `serie_generos` (
  `serie_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporadas`
--

CREATE TABLE `temporadas` (
  `temporada_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `numero_temporada` int(11) NOT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `episodios` int(11) DEFAULT NULL,
  `año` int(11) DEFAULT NULL,
  `sinopsis` text DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) NOT NULL,
  `user_img` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `user_img`, `email`, `nickname`, `password_hash`, `is_active`, `last_login`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, NULL, 'frannm1703@gmail.com', 'fransdr17', '$2y$10$SyFZDvfCHYs0NM/xvwzage36MPiUCYaH./ihoCN/45iy4Qrf2WN/.', 0, '2025-06-26 03:40:19', '2025-06-26 03:16:14', '2025-06-29 22:17:55', 0),
(3, NULL, 'frann1703@outlook.com.ar', 'frann17', '$2y$10$23G7jAIJTJsLFoUPgOJ0hO30RjbkiyhkghmdcBLzDm.ATuq/5J5de', 1, '2025-07-14 20:05:10', '2025-06-27 16:36:00', '2025-07-14 20:05:10', 1),
(4, NULL, 'jose33@yahoo.com.ar', 'Jose2001', '$2y$10$yYtqnFOzATz2gzbFEj2Dk.O7Xl3QSGBIvHd0aeI60CN.31pQ8pD9u', 1, NULL, '2025-06-29 18:51:08', '2025-06-29 22:08:37', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `episodios`
--
ALTER TABLE `episodios`
  ADD PRIMARY KEY (`episodio_id`),
  ADD UNIQUE KEY `unique_episodio` (`temporada_id`,`numero_episodio`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`favorito_id`),
  ADD UNIQUE KEY `unique_favorito` (`user_id`,`tipo`,`contenido_id`);

--
-- Indices de la tabla `favoritos_movies_items`
--
ALTER TABLE `favoritos_movies_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `unique_fav_movie` (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indices de la tabla `favoritos_series_items`
--
ALTER TABLE `favoritos_series_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `unique_fav_serie` (`user_id`,`serie_id`),
  ADD KEY `serie_id` (`serie_id`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`genero_id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `movies_reviews`
--
ALTER TABLE `movies_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indices de la tabla `pelicula_generos`
--
ALTER TABLE `pelicula_generos`
  ADD PRIMARY KEY (`movie_id`,`genero_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Indices de la tabla `review_helpful`
--
ALTER TABLE `review_helpful`
  ADD PRIMARY KEY (`helpful_id`),
  ADD UNIQUE KEY `unique_helpful_vote` (`review_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`serie_id`);

--
-- Indices de la tabla `series_reviews`
--
ALTER TABLE `series_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `serie_id` (`serie_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `serie_generos`
--
ALTER TABLE `serie_generos`
  ADD PRIMARY KEY (`serie_id`,`genero_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Indices de la tabla `temporadas`
--
ALTER TABLE `temporadas`
  ADD PRIMARY KEY (`temporada_id`),
  ADD UNIQUE KEY `unique_temporada` (`serie_id`,`numero_temporada`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nickname` (`nickname`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `episodios`
--
ALTER TABLE `episodios`
  MODIFY `episodio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `favorito_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos_movies_items`
--
ALTER TABLE `favoritos_movies_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos_series_items`
--
ALTER TABLE `favoritos_series_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `genero_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `movies_reviews`
--
ALTER TABLE `movies_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `review_helpful`
--
ALTER TABLE `review_helpful`
  MODIFY `helpful_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `series`
--
ALTER TABLE `series`
  MODIFY `serie_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `series_reviews`
--
ALTER TABLE `series_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `temporadas`
--
ALTER TABLE `temporadas`
  MODIFY `temporada_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `episodios`
--
ALTER TABLE `episodios`
  ADD CONSTRAINT `episodios_ibfk_1` FOREIGN KEY (`temporada_id`) REFERENCES `temporadas` (`temporada_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favoritos_movies_items`
--
ALTER TABLE `favoritos_movies_items`
  ADD CONSTRAINT `favoritos_movies_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_movies_items_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `peliculas` (`movie_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favoritos_series_items`
--
ALTER TABLE `favoritos_series_items`
  ADD CONSTRAINT `favoritos_series_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_series_items_ibfk_2` FOREIGN KEY (`serie_id`) REFERENCES `series` (`serie_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movies_reviews`
--
ALTER TABLE `movies_reviews`
  ADD CONSTRAINT `movies_reviews_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `peliculas` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movies_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pelicula_generos`
--
ALTER TABLE `pelicula_generos`
  ADD CONSTRAINT `pelicula_generos_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `peliculas` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelicula_generos_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`genero_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `review_helpful`
--
ALTER TABLE `review_helpful`
  ADD CONSTRAINT `review_helpful_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `movies_reviews` (`review_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_helpful_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `series_reviews`
--
ALTER TABLE `series_reviews`
  ADD CONSTRAINT `series_reviews_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`serie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `series_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`user_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `serie_generos`
--
ALTER TABLE `serie_generos`
  ADD CONSTRAINT `serie_generos_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`serie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `serie_generos_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`genero_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `temporadas`
--
ALTER TABLE `temporadas`
  ADD CONSTRAINT `temporadas_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`serie_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
