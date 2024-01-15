-- Adminer 4.8.1 MySQL 5.7.11 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admins_user_id_foreign` (`user_id`),
  CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `user_id`, `position`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(2,	2,	1,	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(3,	10,	2,	'2024-01-09 07:22:49',	'2024-01-09 07:22:49'),
(4,	12,	3,	'2024-01-09 07:25:37',	'2024-01-09 07:25:37');

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_user_id_foreign` (`user_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(39,	2,	3,	3,	'2024-01-10 21:11:27',	'2024-01-10 21:17:00');

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `buyer_rating` int(11) DEFAULT NULL,
  `buyer_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_rating` int(11) DEFAULT NULL,
  `seller_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_order_id_foreign` (`order_id`),
  CONSTRAINT `comments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comments` (`id`, `order_id`, `buyer_rating`, `buyer_message`, `seller_rating`, `seller_message`, `created_at`, `updated_at`) VALUES
(1,	1,	3,	'123',	2,	'123',	'2024-01-09 03:25:35',	'2024-01-09 18:51:45'),
(2,	5,	3,	'1',	3,	'345',	'2024-01-09 08:18:23',	'2024-01-09 17:25:29'),
(3,	6,	4,	'Good',	NULL,	NULL,	'2024-01-09 16:42:51',	'2024-01-09 16:42:51'),
(4,	10,	2,	'Good!',	NULL,	NULL,	'2024-01-09 17:49:59',	'2024-01-09 17:50:06');

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contacts` (`id`, `name`, `phone`, `email`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1,	'Ryan',	'09876543211',	'Ryan@gmail.com',	'Order',	'123',	'2024-01-10 05:11:30',	'2024-01-10 05:11:30');

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
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


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(181,	'2014_10_12_000000_create_users_table',	1),
(182,	'2014_10_12_100000_create_password_reset_tokens_table',	1),
(183,	'2019_08_19_000000_create_failed_jobs_table',	1),
(184,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(185,	'2023_12_10_073201_create_products_table',	1),
(186,	'2023_12_10_073217_create_product_categories_table',	1),
(187,	'2023_12_10_073239_create_cart_items_table',	1),
(188,	'2023_12_10_073314_create_orders_table',	1),
(189,	'2023_12_10_073403_create_order_items_table',	1),
(190,	'2023_12_10_073411_create_admins_table',	1),
(191,	'2023_12_10_073506_create_sellers_table',	1),
(192,	'2023_12_10_073514_create_posts_table',	1),
(193,	'2023_12_10_080818_add_foreign_keys_to_products_table',	1),
(194,	'2023_12_10_081652_add_foreign_keys_to_cart_items_table',	1),
(195,	'2023_12_10_081908_add_foreign_keys_to_orders_table',	1),
(196,	'2023_12_10_082024_add_foreign_keys_to_order_items_table',	1),
(197,	'2023_12_10_082131_add_foreign_keys_to_admins_table',	1),
(198,	'2023_12_10_082210_add_foreign_keys_to_sellers_table',	1),
(199,	'2023_12_10_082214_add_foreign_keys_to_posts_table',	1),
(200,	'2024_01_03_105708_create_comments_table',	1),
(201,	'2024_01_04_065803_create_contacts_table',	1),
(202,	'2024_01_06_033816_add_foreign_keys_to_comments_table',	1);

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `status` int(11) NOT NULL,
  `date` date NOT NULL,
  `pay` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_seller_id_foreign` (`seller_id`),
  CONSTRAINT `orders_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` (`id`, `user_id`, `seller_id`, `status`, `date`, `pay`, `price`, `receiver`, `receiver_phone`, `receiver_address`, `bank_account`, `month`, `year`, `created_at`, `updated_at`) VALUES
(1,	3,	1,	5,	'2024-01-09',	1,	13037,	'Ms. Janice Hintz IV',	'0123456789',	'Taiwan',	'1234567812345678',	2,	2027,	'2024-01-09 03:18:30',	'2024-01-09 03:25:22'),
(2,	3,	1,	1,	'2024-01-09',	1,	680,	'Ms. Janice Hintz IV',	'0123456789',	'Taiwan',	'1234567812345678',	6,	2025,	'2024-01-09 03:19:19',	'2024-01-09 17:32:11'),
(3,	4,	1,	1,	'2024-01-09',	1,	3959,	'Lydia Bechtelar',	'0123456789',	'Taiwan',	'1234567812345678',	3,	2025,	'2024-01-09 03:21:31',	'2024-01-09 03:21:48'),
(4,	4,	1,	2,	'2024-01-09',	1,	360,	'Lydia Bechtelar',	'0123456789',	'Taiwan',	'1234567812345678',	6,	2029,	'2024-01-09 03:22:00',	'2024-01-09 03:24:03'),
(5,	5,	1,	5,	'2024-01-09',	1,	559,	'Greyson Kerluke',	'0123456789',	'Taiwan',	'1234567812345678',	7,	2027,	'2024-01-09 03:23:10',	'2024-01-09 08:18:08'),
(6,	2,	1,	5,	'2024-01-09',	1,	4979,	'admin',	'0987654321',	'Taiwan',	'1234567812345678',	8,	2029,	'2024-01-09 07:18:10',	'2024-01-09 16:42:36'),
(8,	2,	3,	0,	'2024-01-09',	0,	259,	'admin',	'0987654321',	'Taiwan',	NULL,	NULL,	NULL,	'2024-01-09 07:18:10',	'2024-01-09 07:18:10'),
(9,	3,	1,	0,	'2024-01-10',	0,	7254,	'Ms. Janice Hintz IV',	'0123456789',	'Taiwan',	NULL,	NULL,	NULL,	'2024-01-09 17:47:39',	'2024-01-09 17:47:39'),
(10,	3,	2,	5,	'2024-01-10',	1,	110,	'Ms. Janice Hintz IV',	'0123456789',	'Taiwan',	'1234567812345678',	3,	2027,	'2024-01-09 17:47:39',	'2024-01-09 17:49:49'),
(11,	3,	1,	0,	'2024-01-15',	0,	2757,	'Ms. Janice Hintz IV',	'0123456789',	'Taiwan',	NULL,	NULL,	NULL,	'2024-01-14 23:20:44',	'2024-01-14 23:20:44'),
(12,	3,	3,	0,	'2024-01-15',	0,	259,	'Ms. Janice Hintz IV',	'0123456789',	'Taiwan',	NULL,	NULL,	NULL,	'2024-01-14 23:20:44',	'2024-01-14 23:20:44');

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1,	1,	22,	2,	'2024-01-09 03:18:30',	'2024-01-09 03:18:30'),
(2,	1,	21,	1,	'2024-01-09 03:18:30',	'2024-01-09 03:18:30'),
(3,	1,	20,	1,	'2024-01-09 03:18:30',	'2024-01-09 03:18:30'),
(4,	1,	19,	1,	'2024-01-09 03:18:30',	'2024-01-09 03:18:30'),
(5,	2,	13,	1,	'2024-01-09 03:19:19',	'2024-01-09 03:19:19'),
(6,	2,	9,	1,	'2024-01-09 03:19:19',	'2024-01-09 03:19:19'),
(7,	3,	6,	1,	'2024-01-09 03:21:31',	'2024-01-09 03:21:31'),
(8,	3,	19,	1,	'2024-01-09 03:21:31',	'2024-01-09 03:21:31'),
(9,	3,	16,	1,	'2024-01-09 03:21:31',	'2024-01-09 03:21:31'),
(10,	3,	11,	1,	'2024-01-09 03:21:31',	'2024-01-09 03:21:31'),
(11,	4,	12,	1,	'2024-01-09 03:22:00',	'2024-01-09 03:22:00'),
(12,	5,	10,	1,	'2024-01-09 03:23:10',	'2024-01-09 03:23:10'),
(13,	5,	11,	1,	'2024-01-09 03:23:10',	'2024-01-09 03:23:10'),
(14,	6,	23,	1,	'2024-01-09 07:18:10',	'2024-01-09 07:18:10'),
(15,	6,	22,	1,	'2024-01-09 07:18:10',	'2024-01-09 07:18:10'),
(16,	6,	21,	4,	'2024-01-09 07:18:10',	'2024-01-09 07:18:10'),
(18,	8,	25,	1,	'2024-01-09 07:18:10',	'2024-01-09 07:18:10'),
(19,	9,	2,	6,	'2024-01-09 17:47:39',	'2024-01-09 17:47:39'),
(20,	10,	24,	1,	'2024-01-09 17:47:39',	'2024-01-09 17:47:39'),
(21,	11,	1,	3,	'2024-01-14 23:20:44',	'2024-01-14 23:20:44'),
(22,	12,	25,	1,	'2024-01-14 23:20:44',	'2024-01-14 23:20:44');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@gmail.com',	'$2y$12$uRDJdCIY0lToRqRvLf93eebtI5dN7dK4fzZ7OoTyzdPj1VGYvLzV6',	'2024-01-09 04:53:55');

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint(20) unsigned NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_admin_id_foreign` (`admin_id`),
  CONSTRAINT `posts_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `posts` (`id`, `admin_id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1,	1,	'客服中心服務調整公告',	'1月16日12:30~14:00 因春酒活動，暫停客服電話及信件回覆，造成不便之處，敬請見諒。',	1,	'2024-01-09 03:14:47',	'2024-01-09 07:40:05'),
(2,	1,	'客服電話異動公告',	'因客服中心實施居家工作，客服電話請改撥02-6605-7599 分機102，或使用客服信箱來信洽詢，謝謝您。客戶服務時間：週一~五 9:00~20:00，週六日及國定假日 18:00~21:00 僅提供電話諮詢，上班日始回覆信件訊息。',	1,	'2024-01-09 03:15:09',	'2024-01-09 03:15:14');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_category_id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `inventory` int(11) NOT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_product_category_id_foreign` (`product_category_id`),
  KEY `products_seller_id_foreign` (`seller_id`),
  CONSTRAINT `products_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `product_category_id`, `seller_id`, `name`, `image_url`, `price`, `inventory`, `detail`, `status`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	'Intel 670P 512G',	'1704849956.jpg',	899,	7,	'Intel 670P 512G',	3,	'2024-01-09 01:43:37',	'2024-01-14 23:20:44'),
