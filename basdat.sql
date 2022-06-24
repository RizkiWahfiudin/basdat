/*
 Navicat Premium Data Transfer

 Source Server         : Local - MySQL
 Source Server Type    : MySQL
 Source Server Version : 80029
 Source Host           : localhost:3307
 Source Schema         : db_event

 Target Server Type    : MySQL
 Target Server Version : 80029
 File Encoding         : 65001

 Date: 23/06/2022 09:59:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activity_log
-- ----------------------------
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log`  (
  `id` bigint(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `subject_id` bigint(0) UNSIGNED NULL DEFAULT NULL,
  `causer_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `causer_id` bigint(0) UNSIGNED NULL DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `subject`(`subject_type`, `subject_id`) USING BTREE,
  INDEX `causer`(`causer_type`, `causer_id`) USING BTREE,
  INDEX `activity_log_log_name_index`(`log_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of activity_log
-- ----------------------------
INSERT INTO `activity_log` VALUES (1, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:08:01', '2022-01-18 23:08:01');
INSERT INTO `activity_log` VALUES (2, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:08:41', '2022-01-18 23:08:41');
INSERT INTO `activity_log` VALUES (3, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:10:34', '2022-01-18 23:10:34');
INSERT INTO `activity_log` VALUES (4, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:14:19', '2022-01-18 23:14:19');
INSERT INTO `activity_log` VALUES (5, 'default', 'Informasi website telah diperbarui', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:14:45', '2022-01-18 23:14:45');
INSERT INTO `activity_log` VALUES (6, 'default', 'Memilih roles Guest', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:15:19', '2022-01-18 23:15:19');
INSERT INTO `activity_log` VALUES (7, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:15:23', '2022-01-18 23:15:23');
INSERT INTO `activity_log` VALUES (8, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:52:22', '2022-01-18 23:52:22');
INSERT INTO `activity_log` VALUES (9, 'default', 'Memilih roles Guest', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:52:32', '2022-01-18 23:52:32');
INSERT INTO `activity_log` VALUES (10, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:52:35', '2022-01-18 23:52:35');
INSERT INTO `activity_log` VALUES (11, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-18 23:52:49', '2022-01-18 23:52:49');
INSERT INTO `activity_log` VALUES (12, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-19 15:27:09', '2022-01-19 15:27:09');
INSERT INTO `activity_log` VALUES (13, 'default', 'Memilih roles Guest', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-19 15:28:03', '2022-01-19 15:28:03');
INSERT INTO `activity_log` VALUES (14, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-19 15:28:17', '2022-01-19 15:28:17');
INSERT INTO `activity_log` VALUES (15, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-21 13:35:24', '2022-01-21 13:35:24');
INSERT INTO `activity_log` VALUES (16, 'default', 'Memilih roles Guest', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-21 13:35:34', '2022-01-21 13:35:34');
INSERT INTO `activity_log` VALUES (17, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-21 13:35:54', '2022-01-21 13:35:54');
INSERT INTO `activity_log` VALUES (18, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-26 16:38:51', '2022-01-26 16:38:51');
INSERT INTO `activity_log` VALUES (19, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-26 16:39:26', '2022-01-26 16:39:26');
INSERT INTO `activity_log` VALUES (20, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-27 13:26:45', '2022-01-27 13:26:45');
INSERT INTO `activity_log` VALUES (21, 'default', 'Informasi website telah diperbarui', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-01-27 13:27:01', '2022-01-27 13:27:01');
INSERT INTO `activity_log` VALUES (22, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-02-03 11:24:24', '2022-02-03 11:24:24');
INSERT INTO `activity_log` VALUES (23, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-02-03 11:24:55', '2022-02-03 11:24:55');
INSERT INTO `activity_log` VALUES (24, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-02-15 11:09:42', '2022-02-15 11:09:42');
INSERT INTO `activity_log` VALUES (25, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-02-15 11:12:22', '2022-02-15 11:12:22');
INSERT INTO `activity_log` VALUES (26, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-02-15 11:12:36', '2022-02-15 11:12:36');
INSERT INTO `activity_log` VALUES (27, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-02-22 11:40:36', '2022-02-22 11:40:36');
INSERT INTO `activity_log` VALUES (28, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-02-22 11:46:07', '2022-02-22 11:46:07');
INSERT INTO `activity_log` VALUES (29, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-05-07 09:41:46', '2022-05-07 09:41:46');
INSERT INTO `activity_log` VALUES (30, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-12 15:50:23', '2022-06-12 15:50:23');
INSERT INTO `activity_log` VALUES (31, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-13 16:56:04', '2022-06-13 16:56:04');
INSERT INTO `activity_log` VALUES (32, 'default', 'Role Item: Event ditambahkan', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-13 16:57:06', '2022-06-13 16:57:06');
INSERT INTO `activity_log` VALUES (33, 'default', 'Role Item: Region ditambahkan', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-13 16:57:28', '2022-06-13 16:57:28');
INSERT INTO `activity_log` VALUES (34, 'default', 'Role Item: Kota ditambahkan', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-13 16:57:50', '2022-06-13 16:57:50');
INSERT INTO `activity_log` VALUES (35, 'default', 'Role Item: Kategori ditambahkan', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-13 16:58:23', '2022-06-13 16:58:23');
INSERT INTO `activity_log` VALUES (36, 'default', 'Role: Super Admin diperbarui', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-13 16:58:56', '2022-06-13 16:58:56');
INSERT INTO `activity_log` VALUES (37, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-14 16:16:38', '2022-06-14 16:16:38');
INSERT INTO `activity_log` VALUES (38, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-14 18:35:45', '2022-06-14 18:35:45');
INSERT INTO `activity_log` VALUES (39, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-14 18:53:44', '2022-06-14 18:53:44');
INSERT INTO `activity_log` VALUES (40, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-14 18:54:15', '2022-06-14 18:54:15');
INSERT INTO `activity_log` VALUES (41, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-21 00:44:38', '2022-06-21 00:44:38');
INSERT INTO `activity_log` VALUES (42, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-21 14:18:45', '2022-06-21 14:18:45');
INSERT INTO `activity_log` VALUES (43, 'default', 'Memilih roles Super Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-21 18:08:25', '2022-06-21 18:08:25');
INSERT INTO `activity_log` VALUES (44, 'default', 'Role: Owner diperbarui', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-21 18:10:05', '2022-06-21 18:10:05');
INSERT INTO `activity_log` VALUES (45, 'default', 'Role: Admin diperbarui', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-21 18:10:21', '2022-06-21 18:10:21');
INSERT INTO `activity_log` VALUES (46, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-21 18:10:34', '2022-06-21 18:10:34');
INSERT INTO `activity_log` VALUES (47, 'default', 'Memilih roles Owner', NULL, NULL, 'App\\Models\\User', 2, '[]', '2022-06-21 18:11:00', '2022-06-21 18:11:00');
INSERT INTO `activity_log` VALUES (48, 'default', 'Melakukan Logout', NULL, NULL, 'App\\Models\\User', 2, '[]', '2022-06-21 18:11:17', '2022-06-21 18:11:17');
INSERT INTO `activity_log` VALUES (49, 'default', 'Memilih roles Admin', NULL, NULL, 'App\\Models\\User', 1, '[]', '2022-06-21 19:08:14', '2022-06-21 19:08:14');

-- ----------------------------
-- Table structure for event
-- ----------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event`  (
  `id_event` int(0) NOT NULL AUTO_INCREMENT,
  `region_id` int(0) NULL DEFAULT NULL,
  `kota_id` int(0) NULL DEFAULT NULL,
  `kategori_id` int(0) NULL DEFAULT NULL,
  `lokasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `speaker` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `moderator` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_event`) USING BTREE,
  INDEX `FK_region_id_event`(`region_id`) USING BTREE,
  INDEX `FK_kota_id_event`(`kota_id`) USING BTREE,
  INDEX `FK_kategori_id_event`(`kategori_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of event
-- ----------------------------
INSERT INTO `event` VALUES (2, 6, 3, 1, 'Sukodono, Sidoarjo', 'asd', 'qwerty', '2022-06-10');

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id_kategori` int(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'Kesehatan');
INSERT INTO `kategori` VALUES (2, 'Teknologi');

-- ----------------------------
-- Table structure for kota
-- ----------------------------
DROP TABLE IF EXISTS `kota`;
CREATE TABLE `kota`  (
  `id_kota` int(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `region_id` int(0) NULL DEFAULT NULL,
  `nama_kota` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kota`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kota
-- ----------------------------
INSERT INTO `kota` VALUES (3, 6, 'Sidoarjo');
INSERT INTO `kota` VALUES (4, 6, 'Surabaya');
INSERT INTO `kota` VALUES (5, 2, 'Bandung');
INSERT INTO `kota` VALUES (6, 3, 'Semarang');

-- ----------------------------
-- Table structure for region
-- ----------------------------
DROP TABLE IF EXISTS `region`;
CREATE TABLE `region`  (
  `id_region` int(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_region` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_region`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of region
-- ----------------------------
INSERT INTO `region` VALUES (1, 'GJR');
INSERT INTO `region` VALUES (2, 'WJR');
INSERT INTO `region` VALUES (3, 'CJR');
INSERT INTO `region` VALUES (4, 'NSMR');
INSERT INTO `region` VALUES (5, 'NSLR');
INSERT INTO `region` VALUES (6, 'EJR');
INSERT INTO `region` VALUES (7, 'KLR');
INSERT INTO `region` VALUES (8, 'SSMR');
INSERT INTO `region` VALUES (9, 'SSLR');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Admin', '2021-07-21 08:42:56', '2022-06-21 18:10:21');
INSERT INTO `roles` VALUES (2, 'Owner', '2021-07-21 09:32:47', '2022-06-21 18:10:05');

-- ----------------------------
-- Table structure for roles_item_pivot
-- ----------------------------
DROP TABLE IF EXISTS `roles_item_pivot`;
CREATE TABLE `roles_item_pivot`  (
  `roles_id` bigint(0) UNSIGNED NOT NULL,
  `roles_item_id` bigint(0) UNSIGNED NOT NULL,
  `create` int(0) NOT NULL,
  `read` int(0) NOT NULL,
  `update` int(0) NOT NULL,
  `delete` int(0) NOT NULL,
  `print` int(0) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`roles_id`, `roles_item_id`) USING BTREE,
  INDEX `roles_item_pivot_roles_item_id_foreign`(`roles_item_id`) USING BTREE,
  CONSTRAINT `roles_item_pivot_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `roles_item_pivot_ibfk_2` FOREIGN KEY (`roles_item_id`) REFERENCES `roles_items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles_item_pivot
-- ----------------------------
INSERT INTO `roles_item_pivot` VALUES (1, 1, 1, 1, 1, 1, 1, NULL, '2022-06-21 18:10:21');
INSERT INTO `roles_item_pivot` VALUES (1, 2, 1, 1, 1, 1, 1, NULL, '2022-06-21 18:10:21');
INSERT INTO `roles_item_pivot` VALUES (1, 3, 1, 1, 1, 1, 1, NULL, '2022-06-21 18:10:21');
INSERT INTO `roles_item_pivot` VALUES (1, 4, 1, 1, 1, 1, 1, NULL, '2022-06-21 18:10:21');
INSERT INTO `roles_item_pivot` VALUES (1, 5, 1, 1, 1, 0, 0, NULL, '2022-06-21 18:10:21');
INSERT INTO `roles_item_pivot` VALUES (1, 6, 1, 1, 1, 1, 1, NULL, '2022-06-21 18:10:21');
INSERT INTO `roles_item_pivot` VALUES (1, 7, 1, 1, 1, 1, 1, NULL, '2022-06-21 18:10:21');
INSERT INTO `roles_item_pivot` VALUES (1, 8, 1, 1, 1, 1, 1, NULL, '2022-06-21 18:10:21');
INSERT INTO `roles_item_pivot` VALUES (2, 1, 0, 0, 0, 0, 0, NULL, '2022-06-21 18:10:05');
INSERT INTO `roles_item_pivot` VALUES (2, 2, 0, 0, 0, 0, 0, NULL, '2022-06-21 18:10:05');
INSERT INTO `roles_item_pivot` VALUES (2, 3, 0, 0, 0, 0, 0, NULL, '2022-06-21 18:10:05');
INSERT INTO `roles_item_pivot` VALUES (2, 4, 0, 0, 0, 0, 0, NULL, '2022-06-21 18:10:05');
INSERT INTO `roles_item_pivot` VALUES (2, 5, 0, 0, 0, 0, 0, NULL, '2022-06-21 18:10:05');
INSERT INTO `roles_item_pivot` VALUES (2, 6, 0, 0, 0, 0, 0, NULL, '2022-06-21 18:10:05');
INSERT INTO `roles_item_pivot` VALUES (2, 7, 0, 0, 0, 0, 0, NULL, '2022-06-21 18:10:05');
INSERT INTO `roles_item_pivot` VALUES (2, 8, 0, 0, 0, 0, 0, NULL, '2022-06-21 18:10:05');

-- ----------------------------
-- Table structure for roles_items
-- ----------------------------
DROP TABLE IF EXISTS `roles_items`;
CREATE TABLE `roles_items`  (
  `id` bigint(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles_items
-- ----------------------------
INSERT INTO `roles_items` VALUES (1, 'Umum', '2021-07-21 08:42:56', NULL);
INSERT INTO `roles_items` VALUES (2, 'Roles', '2021-07-21 08:42:56', NULL);
INSERT INTO `roles_items` VALUES (3, 'RolesItem', '2021-07-21 08:42:56', NULL);
INSERT INTO `roles_items` VALUES (4, 'Users', '2021-07-21 08:42:56', NULL);
INSERT INTO `roles_items` VALUES (5, 'Event', NULL, NULL);
INSERT INTO `roles_items` VALUES (6, 'Region', NULL, NULL);
INSERT INTO `roles_items` VALUES (7, 'Kota', NULL, NULL);
INSERT INTO `roles_items` VALUES (8, 'Kategori', NULL, NULL);

-- ----------------------------
-- Table structure for roles_user
-- ----------------------------
DROP TABLE IF EXISTS `roles_user`;
CREATE TABLE `roles_user`  (
  `user_id` bigint(0) UNSIGNED NOT NULL,
  `roles_id` bigint(0) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `roles_id`) USING BTREE,
  INDEX `roles_user_roles_id_foreign`(`roles_id`) USING BTREE,
  CONSTRAINT `roles_user_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `roles_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles_user
-- ----------------------------
INSERT INTO `roles_user` VALUES (1, 1, '2021-07-21 09:35:48', NULL);
INSERT INTO `roles_user` VALUES (1, 2, '2021-07-21 09:35:48', NULL);
INSERT INTO `roles_user` VALUES (2, 2, '2021-07-21 09:34:49', NULL);

-- ----------------------------
-- Table structure for umums
-- ----------------------------
DROP TABLE IF EXISTS `umums`;
CREATE TABLE `umums`  (
  `id` bigint(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of umums
-- ----------------------------
INSERT INTO `umums` VALUES (1, 'Sistem Monitoring Event', 'logo.jpg', 'favicon.png', '2021-10-28 15:42:44', '2021-10-28 15:42:44');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$t2uCekTJamntCqDlOuUIBu2PqSQS4RI9SiwiaDI166LwK2vWngmwS',
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('y','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'admin', 'admin@admin.com', '$2y$10$qM4vBwnu9ih.XJ6BAq4GLOJ5LDTHUu9VF6zwGfpNdRm72o5oydKQe', '1642580871.png', 'y', NULL, '2022-01-19 15:27:51');
INSERT INTO `users` VALUES (2, 'owner', 'owner', 'owner@gmail.com', '$2y$10$88tn/S5W/Dhf7b3IRuQ5NurXUIVNZFv0AGCKsWvqIVxQErXFsin0q', '1642580871.png', 'y', '2021-07-21 09:09:34', '2021-07-21 09:29:42');

SET FOREIGN_KEY_CHECKS = 1;
