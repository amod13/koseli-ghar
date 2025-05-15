-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2025 at 12:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amdsoft_itsamagri`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL DEFAULT 'link',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `url`, `parent_id`, `position`, `type`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Home', NULL, NULL, 1, 'link', 1, '2025-03-19 05:42:59', '2025-03-19 05:43:42'),
(3, 'About Us', NULL, NULL, 3, 'link', 1, '2025-03-19 05:43:16', '2025-03-19 05:43:41'),
(4, 'Contact us', NULL, NULL, 2, 'link', 1, '2025-03-19 05:43:26', '2025-03-19 05:43:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_21_064731_create_roles_table', 1),
(6, '2024_11_21_064732_create_users_table', 1),
(7, '2024_11_21_072115_create_permissions_table', 1),
(8, '2024_11_21_075339_create_role_has_permission_table', 1),
(9, '2025_02_27_052458_create_user_details_table', 2),
(10, '2025_02_27_095955_create_settings_table', 2),
(11, '2024_12_11_085248_create_menus_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `action`, `controller`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'index', 'index', 'UserController', 'Users', '2025-02-18 01:48:13', '2025-02-18 01:48:13'),
(2, 'create', 'create', 'UserController', 'Users', '2025-02-18 02:37:02', '2025-02-18 02:37:02'),
(3, 'store', 'store', 'UserController', 'Users', '2025-02-18 02:37:24', '2025-02-18 02:37:24'),
(4, 'edit', 'edit', 'UserController', 'Users', '2025-02-18 02:37:45', '2025-02-18 02:37:45'),
(5, 'update', 'update', 'UserController', 'Users', '2025-02-18 02:38:04', '2025-02-18 02:38:04'),
(6, 'delete', 'delete', 'UserController', 'Users', '2025-02-18 02:38:24', '2025-02-18 02:38:24'),
(7, 'index', 'index', 'PermissionController', 'Permission', '2025-02-18 02:39:18', '2025-02-18 02:39:18'),
(8, 'create', 'create', 'PermissionController', 'Permission', '2025-02-18 02:39:47', '2025-02-18 02:39:47'),
(9, 'store', 'store', 'PermissionController', 'Permission', '2025-02-18 02:40:10', '2025-02-18 02:40:10'),
(10, 'edit', 'edit', 'PermissionController', 'Permission', '2025-02-18 02:40:29', '2025-02-18 02:40:29'),
(11, 'update', 'update', 'PermissionController', 'Permission', '2025-02-18 02:40:50', '2025-02-18 02:41:58'),
(12, 'delete', 'delete', 'PermissionController', 'Permission', '2025-02-18 02:41:34', '2025-02-18 02:41:34'),
(13, 'create', 'create', 'RoleController', 'Role', '2025-02-18 02:42:22', '2025-02-18 02:42:22'),
(14, 'index', 'index', 'RoleController', 'Role', '2025-02-18 02:43:01', '2025-02-18 02:43:01'),
(15, 'edit', 'edit', 'RoleController', 'Role', '2025-02-18 02:43:18', '2025-02-18 02:43:18'),
(16, 'update', 'update', 'RoleController', 'Role', '2025-02-18 02:43:34', '2025-02-18 02:43:34'),
(17, 'delete', 'delete', 'RoleController', 'Role', '2025-02-18 02:43:57', '2025-02-18 02:43:57'),
(18, 'Permission Assign', 'addPermission', 'RoleController', 'Role', '2025-02-18 02:44:26', '2025-02-18 04:10:22'),
(19, 'index', 'AdminLayout', 'DashboardController', 'Dashboard', '2025-02-18 02:45:53', '2025-02-18 02:45:53'),
(20, 'index', 'index', 'UserDetailController', 'User Detail', '2025-03-19 05:25:32', '2025-03-19 05:25:32'),
(21, 'edit', 'edit', 'UserDetailController', 'User Detail', '2025-03-19 05:25:49', '2025-03-19 05:25:59'),
(22, 'update', 'update', 'UserDetailController', 'User Detail', '2025-03-19 05:26:16', '2025-03-19 05:26:16'),
(23, 'index', 'index', 'SettingController', 'Setting', '2025-03-19 05:26:39', '2025-03-19 05:26:39'),
(24, 'update', 'update', 'SettingController', 'Setting', '2025-03-19 05:26:56', '2025-03-19 05:26:56'),
(25, 'create', 'create', 'MenuController', 'Menu', '2025-03-19 05:38:33', '2025-03-19 05:38:33'),
(26, 'index', 'index', 'MenuController', 'Menu', '2025-03-19 05:38:49', '2025-03-19 05:38:49'),
(27, 'store', 'store', 'MenuController', 'Menu', '2025-03-19 05:40:00', '2025-03-19 05:40:00'),
(28, 'edit', 'edit', 'MenuController', 'Menu', '2025-03-19 05:40:16', '2025-03-19 05:40:16'),
(29, 'update', 'update', 'MenuController', 'Menu', '2025-03-19 05:40:34', '2025-03-19 05:40:34'),
(30, 'delete', 'destroy', 'MenuController', 'Menu', '2025-03-19 05:40:56', '2025-03-19 05:42:44'),
(31, 'update order', 'updateOrder', 'MenuController', 'Menu', '2025-03-19 05:41:15', '2025-03-19 05:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', '2025-02-17 23:30:32', '2025-02-18 01:36:49'),
(2, 'Admin', '2025-02-17 23:33:47', '2025-02-17 23:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permission`
--

