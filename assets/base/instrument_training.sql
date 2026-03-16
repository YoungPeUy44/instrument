/*
 Navicat Premium Data Transfer

 Source Server         : 192.168.99.98
 Source Server Type    : MySQL
 Source Server Version : 100529 (10.5.29-MariaDB)
 Source Host           : 192.168.99.98:3306
 Source Schema         : executive_web

 Target Server Type    : MySQL
 Target Server Version : 100529 (10.5.29-MariaDB)
 File Encoding         : 65001

 Date: 16/03/2026 11:00:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for instrument_training
-- ----------------------------
DROP TABLE IF EXISTS `instrument_training`;
CREATE TABLE `instrument_training`  (
  `training_id` int NOT NULL AUTO_INCREMENT,
  `training_topic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `training_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `training_start` datetime NOT NULL,
  `training_end` datetime NULL DEFAULT NULL,
  `training_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `training_status` tinyint NULL DEFAULT 0,
  `created_by` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `updated_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`training_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of instrument_training
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
