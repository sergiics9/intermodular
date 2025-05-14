-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2025 a las 02:34:36
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
-- Base de datos: `intermodular`
--
CREATE DATABASE IF NOT EXISTS `intermodular` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `intermodular`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `permisos` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_cupones`
--

CREATE TABLE `admin_cupones` (
  `id_admin` int(11) NOT NULL,
  `id_cupon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidad_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cantidad_productos` (
`categoria` varchar(100)
,`cantidad_productos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidad_productos_ordenados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cantidad_productos_ordenados` (
`categoria` varchar(100)
,`cantidad_productos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidad_productos_por_categoria`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cantidad_productos_por_categoria` (
`categoria` varchar(100)
,`cantidad_productos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compra`
--

CREATE TABLE `carrito_compra` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Camisetas'),
(2, 'Sudaderas'),
(3, 'Gorras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_descuentos_productos`
--

CREATE TABLE `categorias_descuentos_productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_descuento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `categorias_mas_5_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `categorias_mas_5_productos` (
`categoria` varchar(100)
,`cantidad_productos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `categorias_precio_promedio_mayor_100`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `categorias_precio_promedio_mayor_100` (
`categoria` varchar(100)
,`precio_promedio` decimal(11,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `categorias_producto_mas_barato_mayor_50`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `categorias_producto_mas_barato_mayor_50` (
`categoria` varchar(100)
,`precio_minimo` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `suscrito` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` int(11) NOT NULL,
  `color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `texto` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `producto_id`, `usuario_id`, `texto`, `fecha`, `ip`) VALUES
(2, 42, 6, 'El papa no es negre', '2025-05-09 18:39:33', NULL),
(3, 43, 6, 'asd', '2025-05-14 02:21:36', NULL),
(4, 42, 8, 'asdasd', '2025-05-14 02:23:16', '::1');

--
-- Disparadores `comentarios`
--
DELIMITER $$
CREATE TRIGGER `actualizar_contador_comentarios` AFTER INSERT ON `comentarios` FOR EACH ROW BEGIN
   
    UPDATE productos 
    SET num_comentarios = (
        SELECT COUNT(*) FROM comentarios 
        WHERE producto_id = NEW.producto_id
    )
    WHERE id = NEW.producto_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `email`, `mensaje`, `fecha_envio`) VALUES
(1, 'Sergi', 'sergi2@gmail.com', 'ASDFFFFFFFFF', '2025-01-31 15:46:26'),
(3, 'David', 'sergi4@gmail.com', 'gddfgdfg', '2025-02-18 14:56:07'),
(5, 'Jordi', 'sergi4@gmail.com', 'asdasdadddddddd', '2025-02-18 14:57:26'),
(6, 'David', 'sergi4@gmail.com', 'asd', '2025-02-18 14:58:25'),
(7, 'Jordi', 'sergi20031005@gmail.com', 'asd', '2025-03-04 18:17:20'),
(8, 'David', 'prueba@test.com', 'prueba', '2025-03-13 15:31:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones`
--

CREATE TABLE `cupones` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `cantidad_minima` int(11) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id` int(11) NOT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `validez` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE `detalles_pedido` (
  `id` int(11) NOT NULL,
  `PedidoID` int(11) NOT NULL,
  `ProductoID` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `talla` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_pedido`
--

INSERT INTO `detalles_pedido` (`id`, `PedidoID`, `ProductoID`, `Cantidad`, `Precio`, `talla`) VALUES
(30, 44, 45, 1, 65.00, 'L'),
(31, 45, 44, 1, 39.00, 'XL'),
(32, 45, 46, 1, 33.00, 'S'),
(33, 46, 43, 1, 47.00, 'XL'),
(34, 47, 43, 1, 47.00, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

CREATE TABLE `devoluciones` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones_envio`
--

CREATE TABLE `direcciones_envio` (
  `id` int(11) NOT NULL,
  `calle` varchar(255) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_logistica`
--

CREATE TABLE `empresa_logistica` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE `envios` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_envio` date DEFAULT NULL,
  `direccion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios_logistica`
--

CREATE TABLE `envios_logistica` (
  `id_envio` int(11) NOT NULL,
  `id_logistica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios_metodos`
--

CREATE TABLE `envios_metodos` (
  `id_envio` int(11) NOT NULL,
  `id_metodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compras`
--

CREATE TABLE `historial_compras` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_metodo_pago` int(11) NOT NULL,
  `precio_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_devoluciones`
--

CREATE TABLE `historial_devoluciones` (
  `id_historial` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_puntos`
--

CREATE TABLE `historial_puntos` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `recompensa` int(11) DEFAULT NULL,
  `puntos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `año` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_envio`
--

CREATE TABLE `metodos_envio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_logistica`
--

CREATE TABLE `metodos_logistica` (
  `id_metodo` int(11) NOT NULL,
  `id_logistica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paypal`
--

CREATE TABLE `paypal` (
  `transaccion_id` int(11) NOT NULL,
  `pago_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Direccion` text NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Fecha` datetime DEFAULT current_timestamp(),
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `UsuarioID`, `Nombre`, `Email`, `Direccion`, `Telefono`, `Fecha`, `Total`) VALUES
(42, 6, 'Carlos Latre', 'carloslatre@gmail.com', 'Calle fuerteventura, 1', '639503690', '2025-05-13 18:22:29', 32.00),
(43, 6, 'Carlos Latre', 'carloslatre@gmail.com', 'Calle fuerteventura, 1', '639503690', '2025-05-13 18:24:18', 65.00),
(44, 6, 'Carlos Latre', 'carloslatre@gmail.com', 'Calle fuerteventura, 1', '639503690', '2025-05-13 18:25:23', 65.00),
(45, 6, 'Carlos Latre', 'carloslatre@gmail.com', 'Calle fuerteventura, 1', '639503690', '2025-05-13 19:48:12', 72.00),
(46, 6, 'Carlos Latre', 'carloslatre@gmail.com', 'Calle fuerteventura, 1', '639503690', '2025-05-13 19:53:21', 47.00),
(47, 9, 'Jordi', 'jordi@gmail.com', 'Calle fuerteventura, 1', '123456789', '2025-05-14 02:26:14', 47.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_envios_logistica`
--

CREATE TABLE `pedidos_envios_logistica` (
  `id_pedido` int(11) NOT NULL,
  `id_envio` int(11) NOT NULL,
  `id_logistica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `precio_promedio_categoria`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `precio_promedio_categoria` (
`categoria` varchar(100)
,`precio_promedio` decimal(14,6)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `precio_promedio_por_categoria`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `precio_promedio_por_categoria` (
`categoria` varchar(100)
,`precio_promedio` decimal(11,2)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `categoria_id` int(11) DEFAULT NULL,
  `num_comentarios` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `descripcion`, `fecha_creacion`, `categoria_id`, `num_comentarios`) VALUES
(42, 'Camiseta Corta', 32.00, 'Ligera y fresca, la Camiseta Corta es ideal para los días calurosos o para combinar con tu estilo casual. Su ajuste cómodo y tejido transpirable la hacen una opción perfecta para cualquier ocasión.', '2025-02-20 16:03:22', 1, 2),
(43, 'Camiseta Cybertruck', 47.00, 'Inspirada en el diseño futurista del Cybertruck, esta camiseta destaca por su estilo audaz y moderno. Perfecta para los fanáticos de la innovación y la tecnología, ofrece un ajuste cómodo y un look vanguardista.', '2025-02-20 16:03:45', 1, 1),
(44, 'Camiseta Minimalista', 39.00, 'Disfruta del diseño elegante y sencillo de nuestra Camiseta Minimalista. Confeccionada con algodón suave y transpirable, es perfecta para cualquier ocasión, combinando estilo y comodidad.', '2025-02-20 16:04:10', 1, 0),
(45, 'Sudadera Negra', 65.00, 'Una sudadera clásica y versátil que no puede faltar en tu armario. Hecha con tejido de alta calidad, te mantiene abrigado sin sacrificar el estilo. Ideal para combinar con cualquier outfit.', '2025-02-20 16:04:33', 2, 0),
(46, 'Camiseta Gris Tesla', 33.00, 'Inspirada en la innovación y la tecnología, esta camiseta gris Tesla es perfecta para los amantes del diseño moderno. Su tejido premium ofrece confort y durabilidad para el día a día.', '2025-02-20 16:04:54', 1, 0),
(47, 'Camiseta Negra', 45.00, 'Un básico imprescindible. La camiseta negra combina con todo y es ideal tanto para looks casuales como urbanos. Fabricada con materiales de alta calidad para máxima comodidad.', '2025-02-20 16:05:12', 1, 0),
(48, 'Gorra Gris Tesla', 24.00, 'Protege tu estilo con la Gorra Gris Tesla. Diseño moderno con ajuste perfecto para cualquier tamaño. Ideal para complementar tu outfit y destacar con un toque deportivo y sofisticado.', '2025-02-20 16:05:33', 3, 0),
(49, 'Sudadera Azul Marino', 65.00, 'Elegante y cómoda, esta sudadera azul marino te ofrece calidez y estilo en un solo producto. Perfecta para el frío y fácil de combinar con cualquier prenda de tu guardarropa.', '2025-02-20 16:05:52', 2, 0),
(50, 'Camiseta Negra Tesla Logo', 34.00, 'Demuestra tu pasión por Tesla con esta camiseta negra de diseño exclusivo. Con un logo distintivo, es la elección perfecta para quienes buscan una prenda moderna y con personalidad.', '2025-02-20 16:07:57', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_categorias`
--

CREATE TABLE `productos_categorias` (
  `producto_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_colores`
--

CREATE TABLE `productos_colores` (
  `id_producto` int(11) NOT NULL,
  `id_color` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_inventario`
--

CREATE TABLE `productos_inventario` (
  `id_producto` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_marcas`
--

CREATE TABLE `productos_marcas` (
  `id_producto` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_proveedores`
--

CREATE TABLE `productos_proveedores` (
  `id_producto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `producto_mas_caro_por_categoria`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `producto_mas_caro_por_categoria` (
`producto` varchar(100)
,`categoria` varchar(100)
,`precio` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `promedio_precio_mas_3_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `promedio_precio_mas_3_productos` (
`categoria` varchar(100)
,`precio_promedio` decimal(11,2)
,`cantidad_productos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos`
--

CREATE TABLE `puntos` (
  `id` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_recompensas`
--

CREATE TABLE `puntos_recompensas` (
  `id_puntos` int(11) NOT NULL,
  `id_recompensa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_recompensas_historial_puntos`
--

CREATE TABLE `puntos_recompensas_historial_puntos` (
  `id_puntos` int(11) NOT NULL,
  `id_recompensas` int(11) NOT NULL,
  `id_historial_puntos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recompensas`
--

CREATE TABLE `recompensas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenyas`
--

CREATE TABLE `resenyas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `texto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguir`
--

CREATE TABLE `seguir` (
  `id_1` int(11) NOT NULL,
  `id_2` int(11) NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `suma_precios_por_categoria`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `suma_precios_por_categoria` (
`categoria` varchar(100)
,`total_precio` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `tallas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `id_producto`, `tallas`) VALUES
(52, 43, 'S'),
(53, 43, 'M'),
(54, 43, 'L'),
(55, 43, 'XL'),
(56, 44, 'L'),
(57, 44, 'XL'),
(58, 45, 'S'),
(59, 45, 'M'),
(60, 45, 'L'),
(61, 45, 'XL'),
(62, 46, 'S'),
(63, 47, 'S'),
(64, 47, 'M'),
(65, 48, 'M'),
(66, 49, 'S'),
(67, 49, 'M'),
(68, 50, 'S'),
(69, 50, 'M'),
(87, 42, 'XS'),
(88, 42, 'S'),
(89, 42, 'M'),
(90, 42, 'L'),
(91, 42, 'XL'),
(92, 42, 'XXL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `numero_tarjeta` varchar(16) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `pago_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `contraseña` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `ip_registro` varchar(45) DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contraseña`, `email`, `telefono`, `fecha_registro`, `ip_registro`, `role`) VALUES
(1, 'Sergi', '$2y$10$YEMEl9b.USZXaqJH4EqXqutCObAjD9jrnB/PLBxlEYHXCX40/pGZm', 'sergi22@gmail.com', '639503672', '2025-02-06 00:00:00', NULL, 1),
(2, 'Jordi', '$2y$10$JiHg6AE83a4wVWZV34epDO/xPDXPhafdnsNA2TQ.tiZqat8BcxTC2', 'jordi2@gmail.com', '639503672', '2025-02-13 00:00:00', NULL, 0),
(3, 'Sergi Casiano', '$2y$10$F6FwP2JSL/Bx9XkSj56pxuEnJoAPn88LkbL3g8ZOFCv7TCQrZPPBK', 'sergi4@gmail.com', '639503663', '2025-02-18 00:00:00', NULL, 1),
(5, 'Sergi Casiano Soler', '$2y$10$6qpKPrF4TZ7f/KLcktw1Huo/VztVnLdI3w7gRcSCpiwsgPqTJXDji', 'sergi1@gmail.com', NULL, '2025-05-08 16:41:30', NULL, 0),
(6, 'Carlos Latre', '$2y$10$cCh9KJaRgrOEg3yerOPJq.EC2CZXo0UJUd57XIIQQjvNwFfzxnykW', 'carloslatre@gmail.com', '639503690', '2025-05-08 16:46:14', NULL, 1),
(7, 'Luis Suarez', '$2y$10$aUbobRVdBpkP9NTKb4FMA.jXzx5QqBied951UiTucFgUlmaXZFgUC', 'luissuarez@email.com', '639503643', '2025-05-10 17:38:12', NULL, 0),
(8, 'Kolde', '$2y$10$rg4NDHP00E8z3hu56ljOAenXyghp1X8gdU/bhL70ZujQ3BLLbckCe', 'kolde@gmail.com', '966860105', '2025-05-14 02:22:29', NULL, 0),
(9, 'Jordi', '$2y$10$YhMSqpdYCUwX7Ic3pOcJ9.cFlTp6HbzJmb8Nzh2FZN4k9c1GgtM1y', 'jordi@gmail.com', '123456789', '2025-05-14 02:24:03', '::1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_carrito_productos`
--

CREATE TABLE `usuarios_carrito_productos` (
  `id_usuario` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_direcciones`
--

CREATE TABLE `usuarios_direcciones` (
  `id_usuario` int(11) NOT NULL,
  `id_direccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_pagos`
--

CREATE TABLE `usuarios_pagos` (
  `id_usuario` int(11) NOT NULL,
  `id_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_productos`
--

CREATE TABLE `usuarios_productos` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_productos_historial`
--

CREATE TABLE `usuarios_productos_historial` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_historial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_productos_pedidos`
--

CREATE TABLE `usuarios_productos_pedidos` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_productos_puntos`
--

CREATE TABLE `usuarios_productos_puntos` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_puntos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidad_productos`
--
DROP TABLE IF EXISTS `cantidad_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidad_productos`  AS SELECT `categorias`.`nombre` AS `categoria`, count(0) AS `cantidad_productos` FROM (`productos` join `categorias` on(`productos`.`categoria_id` = `categorias`.`id`)) GROUP BY `productos`.`categoria_id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidad_productos_ordenados`
--
DROP TABLE IF EXISTS `cantidad_productos_ordenados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidad_productos_ordenados`  AS SELECT `c`.`nombre` AS `categoria`, count(`p`.`id`) AS `cantidad_productos` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` GROUP BY `c`.`nombre` ORDER BY count(`p`.`id`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidad_productos_por_categoria`
--
DROP TABLE IF EXISTS `cantidad_productos_por_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidad_productos_por_categoria`  AS SELECT `c`.`nombre` AS `categoria`, count(`p`.`id`) AS `cantidad_productos` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` GROUP BY `c`.`nombre` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `categorias_mas_5_productos`
--
DROP TABLE IF EXISTS `categorias_mas_5_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `categorias_mas_5_productos`  AS SELECT `c`.`nombre` AS `categoria`, count(`p`.`id`) AS `cantidad_productos` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` GROUP BY `c`.`nombre` HAVING count(`p`.`id`) > 5 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `categorias_precio_promedio_mayor_100`
--
DROP TABLE IF EXISTS `categorias_precio_promedio_mayor_100`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `categorias_precio_promedio_mayor_100`  AS SELECT `c`.`nombre` AS `categoria`, round(avg(`p`.`precio`),2) AS `precio_promedio` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` GROUP BY `c`.`nombre` HAVING avg(`p`.`precio`) > 100 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `categorias_producto_mas_barato_mayor_50`
--
DROP TABLE IF EXISTS `categorias_producto_mas_barato_mayor_50`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `categorias_producto_mas_barato_mayor_50`  AS SELECT `c`.`nombre` AS `categoria`, min(`p`.`precio`) AS `precio_minimo` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` GROUP BY `c`.`nombre` HAVING min(`p`.`precio`) > 50 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `precio_promedio_categoria`
--
DROP TABLE IF EXISTS `precio_promedio_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `precio_promedio_categoria`  AS SELECT `categorias`.`nombre` AS `categoria`, avg(`productos`.`precio`) AS `precio_promedio` FROM (`productos` join `categorias` on(`productos`.`categoria_id` = `categorias`.`id`)) GROUP BY `productos`.`categoria_id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `precio_promedio_por_categoria`
--
DROP TABLE IF EXISTS `precio_promedio_por_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `precio_promedio_por_categoria`  AS SELECT `c`.`nombre` AS `categoria`, round(avg(`p`.`precio`),2) AS `precio_promedio` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` GROUP BY `c`.`nombre` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `producto_mas_caro_por_categoria`
--
DROP TABLE IF EXISTS `producto_mas_caro_por_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `producto_mas_caro_por_categoria`  AS SELECT `p`.`nombre` AS `producto`, `c`.`nombre` AS `categoria`, `p`.`precio` AS `precio` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` AND `p`.`precio` = (select max(`productos`.`precio`) from `productos` where `productos`.`categoria_id` = `p`.`categoria_id`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `promedio_precio_mas_3_productos`
--
DROP TABLE IF EXISTS `promedio_precio_mas_3_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `promedio_precio_mas_3_productos`  AS SELECT `c`.`nombre` AS `categoria`, round(avg(`p`.`precio`),2) AS `precio_promedio`, count(`p`.`id`) AS `cantidad_productos` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` GROUP BY `c`.`nombre` HAVING count(`p`.`id`) > 3 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `suma_precios_por_categoria`
--
DROP TABLE IF EXISTS `suma_precios_por_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `suma_precios_por_categoria`  AS SELECT `c`.`nombre` AS `categoria`, sum(`p`.`precio`) AS `total_precio` FROM (`productos` `p` join `categorias` `c`) WHERE `p`.`categoria_id` = `c`.`id` GROUP BY `c`.`nombre` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `admin_cupones`
--
ALTER TABLE `admin_cupones`
  ADD PRIMARY KEY (`id_admin`,`id_cupon`),
  ADD KEY `id_cupon` (`id_cupon`);

--
-- Indices de la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias_descuentos_productos`
--
ALTER TABLE `categorias_descuentos_productos`
  ADD PRIMARY KEY (`id_producto`,`id_categoria`,`id_descuento`),
  ADD UNIQUE KEY `calt_cdp` (`id_producto`,`id_descuento`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_descuento` (`id_descuento`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PedidoID` (`PedidoID`),
  ADD KEY `ProductoID` (`ProductoID`);

--
-- Indices de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `direcciones_envio`
--
ALTER TABLE `direcciones_envio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa_logistica`
--
ALTER TABLE `empresa_logistica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `direccion_id` (`direccion_id`);

--
-- Indices de la tabla `envios_logistica`
--
ALTER TABLE `envios_logistica`
  ADD PRIMARY KEY (`id_envio`,`id_logistica`),
  ADD KEY `id_logistica` (`id_logistica`);

--
-- Indices de la tabla `envios_metodos`
--
ALTER TABLE `envios_metodos`
  ADD PRIMARY KEY (`id_envio`,`id_metodo`),
  ADD KEY `id_metodo` (`id_metodo`);

--
-- Indices de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_metodo_pago` (`id_metodo_pago`);

--
-- Indices de la tabla `historial_devoluciones`
--
ALTER TABLE `historial_devoluciones`
  ADD PRIMARY KEY (`id_historial`,`id_devolucion`),
  ADD KEY `id_devolucion` (`id_devolucion`);

--
-- Indices de la tabla `historial_puntos`
--
ALTER TABLE `historial_puntos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `metodos_envio`
--
ALTER TABLE `metodos_envio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `metodos_logistica`
--
ALTER TABLE `metodos_logistica`
  ADD PRIMARY KEY (`id_metodo`,`id_logistica`),
  ADD KEY `id_logistica` (`id_logistica`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`transaccion_id`),
  ADD KEY `pago_id` (`pago_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UsuarioID` (`UsuarioID`);

--
-- Indices de la tabla `pedidos_envios_logistica`
--
ALTER TABLE `pedidos_envios_logistica`
  ADD PRIMARY KEY (`id_pedido`,`id_envio`),
  ADD KEY `id_envio` (`id_envio`),
  ADD KEY `id_logistica` (`id_logistica`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD PRIMARY KEY (`producto_id`,`categoria_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `productos_colores`
--
ALTER TABLE `productos_colores`
  ADD PRIMARY KEY (`id_producto`,`id_color`),
  ADD KEY `id_color` (`id_color`);

--
-- Indices de la tabla `productos_inventario`
--
ALTER TABLE `productos_inventario`
  ADD PRIMARY KEY (`id_producto`,`id_inventario`),
  ADD KEY `id_inventario` (`id_inventario`);

--
-- Indices de la tabla `productos_marcas`
--
ALTER TABLE `productos_marcas`
  ADD PRIMARY KEY (`id_producto`,`id_marca`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Indices de la tabla `productos_proveedores`
--
ALTER TABLE `productos_proveedores`
  ADD PRIMARY KEY (`id_producto`,`id_proveedor`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puntos_recompensas`
--
ALTER TABLE `puntos_recompensas`
  ADD PRIMARY KEY (`id_puntos`,`id_recompensa`),
  ADD KEY `id_recompensa` (`id_recompensa`);

--
-- Indices de la tabla `puntos_recompensas_historial_puntos`
--
ALTER TABLE `puntos_recompensas_historial_puntos`
  ADD KEY `id_puntos` (`id_puntos`),
  ADD KEY `id_recompensas` (`id_recompensas`),
  ADD KEY `id_historial_puntos` (`id_historial_puntos`);

--
-- Indices de la tabla `recompensas`
--
ALTER TABLE `recompensas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resenyas`
--
ALTER TABLE `resenyas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`,`id_producto`);

--
-- Indices de la tabla `seguir`
--
ALTER TABLE `seguir`
  ADD PRIMARY KEY (`id_1`,`id_2`),
  ADD KEY `id_2` (`id_2`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`numero_tarjeta`),
  ADD KEY `pago_id` (`pago_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_carrito_productos`
--
ALTER TABLE `usuarios_carrito_productos`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`),
  ADD UNIQUE KEY `id_producto` (`id_producto`,`id_carrito`),
  ADD KEY `id_carrito` (`id_carrito`);

--
-- Indices de la tabla `usuarios_direcciones`
--
ALTER TABLE `usuarios_direcciones`
  ADD PRIMARY KEY (`id_usuario`,`id_direccion`),
  ADD KEY `id_direccion` (`id_direccion`);

--
-- Indices de la tabla `usuarios_pagos`
--
ALTER TABLE `usuarios_pagos`
  ADD PRIMARY KEY (`id_usuario`,`id_pago`),
  ADD KEY `id_pago` (`id_pago`);

--
-- Indices de la tabla `usuarios_productos`
--
ALTER TABLE `usuarios_productos`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `usuarios_productos_historial`
--
ALTER TABLE `usuarios_productos_historial`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`,`id_historial`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_historial` (`id_historial`);

--
-- Indices de la tabla `usuarios_productos_pedidos`
--
ALTER TABLE `usuarios_productos_pedidos`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`,`id_pedido`),
  ADD UNIQUE KEY `calt_upp` (`id_producto`,`id_pedido`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `usuarios_productos_puntos`
--
ALTER TABLE `usuarios_productos_puntos`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`,`id_puntos`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_puntos` (`id_puntos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `admin_cupones`
--
ALTER TABLE `admin_cupones`
  ADD CONSTRAINT `admin_cupones_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `admin_cupones_ibfk_2` FOREIGN KEY (`id_cupon`) REFERENCES `cupones` (`id`);

--
-- Filtros para la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  ADD CONSTRAINT `carrito_compra_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `categorias_descuentos_productos`
--
ALTER TABLE `categorias_descuentos_productos`
  ADD CONSTRAINT `categorias_descuentos_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `categorias_descuentos_productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `categorias_descuentos_productos_ibfk_3` FOREIGN KEY (`id_descuento`) REFERENCES `descuentos` (`id`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD CONSTRAINT `cupones_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD CONSTRAINT `detalles_pedido_ibfk_1` FOREIGN KEY (`PedidoID`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_pedido_ibfk_2` FOREIGN KEY (`ProductoID`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `envios_ibfk_1` FOREIGN KEY (`direccion_id`) REFERENCES `direcciones_envio` (`id`);

--
-- Filtros para la tabla `envios_logistica`
--
ALTER TABLE `envios_logistica`
  ADD CONSTRAINT `envios_logistica_ibfk_1` FOREIGN KEY (`id_envio`) REFERENCES `envios` (`id`),
  ADD CONSTRAINT `envios_logistica_ibfk_2` FOREIGN KEY (`id_logistica`) REFERENCES `empresa_logistica` (`id`);

--
-- Filtros para la tabla `envios_metodos`
--
ALTER TABLE `envios_metodos`
  ADD CONSTRAINT `envios_metodos_ibfk_1` FOREIGN KEY (`id_envio`) REFERENCES `envios` (`id`),
  ADD CONSTRAINT `envios_metodos_ibfk_2` FOREIGN KEY (`id_metodo`) REFERENCES `metodos_envio` (`id`);

--
-- Filtros para la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `historial_compras_ibfk_2` FOREIGN KEY (`id_metodo_pago`) REFERENCES `pagos` (`id`);

--
-- Filtros para la tabla `historial_devoluciones`
--
ALTER TABLE `historial_devoluciones`
  ADD CONSTRAINT `historial_devoluciones_ibfk_1` FOREIGN KEY (`id_historial`) REFERENCES `historial_compras` (`id`),
  ADD CONSTRAINT `historial_devoluciones_ibfk_2` FOREIGN KEY (`id_devolucion`) REFERENCES `devoluciones` (`id`);

--
-- Filtros para la tabla `metodos_logistica`
--
ALTER TABLE `metodos_logistica`
  ADD CONSTRAINT `metodos_logistica_ibfk_1` FOREIGN KEY (`id_metodo`) REFERENCES `metodos_envio` (`id`),
  ADD CONSTRAINT `metodos_logistica_ibfk_2` FOREIGN KEY (`id_logistica`) REFERENCES `empresa_logistica` (`id`);

--
-- Filtros para la tabla `paypal`
--
ALTER TABLE `paypal`
  ADD CONSTRAINT `paypal_ibfk_1` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos_envios_logistica`
--
ALTER TABLE `pedidos_envios_logistica`
  ADD CONSTRAINT `pedidos_envios_logistica_ibfk_2` FOREIGN KEY (`id_envio`) REFERENCES `envios` (`id`),
  ADD CONSTRAINT `pedidos_envios_logistica_ibfk_3` FOREIGN KEY (`id_logistica`) REFERENCES `empresa_logistica` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD CONSTRAINT `productos_categorias_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `productos_categorias_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `productos_colores`
--
ALTER TABLE `productos_colores`
  ADD CONSTRAINT `productos_colores_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `productos_colores_ibfk_2` FOREIGN KEY (`id_color`) REFERENCES `colores` (`id`);

--
-- Filtros para la tabla `productos_inventario`
--
ALTER TABLE `productos_inventario`
  ADD CONSTRAINT `productos_inventario_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `productos_inventario_ibfk_2` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id`);

--
-- Filtros para la tabla `productos_marcas`
--
ALTER TABLE `productos_marcas`
  ADD CONSTRAINT `productos_marcas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `productos_marcas_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`);

--
-- Filtros para la tabla `productos_proveedores`
--
ALTER TABLE `productos_proveedores`
  ADD CONSTRAINT `productos_proveedores_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `productos_proveedores_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`);

--
-- Filtros para la tabla `puntos_recompensas`
--
ALTER TABLE `puntos_recompensas`
  ADD CONSTRAINT `puntos_recompensas_ibfk_1` FOREIGN KEY (`id_puntos`) REFERENCES `puntos` (`id`),
  ADD CONSTRAINT `puntos_recompensas_ibfk_2` FOREIGN KEY (`id_recompensa`) REFERENCES `recompensas` (`id`);

--
-- Filtros para la tabla `puntos_recompensas_historial_puntos`
--
ALTER TABLE `puntos_recompensas_historial_puntos`
  ADD CONSTRAINT `puntos_recompensas_historial_puntos_ibfk_1` FOREIGN KEY (`id_puntos`) REFERENCES `puntos` (`id`),
  ADD CONSTRAINT `puntos_recompensas_historial_puntos_ibfk_2` FOREIGN KEY (`id_recompensas`) REFERENCES `recompensas` (`id`),
  ADD CONSTRAINT `puntos_recompensas_historial_puntos_ibfk_3` FOREIGN KEY (`id_historial_puntos`) REFERENCES `historial_puntos` (`id`);

--
-- Filtros para la tabla `resenyas`
--
ALTER TABLE `resenyas`
  ADD CONSTRAINT `resenyas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resenyas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `resenyas_ibfk_3` FOREIGN KEY (`id_usuario`,`id_producto`) REFERENCES `usuarios_productos` (`id_usuario`, `id_producto`);

--
-- Filtros para la tabla `seguir`
--
ALTER TABLE `seguir`
  ADD CONSTRAINT `seguir_ibfk_1` FOREIGN KEY (`id_1`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `seguir_ibfk_2` FOREIGN KEY (`id_2`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD CONSTRAINT `tallas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `tarjeta_ibfk_1` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`);

--
-- Filtros para la tabla `usuarios_carrito_productos`
--
ALTER TABLE `usuarios_carrito_productos`
  ADD CONSTRAINT `usuarios_carrito_productos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_carrito_productos_ibfk_2` FOREIGN KEY (`id_carrito`) REFERENCES `carrito_compra` (`id`),
  ADD CONSTRAINT `usuarios_carrito_productos_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `usuarios_direcciones`
--
ALTER TABLE `usuarios_direcciones`
  ADD CONSTRAINT `usuarios_direcciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_direcciones_ibfk_2` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones_envio` (`id`);

--
-- Filtros para la tabla `usuarios_pagos`
--
ALTER TABLE `usuarios_pagos`
  ADD CONSTRAINT `usuarios_pagos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_pagos_ibfk_2` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id`);

--
-- Filtros para la tabla `usuarios_productos`
--
ALTER TABLE `usuarios_productos`
  ADD CONSTRAINT `usuarios_productos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `usuarios_productos_historial`
--
ALTER TABLE `usuarios_productos_historial`
  ADD CONSTRAINT `usuarios_productos_historial_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_productos_historial_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `usuarios_productos_historial_ibfk_3` FOREIGN KEY (`id_historial`) REFERENCES `historial_compras` (`id`);

--
-- Filtros para la tabla `usuarios_productos_pedidos`
--
ALTER TABLE `usuarios_productos_pedidos`
  ADD CONSTRAINT `usuarios_productos_pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_productos_pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `usuarios_productos_puntos`
--
ALTER TABLE `usuarios_productos_puntos`
  ADD CONSTRAINT `usuarios_productos_puntos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_productos_puntos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `usuarios_productos_puntos_ibfk_3` FOREIGN KEY (`id_puntos`) REFERENCES `puntos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