CREATE TABLE `role_has_permission` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permission`
--

INSERT INTO `role_has_permission` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(2, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `meta_tags` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `google_map` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `logo`, `favicon`, `address`, `phone`, `email`, `facebook`, `twitter`, `instagram`, `youtube`, `tiktok`, `whatsapp`, `meta_tags`, `meta_title`, `meta_description`, `meta_keywords`, `google_map`, `created_at`, `updated_at`) VALUES
(1, 'It Samagri', NULL, NULL, 'Est aut distinctio', '45', 'myvylyxuza@mailinator.com', 'Adipisci qui aliqua', 'Optio sed molestiae', 'Dolor aut error corr', 'Et quod cumque qui i', 'Dolore at qui esse e', 'Sunt do unde tempor', 'Molestiae non cumque', 'Hic architecto accus', 'Distinctio Et labor', 'Qui perferendis volu', 'Expedita eu Nam quas', NULL, '2025-03-19 05:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_verification_token` varchar(64) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT 0,
  `is_superadmin` int(11) DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `email_verification_token`, `password`, `role_id`, `is_superadmin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ranjit Raut', 'admin@gmail.com', NULL, NULL, '$2y$12$GVs79Sh1fjktEY4/TS1VKuK9utIwLTAPK7ZIZaY53boU9QasEfKL.', 1, 0, NULL, '2025-02-18 02:30:09', '2025-02-18 03:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `exclusive_offers` int(11) NOT NULL DEFAULT 0,
  `daily_messages` int(11) NOT NULL DEFAULT 0,
  `weekly_summary` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `designation`, `website`, `address`, `image`, `facebook`, `whatsapp`, `twitter`, `exclusive_offers`, `daily_messages`, `weekly_summary`, `created_at`, `updated_at`) VALUES
(1, 1, 'Camden', 'Hall Bauer', 'Kirby', 'noriwizihu@mailinator.com', '+1 (874) 866-8214', 'Deserunt dolorum et', 'https://www.lowedywu.me.uk', 'Animi quas aut labo', '1742382892_profile.png', 'Qui eaque laboriosam', 'Vel sapiente ad quas', 'Deserunt rerum sed q', 1, 1, 0, '2025-03-19 05:29:27', '2025-03-19 05:29:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD KEY `role_has_permission_role_id_foreign` (`role_id`),
  ADD KEY `role_has_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_details_email_unique` (`email`),
  ADD KEY `user_details_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD CONSTRAINT `role_has_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `role_has_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
