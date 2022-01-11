/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : ibad_kasir

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 05/01/2022 15:07:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for extras
-- ----------------------------
DROP TABLE IF EXISTS `extras`;
CREATE TABLE `extras`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `division_id` int(11) NULL DEFAULT NULL,
  `transaction_id` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of extras
-- ----------------------------
INSERT INTO `extras` VALUES (1, 1, 0, 'buku tulis', '10000', '1', NULL, NULL);
INSERT INTO `extras` VALUES (2, 1, 1, 'buku gambar', '100', '1', NULL, NULL);
INSERT INTO `extras` VALUES (3, 2, 17, '1', '100000', '2', '2021-11-09 08:57:24', '2021-11-09 08:57:24');
INSERT INTO `extras` VALUES (6, 1, 19, 'buku gambar', '10000', '2', '2021-11-14 14:05:10', '2021-11-14 14:05:10');
INSERT INTO `extras` VALUES (7, 2, 19, 'buku tulis', '20000', '2', '2021-11-14 14:05:10', '2021-11-14 14:05:10');

-- ----------------------------
-- Table structure for m_bahan
-- ----------------------------
DROP TABLE IF EXISTS `m_bahan`;
CREATE TABLE `m_bahan`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `property` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `hidden_property` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `id_category` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_customer_type` int(11) UNSIGNED NULL DEFAULT NULL,
  `is_minimum` int(11) NULL DEFAULT NULL,
  `formula` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_category_m_bahan`(`id_category`) USING BTREE,
  INDEX `fk_m_customer_type_m_bahan`(`id_customer_type`) USING BTREE,
  CONSTRAINT `fk_m_category_m_bahan` FOREIGN KEY (`id_category`) REFERENCES `m_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_m_customer_type_m_bahan` FOREIGN KEY (`id_customer_type`) REFERENCES `m_customer_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_bahan
-- ----------------------------
INSERT INTO `m_bahan` VALUES (1, 'Tes', '100000', '{\"panjang\":\"10\",\"lebar\":\"5\"}', '{\"panjang_min\":\"5\",\"lebar_min\":\"1\"}', 1, 1, NULL, NULL);
INSERT INTO `m_bahan` VALUES (2, 'Sticker Ritrama', '125000', '{\"panjang\":\"7000\",\"lebar\":\"100\"}', '{\"panjang_min\":\"500\",\"lebar_min\":\"25\"}', 3, 2, NULL, NULL);
INSERT INTO `m_bahan` VALUES (3, 'qw', '10000', '{\"waktu\":\"11\"}', NULL, 6, 2, NULL, NULL);
INSERT INTO `m_bahan` VALUES (4, 'Stiker A4', '50000', '{\"panjang\":\"140\",\"lebar\":\"80\"}', '{\"panjang_min\":\"10\",\"lebar_min\":\"10\"}', 3, 2, NULL, NULL);
INSERT INTO `m_bahan` VALUES (5, 'Stiker A5', '30000', '{\"panjang\":\"100\",\"lebar\":\"75\"}', '{\"panjang_min\":\"10\",\"lebar_min\":\"10\"}', 3, 2, 1, NULL);
INSERT INTO `m_bahan` VALUES (6, 'Flexi', '20000', '{\"panjang\":\"1000\",\"lebar\":\"100\"}', '{\"panjang_min\":\"1000\",\"lebar_min\":\"101\"}', 7, 1, 1, NULL);
INSERT INTO `m_bahan` VALUES (7, 'Flexi 2', '20000', '{\"panjang\":\"1000\",\"lebar\":\"200\"}', '{\"panjang_min\":\"\",\"lebar_min\":\"205\"}', 7, 1, NULL, NULL);
INSERT INTO `m_bahan` VALUES (8, 'qqq', '123', '{\"panjang\":\"200\"}', '{\"panjang_min\":\"10\"}', 4, 1, NULL, NULL);
INSERT INTO `m_bahan` VALUES (9, 'qqq', '12312', '{\"panjang\":\"150\"}', '{\"panjang_min\":\"10\"}', 4, 3, NULL, NULL);
INSERT INTO `m_bahan` VALUES (10, 'qqq', '12331', '{\"panjang\":\"100\"}', '{\"panjang_min\":\"10\"}', 4, 2, 1, NULL);
INSERT INTO `m_bahan` VALUES (11, 'Tes Bahan Dengan Tipe Customer Edit', '15000', '{\"panjang\":\"200\"}', '{\"panjang_min\":\"200\"}', 4, 3, 0, '[panjang]*10');

-- ----------------------------
-- Table structure for m_bahan_finishing
-- ----------------------------
DROP TABLE IF EXISTS `m_bahan_finishing`;
CREATE TABLE `m_bahan_finishing`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `property` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `id_category` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_customer_type` int(11) UNSIGNED NULL DEFAULT NULL,
  `formula` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_customer_type_m_bahan_finishing`(`id_customer_type`) USING BTREE,
  INDEX `fk_m_category_m_bahan_finishing`(`id_category`) USING BTREE,
  CONSTRAINT `fk_m_category_m_bahan_finishing` FOREIGN KEY (`id_category`) REFERENCES `m_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_m_customer_type_m_bahan_finishing` FOREIGN KEY (`id_customer_type`) REFERENCES `m_customer_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_bahan_finishing
