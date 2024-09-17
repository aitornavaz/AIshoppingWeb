-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2023 a las 22:41:21
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `web_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `IDUsuario` int(11) NOT NULL,
  `IDObra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `ID` int(11) NOT NULL,
  `IDUsuario` int(11) DEFAULT NULL,
  `IDObraDeArte` int(11) DEFAULT NULL,
  `FechaDeCompra` date DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obrasdearte`
--

CREATE TABLE `obrasdearte` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Imagen` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(1000) DEFAULT NULL,
  `AnoDeCreacion` int(11) DEFAULT NULL,
  `Estilo` varchar(50) DEFAULT NULL,
  `Autor` varchar(50) DEFAULT NULL,
  `TipoDeArte` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `obrasdearte`
--

INSERT INTO `obrasdearte` (`ID`, `Nombre`, `Precio`, `Imagen`, `Descripcion`, `AnoDeCreacion`, `Estilo`, `Autor`, `TipoDeArte`) VALUES
(1, 'El Reino Mágico del Bosque Encantado', 3100.00, 'bosque_encantado.png', 'Adéntrate en el asombroso mundo de \"El Reino Mágico del Bosque Encantado\". En esta impresionante obra de arte, el espectador se sumerge en un paisaje inigualable donde la realidad se entrelaza con la fantasía. Las pinceladas magistrales y la paleta de colores exuberantes del estilo impresionista te transportarán a un lugar donde la naturaleza cobra vida de una manera mágica y vibrante.\r\n\r\nEl bosque, con sus árboles majestuosos, se viste de una paleta de colores que danzan en la brisa. Los rayos dorados del sol filtrándose a través de las hojas pintan un escenario de luces y sombras, creando una atmósfera etérea y misteriosa. En este mundo encantado, los animales fantásticos, criaturas de la imaginación, se esconden entre los árboles y las hojas, listos para revelarse solo a los ojos más observadores y curiosos.', 1432, 'Impresionista', 'Autor1', 'Cuadro'),
(2, 'Sueño de Tortuga', 2300.00, 'tortuga_cristal.png', 'En ”Sue˜no de Tortuga”, los trazos abstractos y geom´etricos\r\nde una pintura generada por inteligencia artificial cobran vida, capturando\r\nla esencia de una tortuga con un caparaz´on cristalino desde una perspectiva cubista. Los colores vibrantes y las formas angulares crean una\r\natm´osfera intrigante que rompe con la representaci´on convencional. El\r\ncaparaz´on de la tortuga se descompone en facetas geom´etricas, como un\r\nrompecabezas visual, mientras que el entorno circundante se transforma\r\nen una composici´on de formas abstractas. Esta obra de arte invita a los\r\nespectadores a explorar la redefinici´on de la realidad y a contemplar la\r\nnaturaleza desde una perspectiva cubista ´unica.', 2023, 'Cubismo', 'Autor2', 'Cuadro'),
(3, 'Café Rétro en Montmartre', 5120.00, 'paris_vintage.png', 'El cuadro \"Café Rétro en Montmartre\" es un viaje en el tiempo a la atmósfera efervescente de las icónicas cafeterías de París en el siglo pasado. La imagen captura la esencia de la Belle Époque, donde artistas y pensadores se reunían en torno a una taza de café para discutir arte, literatura y filosofía.\r\n\r\nEl artista, conocido como \"Édouard Clichet,\" ha logrado recrear la magia de aquella época dorada en cada detalle. El café, con su mobiliario de madera desgastada y sillas de mimbre, parece impregnado de historias y susurros de pasiones intelectuales. La luz suave y dorada que se filtra a través de las ventanas ilumina rostros y conversaciones en la penumbra.\r\n\r\nEl aroma de café recién hecho se mezcla con el sutil perfume del tabaco y los ecos de un acordeón en el rincón. Las sombras y reflejos en las tazas de café añaden un toque de misterio a la escena, como si el tiempo se hubiera detenido en este rincón parisino.', 1930, 'Realismo', 'Autor3', 'Cuadro'),
(4, 'Batalla Marítima en la Era Medieval', 12300.00, 'grabados_medievales_batalla_mar.png', 'Estos grabados medievales, que componen la serie \"Batalla Marítima en la Era Medieval,\" son una crónica visual de la valentía y la tumultuosa lucha en alta mar durante tiempos lejanos. Cada grabado cuenta una historia única de intriga, coraje y la eterna lucha entre navíos en un vasto y misterioso océano.\r\n\r\nEl artista, cuyo nombre se ha perdido en los anales del tiempo, ha plasmado con destreza las escenas de enfrentamientos navales, donde imponentes veleros cargados de caballeros y arqueros desafían a las turbulentas aguas y a enemigos desconocidos. Los detalles meticulosos en cada embarcación, las enseñas ondeando al viento y las armaduras chispeantes de los guerreros son una muestra de la habilidad artística del autor.\r\n\r\nLos grabados transmiten la tensión palpable en el aire, con el estruendo de los cañones y el choque de las espadas resonando en las olas. La mar está viva, con el cielo tormentoso reflejándose en el mar embravecido. En cada grabado, se revela un episodio diferente', 742, 'Románico', 'Autor4', 'Grabado Medieval'),
(5, 'El Vaquero del Mar Impresionista', 230.00, 'tiburon_cowboy.png', '\"El Vaquero del Mar Impresionista\" es una obra de arte única que desafía las convenciones y nos transporta a un mundo de imaginación y surrealismo. En esta pintura impresionista, el artista, \"Pierre Le Mareno,\" ha capturado el asombroso instante en que un valiente vaquero, ataviado con sombrero y chaleco, desafía la lógica y la gravedad mientras monta con gracia un tiburón en medio de un escenario marino onírico.\r\n\r\nLa pincelada suelta y la paleta de colores vivos típicas del impresionismo añaden un toque de misterio y movimiento a la escena. El tiburón, majestuoso y surreal, parece fluir en las aguas del lienzo como si estuviera en su propio elemento, mientras el vaquero mantiene un equilibrio precario sobre su lomo. El mar en tumulto y el cielo nublado se mezclan en una danza de luces y sombras que infunde a la obra un aire de intriga y emoción.', 2018, 'Impresionista', 'Autor5', 'Lámina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `CorreoElectronico` varchar(50) DEFAULT NULL,
  `Contrasena` varchar(50) DEFAULT NULL,
  `Admin` bit DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `CorreoElectronico`, `Contrasena`) VALUES
