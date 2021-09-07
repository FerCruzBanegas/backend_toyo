-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para bd_toyo
CREATE DATABASE IF NOT EXISTS `bd_toyo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `bd_toyo`;

-- Volcando estructura para tabla bd_toyo.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cities_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.cities: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Santa Cruz', '2021-08-23 11:27:26', '2021-08-23 11:27:26', NULL),
	(2, 'La Paz', '2021-08-23 17:21:28', '2021-08-23 17:21:28', NULL);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `names` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surnames` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_ci_unique` (`ci`),
  FULLTEXT KEY `customers_names_surnames_fulltext` (`names`,`surnames`),
  FULLTEXT KEY `customers_ci_fulltext` (`ci`),
  FULLTEXT KEY `names` (`names`),
  FULLTEXT KEY `surnames` (`surnames`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.customers: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`id`, `uuid`, `names`, `surnames`, `phone`, `ci`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '8b750be1-6405-47ac-b00c-50fed4f06a93', 'pablo', 'llanes', '76896456', '8976567', NULL, '2021-08-24 16:23:11', '2021-08-23 16:23:11', NULL),
	(2, 'ebbe9ad8-a506-461c-b98b-d61566d45410', 'jose', 'campos', '687657789', '8097688', NULL, '2021-08-23 17:50:04', '2021-08-23 17:50:04', NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.exchanges
CREATE TABLE IF NOT EXISTS `exchanges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `quantity` int(10) unsigned NOT NULL,
  `delivered` datetime DEFAULT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.exchanges: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `exchanges` DISABLE KEYS */;