-- ----------------------------
INSERT INTO `m_bahan_finishing` VALUES (1, 'Tes Finishing', '5000', '{\"panjang\":\"10\",\"lebar\":\"5\",\"qty\":\"10\"}', 1, 1, '[panjang]*[lebar]*[qty]');
INSERT INTO `m_bahan_finishing` VALUES (2, 'finish him', '10000', '{\"panjang\":\"15\",\"lebar\":\"15\",\"qty\":\"15\"}', 3, 1, NULL);
INSERT INTO `m_bahan_finishing` VALUES (3, 'banner pleksi', '10000', '{\"panjang\":\"10\",\"lebar\":\"10\",\"qty\":\"1\"}', 7, 1, NULL);
INSERT INTO `m_bahan_finishing` VALUES (4, 'Tes Finising Baru', '100000', '{\"panjang\":\"100\",\"lebar\":\"100\",\"qty\":\"10\"}', 1, 1, NULL);

-- ----------------------------
-- Table structure for m_bahan_finishing_potongan
-- ----------------------------
DROP TABLE IF EXISTS `m_bahan_finishing_potongan`;
CREATE TABLE `m_bahan_finishing_potongan`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_finishing` int(11) UNSIGNED NULL DEFAULT NULL,
  `batas_bawah` int(11) UNSIGNED NULL DEFAULT NULL,
  `batas_atas` int(11) UNSIGNED NULL DEFAULT NULL,
  `potongan_harga` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_bahan_finishing_m_bahan_finishing_potongan`(`id_finishing`) USING BTREE,
  CONSTRAINT `fk_m_bahan_finishing_m_bahan_finishing_potongan` FOREIGN KEY (`id_finishing`) REFERENCES `m_bahan_finishing` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_bahan_finishing_potongan
-- ----------------------------
INSERT INTO `m_bahan_finishing_potongan` VALUES (1, 1, 50, 100, '2000');
INSERT INTO `m_bahan_finishing_potongan` VALUES (2, NULL, 50, 100, '1000');