(2,	1,	1,	'Samsung 870 EVO 512G',	'1704793693.jpg',	1199,	0,	'Samsung 870 EVO 512G',	4,	'2024-01-09 01:48:13',	'2024-01-09 17:47:39'),
(3,	5,	1,	'ASROCK Z68',	'1704793735.jpg',	399,	3,	'ASROCK Z68',	3,	'2024-01-09 01:48:55',	'2024-01-09 02:03:13'),
(4,	2,	1,	'ASUS DUAL RTX4060 OC',	'1704793761.jpg',	7999,	1,	'AUSU DUAL RTX4060 OC',	3,	'2024-01-09 01:49:21',	'2024-01-09 08:14:19'),
(5,	1,	1,	'Crucial BX500 512G',	'1704793790.jpg',	499,	2,	'Crucial BX500 512G',	3,	'2024-01-09 01:49:50',	'2024-01-09 01:56:22'),
(6,	4,	1,	'AL05M',	'1704793814.jpg',	199,	1,	'AL05M',	3,	'2024-01-09 01:50:14',	'2024-01-09 03:21:31'),
(7,	1,	1,	'Kingston A400 512G',	'1704793838.jpg',	399,	5,	'Kingston A400 512G',	3,	'2024-01-09 01:50:38',	'2024-01-09 02:03:14'),
(8,	5,	1,	'B450 AORUS ELITE',	'1704793876.jpg',	1340,	2,	'B450 AORUS ELITE',	3,	'2024-01-09 01:51:16',	'2024-01-09 02:38:05'),
(9,	6,	1,	'DDR 400 512m',	'1704793898.jpg',	20,	9,	'DDR 400 512m',	3,	'2024-01-09 01:51:38',	'2024-01-09 03:19:19'),
(10,	6,	1,	'DDR3 1600 4G',	'1704793920.jpg',	199,	2,	'DDR3 1600 4G',	3,	'2024-01-09 01:52:00',	'2024-01-09 03:23:10'),
(11,	1,	1,	'ADATA SU650 256G',	'1704793942.jpg',	300,	4,	'ADATA SU650 256G',	3,	'2024-01-09 01:52:22',	'2024-01-09 03:23:10'),
(12,	8,	1,	'ViewSonic VA1913vm',	'1704793976.jpg',	300,	4,	'ViewSonic VA1913vm',	3,	'2024-01-09 01:52:56',	'2024-01-09 03:22:00'),
(13,	8,	1,	'ASUS VP228',	'1704794021.jpg',	600,	0,	'VP228',	4,	'2024-01-09 01:53:41',	'2024-01-09 03:19:19'),
(14,	1,	1,	'FSP500 500W',	'1704794045.jpg',	380,	3,	'FSP500 500W',	1,	'2024-01-09 01:54:05',	'2024-01-09 02:41:58'),
(15,	6,	1,	'Fury Beast 16G',	'1704794065.jpg',	999,	14,	'Fury Beast 16G',	3,	'2024-01-09 01:54:25',	'2024-01-09 02:38:48'),
(16,	3,	1,	'G PRO X SUPERLIGHT',	'1704794085.jpg',	2100,	2,	'G PRO X SUPERLIGHT',	3,	'2024-01-09 01:54:45',	'2024-01-09 03:21:31'),
(17,	1,	1,	'G PRO X',	'1704794103.jpg',	1360,	9,	'G PRO X',	1,	'2024-01-09 01:55:03',	'2024-01-09 01:55:50'),
(18,	4,	1,	'Xigmatek 80 plus',	'1704794364.jpg',	600,	3,	'Xigmatek 80 plus',	1,	'2024-01-09 01:59:24',	'2024-01-09 02:42:04'),
(19,	1,	1,	'WD SN770  512G',	'1704794391.jpg',	1300,	4,	'WD SN770  512G',	3,	'2024-01-09 01:59:51',	'2024-01-09 03:21:31'),
(20,	10,	1,	'Intel i9 9900K',	'1704794419.jpg',	8999,	6,	'Intel i9 9900K',	3,	'2024-01-09 02:00:19',	'2024-01-09 03:18:30'),
(21,	2,	1,	'msi GT730',	'1704794447.jpg',	680,	1,	'msi GT730',	3,	'2024-01-09 02:00:47',	'2024-01-09 07:18:10'),
(22,	9,	1,	'EVGA 1000W Gold',	'1704794469.jpg',	999,	0,	'EVGA 1000W Gold',	4,	'2024-01-09 02:01:09',	'2024-01-09 07:18:10'),
(23,	10,	1,	'Intel i5-4460',	'1704794508.jpg',	1200,	1,	'Intel i5-4460',	3,	'2024-01-09 02:01:48',	'2024-01-09 07:18:10'),
(24,	10,	2,	'i3 2100',	'1704811983.jpg',	50,	2,	'i3 2100',	3,	'2024-01-09 06:53:03',	'2024-01-09 18:05:16'),
(25,	7,	3,	'SDRW-08U9M',	'1704812101.jpg',	199,	0,	'SDRW-08U9M',	4,	'2024-01-09 06:55:01',	'2024-01-14 23:20:44'),
(26,	2,	1,	'1630',	'1704851593.jpg',	199,	1,	'1630',	3,	'2024-01-09 17:53:13',	'2024-01-09 17:55:03');

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1,	'硬碟',	1,	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(2,	'顯示卡',	1,	'2024-01-09 00:50:23',	'2024-01-09 00:50:23'),
(3,	'電腦週邊',	1,	'2024-01-09 00:50:31',	'2024-01-09 00:50:31'),
(4,	'機殼',	1,	'2024-01-09 00:52:10',	'2024-01-09 00:52:10'),
(5,	'主機板',	1,	'2024-01-09 00:52:14',	'2024-01-09 00:52:14'),
(6,	'記憶體',	1,	'2024-01-09 00:52:21',	'2024-01-09 00:52:21'),
(7,	'光碟機',	1,	'2024-01-09 00:52:37',	'2024-01-09 00:52:37'),
(8,	'電腦螢幕',	1,	'2024-01-09 00:53:03',	'2024-01-09 00:53:03'),
(9,	'電源供應器',	1,	'2024-01-09 00:53:24',	'2024-01-09 00:53:24'),
(10,	'CPU',	1,	'2024-01-09 01:06:50',	'2024-01-09 01:06:50');

