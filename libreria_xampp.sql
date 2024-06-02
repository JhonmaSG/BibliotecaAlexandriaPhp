-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 02-06-2024 a las 17:49:53
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `libreria`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `filtrarLibroPorCategoria` (IN `categoria_buscada` VARCHAR(20))   SELECT * FROM libro
WHERE categoria = categoria_buscada$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filtrarLibroPorId` (IN `id_buscado` INT)   SELECT * FROM libro
WHERE id_libro = id_buscado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filtrarLibroPorNombre` (IN `nombre_buscado` VARCHAR(40))   SELECT * FROM libro
WHERE titulo = nombre_buscado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prestamosNoTerminados` ()   SELECT * FROM prestamo INNER JOIN libro
ON prestamo.id_libro = libro.id_libro INNER JOIN
cliente 
ON prestamo.id_cliente = cliente.id_cliente INNER JOIN
empleado 
ON prestamo.id_empleado_presta = empleado.id_empleado
where fecha_entrega IS NULL$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prestamosPorCliente` (IN `idClienteBuscado` INT)   SELECT * FROM prestamo INNER JOIN libro
ON prestamo.id_libro = libro.id_libro INNER JOIN
cliente 
ON prestamo.id_usuario = cliente.id_usuario INNER JOIN
empleado 
ON prestamo.id_empleado_presta = empleado.id_usuario
where prestamo.id_usuario = idClienteBuscado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prestamosPorEmpleado` (IN `idEmpleadoBuscado` INT)   SELECT * FROM prestamo INNER JOIN libro
ON prestamo.id_libro = libro.id_libro INNER JOIN
cliente 
ON prestamo.id_usuario = cliente.id_usuario INNER JOIN
empleado 
ON prestamo.id_empleado_presta = empleado.id_usuario
where prestamo.id_empleado_presta = idEmpleadoBuscado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prestamosPorLibro` (IN `idLibroBuscado` INT)   SELECT * FROM prestamo INNER JOIN libro
ON prestamo.id_libro = libro.id_libro INNER JOIN
cliente 
ON prestamo.id_usuario = cliente.id_usuario INNER JOIN
empleado 
ON prestamo.id_empleado_presta = empleado.id_usuario
where prestamo.id_libro = idLibroBuscado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prestamosTerminados` ()   SELECT * FROM prestamo INNER JOIN libro
ON prestamo.id_libro = libro.id_libro INNER JOIN
cliente 
ON prestamo.id_usuario = cliente.id_usuario INNER JOIN
empleado 
ON prestamo.id_empleado_presta = empleado.id_usuario
where fecha_entrega IS NOT NULL$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prestamosTerminadosPorFecha` (IN `fechaFinal` DATE)   SELECT * FROM prestamo INNER JOIN libro
ON prestamo.id_libro = libro.id_libro INNER JOIN
cliente 
ON prestamo.id_cliente = cliente.id_cliente INNER JOIN
empleado 
ON prestamo.id_empleado_presta = empleado.id_empleado
where fecha_entrega = fechaFinal$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `cedula` int(11) NOT NULL,
  `respuesta` varchar(45) NOT NULL,
  `nombre_usuario` varchar(30) DEFAULT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(10) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `usuario`, `contraseña`, `correo`, `cedula`, `respuesta`, `nombre_usuario`, `fecha_inicio`, `estado`) VALUES