-- ----------------------------
-- Table structure for m_bahan_potongan
-- ----------------------------
DROP TABLE IF EXISTS `m_bahan_potongan`;
CREATE TABLE `m_bahan_potongan`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_bahan` int(11) UNSIGNED NULL DEFAULT NULL,
  `batas_bawah` int(11) UNSIGNED NULL DEFAULT NULL,
  `batas_atas` int(11) UNSIGNED NULL DEFAULT NULL,
  `potongan_harga` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_bahan_m_bahan_potongan`(`id_bahan`) USING BTREE,
  CONSTRAINT `fk_m_bahan_m_bahan_potongan` FOREIGN KEY (`id_bahan`) REFERENCES `m_bahan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_bahan_potongan
-- ----------------------------
INSERT INTO `m_bahan_potongan` VALUES (1, 1, 50, 100, '10000');
INSERT INTO `m_bahan_potongan` VALUES (2, NULL, 50, 100, '1000');
INSERT INTO `m_bahan_potongan` VALUES (3, 2, 1, 50, '25000');
INSERT INTO `m_bahan_potongan` VALUES (4, 2, 50, NULL, '50000');

-- ----------------------------
-- Table structure for m_category
-- ----------------------------
DROP TABLE IF EXISTS `m_category`;
CREATE TABLE `m_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_division` int(11) UNSIGNED NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `property` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `hidden_property` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `satuan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `validation` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_division_m_category`(`id_division`) USING BTREE,
  CONSTRAINT `fk_m_division_m_category` FOREIGN KEY (`id_division`) REFERENCES `m_division` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_category
-- ----------------------------
INSERT INTO `m_category` VALUES (1, 2, 'Tes', '[\"panjang\",\"lebar\",\"qty\"]', '[\"panjang_min\",\"lebar_min\"]', '[\"Cm\",\"Cm\",\"Total\"]', '[\"panjang\"]');
INSERT INTO `m_category` VALUES (2, 2, 'Category 2', '[\"qty\"]', '[]', '[\"Total\"]', NULL);
INSERT INTO `m_category` VALUES (3, 2, 'Sticker', '[\"panjang\",\"lebar\",\"qty\"]', '[\"panjang_min\",\"lebar_min\"]', '[\"Cm\",\"Cm\",\"Total\"]', '[\"panjang\",\"lebar\"]');
INSERT INTO `m_category` VALUES (4, 1, 'Bruce Banner', '[\"panjang\",\"qty\"]', '[\"panjang_min\"]', '[\"Cm\",\"Total\"]', '[\"panjang\"]');
INSERT INTO `m_category` VALUES (5, 3, 'Stiker A3', '[\"qty\"]', '[]', '[\"Total\"]', NULL);
INSERT INTO `m_category` VALUES (6, 1, 'KP', '[\"waktu\",\"qty\"]', '[\"waktu_min\"]', '[\"jam\",\"total\"]', NULL);
INSERT INTO `m_category` VALUES (7, 2, 'Banner', '[\"panjang\",\"lebar\",\"qty\"]', '[\"panjang_min\",\"lebar_min\"]', '[\"Meter\",\"Cm\",\"Total\"]', '[\"lebar\"]');

-- ----------------------------
-- Table structure for m_customer
-- ----------------------------
DROP TABLE IF EXISTS `m_customer`;
CREATE TABLE `m_customer`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nohp` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nokartu` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_limit_customer` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_limit_customer_m_customer`(`id_limit_customer`) USING BTREE,
  INDEX `nama`(`nama`) USING BTREE,
  INDEX `nohp`(`nohp`) USING BTREE,
  INDEX `nokartu`(`nokartu`) USING BTREE,
  CONSTRAINT `fk_m_limit_customer_m_customer` FOREIGN KEY (`id_limit_customer`) REFERENCES `m_limit_customer` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_customer
-- ----------------------------
INSERT INTO `m_customer` VALUES (1, 'Yusuf', '08123456789', '1', 1);
INSERT INTO `m_customer` VALUES (2, 'Yusuf 1', '08987654321', '2', 1);
INSERT INTO `m_customer` VALUES (3, 'Yusuf 2', '08987654321', '2', 1);
INSERT INTO `m_customer` VALUES (4, 'Yusuf 3', '08987654321', '2', 1);
INSERT INTO `m_customer` VALUES (5, 'Yusuf 4', '08987654321', '2', 1);
INSERT INTO `m_customer` VALUES (6, 'Yusuf 5', '08987654321', '2', 1);
INSERT INTO `m_customer` VALUES (7, 'Pelanggan', '08388127123', '091238', 1);

-- ----------------------------
-- Table structure for m_customer_type
-- ----------------------------
DROP TABLE IF EXISTS `m_customer_type`;
CREATE TABLE `m_customer_type`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_customer_type
-- ----------------------------
INSERT INTO `m_customer_type` VALUES (1, 'reklame');
INSERT INTO `m_customer_type` VALUES (2, 'umum');
INSERT INTO `m_customer_type` VALUES (3, 'reklame baru');

-- ----------------------------
-- Table structure for m_customer_type_division
-- ----------------------------
DROP TABLE IF EXISTS `m_customer_type_division`;
CREATE TABLE `m_customer_type_division`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_customer_type` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_division` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_customer_m_customer_type_division`(`id_customer`) USING BTREE,
  INDEX `fk_m_customer_type_m_customer_type_division`(`id_customer_type`) USING BTREE,
  INDEX `fk_m_division_m_customer_type_division`(`id_division`) USING BTREE,
  CONSTRAINT `fk_m_customer_m_customer_type_division` FOREIGN KEY (`id_customer`) REFERENCES `m_customer` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_m_customer_type_m_customer_type_division` FOREIGN KEY (`id_customer_type`) REFERENCES `m_customer_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_m_division_m_customer_type_division` FOREIGN KEY (`id_division`) REFERENCES `m_division` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 74 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_customer_type_division
-- ----------------------------
INSERT INTO `m_customer_type_division` VALUES (11, 1, 1, 1);
INSERT INTO `m_customer_type_division` VALUES (12, 1, 1, 2);
INSERT INTO `m_customer_type_division` VALUES (21, 2, 1, 1);
INSERT INTO `m_customer_type_division` VALUES (22, 2, 2, 2);
INSERT INTO `m_customer_type_division` VALUES (71, 7, 2, 1);
INSERT INTO `m_customer_type_division` VALUES (72, 7, 2, 2);
INSERT INTO `m_customer_type_division` VALUES (73, 7, 2, 3);

-- ----------------------------
-- Table structure for m_design
-- ----------------------------
DROP TABLE IF EXISTS `m_design`;
CREATE TABLE `m_design`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_design
-- ----------------------------
INSERT INTO `m_design` VALUES (1, 'Tes Design', '10000');

-- ----------------------------
-- Table structure for m_division
-- ----------------------------
DROP TABLE IF EXISTS `m_division`;
CREATE TABLE `m_division`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_division
-- ----------------------------
INSERT INTO `m_division` VALUES (1, 'Outdoor');
INSERT INTO `m_division` VALUES (2, 'Indoor');
INSERT INTO `m_division` VALUES (3, 'Print A3');
INSERT INTO `m_division` VALUES (4, 'Print A5');

-- ----------------------------
-- Table structure for m_jenis_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `m_jenis_pembayaran`;
CREATE TABLE `m_jenis_pembayaran`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_jenis_pembayaran
-- ----------------------------
INSERT INTO `m_jenis_pembayaran` VALUES (1, 'Tes Jenis Pembayaran');
INSERT INTO `m_jenis_pembayaran` VALUES (2, 'Jenis Pembayaran 2');
INSERT INTO `m_jenis_pembayaran` VALUES (3, 'Jenis Pembayaran 3');

-- ----------------------------
-- Table structure for m_limit_customer
-- ----------------------------
DROP TABLE IF EXISTS `m_limit_customer`;
CREATE TABLE `m_limit_customer`  (
  `id` int(11) UNSIGNED NOT NULL,
  `limit` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tempo` int(3) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_limit_customer
