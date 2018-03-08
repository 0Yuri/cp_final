-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 04-Fev-2018 às 04:59
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_crescendo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `address`
--

CREATE TABLE `address` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `cep` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UF` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `neighborhood` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complement` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `address`
--

INSERT INTO `address` (`id`, `user_id`, `store_id`, `cep`, `street`, `city`, `UF`, `number`, `neighborhood`, `complement`, `reference`, `created_at`) VALUES
(1, 1, NULL, '50721-200', 'Rua Adelino Frutuoso', 'Recife', 'PE', '35', 'Cordeiro', 'Apto 201', 'Nothing', '2018-01-30 17:38:17'),
(2, 2, NULL, '50720-001', 'Rua Benfica', 'Recife', 'PE', '715', 'Madalena', 'Dentro do supermercado', 'Extra', '2018-01-30 18:10:30'),
(3, 3, NULL, '09520-010', 'Rua Adelino Frutuoso', 'Recife', 'PE', '35', 'Cordeiro', 'Apto 201', 'Perto do bar esquina sertaneja', '2018-02-01 13:15:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `banned_users`
--

CREATE TABLE `banned_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `banned_id` int(10) UNSIGNED NOT NULL,
  `cpf` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rg` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ban_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` enum('ativado','desativado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativado',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `brands`
--

INSERT INTO `brands` (`id`, `status`, `name`) VALUES
(1, 'ativado', 'Outros'),
(2, 'ativado', 'Tigor Tigre'),
(3, 'ativado', 'Tip Top'),
(4, 'ativado', 'Chicco'),
(5, 'ativado', 'Burigotto'),
(6, 'ativado', 'Croes'),
(7, 'ativado', 'Hello Kitty'),
(8, 'ativado', 'Melissa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` enum('ativado','desativado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativado',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `status`, `name`) VALUES
(1, 'ativado', 'Outros'),
(2, 'ativado', 'Acessórios'),
(3, 'ativado', 'Banho e Higiene'),
(4, 'ativado', 'Brinquedos'),
(5, 'ativado', 'Móveis');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contact`
--

CREATE TABLE `contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ddd` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorites`
--

CREATE TABLE `favorites` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `writer_id` int(10) UNSIGNED NOT NULL,
  `destiny_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2017_11_20_181043_create_users_table', 1),
(3, '2017_11_20_182018_create_stores_table', 1),
(4, '2017_11_20_182342_create_products_table', 1),
(5, '2017_11_20_182944_create_categories_table', 1),
(6, '2017_11_20_183350_create_brands_table', 1),
(7, '2017_11_20_183720_create_address_table', 1),
(8, '2017_11_20_194413_create_favorites_table', 1),
(9, '2017_11_20_231509_create_contact_table', 1),
(10, '2017_11_23_175017_create_questions_table', 1),
(11, '2017_11_24_030940_create_moip_accounts_table', 1),
(12, '2017_11_26_053948_create_evaluations_table', 1),
(13, '2017_12_01_022126_create_orders_table', 1),
(14, '2018_01_02_063349_orders_chat', 1),
(15, '2018_01_09_211650_create_product_images', 1),
(16, '2018_01_21_062930_create_messages_table', 1),
(17, '2018_01_24_082659_create_banned_users_tables', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `moip_accounts`
--

CREATE TABLE `moip_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `account_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accessToken` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `moip_accounts`
--

INSERT INTO `moip_accounts` (`id`, `user_id`, `account_id`, `client_id`, `accessToken`, `created_at`) VALUES
(1, 1, 'MPA-4B1C6D2D2F70', 'CUS-AYMDP3DY25T0', '5a468c09447d4cd1909e749fa300b073_v2', '2018-01-30 17:38:20'),
(2, 2, 'MPA-1F265F27F2E7', 'CUS-B1ALP8GJEYHC', '866fafd940b145f2bece1ef96e7261a8_v2', '2018-01-30 18:10:32'),
(3, 3, 'MPA-C6B4BA163163', 'CUS-GBUMC37UI13O', 'd1f90014012348c5851df38332e1c01c_v2', '2018-02-01 13:15:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `buyer_id` int(10) UNSIGNED NOT NULL,
  `seller_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` enum('card','boleto','debit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payed_at` timestamp NULL DEFAULT NULL,
  `status` enum('CREATED','WAITING','IN_ANALYSIS','PRE_AUTHORIZED','AUTHORIZED','CANCELLED','REFUNDED','PAID','REVERSED','SETTLED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CREATED',
  `shipping_method` enum('pac','sedex') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `seller_id`, `unique_id`, `payment_id`, `order_id`, `payment_method`, `payed_at`, `status`, `shipping_method`, `tracking_code`, `created_at`) VALUES
(1, 2, 'MPA-4B1C6D2D2F70', 'CP-ORD-5a720525ee701', NULL, 'ORD-Z0WCGVIAZD4A', 'boleto', NULL, 'CREATED', 'sedex', NULL, '2018-01-31 18:04:21'),
(2, 2, 'MPA-4B1C6D2D2F70', 'CP-ORD-5a731a0538785', NULL, 'ORD-N07CZC81GT9C', 'boleto', NULL, 'CREATED', 'sedex', NULL, '2018-02-01 13:45:41'),
(3, 2, 'MPA-4B1C6D2D2F70', 'CP-ORD-5a731a1486605', NULL, 'ORD-ELZB8GZ7OPFP', 'boleto', NULL, 'CREATED', 'sedex', NULL, '2018-02-01 13:45:56'),
(4, 2, 'MPA-4B1C6D2D2F70', 'CP-ORD-5a731a1e5edb7', NULL, 'ORD-MHY7HNZG8RWH', 'boleto', NULL, 'CREATED', 'sedex', NULL, '2018-02-01 13:46:06'),
(5, 2, 'MPA-4B1C6D2D2F70', 'CP-ORD-5a731abbf3195', NULL, 'ORD-HPGP6V4FRND8', 'boleto', NULL, 'CREATED', 'sedex', NULL, '2018-02-01 13:48:43'),
(6, 2, 'MPA-4B1C6D2D2F70', 'CP-ORD-5a731abe6969d', NULL, 'ORD-7GY0THIIOZ4Y', 'boleto', NULL, 'CREATED', 'sedex', NULL, '2018-02-01 13:48:46'),
(7, 2, 'MPA-4B1C6D2D2F70', 'CP-ORD-5a731b95776d4', NULL, 'ORD-DWDI3NY0GB1L', 'boleto', NULL, 'CREATED', 'sedex', NULL, '2018-02-01 13:52:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders_chat`
--

CREATE TABLE `orders_chat` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `writer_id` int(10) UNSIGNED NOT NULL,
  `content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(600) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ativado','desativado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativado',
  `gender` enum('meninos','meninas','papai','mamae') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quality` enum('Novo','Bom estado','Com marcas de uso') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` decimal(3,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `stock` bigint(20) NOT NULL DEFAULT '1',
  `solds` bigint(20) NOT NULL DEFAULT '0',
  `original_price` decimal(7,2) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `local` tinyint(1) NOT NULL DEFAULT '1',
  `shipping` tinyint(1) NOT NULL DEFAULT '1',
  `height` bigint(20) NOT NULL,
  `width` bigint(20) NOT NULL,
  `length` bigint(20) NOT NULL,
  `weight` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `store_id`, `category_id`, `brand_id`, `name`, `description`, `status`, `gender`, `quality`, `discount`, `stock`, `solds`, `original_price`, `price`, `local`, `shipping`, `height`, `width`, `length`, `weight`, `created_at`) VALUES
(1, 1, 2, 2, 'Produto teste - Admin', 'Este é um produto teste.', 'ativado', 'meninos', 'Novo', '0.00', 3, 0, '8.00', '5.20', 1, 1, 150, 200, 300, 100, '2018-01-30 18:08:22'),
(2, 2, 2, 3, 'Produto teste - Yves', 'Este é um produto teste.', 'ativado', 'meninos', 'Novo', '0.00', 1, 0, '250.00', '200.10', 1, 1, 150, 200, 300, 100, '2018-02-01 21:26:05'),
(3, 1, 2, 2, 'Produto teste dois - Admin', 'Este é um produto teste.', 'ativado', 'meninos', 'Novo', '0.00', 1, 0, '8.00', '4.30', 1, 1, 250, 200, 300, 200, '2018-01-30 18:08:22'),
(4, 2, 2, 3, 'Produto teste dois - Yves', 'Este é um produto teste.', 'ativado', 'meninos', 'Novo', '0.00', 1, 0, '2.50', '1.10', 1, 1, 150, 200, 300, 100, '2018-02-01 21:26:05');

-- --------------------------------------------------------

--
-- Estrutura da tabela `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('profile','extra') COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `ask_id` int(10) UNSIGNED NOT NULL,
  `question` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('criada','respondida') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'criada',
  `answered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `status` enum('ativado','desativado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativado',
  `profile_image` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `banner_image` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnpj` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ddd` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `stores`
--

INSERT INTO `stores` (`id`, `owner_id`, `status`, `profile_image`, `banner_image`, `name`, `description`, `cnpj`, `ddd`, `phone`, `created_at`) VALUES
(1, 1, 'ativado', 'default.png', 'default.png', 'Loja do admin', 'Teste', '38.947.294/8327-43', '81', '999999999', '2018-01-30 17:51:40'),
(2, 3, 'ativado', 'default.png', 'default.png', 'Loja do Yves', 'Teste', '83.173.127/3812-73', '81', '493829482', '2018-02-01 21:24:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_id` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rg` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issuer` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `birthdate` date NOT NULL,
  `ddd_1` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_1` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ddd_2` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_2` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name_id`, `email`, `password`, `name`, `last_name`, `gender`, `cpf`, `rg`, `issuer`, `issue_date`, `birthdate`, `ddd_1`, `tel_1`, `ddd_2`, `tel_2`, `remember_token`, `created_at`) VALUES
(1, 'admin5a70ad89e9c04', 'admin@admin.com', '123', 'admin', 'admin', 'male', '25291581000', '8988887', 'SDS', '2006-01-20', '1994-04-12', '81', '997021193', '81', '997021193', NULL, '2018-01-30 17:38:17'),
(2, 'teste5a70b5164dd6c', 'teste@teste.com', '123', 'teste', 'teste', 'male', '31480510092', '9938292', 'SDS', '2006-01-20', '1994-02-02', '81', '483298424', '81', '989238293', NULL, '2018-01-30 18:10:30'),
(3, 'Yves5a7312fc1e047', 'yves@yves.com', '123', 'Yves', 'Gregorio', 'male', '25221561018', '7879444', 'SDS', '2006-01-20', '1994-04-12', '81', '997021193', '81', '997021193', NULL, '2018-02-01 13:15:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_user_id_foreign` (`user_id`),
  ADD KEY `address_store_id_foreign` (`store_id`);

--
-- Indexes for table `banned_users`
--
ALTER TABLE `banned_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banned_users_banned_id_foreign` (`banned_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_writer_id_foreign` (`writer_id`),
  ADD KEY `messages_destiny_id_foreign` (`destiny_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moip_accounts`
--
ALTER TABLE `moip_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `moip_accounts_user_id_unique` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_unique_id_unique` (`unique_id`),
  ADD KEY `orders_buyer_id_foreign` (`buyer_id`);

--
-- Indexes for table `orders_chat`
--
ALTER TABLE `orders_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_chat_order_id_foreign` (`order_id`),
  ADD KEY `orders_chat_writer_id_foreign` (`writer_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_store_id_foreign` (`store_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_product_id_foreign` (`product_id`),
  ADD KEY `questions_ask_id_foreign` (`ask_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stores_owner_id_unique` (`owner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `banned_users`
--
ALTER TABLE `banned_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `moip_accounts`
--
ALTER TABLE `moip_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `orders_chat`
--
ALTER TABLE `orders_chat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`),
  ADD CONSTRAINT `address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `banned_users`
--
ALTER TABLE `banned_users`
  ADD CONSTRAINT `banned_users_banned_id_foreign` FOREIGN KEY (`banned_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_destiny_id_foreign` FOREIGN KEY (`destiny_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_writer_id_foreign` FOREIGN KEY (`writer_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `moip_accounts`
--
ALTER TABLE `moip_accounts`
  ADD CONSTRAINT `moip_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `orders_chat`
--
ALTER TABLE `orders_chat`
  ADD CONSTRAINT `orders_chat_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orders_chat_writer_id_foreign` FOREIGN KEY (`writer_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Limitadores para a tabela `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Limitadores para a tabela `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ask_id_foreign` FOREIGN KEY (`ask_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `questions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Limitadores para a tabela `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