(1, 'Usuario1', 'usuario1@example.com', 'f1b4dea0aceeb5b732d62bad9545cd35'),
(2, 'Usuario2', 'usuario2@example.com', 'c9050e7078a260e808a8991e5cc1b3f0'),
(3, 'Usuario3', 'usuario3@example.com', '90fe2049445178a1840bd71dc6c07ce8'),
(4, 'Usuario4', 'usuario4@example.com', '9794230d6e317739e0d2a1be87becb94'),
(5, 'Usuario5', 'usuario5@example.com', '6bf1c4df57af5ade48b354bf959b4464'),
(6, 'Usuario6', 'usuario6@example.com', '91a81c79944c294500eca88bd906ed13'),
(7, 'Usuario7', 'usuario7@example.com', '1abc9603f106657665bcdd608f302b0b'),
(8, 'Usuario8', 'usuario8@example.com', '8b07327223bcdd1a7c4e16fd9bf04831'),
(9, 'Usuario9', 'usuario9@example.com', '39bcf9ff587fa61fef01735543b25e60'),
(10, 'Usuario10', 'usuario10@example.com', '60da703b0fcbd743ab453382a0b351c6');

INSERT INTO `usuarios` (`ID`, `Nombre`, `CorreoElectronico`, `Contrasena`, `Admin`) VALUES ('12', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', b'1'); 

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`IDUsuario`,`IDObra`),
  ADD KEY `IDObra` (`IDObra`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDUsuario` (`IDUsuario`),
  ADD KEY `IDObraDeArte` (`IDObraDeArte`);

--
-- Indices de la tabla `obrasdearte`
--
ALTER TABLE `obrasdearte`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`IDUsuario`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`IDObra`) REFERENCES `obrasdearte` (`ID`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`IDUsuario`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`IDObraDeArte`) REFERENCES `obrasdearte` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