-- ----------------------------
INSERT INTO `m_limit_customer` VALUES (1, '50000', 30);
INSERT INTO `m_limit_customer` VALUES (2, '200000', 30);

-- ----------------------------
-- Table structure for m_promo
-- ----------------------------
DROP TABLE IF EXISTS `m_promo`;
CREATE TABLE `m_promo`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `diskon` smallint(100) UNSIGNED NULL DEFAULT NULL,
  `diskon_maks` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `expired` date NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` enum('yes','no') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_promo
-- ----------------------------
INSERT INTO `m_promo` VALUES (1, 'HR15JLY21', 50, '25000', '2021-12-24', 'Tes Promo', 'yes', '2021-07-15 10:01:10');

-- ----------------------------
-- Table structure for m_promo_division
-- ----------------------------
DROP TABLE IF EXISTS `m_promo_division`;
CREATE TABLE `m_promo_division`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_promo` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_division` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_promo_m_promo_division`(`id_promo`) USING BTREE,
  INDEX `fk_m_division_m_promo_division`(`id_division`) USING BTREE,
  CONSTRAINT `fk_m_division_m_promo_division` FOREIGN KEY (`id_division`) REFERENCES `m_division` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_m_promo_m_promo_division` FOREIGN KEY (`id_promo`) REFERENCES `m_promo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_promo_division