INSERT INTO `exchanges` (`id`, `uuid`, `state`, `quantity`, `delivered`, `owner_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(33, 'b84b05d7-2203-44ac-bb8d-db24f133856a', 1, 1, NULL, 2, '2021-08-31 19:04:58', '2021-08-31 19:04:58', NULL);
/*!40000 ALTER TABLE `exchanges` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.exchange_ticket
CREATE TABLE IF NOT EXISTS `exchange_ticket` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exchange_id` int(10) unsigned NOT NULL,
  `ticket_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `exchange_ticket_exchange_id_foreign` (`exchange_id`),
  KEY `exchange_ticket_ticket_id_foreign` (`ticket_id`),
  CONSTRAINT `exchange_ticket_exchange_id_foreign` FOREIGN KEY (`exchange_id`) REFERENCES `exchanges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `exchange_ticket_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.exchange_ticket: ~15 rows (aproximadamente)
/*!40000 ALTER TABLE `exchange_ticket` DISABLE KEYS */;
INSERT INTO `exchange_ticket` (`id`, `exchange_id`, `ticket_id`) VALUES
	(436, 33, 3),
	(437, 33, 4),
	(438, 33, 5),
	(439, 33, 6),
	(440, 33, 7),
	(441, 33, 8),
	(442, 33, 9),
	(443, 33, 10),
	(444, 33, 11),
	(445, 33, 12),
	(446, 33, 13),
	(447, 33, 14),
	(448, 33, 15),
	(449, 33, 16),
	(450, 33, 17);
/*!40000 ALTER TABLE `exchange_ticket` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.migrations: ~15 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
	(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
	(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
	(6, '2016_06_01_000004_create_oauth_clients_table', 1),
	(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
	(8, '2019_08_19_000000_create_failed_jobs_table', 1),
	(9, '2021_08_16_142844_create_owners_table', 1),
	(10, '2021_08_16_142930_create_cities_table', 1),
	(11, '2021_08_16_143044_create_stores_table', 1),
	(12, '2021_08_16_143045_create_customers_table', 1),
	(13, '2021_08_16_143116_create_tickets_table', 1),
	(14, '2021_08_16_143433_create_exchanges_table', 1),
	(15, '2021_08_16_143623_create_exchange_ticket_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.oauth_access_tokens
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.oauth_access_tokens: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
	('18f829a5e3296b4155e88279e887ef6bd559939f42546aa81e867f601bdec257114fe56b74581a51', 2, 2, NULL, '[]', 1, '2021-08-31 16:08:55', '2021-08-31 16:08:55', '2022-08-31 16:08:55'),
	('2febce6ae9cd2e72525e0c091cae0418fb9abcea35713ea508b7f8265db60303174e1a61d4c171ae', 4, 2, NULL, '[]', 1, '2021-08-27 15:38:36', '2021-08-27 15:38:36', '2022-08-27 15:38:36'),
	('66807c83a3da95ea7dd4bb493ec4d88c3f5545656e51a7c0fa36e04b6bba36f86b9d94b170713503', 2, 2, NULL, '[]', 0, '2021-08-31 21:11:13', '2021-08-31 21:11:13', '2022-08-31 21:11:13'),
	('6ed3141a7c5d4c1ee4aed5ba0082c1a3af4973cbf1352c06c59ac7624883e4d36bff036f6c14f52e', 1, 2, NULL, '[]', 1, '2021-08-31 21:04:32', '2021-08-31 21:04:32', '2022-08-31 21:04:32'),
	('82da5c4bf146d775febfaf2ec3c31dd2e888b008a77b233d9235e73347579d6bb754a2607b5000e1', 2, 2, NULL, '[]', 1, '2021-08-31 17:55:18', '2021-08-31 17:55:18', '2022-08-31 17:55:18'),
	('a71bfe578b23a9028613a5116fa13f06cf94aa9838bb46c3b66d651154216a470a7ea5b39d8e1bc5', 4, 2, NULL, '[]', 1, '2021-08-27 15:36:57', '2021-08-27 15:36:57', '2022-08-27 15:36:57'),
	('a9d855a7cae2786f58c98ed22059d3de7cb5872db7ae586443ba7f0e9531139dc09b123ee170d293', 2, 2, NULL, '[]', 1, '2021-08-31 16:07:58', '2021-08-31 16:07:58', '2022-08-31 16:07:58'),
	('cc3b694f2c494f9c370cbcb7bc6d716f0f662b67af94471b1f65e598ef44a94e44e84273241f66e7', 2, 2, NULL, '[]', 1, '2021-08-31 18:11:15', '2021-08-31 18:11:15', '2022-08-31 18:11:15'),
	('e98309545e6215e4f95696766c148dfc7a7b1c3eb93adf99e9c80a747f02c9bb193d72c19922f9a9', 4, 2, NULL, '[]', 1, '2021-08-31 16:08:08', '2021-08-31 16:08:08', '2022-08-31 16:08:08'),
	('f629416de0dc16a13cbe2dacf32a4e1d3bdcd7a2ff20ef098c1e3dedab285a466fea7b29e6bdec3e', 4, 2, NULL, '[]', 1, '2021-08-27 17:51:55', '2021-08-27 17:51:55', '2022-08-27 17:51:55'),
	('f9b197fcc895ff6da455540e40a7eeef7f8c20352d589ddf3dff4214753e7d4ee96205b518b0190d', 4, 2, NULL, '[]', 1, '2021-08-27 15:40:03', '2021-08-27 15:40:03', '2022-08-27 15:40:03');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.oauth_auth_codes
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.oauth_auth_codes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.oauth_clients
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.oauth_clients: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Baterías Toyo Personal Access Client', 'RnATTGSxMAb1IRF3rY2jf3WBuWgliZWfOtM6J49n', NULL, 'http://localhost', 1, 0, 0, '2021-08-23 15:25:48', '2021-08-23 15:25:48'),
	(2, NULL, 'Baterías Toyo Password Grant Client', 'JIwSBABKD8DOd4iJscU6uxB6BGy7sdu5pLYJa4Yr', 'users', 'http://localhost', 0, 1, 0, '2021-08-23 15:25:48', '2021-08-23 15:25:48');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.oauth_personal_access_clients
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.oauth_personal_access_clients: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2021-08-23 15:25:48', '2021-08-23 15:25:48');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.oauth_refresh_tokens
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.oauth_refresh_tokens: ~57 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
	('049d2befdb9a3e15343e40839602b18127ff21f6b8a1d97b8e8265f293804c1f090027060f442ece', 'aebb2840554c2f56267a289f8a7dee9219d77dfbe282b57750e192dbe153b07a0a6df9ac978247ec', 1, '2022-08-26 14:30:49'),
	('05f63dcfd1fc8f29e52742720c98ca4b14b466811baf821647599522bdae1678be5b19899bfcf5e4', '7add0d44adbc75274d5f4307071cb063ac0ad600a7a17d14b68f424aeb3c689122a00c2c906fd573', 1, '2022-08-23 21:39:01'),
	('0e8172cce6474566d5ec083f00d576d23f678e8df73cf00124de4079e6e81ea334f3e86c518a22d4', 'c54c6806ea1348cee897e2ef69c0947bf8885d5970761b4417134aa1f7cbbc4a3c04a9171674bba7', 0, '2022-08-23 18:49:10'),
	('0eef98c6c9d1f02db67cd376e42bd7d398ef8481d827790617e048ad8a3bce0c8b8a6dc98d32ef5d', 'b91f808bedb2c9b74e2514a008cff9454e84a1d406a61536d3a975759694ef05013e4a9710f48ab6', 1, '2022-08-27 15:42:47'),
	('198980e18a800d0c629c37ea81ec4aa271adfd3630e6b9a6cb3f655ae7ddad047674934738d6fe65', 'c5116cab3e2a2739b373df54b163f62666b2e065c0414ae214af3faacd3c9ad07bf2e569049cf0fc', 1, '2022-08-29 02:11:05'),
	('1a362c02893339c070cc5bd77fd92b6971014e706c5ce7c78012ac27a6e787baf9147366a067807b', 'ae4d8b961a81315bcf1b4972a484ebe6c6ced9a95b33224f77723cdccb1dfe6cc93815676f7d2766', 1, '2022-08-27 19:43:48'),
	('1cc782342253c325dd9b80f0fbb50d164275e0a80252fa481f67223643a20bc02f882556f728590d', '2c347a508150bc2a9ca1f555241f53a9819d30fc40fb8ef8b0277c24f9518dfcc9f807188c991ae2', 1, '2022-08-27 19:47:57'),
	('20b3e70a1cb65bc33a13e2e3c4bfeb49e7af88bd1d57c1b9145656f004481249dbbc1305351710ee', 'a71bfe578b23a9028613a5116fa13f06cf94aa9838bb46c3b66d651154216a470a7ea5b39d8e1bc5', 1, '2022-08-27 15:36:57'),
	('21a049baef44d11167cd674beb8cbb6a7dbc63fdc51e6d7ba3bd0ae81e9653ab048cabe17a6b7e41', 'dbaa26a41e9c0e2ca3ea492f8e391c463d68739062b86011b9899f351a3910f1cf52e1aa8166a0af', 1, '2022-08-28 17:03:43'),
	('246b272a45b6ddabb27bf417fa0656043664ba29f7944d4055fd4f319ec86d7fa4b8eb5417b8f2fa', 'fbbc854b49849af5ebbe6545a862fee2885403d0acfe89685a396e7470503be119d025b386fde09d', 1, '2022-08-23 18:13:03'),
	('27e1784b6504dec348749c1cece1451c582c680dc17b8ffcc1d8bab5fe026c3f4a7685d3bb3cb66f', '8a1b99f24314580f81b2905e082b4bd30a67af0795707ff940621454fe7f075a2afb3e0959d4ce94', 1, '2022-08-23 18:29:55'),
	('28312ec41994eef18d55de96d234064ae5be954d83f277df986d53f86288440bf697f44d5c5a8d19', '8a9e211171597ef2a3d8c96d62f70eb3a57dae9ac33b6bcf4277b5eae1eee1aaa0fb6f4b3ec36496', 1, '2022-08-27 15:51:41'),
	('2999ac0bc4c66720446f81174537fadbec831d8bdf298edf875066737999dac3e0274a6d6ff0e9bb', 'd3c98ac1a9ea633b0ee88187a736dcf8fc7a1e660f8a4dfdfe8bb34bb1a4592540224969a6c41b74', 1, '2022-08-23 15:44:49'),
	('29f9c6de158f5d5712f991020d6ed2eb2b0f718db8c74788244c3c24786daa4497a20e0e9ca73c21', '53237086436fdf2e5dc2525f0c583b8b8e186dc9c1887551b11dfb78e38dc2443f1bc7a7e6efed9b', 1, '2022-08-23 15:54:34'),
	('2d2990794299ecbeeb81f4479e8b0f1f5e510ba414e4a81c426e977e2da9b7f16233d6a9f1106a7b', 'dfcf58fc90cde462e53e50fd86936a220c1d483f636af88227ab35d71f5e778c8bf8eb6d26c64422', 1, '2022-08-29 05:52:23'),
	('2e418dafc405ebac10006ac6e5aad8ba6a6d1c3b1b2c5a11eea520e8665b3927662e6200b1a34819', '6df19bab8630de7157e50be0e7c8611b8617b6695cdbaaca3fffe5d8d697012ae3c0524cdf4f716b', 1, '2022-08-23 21:43:44'),
	('2ea0e4bbabb516b5fca0ff8eca7504a7cf1b378490d73d2a8b5791d77ee6b4b4a2821ef8968ffea0', 'b6b7068ea25641b7b9663a02160c1b406b05fc733ac2f2f878937b7be9e103d2b81d8a9b9f632a74', 1, '2022-08-23 18:36:04'),
	('2f6e02525f51a46898dbb2f0a4bb62c5c563437c5b1d6554763b7d604542a3d8e281e93f1f7cabb4', 'ff1606d0939fd927be10b04e6f328f3d1495e7d6c403e70fd8684ea145568946eb20999d17bb0ade', 1, '2022-08-23 20:23:52'),
	('2fdd649aa06f1f0f3e929e4c2a9eea934f9b8e83c93df638973ba20ef841ef94a14aeb7023c53248', '051f207cf3c5341b14107798878f49a11ccf8d1e0d328ccd6f027685835282f7a3abe1c7751cbecb', 1, '2022-08-26 14:30:19'),
	('305cf92af43fe2509b2af7e3e8f7d6020813fb5fb8b84536e0abf1e1fcdc270e891c64574a3257af', '02117d942770a01147d4c6a8b5fc544bcdb0468c416745624ca4cf9c44445455cdbd213521bad7c6', 1, '2022-08-23 22:07:38'),
	('39543a6bc68cf9f2119617167e78d8ff5a590be3412bf771b5374cd9c19e9cb4cad2a75ce552b34c', '7cfabb319ff55cddc8055866c322f1df7621366ab6bc9c1a944838534b19d8c4802cba49dfe91ba9', 1, '2022-08-23 16:11:17'),
	('40fffc7f4af1aaae469b2d168cff120ef2fa46ad40eb5966781af3c5090787498d8a84395605ad22', '1e4599c70528380fef115ef481b7740123dd22068a58d27ef0926b956778e54945bdbc6b661d9b01', 1, '2022-08-28 21:16:33'),
	('463844767ed3ceceb2c4380f04ab140a244f8a48a9cf78eae4703eb675dc0ae47cf85ddb7daa3897', '18f829a5e3296b4155e88279e887ef6bd559939f42546aa81e867f601bdec257114fe56b74581a51', 1, '2022-08-31 16:08:55'),
	('473ba685a1171fa2c3f54b7b0157a9f9f5bc546e80d911a24602a8bd24b4c973025550564e0f7620', 'a9d855a7cae2786f58c98ed22059d3de7cb5872db7ae586443ba7f0e9531139dc09b123ee170d293', 1, '2022-08-31 16:07:58'),
	('480f516d21b2a92aa3fc9f98122660f0df452164d742f77e3c517cb482a0d7ae8901ef182bfe9b3a', '66807c83a3da95ea7dd4bb493ec4d88c3f5545656e51a7c0fa36e04b6bba36f86b9d94b170713503', 0, '2022-08-31 21:11:13'),
	('4a5164767eb71bda788b0740dab6416597e9d9b8fad42c49b49d0edd341b2017a48de0f01631ef7b', '87d9d7475c2aea3e2e04ec28b6975c468b2fcdabb2673ff661e1ea7175524b8178eba4be86af88ac', 1, '2022-08-23 18:13:14'),
	('4d4ea4b85bf6eaf93bf6d5664f16869916733f8e548da4beee59a1b1a1a124ca1dc2187990707cbb', 'cc3b694f2c494f9c370cbcb7bc6d716f0f662b67af94471b1f65e598ef44a94e44e84273241f66e7', 1, '2022-08-31 18:11:15'),
	('4dc9c53a59f649b1d70b01aeeb884deb0deefa58a6159261b8de857192e35eb8e063e56872357d6a', 'dce4f40ec8b7d63d457b676f0c37496bc44e4f38dc347b1d45dbad9dbdaa3d54b72f48f5430a8830', 1, '2022-08-26 21:24:16'),
	('53c08f0d9c62123aa0cc1cc82942f02e2d74d535385f82488852bdea237faf4dafe3eeafb7c32008', 'be104e23644dd57b80fc38f4e9cf3546ee82dbe9f231e910dccc18a2e2fbfc4f0a69f534e37d9a77', 1, '2022-08-26 21:26:02'),
	('5ad15196c67235d2290d62829416ab5c738a3953fb9c57f8aa79a17dfd177ea1864386efa66d2496', 'ff9ede8842822901b0b1b4577370832981cd12582729902e10730587583347944762ed79426678eb', 1, '2022-08-23 18:46:11'),
	('5fcca1af0bce1479629486bb6201ff3e80090d6f37baa15be73cb05a41e98fc84714288b43decaa4', 'f3cf6ba08cbf1a5a14c330b4668e6cbcd12bff3cd64fdbc101e21f49b83ad6f1cad4d3894b675e9c', 1, '2022-08-23 21:31:18'),
	('64290b5cc42aa9727b1d177ed2c64ab4282163bcfeb0d1a1d39da966a75387baff95c0f786876367', '3e0173ef34489e67b8f78f6a9682d0a1d3521e94a1958edb7a65335e5486199f3c30e0f383d9fff5', 1, '2022-08-23 18:37:30'),
	('65784d0ad9fbb0620dfa5990c7509764eb85c6d8f45f40c051c52a572017acdd3a4028f3343f64fc', '906e3a0db2ffa6dcd9bb93d9fc7474e55d262361d15aed270a201da31d27f165871d10ca60d9afb8', 1, '2022-08-29 05:31:51'),
	('7043c61dd10203bb5dc065570d21e7503853d6c87fc126d66080db96dd6d9a7b955e858ba6a7e6fe', '0c98c1a6d3c4d96eb19a1ca534994c2993e5cc20a63a75381371a6c7616dc847011eb00fd2c68712', 1, '2022-08-23 21:43:36'),
	('74edfeb34a285c78a614b5fb0a10d0dead5eee22a429d16ac5db61f6bb9cd776b2b91ab2e879610d', '22f736cc4aca2d87776232c1ba24d6b2d0bb4bda0e528c005cfae60906743ab86aa11b3ded81bd66', 0, '2022-08-29 16:42:32'),
	('7a63842825c84dfc4d20bfb407a0305e664c7c17e2ba14b5b17cda0ed1758647f11bc8382a2d1233', 'a058f0bb34f9f0b4cc0826d052318a0382904de5d9f9d77324bc286f1eb91023ab6610e00f8ef2e1', 1, '2022-08-23 15:48:31'),
	('7b98a162f4e3525593a83a78af1a6343fb158f626bd1a8f512bf3761e24f58dbcc786f76ed47dc21', '480a075829180aa6a54e77e27e79c489c9df12142118fa371cc546df41d13e336179a3687dbea098', 1, '2022-08-23 18:31:50'),
	('882068b4739093197db756b584f2fa7e6e461c5372b7c8546ac2edbb8c9a15bad6492d2c86061369', '0030db89615f6f3d3d062095228f4854d3ed397dce512c2aa7862d490a498e1203c669fb893f59f5', 1, '2022-08-28 23:35:30'),
	('8ad5760c68c6dcffe4ab7c204adfb8ec359c16a171e7ca31fb8d8278f08faad7441daac5cec4c998', 'e201b09431dab6cbb1281188918f320f2b172e404f30d6a1a40898de039c2ca9982743bcab6867fe', 1, '2022-08-28 23:47:22'),
	('8e7a63d51b676b66bc240f8495eb1e19fbabc5268429661cdbb1361e99c88aabdcb2452eaf2c11b7', '82da5c4bf146d775febfaf2ec3c31dd2e888b008a77b233d9235e73347579d6bb754a2607b5000e1', 1, '2022-08-31 17:55:18'),
	('95709bcf363cad6a7b08d08df767566ba96f9266b930cf46457f3ddbd6b0f53c5d6e73cd5cc3db7e', '78ca8e443d717fb4434c9dfe59df8aa11a4e2611a2f143e7b5c28f34dc1326b45be26ea4e03c42fe', 1, '2022-08-23 22:17:42'),
	('97578bcf0c93f1838c5d4c3a1e638b017631dc432f43957d31131313a18dde38b01378c1003aee45', '7bc23779b0a062650d7388652768ebecff16757be8779f4ee2cb4a44b6b296108c1b43d4a60ce44b', 1, '2022-08-23 18:48:24'),
	('9d883bde45c588bb6d9214ac279e379c4277e600063132dbb2f61b3cc4183bf14e8afc38ef2edb45', 'b733d4f6c587f926b36a3eca727c55fb0f85c142b7de415421e839b4881993df5b63c7973414e7a0', 1, '2022-08-25 22:49:06'),
	('a0ca4cac90cca1d0d808cbc1cbb57b281a8fc58d9f44d71a6798371be7fd3b7238c171c31b5e2a03', '2060045a7bd6e98664a7d3dbd95570829294f671e2cc9eb2aabe2e9cf8020dc0310071b914a0fbb3', 1, '2022-08-28 23:51:04'),
	('a3ca8cc284ccdfbdb2c51035eb47135d923f0ceb7ad6e8573f62be1076c8031c75fb182a3c7b627c', '2febce6ae9cd2e72525e0c091cae0418fb9abcea35713ea508b7f8265db60303174e1a61d4c171ae', 1, '2022-08-27 15:38:36'),
	('a852cecaa13d9ac9099552db679d213a3dc0b8f2a13bd196dae68face3b552a4aea1393e41c609f4', 'e38c5c6d1becfc7df0cc1e3b6d6076b60947290d0951b02b9c702a3c4f1fe8b1e467f7dd288af012', 0, '2022-08-27 19:48:07'),
	('acdbaa053d58a4648c49b87ccc8637f99bdf91133f01c76adc3d0ec92839c3413876cac3dcbc4a01', '05f0983b04f2f011011b496b163d45db7c2317f1aa137f5a3c00a4ffb323f26ba1694584f2c6ba28', 1, '2022-08-28 23:41:00'),
	('adfea135a106e90ca852f8e9204c057617e9a2f11e6807ca3e50e2c39ee2383b6b5ffb37cf70a8c7', 'f9b197fcc895ff6da455540e40a7eeef7f8c20352d589ddf3dff4214753e7d4ee96205b518b0190d', 1, '2022-08-27 15:40:03'),
	('b4f9a3c8bef865ff07e818e1067e9493f4c2152a1fa8dfcaa8f084b35535b927b862a297539e63b7', '032a6b19017a4b1fd43034bb0ab4398fd96b4ce31fa184303dbf61c1632fb88f6ba5c8547f97a3c1', 1, '2022-08-31 16:00:22'),
	('b849c1a5a2b93d63dbd504134f85805de6acc75e562362afa1bef4a1abede9545e0c201c7f1f7b5e', '6eb095800b55c33bad027eed4b455eecdae3ed11437949210c1cb05a97a4eadf00ffa33bc7130e07', 1, '2022-08-23 17:47:15'),
	('bd07b791a3613f58690ada994dd54b96ad381fedef68c4e368871906a6c76941e2e504f22a19c571', '300c7c28f1f7e85b53de1b5e7c22df8f979a335d48fca1498293464647e5f62d7ddba0c9752819f8', 1, '2022-08-23 21:46:50'),
	('c538afcd27342170e325686c948cd846d8e6099da5a0ca0df6e397835e14bb307b8d3e6484923854', 'd41612340c4adf20fc95e45b61acca40bf4874b134a550a9e2868df832cefd9026a950e0802c62e8', 1, '2022-08-23 15:51:46'),
	('d0d8bb40941694abbb14949f2552b49a5337418f665f30fdd88f63c6013a6b35fc7741aa8d584ee1', 'e5789544547c70fd7fa256baea888d8606a4082701d20a623c48e30ee3c5fc6fba06829ec73a4bc2', 1, '2022-08-29 05:10:05'),
	('d1d3a60326c96b3bb0a53b925ed3327756857b68d50925f50c593c1154c62a6fd2be01928f0ee8d0', '6ed3141a7c5d4c1ee4aed5ba0082c1a3af4973cbf1352c06c59ac7624883e4d36bff036f6c14f52e', 1, '2022-08-31 21:04:32'),
	('d1f9951843b847e64b821f62d1ae0641f1ed4678f7805a62b6952ec6a4e432da7f939711e190661c', 'aa11e3691d6cd1ba7ccc6f575c1f9e6237e83fd0b127b2bf94b30def1990760ad6aa5263ed5a28cc', 1, '2022-08-23 18:46:19'),
	('d94fd65d012952499a50c035b1dea1ca437f9701ed62871c34e9cec25d6259c8a76ed0b4cb519b86', 'fd35912c2105fe5c115b482c51d89e230d6cc35970f31047d0f698bd38b3ff3011da778f83cf479d', 1, '2022-08-23 21:25:50'),
	('e0de74ae41ddeb4d50e50806c66a479ec73463d9f009d17d58562f3b45cab38eaa7a426a4a999c1d', 'f9ca977a8d4b6a704f8077e2b30d9d34b8a7ea5d0c1d9c1cee5f6c5db788fd047374465d6c7bcf1b', 1, '2022-08-28 23:40:31'),
	('e69c3e077632fb239ca9b2f05ab5f6b44368e90731b605bade3dffd392f3372efa00452c42ba35d6', 'f629416de0dc16a13cbe2dacf32a4e1d3bdcd7a2ff20ef098c1e3dedab285a466fea7b29e6bdec3e', 1, '2022-08-27 17:51:55'),
	('e9c4a70f56a50cf27d2385f5578fadd712409349c57f4283e80ab7064e4984b1337c5959ca52e328', 'e02e50d6ae34153da5c36bcec494630a8dade557c4327729ae70bb016a4ad52cd3a66bd5064d2c97', 1, '2022-08-24 11:38:42'),
	('ea234303d8d6e65437517e82c82e81eac85172edaeee765b098eb3550c578e5ec17ac7f2fa1ac35a', '32f0e116519ded4112f1cf96a47b99be6d293c7d61848a7f7f483e6efb5a5a2ad7d2f9569ee187d4', 1, '2022-08-23 22:26:09'),
	('ec4d99ef8b718ca397b4e1c666541d1d4a34e99e07b4dfa091f414a6f873d2e05d62eb64265517f2', '1df0c960c2d445325b260503c057eddda94c2084c95c34e7aac97806dba2b6bde8937e2da0c149a1', 1, '2022-08-31 14:48:15'),
	('eeff32873c24224a66c5f85c7db354a9562d807b00a654e20e32d6481a75c729416864eb6a2520c2', '38b11001bee68d219482639628c785e3bd5b1f2e668d01d8f9038354e2529e8b37a7f499248cffdb', 1, '2022-08-23 20:24:11'),
	('ef6496e9033a2d72658033431ea784bffcfea98ee5f6eddfd69a48d6b1736c616e075cbf60de7ab0', 'db69203d13270ae6f1883e0ce3e32f97ae6ec94d9fb5aa5cf405f010ccf3fc85adb2ce55cda10687', 1, '2022-08-23 21:25:28'),
	('f6dc0ed6be06989cf93e514ac40cf64d98a0f2574a23ed8f33ea1aff94e54889c281c72aa0e5716d', 'e98309545e6215e4f95696766c148dfc7a7b1c3eb93adf99e9c80a747f02c9bb193d72c19922f9a9', 1, '2022-08-31 16:08:08'),
	('f807f75e3d9341e58c10ad2d4051c8dc04387a4b6d91feef75bb91bd93d095ca5c152223c1af93b7', '1eaa272435adf2c9c5ea0e1eb6ac84ed2cb79b722235b0028f0c7468ad971535b8ca9f37dcf3646b', 1, '2022-08-23 18:28:40'),
	('fdf94e89bbf879b2ef199aecd1b8716c8d8a0c062c884afddcabc8ade7d4c31ccb31731e6093a738', '93e3743732235d72fa01ba098d3813f6cf426b1d9ebceb4b054f63994463feeee54105d2e85e0b3a', 1, '2022-08-23 21:48:30');
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.owners
CREATE TABLE IF NOT EXISTS `owners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `names` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surnames` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` mediumtext COLLATE utf8mb4_unicode_ci,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `owners_ci_unique` (`ci`),
  KEY `owners_user_id_foreign` (`user_id`),
  FULLTEXT KEY `owners_names_surnames_fulltext` (`names`,`surnames`),
  CONSTRAINT `owners_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.owners: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `owners` DISABLE KEYS */;
INSERT INTO `owners` (`id`, `uuid`, `names`, `surnames`, `phone`, `ci`, `address`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'ea421ba4-5703-4455-b4d6-a6d1f5837f66', 'Jose', 'Mendoza', '78067890', NULL, NULL, 1, '2021-08-23 15:28:04', '2021-08-23 15:28:04', NULL),
	(2, '037bed9c-c82b-4a05-ad08-381ab17a4103', 'Fernando LADISLAO', 'Cruz Banegas', '68774551', '8914346', NULL, 2, '2021-08-23 17:46:31', '2021-08-31 16:22:55', NULL),
	(3, '0471ebc1-06e7-406b-8655-c894836c0dad', 'Pablo', 'Montaño', '7897865', NULL, NULL, 3, '2021-08-23 22:05:38', '2021-08-23 22:05:38', NULL),
	(4, '91d3d34b-906f-4770-9b7d-c984cb35d203', 'Jorge Tito', 'Cruz Mendoza', '72156894', NULL, NULL, 4, '2021-08-27 15:36:12', '2021-08-27 15:36:12', NULL),
	(7, '1dbf0cad-6164-44ca-a36c-3d4d0ab38a1f', 'Nano', 'Banegas', '770785968', NULL, NULL, 7, '2021-08-29 02:07:32', '2021-08-29 02:07:32', NULL),
	(8, 'df7837b2-eed8-4948-827c-4ffec81fff39', 'Manuel', 'Banegas', '78027339', NULL, NULL, 8, '2021-08-29 03:29:24', '2021-08-29 03:29:24', NULL),
	(9, 'a5b698d6-9578-4fc7-be79-3d6060405811', 'Tito', 'Mendoza', '770789578', '8914345', NULL, 9, '2021-08-29 04:34:51', '2021-08-29 04:34:51', NULL),
	(10, '73746c7b-9e2e-47e1-beab-f765f6808a4e', 'Daviv', 'Banegas', '78967587', NULL, NULL, 10, '2021-08-29 05:40:56', '2021-08-29 05:40:56', NULL);
/*!40000 ALTER TABLE `owners` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.stores
CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stores_city_id_foreign` (`city_id`),
  KEY `stores_owner_id_foreign` (`owner_id`),
  KEY `created_at` (`created_at`),
  FULLTEXT KEY `stores_code_fulltext` (`code`),
  FULLTEXT KEY `address` (`address`),
  CONSTRAINT `stores_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stores_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.stores: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` (`id`, `uuid`, `code`, `address`, `phone`, `city_id`, `owner_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'a2758481-1f91-4c9d-a249-27adef8cf50a', 'bb4766aa', '3 Anillo Grigota', NULL, 1, 1, '2021-08-20 15:28:04', '2021-08-23 15:28:04', NULL),
	(2, 'bd588f4c-3f58-4a75-acd3-f4aa91b25c5a', 'b0038940', 'Av. Virgen de Cotoca', NULL, 1, 2, '2021-08-23 17:46:31', '2021-08-23 17:46:31', NULL),
	(3, '5dc23646-e455-4a8b-9352-1708efef3c27', 'd24ea19e', 'Los pozos', NULL, 2, 3, '2021-08-24 22:05:38', '2021-08-23 22:05:38', NULL),
	(4, 'ce31a231-bdab-4211-b4c7-d24174a5b1a9', '97fbbf9f', 'Los Pozos', NULL, 1, 4, '2021-08-27 15:36:12', '2021-08-27 15:36:12', NULL),
	(7, 'b7d918bf-856d-49e0-b878-81db974174e3', 'b2b565b4', 'Los pozos', NULL, 1, 7, '2021-08-29 02:07:32', '2021-08-29 02:07:32', NULL),
	(8, '0c19b43a-e087-4661-9ce8-ecb6cbfd6fb4', 'b7865f1e', '7 calles', NULL, 1, 8, '2021-08-29 03:29:24', '2021-08-29 03:29:24', NULL),
	(9, 'a527fcaf-0688-4c33-996a-6c2637f93ce7', 'fdb2327b', '7 CALLES', NULL, 1, 9, '2021-08-29 04:34:51', '2021-08-29 04:34:51', NULL),
	(10, '5cb44a02-1101-400d-8275-68096229309d', 'd11cd5c2', '7 calles', NULL, 1, 10, '2021-08-29 05:40:56', '2021-08-29 05:40:56', NULL);
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `battery_code` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `owner_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_customer_id_foreign` (`customer_id`),
  KEY `tickets_owner_id_foreign` (`owner_id`),
  FULLTEXT KEY `tickets_battery_code_fulltext` (`battery_code`),
  CONSTRAINT `tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tickets_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.tickets: ~22 rows (aproximadamente)
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` (`id`, `uuid`, `battery_code`, `status`, `owner_id`, `customer_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '266b999e-9232-4182-8b17-111030b1514a', '8987879878878833', 1, 1, 1, '2021-08-23 16:23:11', '2021-08-23 16:23:11', NULL),
	(2, 'a899a0fe-7c40-4700-809e-b14d99795d84', '1234567890112345', 0, 1, 1, '2021-08-23 16:25:35', '2021-08-23 16:25:35', NULL),
	(3, 'f163629f-ab17-4145-a42b-0c7fdd949ad6', '1234457363637233', 0, 2, 2, '2021-08-23 17:50:04', '2021-08-31 19:04:58', NULL),
	(4, '50b15219-cf08-466b-80a3-20ad85cc2b86', '1232323213213132', 0, 2, 1, '2021-08-23 22:13:18', '2021-08-31 19:04:58', NULL),
	(5, '051a02a8-8227-419a-b6c7-7af9097ff58f', '1234567891011121', 0, 2, 1, '2021-08-27 18:09:06', '2021-08-31 19:04:58', NULL),
	(6, '8571731a-efdc-4898-b785-01b5b67ea195', '1231321654687498', 0, 2, 2, '2021-08-27 21:40:00', '2021-08-31 19:04:58', NULL),
	(7, '8ccacddf-cf86-48f9-b6bb-0bf9078cd39b', '1231321654687491', 0, 2, 2, '2021-08-27 21:40:05', '2021-08-31 19:04:58', NULL),
	(8, '558be13c-1df3-45fc-a4f3-0df7b1a5fc29', '1231321654687492', 0, 2, 2, '2021-08-27 21:40:08', '2021-08-31 19:04:58', NULL),
	(9, '7f9aae77-30e0-4362-b5e7-e5147bd2b5eb', '1231321654687493', 0, 2, 2, '2021-08-27 21:40:10', '2021-08-31 19:04:58', NULL),
	(10, '74d4c3af-734f-4a6e-80ae-e896302b535b', '1231321654687494', 0, 2, 2, '2021-08-27 21:40:13', '2021-08-31 19:04:58', NULL),
	(11, 'b3483617-9628-4fd2-8dd1-8570fc87110a', '1231321654687495', 0, 2, 2, '2021-08-27 21:40:15', '2021-08-31 19:04:58', NULL),
	(12, 'ff9dd7dc-91f4-4d66-8260-7a84bd53e7ae', '1231321654687496', 0, 2, 2, '2021-08-27 21:40:18', '2021-08-31 19:04:58', NULL),
	(13, 'e2e1c95e-844b-4147-b9a0-17575c74df57', '1231321654687497', 0, 2, 2, '2021-08-27 21:40:20', '2021-08-31 19:04:58', NULL),
	(14, 'defdd101-258a-4596-ad6b-d843b714a986', '2231321654687498', 0, 2, 2, '2021-08-27 21:40:27', '2021-08-31 19:04:58', NULL),
	(15, 'd9c731df-9d81-496d-9546-7ba70723442c', '3231321654687498', 0, 2, 2, '2021-08-27 21:40:30', '2021-08-31 19:04:58', NULL),
	(16, 'fb9794ce-81ab-429e-9fa4-d3323a0498b9', '4231321654687498', 0, 2, 2, '2021-08-27 21:40:33', '2021-08-31 19:04:58', NULL),
	(17, 'ad69d701-f98f-4937-bfaf-445d05caf593', '5231321654687498', 0, 2, 2, '2021-08-27 21:40:39', '2021-08-31 19:04:58', NULL),
	(18, '234aa1fb-1fd6-404e-b260-8ae19ef21bcc', '6231321654687498', 1, 2, 2, '2021-08-27 21:40:43', '2021-08-27 21:40:43', NULL),
	(19, '4e266510-ee9c-47e0-a574-16aef2783054', '9887546532215445', 1, 2, 2, '2021-08-27 21:42:30', '2021-08-27 21:42:30', NULL),
	(20, '9a3f08ed-e831-43c8-bceb-9634cfe432f6', '9887546532215441', 1, 2, 2, '2021-08-27 21:42:33', '2021-08-27 21:42:33', NULL),
	(21, 'b956598e-a74d-4b55-810a-0144d3606cbb', '9887546532215443', 1, 2, 2, '2021-08-27 21:42:35', '2021-08-27 21:42:35', NULL),
	(22, 'aa402c0d-5b93-443d-9328-288801ec091f', '6757659879879877', 1, 2, 2, '2021-08-28 23:51:28', '2021-08-28 23:51:28', NULL),
	(23, '9605ff37-45b4-49dc-9e16-c2c600ac494f', '5698854545454544', 1, 2, 1, '2021-08-31 20:57:46', '2021-08-31 20:57:46', NULL),
	(24, 'fd31fc83-62d7-4262-ae23-e5e85b07282c', '3216549879875422', 1, 2, 2, '2021-08-31 21:11:41', '2021-08-31 21:11:41', NULL),
	(25, 'c3cdc2fe-6b6b-42e6-847e-b07336a74400', '1236541236549878', 1, 2, 1, '2021-08-31 21:12:30', '2021-08-31 21:12:30', NULL);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;

-- Volcando estructura para tabla bd_toyo.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `rol` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_toyo.users: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `code`, `state`, `rol`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'dede', 'jose@gmail.com', '2021-08-23 15:28:16', '$2y$10$aJ4v8u.qwiAzrH/YssIAHOZ5FVRk5HjcOAg0cHbNfuovXQGvqf54K', 'bb4766aa56', 1, 'admin', NULL, '2021-08-23 15:28:04', '2021-08-31 21:04:22'),
	(2, 'ssxx', 'fcb.dev@outlook.com', '2021-08-23 17:46:57', '$2y$10$N4oO6l7Ncsr7lF3gjXFQ1.mTUkWpoJoK8CRsrAsY6/hJXRJNEjzvi', 'b00389408e', 1, 'user', '4Hlzgdq4Pb', '2021-08-23 17:46:31', '2021-08-31 18:11:02'),
	(3, 'fvfvf', 'pablo@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1652d0dfc4', 1, 'user', NULL, '2021-08-23 22:05:38', '2021-08-23 22:05:38'),
	(4, 'fvfvy', 'tito@gmail.com', '2021-08-27 15:36:32', '$2y$10$WPkBut5fnAvR9CW.I/.J3.JKLI0UDq2yq6/.reiJItcTtD1B9Cioy', '97fbbf9f54', 1, 'user', NULL, '2021-08-27 15:36:12', '2021-08-27 15:36:32'),
	(7, NULL, 'flcb.dev@outlook.com', '2021-08-29 02:08:32', '$2y$10$JEcgSdVU7juYl6XGG5hWEuXsu16ElO5IJxnScWacie5oG8NKltyBi', 'b2b565b45e', 1, 'user', NULL, '2021-08-29 02:07:32', '2021-08-29 02:08:32'),
	(8, NULL, 'manuel@gmail.com', NULL, '$2y$10$O80WBDCrU40zUYn87aonsOxVFohIBWC06bin1hlqUh51qiQd4SB4e', 'b7865f1e88', 1, 'user', NULL, '2021-08-29 03:29:24', '2021-08-29 04:28:09'),
	(9, NULL, 'tito2@gmail.com', NULL, '$2y$10$m4O/.8dFKitcnHq/bm4D4u1wIr9ji38hYfzdNmg1.og70GOwik6Ia', 'fdb2327bba', 1, 'user', NULL, '2021-08-29 04:34:51', '2021-08-29 05:30:00'),
	(10, NULL, 'david@gmail.com', '2021-08-29 05:41:09', '$2y$10$/P.WfMOyzpL0yNRqqoHb4OPIOfz/Cu6/yaGWiDwSkDyDO0r5jsvue', 'd11cd5c2e8', 1, 'user', NULL, '2021-08-29 05:40:56', '2021-08-29 05:41:09');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
