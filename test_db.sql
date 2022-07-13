/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 80019
 Source Host           : 127.0.0.1:3306
 Source Schema         : test_db

 Target Server Type    : MySQL
 Target Server Version : 80019
 File Encoding         : 65001

 Date: 13/07/2022 10:58:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for delivery_services
-- ----------------------------
DROP TABLE IF EXISTS `delivery_services`;
CREATE TABLE `delivery_services`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `tariff_km` double NOT NULL DEFAULT 0,
  `tariff_kg` double NOT NULL,
  `kms_day` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of delivery_services
-- ----------------------------
INSERT INTO `delivery_services` VALUES (1, 'sdek', 0.4, 15, 1000);
INSERT INTO `delivery_services` VALUES (2, 'pek', 0.5, 12, 850);
INSERT INTO `delivery_services` VALUES (3, 'rupost', 0.3, 10, 700);

SET FOREIGN_KEY_CHECKS = 1;
