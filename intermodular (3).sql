-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2025 a las 17:48:24
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
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(6, 'David', 'sergi4@gmail.com', 'asd', '2025-02-18 14:58:25');

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
  `DetalleID` int(11) NOT NULL,
  `PedidoID` int(11) NOT NULL,
  `ProductoID` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `talla` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `PedidoID` int(11) NOT NULL,
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

INSERT INTO `pedidos` (`PedidoID`, `UsuarioID`, `Nombre`, `Email`, `Direccion`, `Telefono`, `Fecha`, `Total`) VALUES
(18, 1, 'Sergi', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-12 17:57:17', 900.00),
(19, 1, 'David', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-12 19:07:13', 1800.00),
(20, 1, 'Sergiiiii', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-13 15:51:24', 900.00),
(21, 1, 'Sergi', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-13 16:37:20', 153.00),
(22, 1, 'Sergi', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-13 16:39:35', 153.00),
(23, 1, 'Sergi', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-13 16:42:15', 153.00),
(24, 1, 'Sergi', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-13 16:43:34', 153.00),
(25, 1, 'Sergi', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-13 16:46:19', 153.00),
(26, 1, 'Sergi', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-13 16:47:11', 256.00),
(27, 1, 'Sergi', 'sergi2@gmail.com', 'calle los olmos 7', '639503673', '2025-02-13 16:51:14', 256.00),
(28, 3, 'Sergi Casiano Soler', 'sergi4@gmail.com', 'calle los olmos 9', '639503673', '2025-02-18 15:46:44', 198.00),
(29, 3, 'Sergi Casiano Soler', 'sergi4@gmail.com', 'calle los olmos 9', '639503673', '2025-02-18 15:49:32', 25.00),
(30, 3, 'Sergi Casiano', 'sergi4@gmail.com', 'Calle fuerteventura 1', '639503663', '2025-02-18 20:53:45', 128.00);

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
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `descripcion`, `fecha_creacion`) VALUES
(42, 'Camiseta Corta', 35.00, 'una camiseta corta', '2025-02-20 16:03:22'),
(43, 'Camiseta Cybertruck', 47.00, 'cybertruck', '2025-02-20 16:03:45'),
(44, 'Camiseta Minimalista', 39.00, 'un toque minimalista', '2025-02-20 16:04:10'),
(45, 'Sudadera Negra', 65.00, 'una sudadera negra', '2025-02-20 16:04:33'),
(46, 'Camiseta Gris Tesla', 33.00, 'camiseta gris', '2025-02-20 16:04:54'),
(47, 'Camiseta Negra', 45.00, 'camiseta negra', '2025-02-20 16:05:12'),
(48, 'Gorra Gris Tesla', 24.00, 'una gorra de tesla gris', '2025-02-20 16:05:33'),
(49, 'Sudadera Azul Marino', 65.00, 'una sudadera azul', '2025-02-20 16:05:52'),
(50, 'Camiseta Negra Tesla Logo', 34.00, 'una camiseta negra con el logo de tesla', '2025-02-20 16:07:57');

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
(49, 42, 'L'),
(50, 42, 'M'),
(51, 42, 'XL'),
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
(69, 50, 'M');

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
  `role` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contraseña`, `email`, `telefono`, `fecha_registro`, `role`) VALUES
(1, 'Sergi', '$2y$10$YEMEl9b.USZXaqJH4EqXqutCObAjD9jrnB/PLBxlEYHXCX40/pGZm', 'sergi2@gmail.com', '639503673', '2025-02-06 00:00:00', 1),
(2, 'Jordi', '$2y$10$JiHg6AE83a4wVWZV34epDO/xPDXPhafdnsNA2TQ.tiZqat8BcxTC2', 'jordi2@gmail.com', '639503672', '2025-02-13 00:00:00', 0),
(3, 'Sergi Casiano', '$2y$10$F6FwP2JSL/Bx9XkSj56pxuEnJoAPn88LkbL3g8ZOFCv7TCQrZPPBK', 'sergi4@gmail.com', '639503663', '2025-02-18 00:00:00', 1);

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
  ADD PRIMARY KEY (`DetalleID`),
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
  ADD PRIMARY KEY (`PedidoID`),
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
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  MODIFY `DetalleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `PedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Filtros para la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD CONSTRAINT `cupones_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD CONSTRAINT `detalles_pedido_ibfk_1` FOREIGN KEY (`PedidoID`) REFERENCES `pedidos` (`PedidoID`) ON DELETE CASCADE ON UPDATE CASCADE,
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