-- ----------------------------
INSERT INTO `m_promo_division` VALUES (11, 1, 1);
INSERT INTO `m_promo_division` VALUES (12, 1, 2);
INSERT INTO `m_promo_division` VALUES (13, 1, 3);

-- ----------------------------
-- Table structure for m_shift
-- ----------------------------
DROP TABLE IF EXISTS `m_shift`;
CREATE TABLE `m_shift`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_shift
-- ----------------------------
INSERT INTO `m_shift` VALUES (1, 'Shift 1 Baru', '07:00:00', '08:15:00');
INSERT INTO `m_shift` VALUES (2, 'Shift 2 Baru', '08:15:00', '09:30:00');

-- ----------------------------
-- Table structure for m_transaction
-- ----------------------------
DROP TABLE IF EXISTS `m_transaction`;
CREATE TABLE `m_transaction`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `method_id` int(11) NULL DEFAULT NULL,
  `promo_id` int(11) NULL DEFAULT NULL,
  `cabang_id` int(11) NULL DEFAULT NULL,
  `no_trx` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_total` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pay` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `status` enum('pending','belum lunas','lunas') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `last_payment` datetime NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_transaction
-- ----------------------------
INSERT INTO `m_transaction` VALUES (9, 1, NULL, NULL, NULL, 'TSG202110291', '1000000', '1000000', 'lunas', NULL, '2021-10-29 04:35:48', '2021-10-29 13:18:04');
INSERT INTO `m_transaction` VALUES (15, 1, NULL, 1, NULL, 'TSG202110319', '360369', '0', 'pending', NULL, '2021-10-31 07:59:59', '2021-10-31 07:59:59');
INSERT INTO `m_transaction` VALUES (16, 1, NULL, 1, 1, 'TSG2021110115', '180000', '180000', 'lunas', NULL, '2021-11-01 15:18:37', '2021-11-01 15:20:31');
INSERT INTO `m_transaction` VALUES (17, 1, NULL, 1, 1, 'TSG2021110916', '525000', '0', 'pending', NULL, '2021-11-09 08:57:24', '2021-11-09 08:57:24');
INSERT INTO `m_transaction` VALUES (19, 1, NULL, NULL, 1, 'TSG2021111417', '100000', '0', 'pending', NULL, '2021-11-14 14:05:10', '2021-11-14 14:05:10');