(1, 'jhonmarios', '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'jmsg@gmail.com', 1013670, 'harry1', 'jhon serrano', '2024-05-28 22:22:37', 'activo'),
(2, 'leytonUD', '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'leytonUD@gmail.com', 1105643, 'harry1', 'heider leyton', '2024-05-28 22:22:37', 'activo'),
(3, 'prueba1', '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'prueba1@gmail.com', 2222222, 'harry1', 'prueba 1', '2024-03-28 22:22:37', 'activo'),
(4, 'prueba2', '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'prueba2@gmail.com', 3333333, 'harry1', 'prueba 2', '2024-02-28 22:22:37', 'activo'),
(5, 'prueba3', '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'prueba3@gmail.com', 4444444, 'harry1', 'prueba 3', '2024-01-28 22:22:37', 'activo'),
(6, 'pipemillos', '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'pipeelmejor@gmail.com', 1214521, 'harry1', 'pipe avila', '2024-05-29 01:59:42', 'activo'),
(7, 'elcomeburras', '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'joelsayas@gmail.com', 9998887, 'harry1', 'joel sayas', '2024-05-29 01:59:42', 'activo'),
(8, 'gafarota', '$2y$10$Sz6u3nakVuEClpDwc4.U7ua9B70NGBkFBcKl7Ryct0YQEEvzpYETu', 'nicolasxd@gmail.com', 4562452, 'harry1', 'nicolas caicedo', '2024-05-29 01:59:42', 'activo'),
(9, 'guevo', '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'waba@gmail.com', 1257457, 'harry1', 'waba montoya', '2024-05-29 01:59:42', 'activo'),
(11, 'tazita', '$2y$10$DT9zrv4KjfRem06nopnz4.srbaFw3tnLmti6LglaMonZz6sG.DuYq', 'daza@gmail.com', 7898765, 'harry1', 'juan pablo daza', '2024-05-29 02:05:56', 'activo'),
(12, 'elingelarota', '$2y$10$oYb1GE2Yk6fZXlSA23rcJequ36R0oIV8Lhifwg6jrhtD2ORN6lUFu', 'cristian@gmail.com', 9986521, 'amo a mi novia', 'larrota', '2024-05-30 00:44:31', 'activo'),
(13, 'andreycunn', '$2y$10$.0HjlFcX2bAQ.DXjxpoK5eFBGpiQpmPDZ8f6zxcnrdurYbOgrQ5eq', 'andrey@gmail.com', 3323212, 'gusanero a morir', 'andreygusanero', '2024-05-30 00:45:41', 'activo');

--
-- Disparadores `cliente`
--
DELIMITER $$
CREATE TRIGGER `respaldo_clientes` BEFORE DELETE ON `cliente` FOR EACH ROW BEGIN
	
    DELETE FROM multa
    WHERE multa.id_cliente = OLD.id_cliente;
    
    DELETE FROM prestamo
    WHERE prestamo.id_cliente = OLD.id_cliente;
   

    INSERT INTO historial_clientes_eliminados (
	id_cliente,
	contraseña,
	correo,
	cedula,
	respuesta,
	nombre_usuario,
	fecha_inicio,
	estado,
	fecha_eliminacion
    ) VALUES (
	OLD.id_cliente,
	OLD.contraseña,
	OLD.correo,
	OLD.cedula,
	OLD.respuesta,
	OLD.nombre_usuario,
	OLD.fecha_inicio,
	'INACTIVO',
	NOW()
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `cedula` int(11) NOT NULL,
  `respuesta` varchar(45) NOT NULL,
  `nombre_emp` varchar(30) NOT NULL,
  `apellido_emp` varchar(30) NOT NULL,
  `fecha_inicio` date DEFAULT curdate(),
  `fecha_fin` date DEFAULT NULL,
  `rol` varchar(30) NOT NULL,
  `estado` varchar(10) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `usuario`, `contraseña`, `correo`, `cedula`, `respuesta`, `nombre_emp`, `apellido_emp`, `fecha_inicio`, `fecha_fin`, `rol`, `estado`) VALUES
(1, 'emp_usuario1', '$2y$10$lgygAk4Jkrww/4Iap6MlEOneL0l2EGSojOQKmSEna7aFZxC/Djq2a', 'carlosgonzales@gmail.com', 555444333, 'harry1', 'Carlos', 'González', '2022-08-10', NULL, 'admin', 'activo'),
(2, 'emp_usuario2', '$2y$10$RtUdum1l.l2PqHwJBcfYTueVO0cAqHKiijsgcN.B3xnrB2wHeVJa6', 'sofiadiaz@gmail.com', 333222111, 'harry2', 'Sofía', 'Díaz', '2023-01-20', NULL, 'emp', 'activo'),
(3, 'emp_usuario3', '$2y$10$STPj8WcYIQHpnlTKrTew6.sC7RZ5wbbjwjleD8c10z3k50sBnGRiy', 'davidmartinez@gmail.com', 222333444, 'harry3', 'David', 'Martínez', '2022-10-05', NULL, 'emp', 'activo'),
(4, 'emp_usuario4', '$2y$10$B11K.t4kloBBIjZF6k6cdeHbw8qaU.43gwvKws0nWH3V1hfvxkpbW', 'elenalopez@gmail.com', 888777666, 'harry4', 'Elena', 'López', '2023-03-25', NULL, 'emp', 'activo'),
(5, 'emp_usuario5', '$2y$10$qXIF4PdHZi4sWVeg9YcmFeNOqr0VCxueufoEOzpuQfDJSVXsfi3gq', 'juliagomez@gmail.com', 999000111, 'harry5', 'Julia', 'Gómez', '2023-02-15', NULL, 'emp', 'activo'),
(6, 'emp_usuario6', '$2y$10$JlF9mZjp8uXCIoFx5t1DWOakEazAfiaZy/vElO3BfAO9jyjeDiQn2', 'carlosgonzales1@gmail.com', 487643, 'harry1', 'Carlos', 'González', '2022-12-10', NULL, 'emp', 'activo'),
(7, 'emp_usuario7', '$2y$10$C8gL/rCve7eVxzKZQwUcReA0jg4sV8DE0WpVnLHUq7kThlCHVMGJu', 'carlosgonzales2@gmail.com', 56387523, 'harry1', 'Carlos', 'González', '2022-02-10', NULL, 'emp', 'activo'),
(8, 'emp_usuario8', '$2y$10$c5GpqgZBaaUT4bb.UX1nJ.OD4l5RezwVZ2E609QdY3ncPQr838GYm', 'carlosgonzales3@gmail.com', 2638597, 'harry1', 'Carlos', 'González', '2022-05-10', NULL, 'emp', 'activo'),
(11, 'elprofevanegas', '$2y$10$Gcz3YT/WP2psYEHyU0wneuXpvgxWXZYb4Fu305YHICNGUGmNxY81y', 'vanegas@gmail.com', 1122338, 'lavar traqueas', 'carlos', 'vanegas', '2023-10-10', NULL, 'emp', 'activo'),
(12, 'asdasd', '$2y$10$q3SdsaYpIJ3FGZB5MzWZ7ewKyGDnwkFppfhFYRcNwTVQ.pQsHdzFe', 'prueba@gmail.com', 123123, 'harry1', 'carlos', 'vanegas', '2024-05-29', NULL, 'emp', 'activo'),
(16, 'jhonmariossss', '$2y$10$gBcLHh1gzA5BZbQ8JOEPyeDH6Ly.e9.H9ELheKkq2kAA6kd0MDgHa', 'prueba@gmail.com', 2147483647, 'amo a mi novia', 'carlos', 'vanegas', '2024-05-29', NULL, 'emp', 'activo');

--
-- Disparadores `empleado`
--
DELIMITER $$
CREATE TRIGGER `respaldo_empleados` BEFORE DELETE ON `empleado` FOR EACH ROW BEGIN
	
    DELETE FROM multa
    WHERE multa.id_empleado_presta = OLD.id_empleado;
    
    DELETE FROM prestamo
    WHERE prestamo.id_empleado_presta = OLD.id_empleado OR prestamo.id_empleado_recibe = OLD.id_empleado;
   

    INSERT INTO historial_empleados_borrados (
	id_empleado,
	usuario,
	contraseña,
	cedula,
	respuesta,
	correo,
	nombre_emp,
	apellido_emp,
	fecha_inicio,
	fecha_fin,
	rol,
	estado,
	fecha_eliminacion
    ) VALUES (
	OLD.id_empleado,
	OLD.usuario,
	OLD.contraseña,
	OLD.cedula,
	OLD.respuesta,
	OLD.correo,
	OLD.nombre_emp,
	OLD.apellido_emp,
	OLD.fecha_inicio,
	NOW(),
	OLD.rol,
	'INACTIVO',
	NOW()
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_clientes_eliminados`
--

CREATE TABLE `historial_clientes_eliminados` (
  `id_cliente` int(11) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `cedula` int(11) NOT NULL,
  `respuesta` varchar(45) NOT NULL,
  `nombre_usuario` varchar(30) DEFAULT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` varchar(10) DEFAULT NULL,
  `fecha_eliminacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_clientes_eliminados`
--

INSERT INTO `historial_clientes_eliminados` (`id_cliente`, `contraseña`, `correo`, `cedula`, `respuesta`, `nombre_usuario`, `fecha_inicio`, `estado`, `fecha_eliminacion`) VALUES
(10, '$2y$10$IDJjybnZhF1ZFMLNKXRaNumhXcBTwuu0t2nhcGAy.wQmKOKBt2YGm', 'asd23@gmail.com', 456788, 'harry1', 'leyton otra vez xd', '2024-05-29 01:59:42', 'INACTIVO', '2024-05-28'),
(14, '$2y$10$veabcMkfFFlZ0WOnMUZoW.KHA4vEWRqh/mS9G5JuWZlkOJrZLmduW', 'david@gmail.com', 5552524, 'exosto', 'david lozano', '2024-05-30 00:46:29', 'INACTIVO', '2024-05-30'),
(15, '$2y$10$LL9O9DRyoURsTqs8AGKSEusvzLscD8If.n4VXWBVeE9j6JCUGsUae', 'neil@udistrital.edu.co', 123456789, 'DDO', 'neil nahomi', '2024-05-30 20:32:23', 'INACTIVO', '2024-05-30'),
(16, '$2y$10$JArhRCRrc/AoDrpZy/g9auoIeRgsOtF5iwgZ.JnscNTEXzAd3Qsj2', 'jhjh@gmail.com', 475048302, 'DDO', 'carlos123', '2024-05-30 21:07:11', 'INACTIVO', '2024-05-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_empleados_borrados`
--

CREATE TABLE `historial_empleados_borrados` (
  `id_empleado` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `cedula` int(11) NOT NULL,
  `respuesta` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `nombre_emp` varchar(30) NOT NULL,
  `apellido_emp` varchar(30) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `rol` varchar(30) NOT NULL,
  `estado` varchar(10) DEFAULT 'INACTIVO',
  `fecha_eliminacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_empleados_borrados`
--

INSERT INTO `historial_empleados_borrados` (`id_empleado`, `usuario`, `contraseña`, `cedula`, `respuesta`, `correo`, `nombre_emp`, `apellido_emp`, `fecha_inicio`, `fecha_fin`, `rol`, `estado`, `fecha_eliminacion`) VALUES
(9, 'emp_usuario9', '$2y$10$7BhP2fDZHSFB2ySnSq/DFOTQ6XVkrw9yaGpqen3w.lkPtBlRERu4q', 56324, 'harry1', 'carlosgonzales4@gmail.com', 'Carlos', 'González', '2022-05-10', '2024-05-28', 'emp', 'INACTIVO', '2024-05-28'),
(13, 'pruebasdsd', '$2y$10$0pTGSgwf/WvkpFPD0FFAFOa4/.3FF4eBBp4h27CPfO0OpvC27suOS', 4597642, 'harry1', 'pruebasdasdasda@gmail.com', 'carlos', 'vanegas', '2024-05-29', '2024-05-29', 'emp', 'INACTIVO', '2024-05-29'),
(14, 'asdasdsdsds', '$2y$10$c1ExftAqd5wgKQRPySAT3O3n.whfIMgmETljgtjb/iDagxK7UcyTC', 969677, 'amo a mi novia', 'prueba@gmail.com', 'carlos', 'vanegas', '2024-05-29', '2024-05-29', 'emp', 'INACTIVO', '2024-05-29'),
(15, '66676767', '$2y$10$8mSqub32llh0o3.ImPTmMuOCgPrg3aEk.IGpf3hwRsYam5J..ndhq', 54575443, 'harry1', 'prueba@gmail.com', 'carlos', 'vanegas', '2024-05-29', '2024-05-29', 'emp', 'INACTIVO', '2024-05-29'),
(17, 'asdasdsdsd', '$2y$10$EpnNhUwv2SMt4u1QqoOFsu2KnTb3Zlx5uPb7ErCrwY3thJjwLhfO.', 1367674, 'amo a mi novia', 'jmsg@gmail.com', 'carlos', 'vanegas', '2024-05-29', '2024-05-29', 'emp', 'INACTIVO', '2024-05-29'),
(18, 'coco de limon', '$2y$10$mcq1ZPAqV/QbRsMPZuHWe.aeVdQJtyIKf4fo74jXN.E5StELLmh12', 1234567, 'coco rallado', 'coco@gmail.com', 'coco', 'cocada', '2024-05-30', '2024-05-30', 'emp', 'INACTIVO', '2024-05-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_libros_borrados`
--

CREATE TABLE `historial_libros_borrados` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(25) NOT NULL,
  `autor` varchar(30) NOT NULL,
  `sinopsis` varchar(100) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `fecha_eliminacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_libros_borrados`
--

INSERT INTO `historial_libros_borrados` (`id_libro`, `titulo`, `autor`, `sinopsis`, `stock`, `categoria`, `estado`, `fecha_eliminacion`) VALUES
(37, 'Cien años de soledad', 'Gabriel García Márquez', 'La historia de la familia Buendía en Macondo', 10, 'Ficción', 'activo', '2024-05-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_multas_borradas`
--

CREATE TABLE `historial_multas_borradas` (
  `id_multa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_prestamo` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `id_empleado_presta` int(11) NOT NULL,
  `valor` float NOT NULL,
  `fecha_pago` date NOT NULL,
  `demora` int(11) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `fecha_eliminacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_prestamos_borrados`
--

CREATE TABLE `historial_prestamos_borrados` (
  `id_prestamo` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_limite_entrega` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `id_libro` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empleado_presta` int(11) NOT NULL,
  `id_empleado_recibe` int(11) DEFAULT NULL,
  `retraso_dias` int(11) DEFAULT NULL,
  `fecha_eliminacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_prestamos_borrados`
--

INSERT INTO `historial_prestamos_borrados` (`id_prestamo`, `fecha_inicio`, `fecha_limite_entrega`, `fecha_entrega`, `id_libro`, `id_cliente`, `id_empleado_presta`, `id_empleado_recibe`, `retraso_dias`, `fecha_eliminacion`) VALUES
(11, '2024-05-10', '2024-05-18', NULL, 5, 6, 2, NULL, NULL, '2024-05-30'),
(12, '2024-05-10', '2024-05-18', NULL, 10, 5, 2, NULL, NULL, '2024-05-30'),
(13, '2024-05-10', '2024-05-18', NULL, 10, 8, 2, NULL, NULL, '2024-05-30'),
(14, '2024-04-10', '0000-00-00', NULL, 10, 2, 2, NULL, NULL, '2024-05-30'),
(15, '2024-03-10', NULL, NULL, 10, 2, 2, NULL, NULL, '2024-05-30'),
(16, '2024-03-10', '2024-03-18', NULL, 10, 2, 2, NULL, NULL, '2024-05-30'),
(17, '2024-03-10', '2024-03-18', NULL, 10, 2, 2, NULL, NULL, '2024-05-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(25) NOT NULL,
  `autor` varchar(30) NOT NULL,
  `sinopsis` varchar(100) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `estado` varchar(10) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id_libro`, `titulo`, `autor`, `sinopsis`, `stock`, `categoria`, `estado`) VALUES
(1, 'Cien años de soledad', 'Gabriel García Márquez', 'La historia de la familia Buendía en Macondo', 9, 'Ficción', 'activo'),
(2, '1984', 'George Orwell', 'Una distopía sobre un régimen totalitario', 15, 'Ciencia Ficción', 'activo'),
(3, 'El Principito', 'Antoine de Saint-Exupéry', 'Las aventuras de un joven príncipe en diferentes planetas', 21, 'Infantil', 'activo'),
(4, 'Harry Potter y la piedra ', 'J.K. Rowling', 'El inicio de las aventuras de Harry Potter en Hogwarts', 8, 'Fantasía', 'activo'),
(5, 'El Hobbit', 'J.R.R. Tolkien', 'El viaje de Bilbo Bolsón hacia la Montaña Solitaria', 12, 'Fantasía', 'activo'),
(6, 'Don Quijote de la Mancha', 'Miguel de Cervantes', 'Las aventuras de un caballero enloquecido y su fiel escudero', 20, 'Clásico', 'activo'),
(7, 'Orgullo y prejuicio', 'Jane Austen', 'Una historia de amor y clases sociales en la Inglaterra del siglo XIX', 18, 'Romance', 'activo'),
(8, 'Moby Dick', 'Herman Melville', 'La obsesiva persecución de una ballena blanca por el Capitán Ahab', 15, 'Aventura', 'activo'),
(9, 'Crimen y castigo', 'Fyodor Dostoevsky', 'La historia de un estudiante pobre que comete un asesinato y enfrenta su culpa', 12, 'Drama', 'activo'),
(10, 'La Odisea', 'Homero', 'El viaje de Ulises de regreso a casa después de la Guerra de Troya', 18, 'Clásico', 'activo'),
(11, 'Las aventuras de Tom Sawy', 'Mark Twain', 'Las travesuras de un niño en el antiguo Mississippi', 16, 'Aventura', 'activo'),
(12, 'Romeo y Julieta', 'William Shakespeare', 'Una tragedia de amor entre dos jóvenes de familias enfrentadas', 21, 'Romance', 'activo'),
(13, 'La metamorfosis', 'Franz Kafka', 'La extraña transformación de un hombre en un insecto gigante', 10, 'Ficción', 'activo'),
(14, 'El retrato de Dorian Gray', 'Oscar Wilde', 'La historia de un hombre cuya belleza no se desvanece mientras su retrato sí lo hace', 14, 'Drama', 'activo'),
(15, 'Los miserables', 'Victor Hugo', 'La historia de Jean Valjean, un exconvicto que busca redención', 23, 'Drama', 'inactivo'),
(16, 'El nombre de la rosa', 'Umberto Eco', 'Una serie de asesinatos en una abadía medieval', 9, 'Misterio', 'activo'),
(17, 'En busca del tiempo perdi', 'Marcel Proust', 'Una reflexión sobre el tiempo y la memoria', 5, 'Clásico', 'activo'),
(18, 'La Iliada', 'Homero', 'La épica historia de la Guerra de Troya', 14, 'Clásico', 'activo'),
(19, 'Ulises', 'James Joyce', 'Un día en la vida de Leopold Bloom en Dublín', 7, 'Clásico', 'activo'),
(20, 'La Divina Comedia', 'Dante Alighieri', 'El viaje de Dante a través del Infierno, el Purgatorio y el Paraíso', 11, 'Clásico', 'activo'),
(21, 'El Gran Gatsby', 'F. Scott Fitzgerald', 'La historia de Jay Gatsby y su obsesión con Daisy Buchanan', 18, 'Ficción', 'inactivo'),
(22, 'El amor en los tiempos de', 'Gabriel García Márquez', 'Una historia de amor que perdura a lo largo del tiempo', 13, 'Romance', 'activo'),
(23, 'El señor de los anillos: ', 'J.R.R. Tolkien', 'El inicio de la aventura de Frodo y sus amigos para destruir el anillo único', 25, 'Fantasía', 'activo'),
(24, 'Jane Eyre', 'Charlotte Brontë', 'La vida y amores de una huérfana que se convierte en institutriz', 15, 'Romance', 'activo'),
(25, 'Fahrenheit 451', 'Ray Bradbury', 'Un futuro donde los libros están prohibidos y son quemados', 14, 'Ciencia Ficción', 'activo'),
(26, 'Matar a un ruiseñor', 'Harper Lee', 'Un drama sobre el racismo y la injusticia en el sur de Estados Unidos', 20, 'Drama', 'activo'),
(27, 'El código Da Vinci', 'Dan Brown', 'Un thriller que combina arte, religión y conspiraciones', 17, 'Misterio', 'activo'),
(28, 'La sombra del viento', 'Carlos Ruiz Zafón', 'Un joven descubre un misterioso libro que cambiará su vida', 19, 'Ficción', 'activo'),
(29, 'El alquimista', 'Paulo Coelho', 'La aventura de un pastor en busca de un tesoro en Egipto', 22, 'Ficción', 'activo'),
(30, 'Drácula', 'Bram Stoker', 'La historia del famoso vampiro y su intento de trasladarse a Inglaterra', 16, 'Horror', 'activo'),
(31, 'Cien años de soledad 2', 'Gabriel García Márquez 2', 'La historia de la familia Buendía en Macondo 2', 8, 'Ficción', 'activo'),
(32, 'Cien años de soledad 3', 'Gabriel García Márquez 3', 'La historia de la familia Buendía en Macondo 3', 15, 'Ficción', 'activo'),
(33, 'Cien años de soledad 4', 'Gabriel García Márquez 4', 'La historia de la familia Buendía en Macondo 4', 5, 'Ficción', 'activo'),
(34, 'Cien años de soledad 5', 'Gabriel García Márquez 5', 'La historia de la familia Buendía en Macondo 5', 12, 'Ficción', 'activo'),
(35, 'Cien años de soledad 6', 'Gabriel García Márquez 6', 'La historia de la familia Buendía en Macondo 6', 6, 'Ficción', 'activo'),
(36, 'Cien años de soledad 7', 'Gabriel García Márquez 7', 'La historia de la familia Buendía en Macondo 7', 3, 'Ficción', 'activo');

--
-- Disparadores `libro`
--
DELIMITER $$
CREATE TRIGGER `respaldo_libros` BEFORE DELETE ON `libro` FOR EACH ROW BEGIN    

	DELETE FROM prestamo
	WHERE id_libro = OLD.id_libro;
	
	DELETE FROM multa
	WHERE id_libro = OLD.id_libro;

    INSERT INTO historial_libros_borrados (
	id_libro,
	titulo,
	autor,
	sinopsis,
	stock,
	categoria,
	estado,
	fecha_eliminacion
    ) VALUES (
	OLD.id_libro,
	OLD.titulo,
	OLD.autor,
	OLD.sinopsis,
	OLD.stock,
	OLD.categoria,
	OLD.estado,
	NOW()
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `movimientoslibros`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `movimientoslibros` (
`id_prestamo` int(11)
,`id_libro` int(11)
,`id_cliente` int(11)
,`id_empleado_presta` int(11)
,`id_empleado_recibe` int(11)
,`retraso_dias` int(11)
,`titulo` varchar(25)
,`autor` varchar(30)
,`sinopsis` varchar(100)
,`categoria` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multa`
--

CREATE TABLE `multa` (
  `id_multa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_prestamo` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `id_empleado_presta` int(11) NOT NULL,
  `valor` float NOT NULL,
  `fecha_pago` date NOT NULL,
  `demora` int(11) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `multa`
--

INSERT INTO `multa` (`id_multa`, `id_cliente`, `id_prestamo`, `id_libro`, `id_empleado_presta`, `valor`, `fecha_pago`, `demora`, `estado`) VALUES
(1, 1, 1, 1, 1, 2000, '2023-04-25', 5, 'PENDIENTE'),
(2, 2, 2, 2, 2, 4000, '2023-04-15', 2, 'PENDIENTE'),
(3, 3, 3, 3, 3, 4000, '2023-05-05', 10, 'PENDIENTE'),
(4, 4, 4, 4, 4, 2000, '2023-04-10', 3, 'PAGA'),
(5, 5, 5, 5, 5, 10000, '2023-03-20', 8, 'PENDIENTE'),
(6, 7, 6, 17, 2, 36000, '2024-05-29', 18, 'PENDIENTE'),
(7, 3, 3, 3, 2, 2000, '2024-05-30', 1, 'PENDIENTE');

--
-- Disparadores `multa`
--
DELIMITER $$
CREATE TRIGGER `respaldo_multas` AFTER DELETE ON `multa` FOR EACH ROW BEGIN    
    INSERT INTO historial_multas_borradas (
        id_cliente, 
        id_prestamo, 
        id_libro, 
        id_empleado_presta, 
        valor, 
        fecha_pago, 
        demora, 
        estado, 
        fecha_eliminacion
    ) VALUES (
        OLD.id_cliente,          
        OLD.id_prestamo,         
        OLD.id_libro,            
        OLD.id_empleado_presta,  
        OLD.valor,
        OLD.fecha_pago,                   
        OLD.demora,         
        OLD.estado, 
        NOW()
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id_prestamo` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_limite_entrega` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `id_libro` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empleado_presta` int(11) NOT NULL,
  `id_empleado_recibe` int(11) DEFAULT NULL,
  `retraso_dias` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`id_prestamo`, `fecha_inicio`, `fecha_limite_entrega`, `fecha_entrega`, `id_libro`, `id_cliente`, `id_empleado_presta`, `id_empleado_recibe`, `retraso_dias`) VALUES
(1, '2023-04-05', '2023-04-13', '2023-04-20', 1, 1, 1, NULL, NULL),
(2, '2023-04-05', '2023-04-13', '2023-04-20', 2, 2, 2, NULL, NULL),
(3, '2023-04-10', '2023-04-18', '2023-04-19', 3, 3, 2, 3, 1),
(4, '2023-03-15', '2023-03-23', '2023-03-30', 1, 4, 3, NULL, NULL),
(5, '2023-02-25', '2023-03-05', '2023-03-12', 5, 3, 4, NULL, NULL),
(6, '2024-05-01', '2024-05-08', '2024-05-26', 17, 7, 2, 2, 18),
(18, '2024-05-10', '2024-05-18', '2024-05-18', 20, 5, 4, 2, 0),
(19, '2024-05-10', '2024-05-18', '2023-05-20', 15, 1, 3, 3, -364),
(20, '2024-05-10', '2024-05-18', NULL, 1, 3, 3, NULL, NULL);

--
-- Disparadores `prestamo`
--
DELIMITER $$
CREATE TRIGGER `respaldo_prestamos` BEFORE DELETE ON `prestamo` FOR EACH ROW BEGIN
	
	DELETE FROM multa
	WHERE id_prestamo = OLD.id_prestamo;    

        INSERT INTO historial_prestamos_borrados ( 
        id_prestamo,
	fecha_inicio,
	fecha_limite_entrega,
	fecha_entrega,
        id_libro,
        id_cliente, 
        id_empleado_presta, 
	id_empleado_recibe,
	retraso_dias,
	fecha_eliminacion
    ) VALUES (
        OLD.id_prestamo,
	OLD.fecha_inicio,
	OLD.fecha_limite_entrega,
	OLD.fecha_entrega,
        OLD.id_libro,
        OLD.id_cliente, 
        OLD.id_empleado_presta, 
	OLD.id_empleado_recibe,
	OLD.retraso_dias,
	NOW()	
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validar_retraso_dias` AFTER UPDATE ON `prestamo` FOR EACH ROW BEGIN
    IF NEW.retraso_dias > 0 THEN
        INSERT INTO multa (id_cliente, id_prestamo, id_libro, id_empleado_presta, valor, fecha_pago, demora, estado)
        VALUES (
            NEW.id_cliente,          
            NEW.id_prestamo,         
            NEW.id_libro,            
            NEW.id_empleado_presta,  
            NEW.retraso_dias * 2000, 
            NOW(),                   
            NEW.retraso_dias,         
	    'PENDIENTE'
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura para la vista `movimientoslibros`
--
DROP TABLE IF EXISTS `movimientoslibros`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `movimientoslibros`  AS SELECT `prestamo`.`id_prestamo` AS `id_prestamo`, `libro`.`id_libro` AS `id_libro`, `cliente`.`id_cliente` AS `id_cliente`, `prestamo`.`id_empleado_presta` AS `id_empleado_presta`, `prestamo`.`id_empleado_recibe` AS `id_empleado_recibe`, `prestamo`.`retraso_dias` AS `retraso_dias`, `libro`.`titulo` AS `titulo`, `libro`.`autor` AS `autor`, `libro`.`sinopsis` AS `sinopsis`, `libro`.`categoria` AS `categoria` FROM (((`prestamo` join `libro` on(`prestamo`.`id_libro` = `libro`.`id_libro`)) join `cliente` on(`prestamo`.`id_cliente` = `cliente`.`id_cliente`)) join `empleado` on(`prestamo`.`id_empleado_presta` = `empleado`.`id_empleado`))  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `historial_clientes_eliminados`
--
ALTER TABLE `historial_clientes_eliminados`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `historial_empleados_borrados`
--
ALTER TABLE `historial_empleados_borrados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `historial_libros_borrados`
--
ALTER TABLE `historial_libros_borrados`
  ADD PRIMARY KEY (`id_libro`);

--
-- Indices de la tabla `historial_multas_borradas`
--
ALTER TABLE `historial_multas_borradas`
  ADD PRIMARY KEY (`id_multa`);

--
-- Indices de la tabla `historial_prestamos_borrados`
--
ALTER TABLE `historial_prestamos_borrados`
  ADD PRIMARY KEY (`id_prestamo`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id_libro`);

--
-- Indices de la tabla `multa`
--
ALTER TABLE `multa`
  ADD PRIMARY KEY (`id_multa`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_prestamo` (`id_prestamo`),
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_empleado_presta` (`id_empleado_presta`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id_prestamo`,`id_libro`,`id_cliente`,`id_empleado_presta`),
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_empleado_presta` (`id_empleado_presta`),
  ADD KEY `id_empleado_recibe` (`id_empleado_recibe`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `historial_clientes_eliminados`
--
ALTER TABLE `historial_clientes_eliminados`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `historial_multas_borradas`
--
ALTER TABLE `historial_multas_borradas`
  MODIFY `id_multa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_prestamos_borrados`
--
ALTER TABLE `historial_prestamos_borrados`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `multa`
--
ALTER TABLE `multa`
  MODIFY `id_multa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `multa`
--
ALTER TABLE `multa`
  ADD CONSTRAINT `multa_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `multa_ibfk_2` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamo` (`id_prestamo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `multa_ibfk_3` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `multa_ibfk_4` FOREIGN KEY (`id_empleado_presta`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`),
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `prestamo_ibfk_3` FOREIGN KEY (`id_empleado_presta`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `prestamo_ibfk_4` FOREIGN KEY (`id_empleado_recibe`) REFERENCES `empleado` (`id_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
