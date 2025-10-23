-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2025 a las 20:15:59
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
-- Base de datos: `aluvid_proyect`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aberturas`
--

CREATE TABLE `aberturas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(35) NOT NULL,
  `imagen` varchar(35) NOT NULL,
  `base` decimal(10,2) NOT NULL,
  `altura` decimal(10,2) NOT NULL,
  `divisiones` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aberturas`
--

INSERT INTO `aberturas` (`id`, `descripcion`, `imagen`, `base`, `altura`, `divisiones`) VALUES
(1, 'CORREDIZA DOS HOJAS', 'images/c2.png', 1500.00, 1500.00, 2),
(2, 'CORREDIZA TRES HOJAS', 'images/c3.png', 0.00, 0.00, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abertura_componentes_aluminio`
--

CREATE TABLE `abertura_componentes_aluminio` (
  `id` int(11) NOT NULL,
  `id_abertura` int(11) NOT NULL,
  `id_producto_aluminio` int(11) NOT NULL,
  `cantidad_producto_aluminio` int(11) DEFAULT NULL,
  `id_orientacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `abertura_componentes_aluminio`
--

INSERT INTO `abertura_componentes_aluminio` (`id`, `id_abertura`, `id_producto_aluminio`, `cantidad_producto_aluminio`, `id_orientacion`) VALUES
(1, 1, 23, 1, NULL),
(2, 1, 24, 1, NULL),
(3, 1, 28, 2, NULL),
(4, 1, 25, 2, NULL),
(5, 1, 27, 2, NULL),
(6, 1, 26, 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abertura_componentes_herrajes`
--

CREATE TABLE `abertura_componentes_herrajes` (
  `id_abertura` int(11) NOT NULL,
  `id_producto_herrajes` int(11) NOT NULL,
  `cantidad_producto_herrajes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `abertura_componentes_herrajes`
--

INSERT INTO `abertura_componentes_herrajes` (`id_abertura`, `id_producto_herrajes`, `cantidad_producto_herrajes`) VALUES
(1, 2, 3),
(1, 12, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_productos`
--

CREATE TABLE `categorias_productos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_productos`
--

INSERT INTO `categorias_productos` (`id`, `descripcion`) VALUES
(1, 'Aluminio'),
(2, 'Herrajes'),
(3, 'Vidrio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_herrajes`
--

CREATE TABLE `categoria_herrajes` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria_herrajes`
--

INSERT INTO `categoria_herrajes` (`id`, `descripcion`) VALUES
(1, 'lineal'),
(2, 'lineal perimetral'),
(3, 'unidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

CREATE TABLE `lineas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `categoria` enum('3','2','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lineas`
--

INSERT INTO `lineas` (`id`, `descripcion`, `categoria`) VALUES
(1, 'Línea española', '3'),
(2, 'Línea nacional', '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_08_004602_create_notifications_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('045aca9f-c64b-4a7a-bd70-dd9f3bcc00df', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":82,\"fecha\":\"2025-09-22 14:23:29\"}', '2025-09-24 07:15:34', '2025-09-22 20:23:29', '2025-09-24 07:15:34'),
('093047bb-cef7-4659-8346-eb5474a08960', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":59,\"fecha\":\"2025-07-08 01:09:36\"}', '2025-07-08 07:09:43', '2025-07-08 07:09:36', '2025-07-08 07:09:43'),
('096b0052-6fd5-444c-8dc3-859eb85404e1', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":4,\"fecha\":\"2025-10-08 03:47:11\"}', NULL, '2025-10-08 09:47:11', '2025-10-08 09:47:11'),
('097b8aec-ec51-4337-a970-e1591fee134e', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":62,\"fecha\":\"2025-07-08 01:16:45\"}', '2025-07-08 07:17:12', '2025-07-08 07:16:45', '2025-07-08 07:17:12'),
('0a8ecb18-4245-4f33-9504-fb9b2fe99d92', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"categoria\":\"Aluminios\",\"fecha\":\"2025-07-08 04:00:42\",\"producto\":\"MOLDURA\"}', '2025-07-08 10:01:21', '2025-07-08 10:00:42', '2025-07-08 10:01:21'),
('114e440e-5b15-4e06-9de5-9d91b145ff64', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":6,\"fecha\":\"2025-10-08 03:25:09\"}', NULL, '2025-10-08 09:25:09', '2025-10-08 09:25:09'),
('12bbec82-33e4-4f2d-8520-609c28bf53db', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":83,\"fecha\":\"2025-09-22 14:33:29\"}', '2025-09-24 07:15:36', '2025-09-22 20:33:29', '2025-09-24 07:15:36'),
('131e5e4f-c786-4d54-8bc2-512cbaa9b725', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"MOLDURA\",\"fecha\":\"2025-07-08 03:40:35\"}', '2025-07-08 09:40:43', '2025-07-08 09:40:35', '2025-07-08 09:40:43'),
('145b6595-768c-49a9-bf6a-f5be0575a72a', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":12,\"fecha\":\"2025-10-08 03:00:54\"}', NULL, '2025-10-08 09:00:54', '2025-10-08 09:00:54'),
('147899fe-638b-4707-8e52-21d137156c9b', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":91,\"fecha\":\"2025-09-30 04:03:21\"}', '2025-10-06 20:43:38', '2025-09-30 10:03:21', '2025-10-06 20:43:38'),
('1677f0b2-673a-4fb4-9250-ef13242447ba', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"categoria\":\"Vidrios\",\"fecha\":\"2025-07-11 16:40:52\",\"tonalidad\":\"FILTRASOL\",\"mm\":3}', '2025-07-11 22:42:08', '2025-07-11 22:40:52', '2025-07-11 22:42:08'),
('16df2100-6ebe-4d56-b059-75c79e591482', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"categoria\":\"Herrajes\",\"fecha\":\"2025-07-11 16:39:43\",\"producto\":\"ESCUADRA FIJO SERIE 3500 CENT.\"}', '2025-07-11 22:42:20', '2025-07-11 22:39:43', '2025-07-11 22:42:20'),
('1792e94f-68cc-4efa-8b27-0c829049572b', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":14,\"fecha\":\"2025-10-08 03:03:53\"}', NULL, '2025-10-08 09:03:53', '2025-10-08 09:03:53'),
('1af274d0-d5f5-4df3-9533-278c80bcbf5b', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":8,\"fecha\":\"2025-10-23 17:39:25\"}', NULL, '2025-10-23 23:39:25', '2025-10-23 23:39:25'),
('1d16aa41-db2a-402f-9246-c7593f0b4951', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":86,\"fecha\":\"2025-09-27 21:23:53\"}', '2025-09-28 03:27:28', '2025-09-28 03:23:53', '2025-09-28 03:27:28'),
('1ecd811f-7024-4277-8b01-3eceb0a2759f', 'App\\Notifications\\Inventario', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"MOLDURA\",\"fecha\":\"2025-07-08 03:25:41\"}', NULL, '2025-07-08 09:25:41', '2025-07-08 09:25:41'),
('20cd444b-85d9-444d-abf1-1726e90aed6d', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":4,\"fecha\":\"2025-10-08 04:06:51\"}', NULL, '2025-10-08 10:06:51', '2025-10-08 10:06:51'),
('2449c74c-981b-4238-aa1a-baebde868eec', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":57,\"fecha\":\"2025-07-08 01:05:40\"}', '2025-07-08 07:08:35', '2025-07-08 07:05:40', '2025-07-08 07:08:35'),
('26dd868e-21d4-4372-b28f-55aee9a22127', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"categoria\":\"Herrajes\",\"fecha\":\"2025-07-08 04:01:06\",\"producto\":\"ESCUADRA FIJO SERIE 3500 CENT.\"}', '2025-07-08 10:01:19', '2025-07-08 10:01:06', '2025-07-08 10:01:19'),
('2a00feba-16f4-447b-9c77-62617b42824a', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":3,\"fecha\":\"2025-10-08 03:46:14\"}', NULL, '2025-10-08 09:46:14', '2025-10-08 09:46:14'),
('2b4208de-ba04-4cab-a0eb-230477408c92', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":6,\"fecha\":\"2025-09-30 05:18:19\"}', '2025-10-06 20:43:44', '2025-09-30 11:18:19', '2025-10-06 20:43:44'),
('2bd8d5b2-f424-45e8-a6c7-d0835d540a06', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":78,\"fecha\":\"2025-07-08 03:16:20\"}', '2025-07-08 09:22:57', '2025-07-08 09:16:20', '2025-07-08 09:22:57'),
('2ef995e0-9c0c-4d9d-9da7-40a7df644470', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":5,\"fecha\":\"2025-10-08 03:24:39\"}', NULL, '2025-10-08 09:24:39', '2025-10-08 09:24:39'),
('32adb71c-35b1-4ac3-8f0b-a352890f062d', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":1,\"fecha\":\"2025-10-08 03:44:28\"}', NULL, '2025-10-08 09:44:28', '2025-10-08 09:44:28'),
('33a6d7e1-41f8-48cd-8853-e9b3df89200f', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":64,\"fecha\":\"2025-07-08 01:20:50\"}', '2025-07-08 07:21:12', '2025-07-08 07:20:50', '2025-07-08 07:21:12'),
('3d283d36-1eda-4cf5-b11c-fd8beece4c66', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":4,\"fecha\":\"2025-09-30 04:38:40\"}', '2025-10-06 20:43:48', '2025-09-30 10:38:40', '2025-10-06 20:43:48'),
('3d738470-23ba-45c3-9895-9ab60b8f99ed', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":70,\"fecha\":\"2025-07-08 01:41:36\"}', '2025-07-08 07:41:50', '2025-07-08 07:41:36', '2025-07-08 07:41:50'),
('3ffc57b9-cea8-48bc-88c0-20535e6e9172', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":5,\"fecha\":\"2025-10-08 04:07:23\"}', NULL, '2025-10-08 10:07:23', '2025-10-08 10:07:23'),
('446fa131-978a-495d-b743-2d2d1e9bc477', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":1,\"fecha\":\"2025-10-08 04:03:44\"}', NULL, '2025-10-08 10:03:44', '2025-10-08 10:03:44'),
('448e1f46-77c6-42b4-ad55-a32d540cdbe2', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"categoria\":\"Vidrios\",\"fecha\":\"2025-07-11 16:40:36\",\"tonalidad\":\"FILTRASOL\",\"mm\":3}', '2025-07-11 22:42:18', '2025-07-11 22:40:36', '2025-07-11 22:42:18'),
('54ccb339-48ed-4f4c-ae2c-0e6008ded68a', 'App\\Notifications\\Inventario', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"MOLDURA\",\"fecha\":\"2025-07-08 02:44:29\"}', '2025-07-08 09:04:50', '2025-07-08 08:44:29', '2025-07-08 09:04:50'),
('55e7fa68-a427-43a6-96a6-b4afa14326dd', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"categoria\":\"Aluminios\",\"fecha\":\"2025-07-11 16:38:28\",\"producto\":\"MOLDURA\"}', '2025-07-11 22:38:43', '2025-07-11 22:38:28', '2025-07-11 22:38:43'),
('57d7db4e-3c4a-4f93-afce-db86655b4594', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":13,\"fecha\":\"2025-10-08 03:03:06\"}', NULL, '2025-10-08 09:03:06', '2025-10-08 09:03:06'),
('5d062103-b25e-4ceb-b0fc-1fe3b0427ddc', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":66,\"fecha\":\"2025-07-08 01:27:13\"}', '2025-07-08 07:27:19', '2025-07-08 07:27:13', '2025-07-08 07:27:19'),
('5e50c2d9-a832-4bef-bbeb-c40593f9e71d', 'App\\Notifications\\Inventario', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"MOLDURA\",\"fecha\":\"2025-07-08 03:21:19\"}', NULL, '2025-07-08 09:21:19', '2025-07-08 09:21:19'),
('5e93e25e-e0ae-49af-85fb-68e93a597571', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":6,\"fecha\":\"2025-10-08 04:13:22\"}', NULL, '2025-10-08 10:13:22', '2025-10-08 10:13:22'),
('6282c017-cfd4-4f3b-b01d-5e9bb890437f', 'App\\Notifications\\Inventario', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto_id\":252,\"nombre\":\"Producto desconocido\",\"fecha\":\"2025-07-08 02:34:48\"}', '2025-07-08 09:04:44', '2025-07-08 08:34:48', '2025-07-08 09:04:44'),
('6a5bf877-0d5b-4446-8eb9-f1c9352c2002', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":85,\"fecha\":\"2025-09-27 21:21:27\"}', '2025-09-28 03:27:32', '2025-09-28 03:21:27', '2025-09-28 03:27:32'),
('6cac80c0-ce73-40f1-b3c2-d055ada0a0d6', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":61,\"fecha\":\"2025-07-08 01:16:31\"}', '2025-07-08 07:17:07', '2025-07-08 07:16:31', '2025-07-08 07:17:07'),
('70af8e4d-fea6-492f-87e6-5c56081bf1c9', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"categoria\":\"Herrajes\",\"fecha\":\"2025-07-11 16:40:08\",\"producto\":\"ESCUADRA FIJO SERIE 3500 CENT.\"}', '2025-07-11 22:42:23', '2025-07-11 22:40:08', '2025-07-11 22:42:23'),
('746b1d65-70c5-452c-87d3-f670a8134191', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":55,\"fecha\":\"2025-07-08 01:04:33\"}', '2025-07-08 07:05:07', '2025-07-08 07:04:33', '2025-07-08 07:05:07'),
('7745ab6d-5a1a-4676-b56f-2d9cc680db5a', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":8,\"fecha\":\"2025-09-30 05:21:27\"}', '2025-10-06 20:43:34', '2025-09-30 11:21:27', '2025-10-06 20:43:34'),
('82f71154-fdd8-4e4d-8ddd-b22fa75f87c2', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":7,\"fecha\":\"2025-10-08 04:14:51\"}', NULL, '2025-10-08 10:14:51', '2025-10-08 10:14:51'),
('88493cd0-51c4-407b-bebf-ac3908b2aca4', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":56,\"fecha\":\"2025-07-08 01:04:57\"}', '2025-07-08 07:05:07', '2025-07-08 07:04:57', '2025-07-08 07:05:07'),
('8dcb7188-37f4-487d-9f78-1efdecb74662', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":4,\"fecha\":\"2025-10-08 03:23:11\"}', NULL, '2025-10-08 09:23:11', '2025-10-08 09:23:11'),
('8f6e6d3b-67a3-469e-88b8-b04775195ac7', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":54,\"fecha\":\"2025-07-08 01:03:51\"}', '2025-07-08 07:04:07', '2025-07-08 07:03:51', '2025-07-08 07:04:07'),
('98308682-e472-4f6b-b54c-c2c4edefa7ce', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":5,\"fecha\":\"2025-10-08 03:48:01\"}', NULL, '2025-10-08 09:48:01', '2025-10-08 09:48:01'),
('9868bef9-5491-4a8c-b97e-bba2ad989085', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":65,\"fecha\":\"2025-07-08 01:25:37\"}', '2025-07-08 07:25:44', '2025-07-08 07:25:37', '2025-07-08 07:25:44'),
('99205b35-4c23-483b-be8a-644f32dae26c', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"ESCUADRA FIJO SERIE 3500 CENT.\",\"fecha\":\"2025-07-08 03:43:14\"}', '2025-07-08 09:49:30', '2025-07-08 09:43:14', '2025-07-08 09:49:30'),
('99713d35-e711-4020-8f2b-35ad167b468f', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":68,\"fecha\":\"2025-07-08 01:38:23\"}', '2025-07-08 07:38:32', '2025-07-08 07:38:23', '2025-07-08 07:38:32'),
('99a29f19-e534-4cd2-bdec-5629df5538fd', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":80,\"fecha\":\"2025-07-08 03:39:55\"}', '2025-07-08 09:40:06', '2025-07-08 09:39:55', '2025-07-08 09:40:06'),
('9a47d169-7159-4cd7-8b20-88c81f987ac9', 'App\\Notifications\\Inventario', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto_id\":252,\"nombre\":\"Producto desconocido\",\"dashboard\":\"inventario\",\"fecha\":\"2025-07-08 02:25:16\"}', '2025-07-08 09:05:05', '2025-07-08 08:25:16', '2025-07-08 09:05:05'),
('9c742821-07b3-4651-9928-02e5aa93a0ad', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":67,\"fecha\":\"2025-07-08 01:37:59\"}', '2025-07-08 07:38:32', '2025-07-08 07:37:59', '2025-07-08 07:38:32'),
('9c75d858-b7fe-4c94-8157-8f066ab9f623', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"categoria\":\"Vidrios\",\"fecha\":\"2025-07-08 04:00:02\",\"tonalidad\":\"FILTRASOL\",\"mm\":3}', '2025-07-08 10:01:22', '2025-07-08 10:00:02', '2025-07-08 10:01:22'),
('a9e7804b-27d7-4350-95a1-d6523861bcf7', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":75,\"fecha\":\"2025-07-08 01:56:31\"}', '2025-07-08 07:56:39', '2025-07-08 07:56:31', '2025-07-08 07:56:39'),
('acd04cd5-7ce1-4457-bd7f-045bd77721c2', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":63,\"fecha\":\"2025-07-08 01:20:23\"}', '2025-07-08 07:21:02', '2025-07-08 07:20:23', '2025-07-08 07:21:02'),
('af74b48d-fa60-4f1e-8974-22ba9e14bdcb', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":76,\"fecha\":\"2025-07-08 01:58:25\"}', '2025-07-08 07:58:32', '2025-07-08 07:58:25', '2025-07-08 07:58:32'),
('b0431223-dbe4-4655-889b-e30015611cb4', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":11,\"fecha\":\"2025-10-08 02:55:59\"}', NULL, '2025-10-08 08:55:59', '2025-10-08 08:55:59'),
('b36211d3-3394-45c2-b10e-d6c4a4150e3b', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":71,\"fecha\":\"2025-07-08 01:43:16\"}', '2025-07-08 07:43:25', '2025-07-08 07:43:16', '2025-07-08 07:43:25'),
('b592ff16-a371-47c9-be67-d6c8b8cb36d3', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":2,\"fecha\":\"2025-10-08 03:32:04\"}', NULL, '2025-10-08 09:32:04', '2025-10-08 09:32:04'),
('b62a21ff-0bca-4820-9537-5b4250149857', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":87,\"fecha\":\"2025-09-27 21:26:08\"}', '2025-09-28 03:27:27', '2025-09-28 03:26:08', '2025-09-28 03:27:27'),
('b828ace2-4fe4-4015-81c1-484048a5b954', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":3,\"fecha\":\"2025-10-08 03:32:47\"}', NULL, '2025-10-08 09:32:47', '2025-10-08 09:32:47'),
('b9224fbb-5c8f-444c-acf2-98a8c980f43e', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":9,\"fecha\":\"2025-09-30 05:36:46\"}', '2025-10-06 20:43:29', '2025-09-30 11:36:46', '2025-10-06 20:43:29'),
('ba86d984-722b-4c1e-a52e-2546b8dcf34a', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":3,\"fecha\":\"2025-09-30 04:17:08\"}', '2025-10-06 20:43:50', '2025-09-30 10:17:08', '2025-10-06 20:43:50'),
('bb15293a-babc-474b-8f4a-f2995b03b163', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":81,\"fecha\":\"2025-07-11 16:37:44\"}', '2025-07-11 22:38:10', '2025-07-11 22:37:44', '2025-07-11 22:38:10'),
('bd00ce3f-bc63-41cb-93c3-0de971b789ed', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":2,\"fecha\":\"2025-10-08 03:45:15\"}', NULL, '2025-10-08 09:45:15', '2025-10-08 09:45:15'),
('bda7b5cc-6598-4cee-97d5-f8d824c75680', 'App\\Notifications\\Inventario', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"MOLDURA\",\"fecha\":\"2025-07-08 03:06:30\"}', NULL, '2025-07-08 09:06:30', '2025-07-08 09:06:30'),
('bed5ce16-6e05-46c3-9a4d-4c2bb9db60e3', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"ESCUADRA FIJO SERIE 3500 CENT.\",\"categoria\":\"Herrajes\",\"fecha\":\"2025-07-08 03:49:41\"}', '2025-07-08 09:49:53', '2025-07-08 09:49:41', '2025-07-08 09:49:53'),
('bf02f237-0078-4c93-af6b-495d8f47e876', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":4,\"fecha\":\"2025-10-08 03:34:58\"}', NULL, '2025-10-08 09:34:58', '2025-10-08 09:34:58'),
('c06ff68b-dcd2-4124-a8f8-a3d6c64ae6a9', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":72,\"fecha\":\"2025-07-08 01:46:01\"}', '2025-07-08 07:46:08', '2025-07-08 07:46:01', '2025-07-08 07:46:08'),
('c2237c0b-7df7-4895-8bce-d9314b93cf53', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":3,\"fecha\":\"2025-10-08 03:22:38\"}', NULL, '2025-10-08 09:22:38', '2025-10-08 09:22:38'),
('c7a8ce03-f28b-45cf-96f5-4aaf27c79700', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":58,\"fecha\":\"2025-07-08 01:08:57\"}', '2025-07-08 07:09:07', '2025-07-08 07:08:57', '2025-07-08 07:09:07'),
('cbe23384-3af2-4e4b-bad2-3a8ec1519ee0', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":84,\"fecha\":\"2025-09-24 02:34:40\"}', '2025-09-24 08:53:24', '2025-09-24 08:34:40', '2025-09-24 08:53:24'),
('ccf59e9a-0eec-4629-9f7c-9c71f6f15095', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":5,\"fecha\":\"2025-09-30 05:04:08\"}', '2025-10-06 20:43:41', '2025-09-30 11:04:08', '2025-10-06 20:43:41'),
('cf013342-acdb-48b7-9d4d-02a1257ca2d3', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":89,\"fecha\":\"2025-09-29 20:05:02\"}', '2025-09-30 02:05:41', '2025-09-30 02:05:02', '2025-09-30 02:05:41'),
('d3e71e04-4e56-460c-b933-316e3d81b81e', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":53,\"fecha\":\"2025-07-08 00:51:15\"}', '2025-07-08 07:02:55', '2025-07-08 06:51:15', '2025-07-08 07:02:55'),
('d4b42fcd-99c3-4cdb-859e-39b0cb9e963a', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":88,\"fecha\":\"2025-09-28 02:57:52\"}', '2025-09-28 12:44:45', '2025-09-28 08:57:52', '2025-09-28 12:44:45'),
('d68a8c76-ff09-48f6-b2b9-201b6767e446', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":2,\"fecha\":\"2025-09-30 04:12:34\"}', '2025-10-06 20:43:53', '2025-09-30 10:12:34', '2025-10-06 20:43:53'),
('d8847bc2-40a2-4a6a-9a5c-2a1468cd1e2f', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":1,\"fecha\":\"2025-10-08 03:20:02\"}', NULL, '2025-10-08 09:20:02', '2025-10-08 09:20:02'),
('d9f44717-0f84-4428-90f0-cb1d58160ffc', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":74,\"fecha\":\"2025-07-08 01:51:52\"}', '2025-07-08 07:52:04', '2025-07-08 07:51:52', '2025-07-08 07:52:04'),
('dcafec18-a134-48f3-baf1-0ea072234e9a', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":10,\"fecha\":\"2025-10-06 14:45:09\"}', '2025-10-06 20:45:24', '2025-10-06 20:45:09', '2025-10-06 20:45:24'),
('e8577a5b-b33f-4bdd-b8f4-94413f06c8e4', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":69,\"fecha\":\"2025-07-08 01:41:20\"}', '2025-07-08 07:41:46', '2025-07-08 07:41:20', '2025-07-08 07:41:46'),
('f25fb44e-ee27-497c-82b2-befe16a89757', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":2,\"fecha\":\"2025-10-08 03:21:52\"}', NULL, '2025-10-08 09:21:52', '2025-10-08 09:21:52'),
('f2e54b04-14ad-4ab9-9a3c-b75f2ce489de', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":1,\"fecha\":\"2025-09-30 04:06:43\"}', '2025-10-06 20:43:55', '2025-09-30 10:06:43', '2025-10-06 20:43:55'),
('f337d549-04d8-4d2b-bb0a-99761bac9a9b', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":90,\"fecha\":\"2025-09-30 03:59:44\"}', '2025-10-06 20:43:57', '2025-09-30 09:59:44', '2025-10-06 20:43:57'),
('f3bfa337-a00e-47a0-bd58-19f0584a6623', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":1,\"fecha\":\"2025-10-08 03:31:33\"}', NULL, '2025-10-08 09:31:33', '2025-10-08 09:31:33'),
('f57f482e-6e62-4c02-baf7-4cea16cee70f', 'App\\Notifications\\Inventario', 'App\\Models\\User', 2, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"MOLDURA\",\"fecha\":\"2025-07-08 03:34:54\"}', '2025-07-08 09:35:26', '2025-07-08 09:34:54', '2025-07-08 09:35:26'),
('f64135b6-42ba-4628-99ff-58c932ac00f4', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":77,\"fecha\":\"2025-07-08 03:05:52\"}', '2025-07-08 09:06:08', '2025-07-08 09:05:52', '2025-07-08 09:06:08'),
('f93a69fc-aee5-48de-9d08-464221f29233', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":7,\"fecha\":\"2025-09-30 05:19:55\"}', '2025-10-06 20:43:31', '2025-09-30 11:19:55', '2025-10-06 20:43:31'),
('f9917aac-3d61-476c-b75a-87ee1e40ce08', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":79,\"fecha\":\"2025-07-08 03:39:32\"}', '2025-07-08 09:40:03', '2025-07-08 09:39:32', '2025-07-08 09:40:03'),
('fb9b310e-c609-4c9d-9fbd-849434d13ccb', 'App\\Notifications\\Inventario', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha actualizado el inventario\",\"producto\":\"MOLDURA\",\"fecha\":\"2025-07-08 02:59:50\"}', '2025-07-08 09:04:48', '2025-07-08 08:59:50', '2025-07-08 09:04:48'),
('fc33a77d-aee0-4c2e-8481-ce1e2263623d', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":3,\"fecha\":\"2025-10-08 04:05:23\"}', NULL, '2025-10-08 10:05:23', '2025-10-08 10:05:23'),
('fcf77dd5-5f23-47c8-9fdf-9634c1a67593', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":60,\"fecha\":\"2025-07-08 01:15:50\"}', '2025-07-08 07:16:03', '2025-07-08 07:15:50', '2025-07-08 07:16:03'),
('fd6a9b27-325d-47ac-b990-a44ab9afe040', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":6,\"fecha\":\"2025-10-08 03:48:39\"}', NULL, '2025-10-08 09:48:39', '2025-10-08 09:48:39'),
('fd85d2c8-985f-473a-a232-b198a32e2d56', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":2,\"fecha\":\"2025-10-08 04:04:24\"}', NULL, '2025-10-08 10:04:24', '2025-10-08 10:04:24'),
('ffe1c345-993d-41b5-95d0-10cd9880a4a1', 'App\\Notifications\\NuevaVenta', 'App\\Models\\User', 1, '{\"mensaje\":\"Se ha registrado una nueva venta\",\"folio\":73,\"fecha\":\"2025-07-08 01:48:45\"}', '2025-07-08 07:48:51', '2025-07-08 07:48:45', '2025-07-08 07:48:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orientacion`
--

CREATE TABLE `orientacion` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orientacion`
--

INSERT INTO `orientacion` (`id`, `descripcion`) VALUES
(1, 'vertical'),
(2, 'horizontal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `porcentaje_precios`
--

CREATE TABLE `porcentaje_precios` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(15) NOT NULL,
  `porcentaje` int(11) NOT NULL,
  `monto` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `porcentaje_precios`
--

INSERT INTO `porcentaje_precios` (`id`, `descripcion`, `porcentaje`, `monto`) VALUES
(1, 'Compra alta', 15, 50000.00),
(2, 'Compra media', 10, 25000.00),
(3, 'Compra baja', 0, 5000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_aluminio`
--

CREATE TABLE `precios_aluminio` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_compra_pieza` decimal(10,2) DEFAULT NULL,
  `precio_venta_pieza` decimal(10,2) GENERATED ALWAYS AS (`precio_compra_pieza` * 1.15) VIRTUAL,
  `precio_compra_metro` decimal(10,2) GENERATED ALWAYS AS (`precio_compra_pieza` / 6) VIRTUAL,
  `precio_venta_metro` decimal(10,2) GENERATED ALWAYS AS (`precio_compra_metro` * 2) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `precios_aluminio`
--

INSERT INTO `precios_aluminio` (`id`, `id_producto`, `precio_compra_pieza`) VALUES
(79, 23, 1200.00),
(80, 24, 1500.00),
(81, 25, 2000.00),
(82, 26, NULL),
(83, 27, NULL),
(84, 28, NULL),
(85, 29, NULL),
(86, 30, NULL),
(87, 31, NULL),
(88, 32, NULL),
(89, 33, NULL),
(90, 34, NULL),
(91, 35, NULL),
(92, 36, NULL),
(93, 37, NULL),
(94, 38, NULL),
(95, 39, NULL),
(96, 40, NULL),
(97, 41, NULL),
(98, 42, NULL),
(99, 43, NULL),
(100, 44, NULL),
(101, 45, NULL),
(102, 46, NULL),
(103, 47, NULL),
(104, 48, NULL),
(105, 49, NULL),
(106, 50, NULL),
(107, 51, NULL),
(108, 52, NULL),
(109, 53, NULL),
(110, 54, NULL),
(111, 55, NULL),
(112, 56, NULL),
(113, 57, NULL),
(114, 58, NULL),
(115, 59, NULL),
(116, 60, NULL),
(117, 61, NULL),
(118, 62, NULL),
(119, 63, NULL),
(120, 64, NULL),
(121, 65, NULL),
(122, 66, NULL),
(123, 67, NULL),
(124, 68, NULL),
(125, 69, NULL),
(126, 70, NULL),
(127, 71, NULL),
(128, 72, NULL),
(129, 74, NULL),
(130, 75, NULL),
(131, 76, NULL),
(132, 77, NULL),
(133, 78, NULL),
(134, 79, NULL),
(135, 80, NULL),
(136, 81, NULL),
(137, 82, NULL),
(138, 83, NULL),
(139, 84, NULL),
(140, 85, NULL),
(141, 86, NULL),
(142, 87, NULL),
(143, 88, NULL),
(144, 89, NULL),
(145, 92, NULL),
(146, 93, NULL),
(147, 94, NULL),
(148, 95, NULL),
(149, 96, NULL),
(150, 97, NULL),
(151, 98, NULL),
(152, 99, NULL),
(153, 100, NULL),
(154, 101, NULL),
(155, 102, NULL),
(156, 103, NULL),
(157, 104, NULL),
(158, 105, NULL),
(159, 106, NULL),
(160, 107, NULL),
(161, 108, NULL),
(162, 109, NULL),
(163, 110, NULL),
(164, 111, NULL),
(165, 112, NULL),
(166, 113, NULL),
(167, 114, NULL),
(168, 115, NULL),
(169, 116, NULL),
(170, 117, NULL),
(171, 118, NULL),
(172, 119, NULL),
(173, 120, NULL),
(174, 121, NULL),
(175, 122, NULL),
(176, 123, NULL),
(177, 124, NULL),
(178, 125, NULL),
(179, 126, NULL),
(180, 127, NULL),
(181, 128, NULL),
(182, 129, NULL),
(183, 131, NULL),
(184, 132, NULL),
(185, 133, NULL),
(186, 134, NULL),
(187, 136, NULL),
(188, 137, NULL),
(189, 138, NULL),
(190, 139, NULL),
(191, 140, NULL),
(192, 141, NULL),
(193, 142, NULL),
(194, 143, NULL),
(195, 144, NULL),
(196, 145, NULL),
(197, 146, NULL),
(198, 147, NULL),
(199, 148, NULL),
(200, 149, NULL),
(201, 150, NULL),
(202, 151, NULL),
(203, 152, NULL),
(204, 153, NULL),
(205, 154, NULL),
(206, 155, NULL),
(207, 156, NULL),
(208, 157, NULL),
(209, 158, NULL),
(210, 159, NULL),
(211, 160, NULL),
(212, 161, NULL),
(213, 162, NULL),
(214, 163, NULL),
(215, 164, NULL),
(216, 165, NULL),
(217, 166, NULL),
(218, 167, NULL),
(219, 168, NULL),
(220, 169, NULL),
(221, 170, NULL),
(222, 171, NULL),
(223, 172, NULL),
(224, 173, NULL),
(225, 174, NULL),
(226, 175, NULL),
(227, 176, NULL),
(228, 177, NULL),
(229, 178, NULL),
(230, 179, NULL),
(231, 180, NULL),
(232, 181, NULL),
(233, 182, NULL),
(234, 183, NULL),
(235, 184, NULL),
(236, 185, NULL),
(237, 186, NULL),
(238, 187, NULL),
(239, 188, NULL),
(240, 189, NULL),
(241, 190, NULL),
(242, 191, NULL),
(243, 192, NULL),
(244, 193, NULL),
(245, 194, NULL),
(246, 195, NULL),
(247, 196, NULL),
(248, 197, NULL),
(249, 198, NULL),
(250, 199, NULL),
(251, 200, NULL),
(252, 201, NULL),
(253, 202, NULL),
(254, 203, NULL),
(255, 204, NULL),
(256, 205, NULL),
(257, 206, NULL),
(258, 207, NULL),
(259, 208, NULL),
(260, 209, NULL),
(261, 210, NULL),
(262, 211, NULL),
(263, 212, NULL),
(264, 213, NULL),
(265, 214, NULL),
(266, 215, NULL),
(267, 216, NULL),
(268, 217, NULL),
(269, 218, NULL),
(270, 219, NULL),
(271, 220, NULL),
(272, 221, NULL),
(273, 222, NULL),
(274, 223, NULL),
(275, 224, NULL),
(276, 225, NULL),
(277, 226, NULL),
(278, 227, NULL),
(279, 228, NULL),
(280, 229, NULL),
(281, 230, NULL),
(282, 231, NULL),
(283, 232, NULL),
(284, 233, NULL),
(285, 234, NULL),
(286, 235, NULL),
(287, 236, NULL),
(288, 237, NULL),
(289, 238, NULL),
(290, 239, NULL),
(291, 240, NULL),
(292, 241, NULL),
(293, 242, NULL),
(294, 243, NULL),
(295, 244, NULL),
(296, 245, NULL),
(297, 246, NULL),
(298, 247, NULL),
(299, 248, NULL),
(300, 249, NULL),
(301, 250, NULL),
(302, 251, NULL),
(303, 252, 400.00),
(304, 253, NULL),
(305, 254, NULL),
(306, 255, NULL),
(307, 256, NULL),
(308, 257, NULL),
(309, 258, NULL),
(310, 259, NULL),
(311, 260, NULL),
(312, 261, NULL),
(313, 262, NULL),
(314, 263, NULL),
(315, 264, NULL),
(316, 265, NULL),
(317, 266, NULL),
(318, 267, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_herrajes`
--

CREATE TABLE `precios_herrajes` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `precio_venta` decimal(10,2) GENERATED ALWAYS AS (`precio_compra` * 1.15) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `precios_herrajes`
--

INSERT INTO `precios_herrajes` (`id`, `id_producto`, `precio_compra`) VALUES
(1, 2, 1600.00),
(2, 3, 700.00),
(3, 4, 300.00),
(4, 5, NULL),
(5, 6, NULL),
(6, 7, NULL),
(7, 8, NULL),
(8, 9, NULL),
(9, 10, NULL),
(10, 11, NULL),
(11, 12, NULL),
(12, 13, NULL),
(13, 14, NULL),
(14, 15, NULL),
(15, 16, NULL),
(16, 17, NULL),
(17, 18, NULL),
(18, 19, NULL),
(19, 20, NULL),
(20, 21, NULL),
(21, 22, NULL),
(22, 23, NULL),
(23, 24, NULL),
(24, 25, NULL),
(25, 26, NULL),
(26, 27, NULL),
(27, 28, NULL),
(28, 29, NULL),
(29, 30, NULL),
(30, 31, NULL),
(31, 32, NULL),
(32, 33, NULL),
(33, 34, NULL),
(34, 35, NULL),
(35, 36, NULL),
(36, 37, 600.00),
(37, 38, 500.00),
(38, 39, NULL),
(39, 40, NULL),
(40, 41, NULL),
(41, 42, NULL),
(42, 43, NULL),
(43, 44, NULL),
(44, 45, NULL),
(45, 46, NULL),
(46, 47, NULL),
(47, 48, NULL),
(48, 49, NULL),
(49, 50, NULL),
(50, 51, NULL),
(51, 52, NULL),
(52, 53, NULL),
(53, 54, NULL),
(54, 55, NULL),
(55, 56, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_vidrio`
--

CREATE TABLE `precios_vidrio` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_compra_hoja` decimal(10,2) DEFAULT NULL,
  `precio_venta_hoja` decimal(10,2) GENERATED ALWAYS AS (`precio_compra_hoja` * 1.15) VIRTUAL,
  `precio_compra_m2` decimal(10,2) GENERATED ALWAYS AS (`precio_compra_hoja` / 4.68) VIRTUAL,
  `precio_venta_m2` decimal(10,2) GENERATED ALWAYS AS (`precio_compra_m2` * 2) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `precios_vidrio`
--

INSERT INTO `precios_vidrio` (`id`, `id_producto`, `precio_compra_hoja`) VALUES
(1, 1, 1500.00),
(2, 2, 2000.00),
(3, 3, 1200.00),
(4, 4, NULL),
(5, 5, NULL),
(6, 6, NULL),
(7, 7, NULL),
(8, 8, NULL),
(9, 9, NULL),
(10, 10, NULL),
(11, 11, NULL),
(12, 12, NULL),
(13, 13, NULL),
(14, 14, NULL),
(15, 15, NULL),
(16, 16, NULL),
(17, 17, NULL),
(18, 18, NULL),
(19, 19, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_aluminio`
--

CREATE TABLE `productos_aluminio` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_categoria_producto` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_aluminio`
--

INSERT INTO `productos_aluminio` (`id`, `codigo`, `producto`, `imagen`, `id_tipo`, `id_categoria_producto`) VALUES
(23, '3501', 'CERCO INFERIOR', 'images/3B6DrVsdPD.png', 1, 1),
(24, '3502', 'CERCO SUPERIOR', 'images/KwG6i1uL4I.png', 1, 1),
(25, '3504', 'HOJA CENTRAL', 'images/yQ0vQWTUZg.png', 1, 1),
(26, '3507', 'HOJA DE RUEDAS', 'images/npiAESP6DB.png', 1, 1),
(27, '3505', 'HOJA LATERAL', 'images/arqJAXN6tc.png', 1, 1),
(28, '3508', 'CERCO LATERAL', 'images/z0lz4dd4Xi.png', 1, 1),
(29, '3554', 'HOJA CENTRAL DOBLE VIDRIO', 'images/bJmMmMD3sT.png', 1, 1),
(30, '3555', 'HOJA LATERAL DOBLE VIDRIO', 'images/caebdyjrGM.png', 1, 1),
(31, '3557', 'HOJA DE RUEDAS DOBLE VIDRIO', 'images/0czLuGPZUc.png', 1, 1),
(32, '3559', 'ZÓCALO', 'images/otBpKFBpf2.png', 1, 1),
(33, '3560', 'ZÓCALO DOBLE VIDRIO', 'images/3UWx5SH4gv.png', 1, 1),
(34, '3517', 'UNIÓN DE CUATRO HOJAS', 'images/HPujexdfUe.png', 1, 1),
(35, '3510', 'FIJO TUBULAR', 'images/tiGkr5AEBh.png', 1, 1),
(36, '3533', 'CLIP ADAPTADOR MOSQUITERO', 'images/8phVeIslOK.png', 1, 1),
(37, '3534', 'GUÍA MOSQUITERO', 'images/aBDJ4oMR47.png', 1, 1),
(38, '3535', 'HOJA LATERAL MOSQUITERO', 'images/dniQjoRR2q.png', 1, 1),
(39, '3537', 'MOSQUITERO CON REFUERZO', 'images/MouqlR0NZL.png', 1, 1),
(40, '3536', 'HOJA RUEDA MOSQUITERO', 'images/L8hVnKUjvU.png', 1, 1),
(41, '3518', 'ESQUINERO REGULABLE HEMBRA', 'images/fcJOczYVqb.png', 1, 1),
(42, '3519', 'ESQUINERO REGULABLE MACHO', 'images/fFKg1oT6a1.png', 1, 1),
(43, '4601', 'MARCO  PERIMETRAL', 'images/OwwBL3ZIrY.png', 2, 1),
(44, '4602', 'MARCO PERIMETRAL  TRES RIELES', 'images/VBDNhQWPpa.png', 2, 1),
(45, '4603', 'FIJO TUBULAR', 'images/k5hG6AYccv.png', 2, 1),
(46, '4613', 'FIJO TUBULAR  TRES RIELES', 'images/d33nEeOX5V.png', 2, 1),
(47, '4605', 'HOJA  PERIMETRAL', 'images/RF7KsQiYFJ.png', 2, 1),
(48, '4615', 'HOJA PERIMETRAL PLAYA', 'images/heKR86kgba.png', 2, 1),
(49, '4606', 'HOJA PERIMETRAL  DOBLE VIDRIO', 'images/hpo6Ht7ein.png', 2, 1),
(50, '4626', 'HOJA PERIMETRAL  DOBLE VIDRIO REFORZADA', 'images/Mzi8d5GDt3.png', 2, 1),
(51, '64625', 'HOJA PERIMETRAL  REFORZADA', 'images/RT6w88lIwQ.png', 2, 1),
(52, '64627', 'HOJA PERIMETRAL PLAYA REFORZADA', 'images/3W3gpNsaHy.png', 2, 1),
(53, '4604', 'TAPA HOJA CENTRAL', 'images/sc3Zk3HKR6.png', 2, 1),
(54, '74633', 'MARCO ADAPTADOR', 'images/IenOFpShTJ.png', 2, 1),
(55, '4607', 'INTERMEDIO', 'images/9iDTqvqdII.png', 2, 1),
(56, '4608', 'INTERMEDIO DOBLE VIDRIO', 'images/Jw5BLBRNCv.png', 2, 1),
(57, '4611', 'TIRADOR REFUERZO', 'images/wtxG0amS0I.png', 2, 1),
(58, '4609', 'UNIÓN CUATRO HOJAS', 'images/dkCElehkIq.png', 2, 1),
(59, '64629', 'UNIÓN CUATRO HOJAS', 'images/UFErWe5ohS.png', 2, 1),
(60, '6410', 'ADAPTADOR MOSQUITERO', 'images/XeTawGQwM8.png', 2, 1),
(61, '4612', 'TAPA TIRADOR REFUERZO', 'images/CLwXxug3Xw.png', 2, 1),
(62, '74631', 'MARCO PERIMETRAL RECTO', 'images/AMbk3WkeTV.png', 3, 1),
(63, '74632', 'MARCO PERIMETRAL TRES RIELES RECTO', 'images/GyItXwIxz3.png', 3, 1),
(64, '64624', 'HOJA PERIMETRAL MOSQUITERO', 'images/JRSrK3aAW7.png', 3, 1),
(65, '64628', 'HOJA PERIMETRAL LISA', 'images/MeSisxTWSg.png', 3, 1),
(66, '74639', 'UNIÓN CUATRO  HOJAS CON  EMBELLECEDOR', 'images/mlEOi1CWvd.png', 3, 1),
(67, '64614', 'TAPA  DOBLE HOJA  CENTRAL', 'images/z0WAGDopyF.png', 3, 1),
(68, '64621', 'HOJA  PERIMETRAL  DOBLE VIDRIO', 'images/s3SOQJcMxB.png', 4, 1),
(69, '64622', 'HOJA  PERIMETRAL MONUMENTAL', 'images/MvqMKDTBzy.png', 4, 1),
(70, '64623', 'HOJA  PERIMETRAL  MOSQUITERO  MONUMENTAL', 'images/LbZpB81gYk.png', 4, 1),
(71, '64620', 'TAPA HOJA CENTRAL  MONUMENTAL', 'images/QcaKP8qydd.png', 4, 1),
(72, '64630', 'TAPA HOJA CENTRAL  MONUMENTAL CORTA', 'images/e90l0oio1k.png', 4, 1),
(74, '10001', 'HOJA PERIMETRAL', 'images/hLVyW5mDV9.png', 5, 1),
(75, '10004', 'TAPA HOJA CENTRAL', 'images/jr2INgY8WD.png', 5, 1),
(76, '10005', 'MARCO ADAPTADOR', 'images/ZROrTlncyr.png', 5, 1),
(77, '10006', 'UNIÓN 4 HOJAS', 'images/byFqzY4FpJ.png', 5, 1),
(78, '10002', 'MARCO PERIMETRAL', 'images/HvLZQTThji.png', 5, 1),
(79, '10003', 'FIJO TUBULAR', 'images/5kxY4Xlz8o.png', 5, 1),
(80, '10012', 'MARCO PERIMETRAL TRES RIELES', 'images/6ksOOcs6CT.png', 5, 1),
(81, '10013', 'FIJO TUBULAR TRES RIELES', 'images/baTxNDNKYG.png', 5, 1),
(82, '6018', 'JUNQUILLO', 'images/RR7R3OZmZ7.png', 6, 1),
(83, '6019', 'JUNQUILLO', 'images/bTnuPteVmb.png', 6, 1),
(84, '6020', 'JUNQUILLO', 'images/bs6BM8livB.png', 6, 1),
(85, '6021', 'JUNQUILLO', 'images/fNOxqKCIaJ.png', 6, 1),
(86, '6027', 'JUNQUILLO', 'images/G11ntnuL3I.png', 6, 1),
(87, '6028', 'JUNQUILLO', 'images/h1nIX9jgLI.png', 6, 1),
(88, '6029', 'JUNQUILLO', 'images/UpYQmsJfYi.png', 6, 1),
(89, '6032', 'JUNQUILLO', 'images/lOGNYGF9NA.png', 6, 1),
(92, '5278', 'CABEZAL Y ZOCLO', 'images/rzyjd9a8yW.png', 9, 1),
(93, '5279', 'JAMBA Y CABEZAL', 'images/8frgbkuYWv.png', 9, 1),
(94, '5280', 'RIEL', 'images/ePfWZtvEoU.png', 9, 1),
(95, '5281', 'CERCO TRASLAPE', 'images/s515nfhpoK.png', 9, 1),
(96, 'JR-1', 'RIEL DE 1 1/2\'\'', 'images/FMAsfoVWA8.png', 10, 1),
(97, 'JR-2', 'INTERMEDIO', 'images/OiRcZkMt3V.png', 10, 1),
(98, 'JR-3', 'JUNQUILLO', 'images/1RBTOulfll.png', 10, 1),
(99, 'JR-4', 'CERCO TRASLAPE', 'images/bkZjdhKQtD.png', 10, 1),
(100, '9073-BC', 'BOLSA CORTA', 'images/VsFDWcXA2A.png', 11, 1),
(101, '9073', 'BOLSA', 'images/aGVBGab9R7.png', 11, 1),
(102, '9074', 'ESCALONADO', 'images/oC93mgSdsS.png', 11, 1),
(103, '9075', 'TAPA BOLSA', 'images/nD4cLGlBKP.png', 11, 1),
(104, '9076', 'BOLSA DE 1 1/2\'\'', 'images/fUDbkDtWzO.png', 11, 1),
(105, '6370', 'JUNQUILLO', 'images/JF1IjY8W36.png', 11, 1),
(106, '11037', 'JAMBA CABEZAL', 'images/7sQ9gXhrH6.png', 12, 1),
(107, '11068', 'RIEL', 'images/lsOOl44xWp.png', 12, 1),
(108, '11041', 'CERCO TRASLAPE', 'images/QGd4PPrIA3.png', 12, 1),
(109, '11044', 'ZOCLO CABEZAL', 'images/L0m6iOzbmi.png', 12, 1),
(110, '9086-BC', 'BOLSA CORTA', 'images/z3pvc0hbZj.png', 13, 1),
(111, '9083', 'BOLSA', 'images/tL4IQWDfX5.png', 13, 1),
(112, '9084', 'ESCALONADO', 'images/w7TWidZcxh.png', 13, 1),
(113, '8591', 'BOLSA LISA', 'images/VUDUdPQlYX.png', 13, 1),
(114, '4051', 'TAPA LISA', 'images/wxjpzlayl0.png', 13, 1),
(115, '9085', 'TAPA BOLSA', 'images/eKA21c7IoQ.png', 13, 1),
(116, '7792', 'MOLDURA UNIÓN 2\'\'', 'images/PoLwf4oG3a.png', 13, 1),
(117, '9088', 'JUNQUILLO', 'images/3KVeZhnaFN.png', 13, 1),
(118, '8586', 'ESQUINERO', 'images/mijLY21XBZ.png', 13, 1),
(119, '7518', 'CHAMBARANA', 'images/6vQZ7J4Bfy.png', 14, 1),
(120, '9953', 'RIEL', 'images/ZNRYlTxyDE.png', 14, 1),
(121, '7819', 'CHAMBRANA DE 2\'\' CON MOSQUITERO', 'images/F0qskyHdbZ.png', 14, 1),
(122, '8370', 'RIEL DE 2\'\' CON MOSQUITERO', 'images/EAhKbpT8Gz.png', 14, 1),
(123, '9966', 'ADAPTADOR MOSQUITERO', 'images/0otXFgI5lx.png', 14, 1),
(124, '7818', 'RIEL ADAPTADOR', 'images/jzI1SE3zdn.png', 14, 1),
(125, '9955', 'TRASLAPE PUERTA', 'images/9xlc9pvYUa.png', 14, 1),
(126, '7821', 'CERCO PUERTA', 'images/TU67rgCtxx.png', 14, 1),
(127, '9954', 'TRASLAPE VENTANA', 'images/0kE0tHG1Jr.png', 14, 1),
(128, '8320', 'CERCO VENTANA', 'images/JMUonXgEab.png', 14, 1),
(129, '11203', 'INTERMEDIO PARA CUADRICULA', 'images/c0FquDdXA1.png', 14, 1),
(131, '7824', 'ZOCLO CORTO', 'images/9KeddZDL3G.png', 14, 1),
(132, '7825', 'ZOCLO PUERTA', 'images/Pn00GE2lWH.png', 14, 1),
(133, '11044', 'ZOCLO CABEZAL', 'images/I9Tv417S7m.png', 14, 1),
(134, '9135', 'BOLSA', 'images/kafSXodBTp.png', 15, 1),
(136, '9136', 'ESCALONADO', 'images/KB28bCwJE1.png', 15, 1),
(137, '9135-BC', 'BOLSA CORTA', 'images/TclEU8Sejv.png', 15, 1),
(138, '9112', 'JUNQUILLO', 'images/Hv9P9IATH0.png', 15, 1),
(139, '9114', 'BOLSA LISA', 'images/hy0vdjfHx7.png', 15, 1),
(140, '7315', 'TAPA BOLSA', 'images/LuxJ8NyhRc.png', 15, 1),
(141, '9115', 'ESQUINERO DE 3\"', 'images/Y7EDu6Gapq.png', 15, 1),
(142, '7316', 'TAPA LISA', 'images/Ep6FmiFQlG.png', 15, 1),
(143, '10266', 'MOLDURA UNIÓN 3\'\'', 'images/5Q3QAX5Al6.png', 15, 1),
(144, '7826', 'CHAMBRANA', 'images/2ESolPVE5d.png', 16, 1),
(145, '9957', 'RIEL', 'images/U15TrcLYcF.png', 16, 1),
(146, '7862', 'CHAMBRANA CON MOSQUITERO', 'images/tnLV04e9pU.png', 16, 1),
(147, '9272', 'RIEL CON MOSQUITERO', 'images/tPNRpIZlXb.png', 16, 1),
(148, '7844', 'TRASLAPE VENTANA', 'images/ajPLKMQVJG.png', 16, 1),
(149, '7843', 'CERCO VENTANA', 'images/qiWZCzWj1V.png', 16, 1),
(150, '7848', 'TRASLAPE PUERTA', 'images/ZNddRd91ub.png', 16, 1),
(151, '7847', 'CERCO CHAPA', 'images/kTWQAbMwkB.png', 16, 1),
(152, '9236', 'CERCO', 'images/qy1BkO3xFY.png', 16, 1),
(153, '7835', 'ZOCLO VENTANA', 'images/0P5svUkhyG.png', 16, 1),
(154, '7836', 'CABEZAL', 'images/J8oZU6cF5p.png', 16, 1),
(155, '7842', 'ZOCLO PUERTA', 'images/08AaYN8dBn.png', 16, 1),
(156, '9081', 'INTERMEDIO CORTO', 'images/j16leVXTOu.png', 16, 1),
(157, '9082', 'INTERMEDIO', 'images/3Yj33MKYBI.png', 16, 1),
(158, '7850', 'CERCO OXXO', 'images/2eKUNM0msy.png', 16, 1),
(159, '10237', 'TAPA BOLSA CORTA', 'images/lHXMIJbQJw.png', 16, 1),
(160, '7394', 'RIEL BAÑO PORTÓN', 'images/asQGW0Bh3t.png', 17, 1),
(161, '9523', 'RIEL DE LUJO', 'images/Kfi1I5tzMm.png', 17, 1),
(162, '11386', 'JAMBA', 'images/efqcUyFdZ5.png', 17, 1),
(163, '11174', 'RIEL', 'images/wvj577sEW0.png', 17, 1),
(164, '11387', 'RIEL', 'images/srFSYUU105.png', 17, 1),
(165, '9524', 'GUÍA', 'images/nIMV1yUvp4.png', 17, 1),
(166, '9525', 'MARCO ECONÓMICO', 'images/tVAZW7oE2W.png', 18, 1),
(167, '9756', 'MARCO SEMI LUJO', 'images/XyXIg0aAbc.png', 18, 1),
(168, '10103', 'MARCO DE LUJO', 'images/SmM3OjgN7e.png', 18, 1),
(169, '9756-B', 'MARCO CON JALADERA', 'images/kpsVPKYfdU.png', 18, 1),
(170, '4105', 'BATIENTE', 'images/zOIJKqTTrp.png', 19, 1),
(171, '11032', 'BATIENTE', 'images/0jmiXtcXsF.png', 19, 1),
(172, '8550', 'BATIENTE CON VENAS', 'images/IV7CdZ38f9.png', 19, 1),
(173, '8560', 'BATIENTE LARGO', 'images/ndYQX7rFbQ.png', 19, 1),
(174, '5844', 'BATIENTE', 'images/Y2mCGz1B76.png', 19, 1),
(175, '7102', 'BATIENTE PESADO', 'images/qhlj3zKDx8.png', 19, 1),
(176, '7013', 'PORTAVIDRIO', 'images/c9QizSV0NR.png', 20, 1),
(177, '7014', 'JUNIQUILLO', 'images/0IU2GYreKj.png', 20, 1),
(178, '5686', 'MARCHINA', 'images/k0AHBwbL0a.png', 20, 1),
(179, '5687', 'TEE DE 3/4\"', 'images/x6IsH27qZB.png', 20, 1),
(180, '6617', 'DUELA LISA', 'images/wltnK8VEVW.png', 21, 1),
(181, '6775', 'DUELA ENTRECALLE', 'images/1TxCXw4Y9y.png', 21, 1),
(182, '8380', 'DUELA GRAFICADA', 'images/nzxyUNgQiq.png', 21, 1),
(183, '11128', 'DUELA ONDULADA', 'images/XmRmXsunKt.png', 21, 1),
(184, '9183', 'INTERMEDIO', 'images/j6IXwELg1W.png', 22, 1),
(185, '9207', 'CABEZAL', 'images/74W2TVF54D.png', 22, 1),
(186, '9204', 'CERCO CHAPA OVALADO', 'images/ljYtz8z8PU.png', 22, 1),
(187, '6370', 'JUNIQUILLO', 'images/yGMCX6kiio.png', 22, 1),
(188, '9187', 'ZOCLO', 'images/vFecro26tH.png', 22, 1),
(189, '8936', 'MARCO', 'images/cKCdraK5R5.png', 23, 1),
(190, '8937', 'CONTRAMARCO', 'images/sFLsidb2m6.png', 23, 1),
(191, '8939', 'JUNIQUILLO', 'images/ruLiAQthwO.png', 23, 1),
(192, 'G-28', 'CELOSIA DE LUJO', 'images/LrindOlV3l.png', 24, 1),
(193, 'G-457', 'CELOSIA ECONÓMICA', 'images/TV5raG4ypS.png', 24, 1),
(194, '7795', 'REPISÓN (STD)', 'images/HZK3vsGL68.png', 24, 1),
(195, '7794', 'CABEZAL (STD)', 'images/o6iT6XDHCT.png', 24, 1),
(196, '10538', 'CLIP PARA CELOSIA', 'images/yhOQ6yXO3l.png', 24, 1),
(197, '10539', 'JAMBA ECONÓMICA PARA CELOSIA', 'images/OtN7uaiWYd.png', 24, 1),
(198, '9740', 'BARRA OPERADORA', 'images/BvBOEA5tQy.png', 24, 1),
(199, '10539', 'JAMBA DE LUJO PARA CELOSIA', 'images/EuUShCKAC0.png', 24, 1),
(200, '7671', 'REPIZÓN', 'images/MUGRvcnaU1.png', 25, 1),
(201, '6053', 'LOUVER', 'images/cljUpeSyAQ.png', 25, 1),
(202, '6063', 'LOUVER ESPECIAL', 'images/mOSf9WNJqt.png', 25, 1),
(203, '6533', 'MOSQUITERO HORIZONTAL', 'images/VQRvBgkO1c.png', 26, 1),
(204, '6534', 'MOSQUITERO VERTICAL', 'images/U0Yk8J07H0.png', 26, 1),
(205, '10358', 'MOSQUITERO UNIVERSAL', 'images/JDcRdDHeAD.png', 26, 1),
(206, '7333', 'LIGERO', 'images/TIAhcsVPLh.png', 26, 1),
(207, '5377', 'MOSQUITERO', 'images/DUgMm76oL8.png', 26, 1),
(208, '1301', 'ÁNGULO DE 1/2\" X 0.050\"', 'images/zxjginph7e.png', 27, 1),
(209, '1303', 'ÁNGULO DE 3/4\" X 0.050\"', 'images/geUziSHD4I.png', 27, 1),
(210, '1308', 'ÁNGULO DE 1\" X 1/8\"', 'images/15I4h9xSfE.png', 27, 1),
(211, '1311', 'ÁNGULO DE 1 1/2\" X 1/8\"', 'images/zg9vBQsXvl.png', 27, 1),
(212, '1314', 'ÁNGULO DE 1 1/2\" X 3/16\"', 'images/iyG8JIJAXz.png', 27, 1),
(213, '1324', 'ÁNGULO DE 1\" X 0.050\"', 'images/iFxHZNo6pM.png', 27, 1),
(214, '1360', 'ÁNGULO DE 1\" X 1/2\"', 'images/a96UIjkaNn.png', 27, 1),
(215, '1361', 'ÁNGULO DE 1 1/4\" X 1/2\"', 'images/Q7PyHKSppf.png', 27, 1),
(216, '1613', 'TEE LIGERA DE 1\"', 'images/Rk8CL2FAGg.png', 27, 1),
(217, '5687', 'TEE DE 3/4\"', 'images/y9aZE838dy.png', 27, 1),
(218, 'CAN-1', '1/2\" X 0.700\"', 'images/HeAV6g8IOg.png', 28, 1),
(219, 'CAN-2', '0.687\" X 1/2\"', 'images/JtVQtAw3G2.png', 28, 1),
(220, 'CAN-3', '2\" X 1\"', 'images/mYZYCJz0xx.png', 28, 1),
(221, 'CAN-4', '2.380\" X 0.875\"', 'images/E4fYza2IHd.png', 28, 1),
(222, '2350', 'TUBO CUADRADO DE 1/2\"', 'images/O5HhPdfPoS.png', 29, 1),
(223, '2351', 'TUBO CUADRADO DE 3/4\"', 'images/SOxNyRW3F6.png', 29, 1),
(224, '2362', 'TUBO CUADRADO DE 1\"', 'images/yGb4GPqMgc.png', 29, 1),
(225, '11093', 'TUBO CUADRADO DE 1 3/4\"', 'images/WG7pjzMjFf.png', 29, 1),
(226, '11154', 'TUBO CUADRADO DE 1 1/4\"', 'images/OxcqoAvRw5.png', 29, 1),
(227, '11067', 'TUBO CUADRADO DE 1 1/2\"', 'images/ZJMb8XXIHY.png', 29, 1),
(228, '2356', 'TUBO CUADRADO DE 2\"', 'images/vbvePuW5Nc.png', 29, 1),
(229, '2500', 'TUBO RECTANGULAR DE 1\" X 1/2\"', 'images/EhRkHMykxv.png', 30, 1),
(230, '11086', 'TUBO RECTANGULAR DE 1 1/2\" X 3/4\"', 'images/NxsxEJSNk7.png', 30, 1),
(231, '11121', 'TUBO RECTANGULAR DE 2\" X 1\"', 'images/FSiOZMBD7P.png', 30, 1),
(232, '11099', 'TUBO RECTANGULAR DE 2 1/2\" X 1 1/4\"', 'images/MEle7XBV9D.png', 30, 1),
(233, '11084', 'TUBO RECTANGULAR DE 3\" X 1 1/2\"', 'images/kUzDevGWwq.png', 30, 1),
(234, '11122', 'TUBO RECTANGULAR DE 3\" X 1 3/4\"', 'images/mIAjgXAPEr.png', 30, 1),
(235, '2520', 'TUBO RECTANGULAR DE 4\" X 1 3/4\"', 'images/nnuhyBLtJu.png', 30, 1),
(236, '51521', 'TUBO RECTANGULAR DE 4\" X 1 3/4\" CON CEJA', 'images/bhks3YD2Q1.png', 30, 1),
(237, '23896', 'PASAMANOS 2\"', 'images/RS8eLqKsta.png', 31, 1),
(238, '2830', 'PASAMANOS 3\"', 'images/8nTgVWJicM.png', 31, 1),
(239, '2121', 'TUBO REDONDO DE 1\"', 'images/92BIglgIkW.png', 31, 1),
(240, '2840', 'PASAMANOS 4\"', 'images/wMBPydgoRn.png', 31, 1),
(241, '28009', 'ZOCLO PARA PASAMANOS', 'images/rDLIwkG0hv.png', 31, 1),
(242, '8327', 'ZOCLO HERCULITE', 'images/hdxwHiyp8u.png', 31, 1),
(243, '7677', 'PASAMANOS', 'images/bsz0I8uIFf.png', 31, 1),
(244, '7676', 'SOLERA PARA PASAMANOS', 'images/YWgkTEqpXU.png', 31, 1),
(245, '9366', 'PASAMANOS TIPO 002', 'images/xgbPoxKqI7.png', 31, 1),
(246, '1216', 'SOLERA DE 2\" X 3/16\"', 'images/lbuGwWGRRL.png', 31, 1),
(247, '1439', 'PERFIL PARA DOMO', 'images/CMkovaQN3n.png', 32, 1),
(248, '1440', 'CANAL PARA DOMO', 'images/kXZhxAcLJC.png', 32, 1),
(249, '3315', 'RIEL', 'images/Tdmt0Eqstf.png', 33, 1),
(250, '3328', 'GUÍA DOBLE 0.040\"', 'images/9Tjez9XnYf.png', 33, 1),
(251, '3357', 'ZOCLO', 'images/kaxNxMhXbt.png', 33, 1),
(252, '033', 'MOLDURA', 'images/3WXKQQN4Sx.png', 34, 1),
(253, '3160', 'PECHO PALOMA', 'images/TWgRdBR81V.png', 34, 1),
(254, '11417', 'BÁSICO ABIERTO', 'images/4Zr16fFcUl.png', 35, 1),
(255, '14738', 'BÁSICO FACHADA', 'images/PYqiWnj2sm.png', 35, 1),
(256, '5472', 'TAPA BÁSICO ABIERTO', 'images/S6dhBtjoYG.png', 35, 1),
(257, '10581', 'BÁSICO', 'images/aQiSxAdGZD.png', 35, 1),
(258, '10582', 'BÁSICO FACHADA DOBLE VIDRIO', 'images/da5THVW9LP.png', 35, 1),
(259, '11163', 'TAPA EXTERIOR FACHADA', 'images/Zv3EADQaD4.png', 35, 1),
(260, '11286', 'MULIÓN FACHADA', 'images/7Iqvbh8UmR.png', 35, 1),
(261, '14668', 'BÁSICO PARA FACHADA', 'images/4dxitMXeXE.png', 35, 1),
(262, '2003', 'BÁSICO GRANDE', 'images/HrKwffDugM.png', 36, 1),
(263, '2004', 'BÁSICO CHICO CON CEJA', 'images/2tQRV3mIPk.png', 36, 1),
(264, '2005', 'BÁSICO MEDIANO', 'images/nfLsVamJdh.png', 36, 1),
(265, '2008', 'BÁSICO MEDIANO SIN CANAL', 'images/FvluCjZy1C.png', 36, 1),
(266, '2006', 'TAPA EXTERIOR', 'images/l6tdiq0osq.png', 36, 1),
(267, '2007', 'PORTAVIDRIO', 'images/VN2YK93x42.png', 36, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_herrajes`
--

CREATE TABLE `productos_herrajes` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_categoria_producto` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_herrajes`
--

INSERT INTO `productos_herrajes` (`id`, `codigo`, `producto`, `imagen`, `id_tipo`, `id_categoria`, `id_categoria_producto`) VALUES
(2, '1305-0', 'ESCUADRA FIJO SERIE 3500 CENT.', 'images/jYodS5DpMR.png', 1, 3, 2),
(3, '1736', 'CIERRE EMBUTIDO S-3500', 'images/TGiMAeTV4N.png', 1, 3, 2),
(4, '3205-0', 'FELPA SEAL-FILM 7x5mm GRIS', 'images/0AWQtUS8mu.png', 1, 1, 2),
(5, '3217-7', 'TAPÓN SALIDA AGUA CORREDERA', 'images/1X8KTVRa6T.png', 1, 3, 2),
(6, '3219-7', 'VÁLVULA DESAGÜE CORREDERA', 'images/RWWCSJZvP5.png', 1, 3, 2),
(7, '7051-0', 'KIT MOSQUITERO UNIVERSAL', 'images/rtEOFhT7iC.png', 1, 3, 2),
(8, '5117-0', 'RUEDA NYLON S-3500', 'images/rudiCWogXH.png', 1, 3, 2),
(9, '5117-02', 'RUEDA GRADUABLE AGUJAS', 'images/oCpEIv6ylz.png', 1, 3, 2),
(10, '5117-03', 'RUEDA GRADUABLE AGUJAS TÁNDEM', 'images/K99YhJFB0b.png', 1, 3, 2),
(11, '5117-7', 'KIT GOMAS SERIE 3500', 'images/HfNuaE5vqb.png', 1, 3, 2),
(12, '1515-7', 'GOMA MOSQUITERO', 'images/zDDsiUBjEc.png', 1, 2, 2),
(13, '3101-7', '(7X10MM) FELPA NEGRA MOSQUITERO', 'images/85rBcGkPLP.png', 1, 1, 2),
(14, '2605', 'CREMONA SISTEMA MULTIPUNTO', 'images/57B8h3uU3l.png', 2, 3, 2),
(15, '7150', 'CIERRE EMBUTIDO', 'images/CV1IelD8W7.png', 2, 3, 2),
(16, '7250', 'CIERRE EMBUTIDO OLÉ', 'images/9Dk01C9XdQ.png', 2, 3, 2),
(17, '2255', 'CIERRE EMBUTIR LLAVE S-4600', 'images/1ID1uwmY81.png', 2, 3, 2),
(18, '7270', 'ASA CIERRE EMBUTIDO OLÉ', 'images/lbGDxAotvr.png', 2, 3, 2),
(19, '7151-7', 'KIT PERIMETRAL S-4600', 'images/51O9efQ3O9.png', 2, 3, 2),
(20, '7153-0', 'RUEDA TÁNDEM GRADUABLE NYLON S-4600', 'images/5VNdIKngRc.png', 2, 3, 2),
(21, '7154-0', 'RUEDA GRADUABLE NYLON AGUJAS S-4600', 'images/2JIS1NwMk5.png', 2, 3, 2),
(22, '2601-0', 'SISTEMA MULTIPUNTO UN PUNTO 125 mm', 'images/LJWSszdBeO.png', 2, 3, 2),
(23, '2602-0', 'SISTEMA MULTIPUNTO DOS PUNTOS 600 mm', 'images/A9GU1woxdV.png', 2, 3, 2),
(24, '2603-0', 'SISTEMA MULTIPUNTO TRES PUNTOS 1800 mm', 'images/lFTJRcpwQE.png', 2, 3, 2),
(25, '2604-0', 'SISTEMA MULTIPUNTO CUATRO PUNTOS 1600 mm', 'images/ZH47AZC6GN.png', 2, 3, 2),
(26, '2500', 'CIERRE EMBUTIDO MULTI', 'images/EoS1DLRnqE.png', 2, 3, 2),
(27, '1326-0', 'ESCUADRA TETÓN HOJA', 'images/mJtJPpYCtZ.png', 2, 3, 2),
(28, '1327-0', 'ESCUADRA TETÓN MARCO TRES RIELES', 'images/3UKJs2SGPb.png', 2, 3, 2),
(29, '1328-0', 'ESCUADRA TETÓN MARCOS Y FIJOS', 'images/tFscGBCrpx.png', 2, 3, 2),
(30, '7052-0', 'ESCUADRA INOX ALINEAMIENTO S-4600', 'images/dS5XXA7Edo.png', 2, 3, 2),
(31, '3206-0', 'FELPA SEAL FILM 7 x 6 mm GRIS', 'images/zXjYl2sbId.png', 2, 1, 2),
(32, '2735', 'TOPE CORREDIZA', 'images/D9Ll7noEhu.png', 2, 3, 2),
(33, '7161', 'TAPÓN REFUERZO PARA HOJA', 'images/5Pq3R5YTu5.png', 2, 3, 2),
(34, '2243', 'UÑERO EMBUTIDO', 'images/JiEgmlKLrc.png', 2, 3, 2),
(35, '2244', 'UÑERO MOSQUITERO', 'images/cRj27A1yqv.png', 2, 3, 2),
(36, '2705', 'CREMONA SISTEMA MULTIPUNTO CON LLAVE', 'images/wLCUECn4Zl.png', 2, 3, 2),
(37, '1324-0', 'ESCUADRA TETÓN CERCO Y FIJO S-10000', 'images/tFTykGOBuk.png', 3, 3, 2),
(38, '1325-0', 'ESCUADRA TETÓN HOJA S-10000', 'images/b9a5NL9RRQ.png', 3, 3, 2),
(39, '2256', 'CIERRE EMBUTIDO C/LLAVE S-10000', 'images/D6QLwFn5ES.png', 3, 3, 2),
(40, '7270', 'ASA CIERRE EMBUTIDO OLÉ', 'images/6L3Y6lX3gJ.png', 3, 3, 2),
(41, '1324-C', 'ESCUADRA TETÓN CERCO Y FIJOS, CORTA', 'images/Yivz0y2vbc.png', 3, 3, 2),
(42, '1374-0', 'ADAPTADOR RUEDA', 'images/anYurtaUL2.png', 3, 1, 2),
(43, '7260', 'CIERRE EMBUTIDO OLÉ S-10000', 'images/t3mR3TUSgO.png', 3, 3, 2),
(44, '7127', 'ASA CON UÑERO S-10000', 'images/hcCVD64xH7.png', 3, 3, 2),
(45, '2601-0', 'SISTEMA MONOPUNTO 125mm', 'images/Zxlbis324v.png', 3, 3, 2),
(46, '2602-2', 'SISTEMA MULTIPUNTO DOS PUNTOS 600mm', 'images/2VjzEIKjVp.png', 3, 3, 2),
(47, '2603-0', 'SISTEMA MULTIPUNTO TRES PUNTOS 1800mm', 'images/sd4RDJgnAj.png', 3, 3, 2),
(48, '2604-0', 'SISTEMA MULTIPUNTO CUATRO PUNTOS 1600mm', 'images/MPlI4qEigp.png', 3, 3, 2),
(49, '2605', 'CREMONA SISTEMA MULTIPUNTO', 'images/FzuUnZ9YQl.png', 3, 3, 2),
(50, '2705', 'CREMONA SISTEMA MULTIPUNTO C/LLAVE', 'images/L5qmGdLZlt.png', 3, 3, 2),
(51, '2689', 'CREMONA MULTIPUNTO ACODADA DER. NEGRA', 'images/TIQ9ML5s4i.png', 3, 3, 2),
(52, '4690', 'CREMONA MULTIPUNTO ACODADA IZQ. NEGRA', 'images/nXb6yOUsGK.png', 3, 3, 2),
(53, '3206-0', 'FELPA SEAL FILM 7x6MM GRIS', 'images/GMmY6Lid7h.png', 3, 1, 2),
(54, '7155-0', 'RUEDA TÁNDEM GRAD. AGUJAS S-10000', 'images/fxij1FSuMt.png', 3, 3, 2),
(55, '7123-7', 'KIT PERIMETRAL S-10000', 'images/LubZ3q4sSP.png', 3, 3, 2),
(56, '7157-0', 'RUEDA TÁNDEM 200KG', 'images/dbME0PG5db.png', 3, 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_vidrio`
--

CREATE TABLE `productos_vidrio` (
  `id` int(11) NOT NULL,
  `id_tonalidad` int(11) DEFAULT NULL,
  `id_mm` int(11) DEFAULT NULL,
  `id_categoria_producto` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_vidrio`
--

INSERT INTO `productos_vidrio` (`id`, `id_tonalidad`, `id_mm`, `id_categoria_producto`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 3),
(3, 2, 1, 3),
(4, 2, 2, 3),
(5, 2, 3, 3),
(6, 3, 1, 3),
(7, 3, 2, 3),
(8, 4, 1, 3),
(9, 4, 2, 3),
(10, 5, 2, 3),
(11, 6, 2, 3),
(12, 7, 2, 3),
(13, 8, 2, 3),
(14, 9, 2, 3),
(15, 10, 2, 3),
(16, 11, 2, 3),
(17, 12, 3, 3),
(18, 13, 2, 3),
(19, 14, 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Colaborador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series_aluminio`
--

CREATE TABLE `series_aluminio` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `series_aluminio`
--

INSERT INTO `series_aluminio` (`id`, `descripcion`) VALUES
(1, '3500'),
(2, '4600 Clásica'),
(3, '4600 Recta'),
(4, '4600 Monumental'),
(5, '10000'),
(6, '10000 Junquillos'),
(7, 'Línea Ligera Serie 1 3/8\"'),
(8, 'Serie JR'),
(9, 'Bolsa Serie 1 1/2\'\''),
(10, 'Corrediza Serie 1 1/2\'\''),
(11, 'Bolsa Serie 2\'\''),
(12, 'Corrediza Serie 2\'\''),
(13, 'Bolsa Serie 3\'\''),
(14, 'Corrediza Serie 3\'\''),
(15, 'Baños'),
(16, 'Serie Baños'),
(17, 'Batientes'),
(18, 'Portavidrios'),
(19, 'Duelas'),
(20, 'Serie Puerta'),
(21, 'Ventila Proyección'),
(22, 'Celosias'),
(23, 'Louver y Repizones'),
(24, 'Mosquiteros'),
(25, 'Ángulos y Tees'),
(26, 'Canales'),
(27, 'Tubos Cuadrados'),
(28, 'Tubos Rectangulares'),
(29, 'Pasamanos'),
(30, 'Domo'),
(31, 'Vitrinas'),
(32, 'Molduras'),
(33, 'Perfiles para Fachada'),
(34, 'Fachada Lucernario'),
(39, 'serie de pruebaaaa'),
(40, 'tonalidad pruebaeeerr'),
(44, 'ESMERILADO CLARO vv');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series_herrajes`
--

CREATE TABLE `series_herrajes` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `series_herrajes`
--

INSERT INTO `series_herrajes` (`id`, `descripcion`) VALUES
(1, '3500'),
(2, '4600'),
(3, '10000'),
(7, '777785ffgggg'),
(8, 'ssdddd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fthrxYVBXzwdmnM2zgjsH2UX56trwGmKZu4TuoDT', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQnFWMHlnbmJ0Nnp1TXNGbUhucldicWdaQXNsdm16bWFIT1RKTUU4diI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb25zdWx0YS92ZW50YXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1761242339),
('Y5Un39bP1hDi9aq5L1CGe1HRkZirB31xWFOQgqOY', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMHA1elBDZjZxeElpREY1SEU5eEd3elZtUVhpeHo1NGJUZk1qZXRZcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXBvcnRlL3ZlbnRhL3VwZGF0ZS83Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1759897223);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_aluminio`
--

CREATE TABLE `stock_aluminio` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `piezas` decimal(14,2) NOT NULL DEFAULT 0.00,
  `cantidad_metros` int(11) GENERATED ALWAYS AS (`piezas` * 6) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock_aluminio`
--

INSERT INTO `stock_aluminio` (`id`, `id_producto`, `piezas`) VALUES
(13, 23, 10.00),
(14, 24, 9.00),
(15, 25, 3.00),
(16, 26, 0.00),
(17, 27, 0.00),
(18, 28, 0.00),
(19, 29, 0.00),
(20, 30, 0.00),
(22, 32, 0.00),
(23, 33, 0.00),
(24, 34, 0.00),
(25, 35, 0.00),
(26, 36, 0.00),
(27, 37, 0.00),
(28, 38, 0.00),
(29, 39, 0.00),
(30, 40, 0.00),
(31, 41, 0.00),
(32, 42, 0.00),
(33, 43, 0.00),
(34, 44, 0.00),
(35, 45, 0.00),
(36, 46, 0.00),
(37, 47, 0.00),
(38, 48, 0.00),
(39, 49, 0.00),
(40, 50, 0.00),
(41, 51, 0.00),
(42, 52, 0.00),
(43, 53, 0.00),
(44, 54, 0.00),
(45, 55, 0.00),
(46, 56, 0.00),
(47, 57, 0.00),
(48, 58, 0.00),
(49, 59, 0.00),
(50, 60, 0.00),
(51, 61, 0.00),
(52, 62, 0.00),
(53, 63, 0.00),
(54, 64, 0.00),
(55, 65, 0.00),
(56, 66, 0.00),
(57, 67, 0.00),
(58, 68, 0.00),
(59, 69, 0.00),
(60, 70, 0.00),
(61, 71, 0.00),
(62, 72, 0.00),
(64, 74, 0.00),
(65, 75, 0.00),
(66, 76, 0.00),
(67, 77, 0.00),
(68, 78, 0.00),
(69, 79, 0.00),
(70, 80, 0.00),
(71, 81, 0.00),
(72, 82, 0.00),
(73, 83, 0.00),
(74, 84, 0.00),
(75, 85, 0.00),
(76, 86, 0.00),
(77, 87, 0.00),
(78, 88, 0.00),
(79, 89, 0.00),
(82, 92, 0.00),
(83, 93, 0.00),
(84, 94, 0.00),
(85, 95, 0.00),
(86, 96, 0.00),
(87, 97, 0.00),
(88, 98, 0.00),
(89, 99, 0.00),
(90, 100, 0.00),
(91, 101, 0.00),
(92, 102, 0.00),
(93, 103, 0.00),
(94, 104, 0.00),
(95, 105, 0.00),
(96, 106, 0.00),
(97, 107, 0.00),
(98, 108, 0.00),
(99, 109, 0.00),
(100, 110, 0.00),
(101, 111, 0.00),
(102, 112, 0.00),
(103, 113, 0.00),
(104, 114, 0.00),
(105, 115, 0.00),
(106, 116, 0.00),
(107, 117, 0.00),
(108, 118, 0.00),
(109, 119, 0.00),
(110, 120, 0.00),
(111, 121, 0.00),
(112, 122, 0.00),
(113, 123, 0.00),
(114, 124, 0.00),
(115, 125, 0.00),
(116, 126, 0.00),
(117, 127, 0.00),
(118, 128, 0.00),
(119, 129, 0.00),
(121, 131, 0.00),
(122, 132, 0.00),
(123, 133, 0.00),
(124, 134, 0.00),
(126, 136, 0.00),
(127, 137, 0.00),
(128, 138, 0.00),
(129, 139, 0.00),
(130, 140, 0.00),
(131, 141, 0.00),
(132, 142, 0.00),
(133, 143, 0.00),
(134, 144, 0.00),
(135, 145, 0.00),
(136, 146, 0.00),
(137, 147, 0.00),
(138, 148, 0.00),
(139, 149, 0.00),
(140, 150, 0.00),
(141, 151, 0.00),
(142, 152, 0.00),
(143, 153, 0.00),
(144, 154, 0.00),
(145, 155, 0.00),
(146, 156, 0.00),
(147, 157, 0.00),
(148, 158, 0.00),
(149, 159, 0.00),
(150, 160, 0.00),
(151, 161, 0.00),
(152, 162, 0.00),
(153, 163, 0.00),
(154, 164, 0.00),
(155, 165, 0.00),
(156, 166, 0.00),
(157, 167, 0.00),
(158, 168, 0.00),
(159, 169, 0.00),
(160, 170, 0.00),
(161, 171, 0.00),
(162, 172, 0.00),
(163, 173, 0.00),
(164, 174, 0.00),
(165, 175, 0.00),
(166, 176, 0.00),
(167, 177, 0.00),
(168, 178, 0.00),
(169, 179, 0.00),
(170, 180, 0.00),
(171, 181, 0.00),
(172, 182, 0.00),
(173, 183, 0.00),
(174, 184, 0.00),
(175, 185, 0.00),
(176, 186, 0.00),
(177, 187, 0.00),
(178, 188, 0.00),
(179, 189, 0.00),
(180, 190, 0.00),
(181, 191, 0.00),
(182, 192, 0.00),
(183, 193, 0.00),
(184, 194, 0.00),
(185, 195, 0.00),
(186, 196, 0.00),
(187, 197, 0.00),
(188, 198, 0.00),
(189, 199, 0.00),
(190, 200, 0.00),
(191, 201, 0.00),
(192, 202, 0.00),
(193, 203, 0.00),
(194, 204, 0.00),
(195, 205, 0.00),
(196, 206, 0.00),
(197, 207, 0.00),
(198, 208, 0.00),
(199, 209, 0.00),
(200, 210, 0.00),
(201, 211, 0.00),
(202, 212, 0.00),
(203, 213, 0.00),
(204, 214, 0.00),
(205, 215, 0.00),
(206, 216, 0.00),
(207, 217, 0.00),
(208, 218, 0.00),
(209, 219, 0.00),
(210, 220, 0.00),
(211, 221, 0.00),
(212, 222, 0.00),
(213, 223, 0.00),
(214, 224, 0.00),
(215, 225, 0.00),
(216, 226, 0.00),
(217, 227, 0.00),
(218, 228, 0.00),
(219, 229, 0.00),
(220, 230, 0.00),
(221, 231, 0.00),
(222, 232, 0.00),
(223, 233, 0.00),
(224, 234, 0.00),
(225, 235, 0.00),
(226, 236, 0.00),
(227, 237, 0.00),
(228, 238, 0.00),
(229, 239, 0.00),
(230, 240, 0.00),
(231, 241, 0.00),
(232, 242, 0.00),
(233, 243, 0.00),
(234, 244, 0.00),
(235, 245, 0.00),
(236, 246, 0.00),
(237, 247, 0.00),
(238, 248, 0.00),
(239, 249, 0.00),
(240, 250, 0.00),
(241, 251, 0.00),
(242, 252, 19.00),
(243, 253, 0.00),
(244, 254, 0.00),
(245, 255, 0.00),
(246, 256, 0.00),
(247, 257, 0.00),
(248, 258, 0.00),
(249, 259, 0.00),
(250, 260, 0.00),
(251, 261, 0.00),
(252, 262, 0.00),
(253, 263, 0.00),
(254, 264, 0.00),
(255, 265, 0.00),
(256, 266, 0.00),
(257, 267, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_herrajes`
--

CREATE TABLE `stock_herrajes` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(100) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock_herrajes`
--

INSERT INTO `stock_herrajes` (`id`, `id_producto`, `cantidad`) VALUES
(2, 2, 10),
(3, 3, 14),
(4, 4, 10),
(5, 5, 0),
(6, 6, 0),
(7, 7, 0),
(8, 8, 0),
(9, 9, 0),
(10, 10, 0),
(11, 11, 0),
(12, 12, 0),
(13, 13, 0),
(14, 14, 0),
(15, 15, 0),
(16, 16, 0),
(17, 17, 0),
(18, 18, 0),
(19, 19, 0),
(20, 20, 0),
(21, 21, 0),
(22, 22, 0),
(23, 23, 0),
(24, 24, 0),
(25, 25, 0),
(26, 26, 0),
(27, 27, 0),
(28, 28, 0),
(29, 29, 0),
(30, 30, 0),
(31, 31, 0),
(32, 32, 0),
(33, 33, 0),
(34, 34, 0),
(35, 35, 0),
(36, 36, 0),
(37, 37, 28),
(38, 38, 0),
(39, 39, 0),
(40, 40, 0),
(41, 41, 0),
(42, 42, 0),
(43, 43, 0),
(44, 44, 0),
(45, 45, 0),
(46, 46, 0),
(47, 47, 0),
(48, 48, 0),
(49, 49, 0),
(50, 50, 0),
(51, 51, 0),
(52, 52, 0),
(53, 53, 0),
(54, 54, 0),
(55, 55, 0),
(56, 56, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_vidrio`
--

CREATE TABLE `stock_vidrio` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `hojas` decimal(14,2) NOT NULL DEFAULT 0.00,
  `cantidad_metros_2` int(11) GENERATED ALWAYS AS (`hojas` * 4) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock_vidrio`
--

INSERT INTO `stock_vidrio` (`id`, `id_producto`, `hojas`) VALUES
(1, 1, 19.00),
(2, 2, 25.00),
(3, 3, 0.00),
(4, 4, 0.00),
(5, 5, 0.00),
(6, 6, 0.00),
(7, 7, 0.00),
(8, 8, 0.00),
(9, 9, 0.00),
(10, 10, 0.00),
(11, 11, 0.00),
(12, 12, 0.00),
(13, 13, 0.00),
(14, 14, 0.00),
(15, 15, 0.00),
(16, 16, 0.00),
(17, 17, 0.00),
(18, 18, 0.00),
(19, 19, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_aluminio`
--

CREATE TABLE `tipos_aluminio` (
  `id` int(11) NOT NULL,
  `id_linea` int(11) NOT NULL,
  `id_serie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_aluminio`
--

INSERT INTO `tipos_aluminio` (`id`, `id_linea`, `id_serie`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(9, 2, 7),
(10, 2, 8),
(11, 2, 9),
(12, 2, 10),
(13, 2, 11),
(14, 2, 12),
(15, 2, 13),
(16, 2, 14),
(17, 2, 15),
(18, 2, 16),
(19, 2, 17),
(20, 2, 18),
(21, 2, 19),
(22, 2, 20),
(23, 2, 21),
(24, 2, 22),
(25, 2, 23),
(26, 2, 24),
(27, 2, 25),
(28, 2, 26),
(29, 2, 27),
(30, 2, 28),
(31, 2, 29),
(32, 2, 30),
(33, 2, 31),
(34, 2, 32),
(35, 2, 33),
(36, 2, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_herrajes`
--

CREATE TABLE `tipos_herrajes` (
  `id` int(11) NOT NULL,
  `id_linea` int(11) NOT NULL,
  `id_serie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_herrajes`
--

INSERT INTO `tipos_herrajes` (`id`, `id_linea`, `id_serie`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(6, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Administrador', 'adminaluvid@gmail.com', NULL, '$2y$12$HOzzOsPCFA7GLDpgy/e4yORez/Wax0JMiwa7Nm2/PFWW8xLSu7yOy', NULL, '2025-02-22 03:09:23', '2025-04-24 09:57:39', 1),
(2, 'Colaborador', 'colaboradoraluvid@gmail.com', NULL, '$2y$12$HOzzOsPCFA7GLDpgy/e4yORez/Wax0JMiwa7Nm2/PFWW8xLSu7yOy', NULL, '2025-04-24 09:35:58', '2025-04-24 09:57:59', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `nombre_cliente` varchar(25) NOT NULL,
  `apellido_cliente` varchar(25) NOT NULL,
  `contacto` varchar(10) NOT NULL,
  `subtotal_aluminio` double(16,2) DEFAULT NULL,
  `subtotal_herrajes` double(16,2) DEFAULT NULL,
  `subtotal_vidrio` double(16,2) DEFAULT NULL,
  `total` double(22,2) DEFAULT NULL,
  `descuento_aplicado` double(10,2) NOT NULL DEFAULT 0.00,
  `id_descuento` int(11) DEFAULT NULL,
  `fecha_solicitud` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `hora_entrega` time NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `productos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `diferencia` double(22,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `nombre_cliente`, `apellido_cliente`, `contacto`, `subtotal_aluminio`, `subtotal_herrajes`, `subtotal_vidrio`, `total`, `descuento_aplicado`, `id_descuento`, `fecha_solicitud`, `fecha_entrega`, `hora_entrega`, `estado`, `productos`, `diferencia`) VALUES
(1, 'Angelv80', 'Aguazul', '7721630414', 3105.00, 0.00, 0.00, 3105.00, 0.00, NULL, '2025-10-08', '2025-10-21', '15:03:00', 0, '[{\"id\":\"23\",\"codigo\":\"3501\",\"producto\":\"CERCO INFERIOR\",\"preciop\":1380,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/3B6DrVsdPD.png\",\"cantidad\":1,\"stock\":\"1.00\",\"idc\":\"1\"},{\"id\":\"24\",\"codigo\":\"3502\",\"producto\":\"CERCO SUPERIOR\",\"preciop\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/KwG6i1uL4I.png\",\"cantidad\":1,\"stock\":\"7.00\",\"idc\":\"1\"}]', NULL),
(2, 'Angel', 'Aguazul', '7721630414', 0.00, 0.00, 5405.00, 5405.00, 0.00, 3, '2025-10-08', '2025-10-15', '15:04:00', 0, '[{\"id\":\"1\",\"tonalidad\":\"FILTRASOL\",\"mm\":\"3\",\"precioh\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/f.jpg\",\"cantidad\":1,\"stock\":\"3.00\",\"idc\":\"3\"},{\"id\":\"2\",\"tonalidad\":\"FILTRASOL\",\"mm\":\"6\",\"precioh\":2300,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/f.jpg\",\"cantidad\":1,\"stock\":\"2.00\",\"idc\":\"3\"},{\"id\":\"3\",\"tonalidad\":\"CLARO\",\"mm\":\"3\",\"precioh\":1380,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/c.jpg\",\"cantidad\":1,\"stock\":\"3.00\",\"idc\":\"3\"}]', NULL),
(3, 'Angel', 'Aguazul', '7721630414', 4025.00, 1150.00, 5405.00, 9522.00, 1058.00, 2, '2025-10-08', '2025-10-22', '14:05:00', 0, '[{\"id\":\"24\",\"codigo\":\"3502\",\"producto\":\"CERCO SUPERIOR\",\"preciop\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/KwG6i1uL4I.png\",\"cantidad\":1,\"stock\":\"6.00\",\"idc\":\"1\"},{\"id\":\"25\",\"codigo\":\"3504\",\"producto\":\"HOJA CENTRAL\",\"preciop\":2300,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/yQ0vQWTUZg.png\",\"cantidad\":1,\"stock\":\"10.00\",\"idc\":\"1\"},{\"id\":\"1\",\"tonalidad\":\"FILTRASOL\",\"mm\":\"3\",\"precioh\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/f.jpg\",\"cantidad\":1,\"stock\":\"2.00\",\"idc\":\"3\"},{\"id\":\"2\",\"tonalidad\":\"FILTRASOL\",\"mm\":\"6\",\"precioh\":2300,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/f.jpg\",\"cantidad\":1,\"stock\":\"1.00\",\"idc\":\"3\"},{\"id\":\"3\",\"tonalidad\":\"CLARO\",\"mm\":\"3\",\"precioh\":1380,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/c.jpg\",\"cantidad\":1,\"stock\":\"2.00\",\"idc\":\"3\"},{\"id\":\"4\",\"codigo\":\"3205-0\",\"producto\":\"FELPA SEAL-FILM 7x5mm GRIS\",\"precio\":345,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/0AWQtUS8mu.png\",\"cantidad\":1,\"stock\":\"11\",\"idc\":\"2\"},{\"id\":\"3\",\"codigo\":\"1736\",\"producto\":\"CIERRE EMBUTIDO S-3500\",\"precio\":805,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/TGiMAeTV4N.png\",\"cantidad\":1,\"stock\":\"11\",\"idc\":\"2\"}]', NULL),
(4, 'Angel', 'Aguazul', '7721630414', 13800.00, 0.00, 3105.00, 15214.50, 1690.50, 2, '2025-10-08', '2025-10-16', '15:06:00', 0, '[{\"id\":\"24\",\"codigo\":\"3502\",\"producto\":\"CERCO SUPERIOR\",\"preciop\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/KwG6i1uL4I.png\",\"cantidad\":4,\"stock\":\"5.00\",\"idc\":\"1\"},{\"id\":\"25\",\"codigo\":\"3504\",\"producto\":\"HOJA CENTRAL\",\"preciop\":2300,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/yQ0vQWTUZg.png\",\"cantidad\":3,\"stock\":\"9.00\",\"idc\":\"1\"},{\"id\":\"1\",\"tonalidad\":\"FILTRASOL\",\"mm\":\"3\",\"precioh\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/f.jpg\",\"cantidad\":1,\"stock\":\"1.00\",\"idc\":\"3\"},{\"id\":\"3\",\"tonalidad\":\"CLARO\",\"mm\":\"3\",\"precioh\":1380,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/c.jpg\",\"cantidad\":1,\"stock\":\"1.00\",\"idc\":\"3\"}]', NULL),
(5, 'Angel', 'Aguazul', '7721630414', 1725.00, 0.00, 0.00, 1466.25, 258.75, 1, '2025-10-08', '2025-10-22', '15:07:00', 0, '[{\"id\":\"24\",\"codigo\":\"3502\",\"producto\":\"CERCO SUPERIOR\",\"preciop\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/KwG6i1uL4I.png\",\"cantidad\":1,\"stock\":\"1.00\",\"idc\":\"1\"}]', NULL),
(6, 'Angel', 'Aguazul', '7721630414', 4600.00, 0.00, 0.00, 3910.00, 690.00, 1, '2025-10-08', '2025-10-15', '14:13:00', 0, '[{\"id\":\"25\",\"codigo\":\"3504\",\"producto\":\"HOJA CENTRAL\",\"preciop\":2300,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/yQ0vQWTUZg.png\",\"cantidad\":2,\"stock\":\"6.00\",\"idc\":\"1\"}]', NULL),
(7, 'Angel', 'Aguazul', '7721630414', 2300.00, 1610.00, 4600.00, 8510.00, 2432.25, 3, '2025-10-08', '2025-10-09', '14:14:00', 0, '[{\"idc\":1,\"id\":\"25\",\"preciop\":\"2300.00\",\"cantidad\":1,\"codigo\":\"3504\",\"producto\":\"HOJA CENTRAL\",\"imagen\":\"images\\/yQ0vQWTUZg.png\",\"stock\":\"3.00\"},{\"idc\":2,\"id\":\"3\",\"precio\":\"805.00\",\"cantidad\":2,\"codigo\":\"1736\",\"producto\":\"CIERRE EMBUTIDO S-3500\",\"imagen\":\"images\\/TGiMAeTV4N.png\",\"stock\":12},{\"idc\":3,\"id\":\"2\",\"cantidad\":2,\"tonalidad\":\"FILTRASOL\",\"mm\":6,\"imagen\":\"images\\/f.jpg\",\"precioh\":\"2300.00\",\"stock\":\"23.00\"}]', -2300.00),
(8, 'Angel', 'Aguazul', '7721630414', 4025.00, 1840.00, 1725.00, 6451.50, 1138.50, 1, '2025-10-23', '2025-10-30', '01:39:00', 0, '[{\"id\":\"25\",\"codigo\":\"3504\",\"producto\":\"HOJA CENTRAL\",\"preciop\":2300,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/yQ0vQWTUZg.png\",\"cantidad\":1,\"stock\":\"4.00\",\"idc\":\"1\"},{\"id\":\"24\",\"codigo\":\"3502\",\"producto\":\"CERCO SUPERIOR\",\"preciop\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/KwG6i1uL4I.png\",\"cantidad\":1,\"stock\":\"10.00\",\"idc\":\"1\"},{\"id\":\"1\",\"tonalidad\":\"FILTRASOL\",\"mm\":\"3\",\"precioh\":1725,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/f.jpg\",\"cantidad\":1,\"stock\":\"20.00\",\"idc\":\"3\"},{\"id\":\"2\",\"codigo\":\"1305-0\",\"producto\":\"ESCUADRA FIJO SERIE 3500 CENT.\",\"precio\":1840,\"imagen\":\"http:\\/\\/127.0.0.1:8000\\/images\\/jYodS5DpMR.png\",\"cantidad\":1,\"stock\":\"11\",\"idc\":\"2\"}]', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vidrio_mm`
--

CREATE TABLE `vidrio_mm` (
  `id` int(11) NOT NULL,
  `mm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vidrio_mm`
--

INSERT INTO `vidrio_mm` (`id`, `mm`) VALUES
(1, 3),
(2, 6),
(3, 9),
(5, 2),
(6, 4),
(7, 5),
(8, 7),
(9, 8),
(11, 10),
(12, 11),
(13, 12),
(14, 13),
(15, 14),
(16, 15),
(17, 16),
(18, 17),
(19, 18),
(20, 19),
(21, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vidrio_tonalidades`
--

CREATE TABLE `vidrio_tonalidades` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vidrio_tonalidades`
--

INSERT INTO `vidrio_tonalidades` (`id`, `descripcion`, `imagen`) VALUES
(1, 'FILTRASOL', 'images/f.jpg'),
(2, 'CLARO', 'images/c.jpg'),
(3, 'ESPEJO', 'images/e.webp'),
(4, 'ESMERILADO CLARO', 'images/gA5vCyvLMB.jpg'),
(5, 'ESMERILADO FILTRASOL', 'images/ef.jpg'),
(6, 'REFLECTA PLATA', 'images/rp.jpg'),
(7, 'REFLECTA  AZUL', 'images/ra.jpg'),
(8, 'REFLECTA  VERDE', 'images/rv.jpeg'),
(9, 'SOLAITE GRIS', 'images/sg.jpg'),
(10, 'SOLAITE VERDE', 'images/sv.webp'),
(11, 'STB', 'images/stb.jpg'),
(12, 'CLARO VERDE', 'images/cv.jpg'),
(13, 'CRISTAZUL', 'images/c.jpg'),
(14, 'VERDE', 'images/v.jpeg'),
(18, 'tonalidad prueba 7', 'images/rCe1oayHoi.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aberturas`
--
ALTER TABLE `aberturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `abertura_componentes_aluminio`
--
ALTER TABLE `abertura_componentes_aluminio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abertura_componentes_aluminio_ibfk_1` (`id_abertura`),
  ADD KEY `abertura_componentes_aluminio_ibfk_2` (`id_producto_aluminio`),
  ADD KEY `abertura_componentes_aluminio_ibfk_3` (`id_orientacion`);

--
-- Indices de la tabla `abertura_componentes_herrajes`
--
ALTER TABLE `abertura_componentes_herrajes`
  ADD KEY `abertura_componentes_herrajes_ibfk_1` (`id_abertura`),
  ADD KEY `abertura_componentes_herrajes_ibfk_2` (`id_producto_herrajes`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_herrajes`
--
ALTER TABLE `categoria_herrajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `orientacion`
--
ALTER TABLE `orientacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `porcentaje_precios`
--
ALTER TABLE `porcentaje_precios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `precios_aluminio`
--
ALTER TABLE `precios_aluminio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `precios_aluminio_ibfk_1` (`id_producto`);

--
-- Indices de la tabla `precios_herrajes`
--
ALTER TABLE `precios_herrajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `precios_herrajes_ibfk_1` (`id_producto`);

--
-- Indices de la tabla `precios_vidrio`
--
ALTER TABLE `precios_vidrio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `precios_vidrio_ibfk_1` (`id_producto`);

--
-- Indices de la tabla `productos_aluminio`
--
ALTER TABLE `productos_aluminio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_aluminio_ibfk_1` (`id_tipo`),
  ADD KEY `productos_aluminio_ibfk_2` (`id_categoria_producto`);

--
-- Indices de la tabla `productos_herrajes`
--
ALTER TABLE `productos_herrajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_herrajes_ibfk_1` (`id_tipo`),
  ADD KEY `productos_herrajes_ibfk_2` (`id_categoria`),
  ADD KEY `productos_herrajes_ibfk_3` (`id_categoria_producto`);

--
-- Indices de la tabla `productos_vidrio`
--
ALTER TABLE `productos_vidrio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria_producto` (`id_categoria_producto`),
  ADD KEY `productos_vidrio_ibfk_1` (`id_tonalidad`),
  ADD KEY `productos_vidrio_ibfk_2` (`id_mm`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `series_aluminio`
--
ALTER TABLE `series_aluminio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `series_herrajes`
--
ALTER TABLE `series_herrajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `stock_aluminio`
--
ALTER TABLE `stock_aluminio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_aluminio_ibfk_1` (`id_producto`);

--
-- Indices de la tabla `stock_herrajes`
--
ALTER TABLE `stock_herrajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_herrajes_ibfk_1` (`id_producto`);

--
-- Indices de la tabla `stock_vidrio`
--
ALTER TABLE `stock_vidrio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_vidrio_ibfk_1` (`id_producto`);

--
-- Indices de la tabla `tipos_aluminio`
--
ALTER TABLE `tipos_aluminio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_linea` (`id_linea`),
  ADD KEY `id_serie` (`id_serie`);

--
-- Indices de la tabla `tipos_herrajes`
--
ALTER TABLE `tipos_herrajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_linea` (`id_linea`),
  ADD KEY `id_serie` (`id_serie`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `role` (`role`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `porcentaje_descuento` (`id_descuento`);

--
-- Indices de la tabla `vidrio_mm`
--
ALTER TABLE `vidrio_mm`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vidrio_tonalidades`
--
ALTER TABLE `vidrio_tonalidades`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aberturas`
--
ALTER TABLE `aberturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `abertura_componentes_aluminio`
--
ALTER TABLE `abertura_componentes_aluminio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria_herrajes`
--
ALTER TABLE `categoria_herrajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lineas`
--
ALTER TABLE `lineas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `orientacion`
--
ALTER TABLE `orientacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `porcentaje_precios`
--
ALTER TABLE `porcentaje_precios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `precios_aluminio`
--
ALTER TABLE `precios_aluminio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT de la tabla `precios_herrajes`
--
ALTER TABLE `precios_herrajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `precios_vidrio`
--
ALTER TABLE `precios_vidrio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productos_aluminio`
--
ALTER TABLE `productos_aluminio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT de la tabla `productos_herrajes`
--
ALTER TABLE `productos_herrajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `productos_vidrio`
--
ALTER TABLE `productos_vidrio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `series_aluminio`
--
ALTER TABLE `series_aluminio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `series_herrajes`
--
ALTER TABLE `series_herrajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `stock_aluminio`
--
ALTER TABLE `stock_aluminio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT de la tabla `stock_herrajes`
--
ALTER TABLE `stock_herrajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `stock_vidrio`
--
ALTER TABLE `stock_vidrio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tipos_aluminio`
--
ALTER TABLE `tipos_aluminio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `tipos_herrajes`
--
ALTER TABLE `tipos_herrajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vidrio_mm`
--
ALTER TABLE `vidrio_mm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `vidrio_tonalidades`
--
ALTER TABLE `vidrio_tonalidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abertura_componentes_aluminio`
--
ALTER TABLE `abertura_componentes_aluminio`
  ADD CONSTRAINT `abertura_componentes_aluminio_ibfk_1` FOREIGN KEY (`id_abertura`) REFERENCES `aberturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `abertura_componentes_aluminio_ibfk_2` FOREIGN KEY (`id_producto_aluminio`) REFERENCES `productos_aluminio` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `abertura_componentes_aluminio_ibfk_3` FOREIGN KEY (`id_orientacion`) REFERENCES `orientacion` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `abertura_componentes_herrajes`
--
ALTER TABLE `abertura_componentes_herrajes`
  ADD CONSTRAINT `abertura_componentes_herrajes_ibfk_1` FOREIGN KEY (`id_abertura`) REFERENCES `aberturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `abertura_componentes_herrajes_ibfk_2` FOREIGN KEY (`id_producto_herrajes`) REFERENCES `productos_herrajes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `precios_aluminio`
--
ALTER TABLE `precios_aluminio`
  ADD CONSTRAINT `precios_aluminio_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos_aluminio` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `precios_herrajes`
--
ALTER TABLE `precios_herrajes`
  ADD CONSTRAINT `precios_herrajes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos_herrajes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `precios_vidrio`
--
ALTER TABLE `precios_vidrio`
  ADD CONSTRAINT `precios_vidrio_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos_vidrio` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos_aluminio`
--
ALTER TABLE `productos_aluminio`
  ADD CONSTRAINT `productos_aluminio_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos_aluminio` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_aluminio_ibfk_2` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categorias_productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos_herrajes`
--
ALTER TABLE `productos_herrajes`
  ADD CONSTRAINT `productos_herrajes_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos_herrajes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_herrajes_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_herrajes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_herrajes_ibfk_3` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categorias_productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos_vidrio`
--
ALTER TABLE `productos_vidrio`
  ADD CONSTRAINT `productos_vidrio_ibfk_1` FOREIGN KEY (`id_tonalidad`) REFERENCES `vidrio_tonalidades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_vidrio_ibfk_2` FOREIGN KEY (`id_mm`) REFERENCES `vidrio_mm` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_vidrio_ibfk_3` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categorias_productos` (`id`);

--
-- Filtros para la tabla `stock_aluminio`
--
ALTER TABLE `stock_aluminio`
  ADD CONSTRAINT `stock_aluminio_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos_aluminio` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `stock_herrajes`
--
ALTER TABLE `stock_herrajes`
  ADD CONSTRAINT `stock_herrajes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos_herrajes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `stock_vidrio`
--
ALTER TABLE `stock_vidrio`
  ADD CONSTRAINT `stock_vidrio_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos_vidrio` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tipos_aluminio`
--
ALTER TABLE `tipos_aluminio`
  ADD CONSTRAINT `tipos_aluminio_ibfk_1` FOREIGN KEY (`id_linea`) REFERENCES `lineas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tipos_aluminio_ibfk_2` FOREIGN KEY (`id_serie`) REFERENCES `series_aluminio` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tipos_herrajes`
--
ALTER TABLE `tipos_herrajes`
  ADD CONSTRAINT `tipos_herrajes_ibfk_1` FOREIGN KEY (`id_linea`) REFERENCES `lineas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tipos_herrajes_ibfk_2` FOREIGN KEY (`id_serie`) REFERENCES `series_herrajes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_descuento`) REFERENCES `porcentaje_precios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