-- ----------------------------
-- Table structure for m_transaction_detail
-- ----------------------------
DROP TABLE IF EXISTS `m_transaction_detail`;
CREATE TABLE `m_transaction_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NULL DEFAULT NULL,
  `division_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `bahan_id` int(11) NOT NULL,
  `finishing_id` int(11) NULL DEFAULT NULL,
  `design_id` int(11) NULL DEFAULT NULL,
  `priority` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `property` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `qty` int(11) NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `price` int(11) NULL DEFAULT NULL,
  `date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_transaction_detail
-- ----------------------------
INSERT INTO `m_transaction_detail` VALUES (3, 9, 2, 1, 1, 3, NULL, 'Standard', '{\"panjang\":\"11\",\"lebar\":\"6\"}', 8, 'awdawd', 800000, '2021-10-29 11:35:48', '2021-10-29 04:35:48', '2021-10-29 04:35:48');
INSERT INTO `m_transaction_detail` VALUES (4, 9, 1, 4, 4, 6, NULL, 'Langsung cetak', '{\"panjang\":\"10\"}', 4, 'awdawd', 200000, '2021-10-29 11:35:48', '2021-10-29 04:35:48', '2021-10-29 04:35:48');
INSERT INTO `m_transaction_detail` VALUES (5, 15, 1, 4, 8, NULL, NULL, 'Langsung cetak', '{\"panjang\":\"4\"}', 3, 'awdawd', 369, '2021-10-31 14:59:59', '2021-10-31 07:59:59', '2021-10-31 07:59:59');
INSERT INTO `m_transaction_detail` VALUES (6, 15, 2, 7, 6, NULL, NULL, 'Langsung cetak', '{\"panjang\":\"4\",\"lebar\":\"4\"}', 3, 'awdawd', 60000, '2021-10-31 14:59:59', '2021-10-31 07:59:59', '2021-10-31 07:59:59');
INSERT INTO `m_transaction_detail` VALUES (7, 15, 2, 1, 1, NULL, NULL, 'Langsung cetak', '{\"panjang\":\"4\",\"lebar\":\"4\"}', 3, 'awdawd', 300000, '2021-10-31 14:59:59', '2021-10-31 07:59:59', '2021-10-31 07:59:59');
INSERT INTO `m_transaction_detail` VALUES (8, 16, 2, 7, 6, NULL, NULL, 'Langsung cetak', '{\"panjang\":\"7\",\"lebar\":\"7\"}', 9, 'qwewe', 180000, '2021-11-01 22:18:37', '2021-11-01 15:18:37', '2021-11-01 15:18:37');
INSERT INTO `m_transaction_detail` VALUES (9, 17, 2, 3, 2, NULL, NULL, 'Langsung cetak', '{\"panjang\":\"4\",\"lebar\":\"4\"}', 3, 'awdawd', 350000, '2021-11-09 15:57:24', '2021-11-09 08:57:24', '2021-11-09 08:57:24');
INSERT INTO `m_transaction_detail` VALUES (11, 19, 2, 7, 6, NULL, NULL, 'Langsung cetak', '{\"panjang\":\"3\",\"lebar\":\"3\"}', 2, 'awdawd', 40000, '2021-11-14 21:05:10', '2021-11-14 14:05:10', '2021-11-14 14:05:10');

-- ----------------------------
-- Table structure for m_user
-- ----------------------------
DROP TABLE IF EXISTS `m_user`;
CREATE TABLE `m_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` enum('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'penjelasan type\r\n\r\n0 = Admin\r\n1 = Sub Admin\r\n2 = Kasir' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_user
-- ----------------------------
INSERT INTO `m_user` VALUES (1, 'admin', 'admin', 'Admin', '0');

-- ----------------------------
-- Table structure for master_cabangs
-- ----------------------------
DROP TABLE IF EXISTS `master_cabangs`;
CREATE TABLE `master_cabangs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tipe_pelanggan` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of master_cabangs
-- ----------------------------
INSERT INTO `master_cabangs` VALUES (1, 'localhost:8000', 1, 1, '2021-10-31 20:39:07', '2021-10-31 20:39:09');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2021_10_26_071855_add_timestamp_in_transaction_table', 1);
INSERT INTO `migrations` VALUES (2, '2021_10_26_072132_create_payment_transaction_table', 2);
INSERT INTO `migrations` VALUES (3, '2021_10_31_073356_create_master_cabangs_table', 3);
INSERT INTO `migrations` VALUES (4, '2021_10_31_131700_create_users_table', 4);
INSERT INTO `migrations` VALUES (5, '2014_10_12_100000_create_password_resets_table', 5);
INSERT INTO `migrations` VALUES (6, '2021_11_07_074755_create_extras_table', 5);
INSERT INTO `migrations` VALUES (7, '2021_12_03_123358_add_last_payment_column_table', 6);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for payment_transaction
-- ----------------------------
DROP TABLE IF EXISTS `payment_transaction`;
CREATE TABLE `payment_transaction`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `pay` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payment_transaction
-- ----------------------------
INSERT INTO `payment_transaction` VALUES (1, 1, 9, 1, '4000', '2021-10-29 06:17:26', '2021-10-29 06:17:26');
INSERT INTO `payment_transaction` VALUES (10, 1, 9, 1, '996000', '2021-10-29 13:18:04', '2021-10-29 13:18:04');
INSERT INTO `payment_transaction` VALUES (11, 1, 16, 1, '80000', '2021-11-01 15:20:01', '2021-11-01 15:20:01');
INSERT INTO `payment_transaction` VALUES (12, 1, 16, 1, '100000', '2021-11-01 15:20:31', '2021-11-01 15:20:31');
INSERT INTO `payment_transaction` VALUES (13, 2, 16, 1, '1000', '2021-12-30 00:38:16', '2021-12-30 00:38:16');
INSERT INTO `payment_transaction` VALUES (14, 2, 16, 1, '2000', '2021-12-30 00:39:10', '2021-12-30 00:39:10');
INSERT INTO `payment_transaction` VALUES (15, 2, 16, 2, '1000', '2021-12-30 07:38:16', '2021-12-30 07:38:16');
INSERT INTO `payment_transaction` VALUES (16, 2, 16, 2, '2000', '2021-12-30 07:38:16', '2021-12-30 07:38:16');

-- ----------------------------
-- Table structure for pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE `pengeluaran`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `deskripsi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO `pengeluaran` VALUES (1, 'Beli Rokok Surya 12', '19000', '2021-12-06 02:33:25');
INSERT INTO `pengeluaran` VALUES (2, 'Beli Susu SGM', '60000', '2021-12-05 02:34:13');
INSERT INTO `pengeluaran` VALUES (3, 'Beli Rokok Surya 12', '19000', '2021-12-30 02:13:26');
INSERT INTO `pengeluaran` VALUES (4, 'Beli Susu SGM', '60000', '2021-12-30 02:13:26');

