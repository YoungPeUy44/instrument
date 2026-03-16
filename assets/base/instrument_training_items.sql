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

 Date: 16/03/2026 11:00:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for instrument_training_items
-- ----------------------------
DROP TABLE IF EXISTS `instrument_training_items`;
CREATE TABLE `instrument_training_items`  (
  `training_item_id` int NOT NULL AUTO_INCREMENT,
  `training_id` int NULL DEFAULT NULL,
  `instrument_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`training_item_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of instrument_training_items
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