DROP TABLE IF EXISTS `sellers`;
CREATE TABLE `sellers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sellers_user_id_foreign` (`user_id`),
  CONSTRAINT `sellers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sellers` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1,	1,	2,	'2024-01-09 00:47:18',	'2024-01-09 00:49:56'),
(2,	2,	2,	'2024-01-09 03:32:15',	'2024-01-09 03:32:20'),
(3,	7,	2,	'2024-01-09 04:53:40',	'2024-01-09 06:54:19'),
(4,	3,	2,	'2024-01-09 17:50:39',	'2024-01-09 17:51:04');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'head.jpg',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `photo`, `name`, `sex`, `birthday`, `phone`, `address`, `email`, `email_verified_at`, `password`, `bank_branch`, `bank_account`, `month`, `year`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'head.jpg',	'seller',	'男',	'2023-11-11',	'0987654321',	'Taoyuan',	'seller@gmail.com',	'2024-01-09 00:47:17',	'$2y$12$Se1AoLk67HWO3fi4uUY1.OLyj.fTdctft9B68A3IEQ5UaWE9r246y',	NULL,	NULL,	NULL,	NULL,	'ClOgdBsoWZ5eJE6c5Csv9WDILLP7xH3CkR0bG8RShr9F45yuvk2puHfkUXQh',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(2,	'head.jpg',	'admin',	'男',	'2023-11-27',	'0987654321',	'Taiwan',	'admin@gmail.com',	'2024-01-09 00:47:18',	'$2y$12$QEc1g5zl5ylEhw8IABneGOSbgwVlkefQ/oIaGNvSFt6dcFvZiUtWm',	NULL,	NULL,	NULL,	NULL,	'GTe0q6nviz3NBBFySfL6z9eQp4XOktCE7Lmv9f4wwiTNvF5wVBjbhfUgHy8B',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(3,	'head.jpg',	'Ms. Janice Hintz IV',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'kreilly@example.com',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'Dw0r88tfrpHbQoV1L7uFcKpjwNSSxsSNGp2O7TF1lOedcQQhN70qbANm9g4E',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(4,	'head.jpg',	'Lydia Bechtelar',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'maximus42@example.org',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'Oo1sPdvfjbm8qfzeOWLu7W70j9o0KCvkQFdP08RT1msJCnFkCGFAYGzu2efA',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(5,	'head.jpg',	'Greyson Kerluke',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'kelvin62@example.com',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'X2aRSrYBljkjru647j9g7j2FwT6hpIal7yTKR117GPNqoxYSH4jZ8rFw519z',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(6,	'head.jpg',	'Dr. Charity Maggio III',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'charlene.berge@example.com',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'ncxZFSeEqG',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(7,	'head.jpg',	'Dr. Mittie Spinka',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'ellen.cronin@example.net',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'uTQXIOMosbWPguAqhDI4FtTuxNeWThYwbZuLScNRBxYEJ0Yd260LS0CASv8G',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(8,	'head.jpg',	'Vickie Kshlerin',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'greenfelder.davion@example.com',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'ZyMgxS1ko1',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(9,	'head.jpg',	'Ms. Imelda Flatley',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'ava.hessel@example.net',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'DCeS61THdW',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(10,	'head.jpg',	'Kamille Buckridge III',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'sipes.jayme@example.org',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'91Byv8YZKdH8ClIjqwsv2bDXVvdu8LSHNPGK6mIWRQH91kMz8oK7bmksTTWA',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(11,	'head.jpg',	'Stone O\'Keefe',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'snolan@example.org',	'2024-01-09 00:47:18',	'$2y$12$OBfbzL6N6gXsil/0RnZzouAB/VjTekKSgYq0A0U3s8.48kZo/4y7y',	NULL,	NULL,	NULL,	NULL,	'UO09ywUQGH',	'2024-01-09 00:47:18',	'2024-01-09 00:47:18'),
(12,	'1704848606.jpg',	'Dr. Misael McLaughlin',	'男',	'2022-12-12',	'0123456789',	'Taiwan',	'schmidt.kaylee@example.com',	'2024-01-09 00:47:18',	'$2y$12$6IRdKljvs/w3BIt5O4uuU.8OGELsQRbsA9An6bE4GMb0/au7yq1GG',	NULL,	NULL,	NULL,	NULL,	'OlIDM8zX3UBJL4eXNmQHDglI4hp572EFkrxqOg4RWAX5VhrXctw4tnlUNXve',	'2024-01-09 00:47:18',	'2024-01-09 17:03:45');

-- 2024-01-15 08:39:06