-- ----------------------------
-- Table structure for tes_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `tes_transaksi`;
CREATE TABLE `tes_transaksi`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `kode` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('belum','sudah','') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `tanggal`, `kode`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC PARTITION BY RANGE (YEAR(tanggal))
PARTITIONS 2
SUBPARTITION BY HASH (MONTH(tanggal))
SUBPARTITIONS 12
(PARTITION `p2021` VALUES LESS THAN (2022) MAX_ROWS = 0 MIN_ROWS = 0 (SUBPARTITION `dec_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `jan_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `feb_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `mar_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `apr_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `may_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `jun_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `jul_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `aug_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `sep_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `oct_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `nov_2021` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ),
PARTITION `pmax` VALUES LESS THAN (MAXVALUE) MAX_ROWS = 0 MIN_ROWS = 0 (SUBPARTITION `dec_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `jan_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `feb_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `mar_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `apr_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `may_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `jun_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `jul_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `aug_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `sep_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `oct_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ,
SUBPARTITION `nov_max` ENGINE = InnoDB MAX_ROWS = 0 MIN_ROWS = 0 ))
;

-- ----------------------------
-- Records of tes_transaksi
-- ----------------------------
INSERT INTO `tes_transaksi` VALUES (1, '2021-06-01 10:06:30', 'TJG0621', '1000', 'belum');
INSERT INTO `tes_transaksi` VALUES (2, '2021-06-02 10:07:09', 'TJG0621', '2000', 'sudah');
INSERT INTO `tes_transaksi` VALUES (5, '2021-06-03 10:00:00', 'TJG0621', '3000', 'belum');
INSERT INTO `tes_transaksi` VALUES (3, '2021-07-21 10:07:29', 'TJG0721', '1000', 'sudah');
INSERT INTO `tes_transaksi` VALUES (4, '2021-08-01 10:07:51', 'TJG0821', '1000', 'belum');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 1, 'Superadmin', 'superadmin', '$2y$10$XaL1FncPMiKDutiSZnD/E.KoS9efpHu1MoN3CORpUVxJSGqpPUWVG', NULL, '2021-10-31 20:38:42', '2021-10-31 20:38:45');

SET FOREIGN_KEY_CHECKS = 1;
