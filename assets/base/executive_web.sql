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

 Date: 16/03/2026 10:32:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for automate_category
-- ----------------------------
DROP TABLE IF EXISTS `automate_category`;
CREATE TABLE `automate_category`  (
  `atm_category_id` int NOT NULL AUTO_INCREMENT,
  `atm_category_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `atm_category_updatedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atm_category_updatedAt` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `atm_category_updatedEv` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`atm_category_id`) USING BTREE,
  UNIQUE INDEX `atm_category_name`(`atm_category_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of automate_category
-- ----------------------------
INSERT INTO `automate_category` VALUES (1, 'Biochemistry', NULL, '0000-00-00 00:00:00', '2025-06-05 00:12:41');
INSERT INTO `automate_category` VALUES (2, 'Hematology', NULL, '0000-00-00 00:00:00', '2025-06-05 00:12:41');
INSERT INTO `automate_category` VALUES (3, 'Immunology', NULL, '0000-00-00 00:00:00', '2025-06-05 00:12:41');
INSERT INTO `automate_category` VALUES (4, 'Microbiology', NULL, '0000-00-00 00:00:00', '2025-06-05 00:12:41');
INSERT INTO `automate_category` VALUES (5, 'Electrolyte', 'บังโต ซิลลี่ฟูลส์', '2025-06-05 00:13:11', '2025-06-05 00:13:11');
INSERT INTO `automate_category` VALUES (6, 'Coagulation', 'บังโต ซิลลี่ฟูลส์', '2025-06-05 00:13:21', '2025-06-05 00:13:21');
INSERT INTO `automate_category` VALUES (7, 'Blood Gas', 'บังโต ซิลลี่ฟูลส์', '2025-06-04 23:33:21', '2025-06-05 00:12:41');
INSERT INTO `automate_category` VALUES (8, 'Microscopy', NULL, '0000-00-00 00:00:00', '2025-06-05 00:12:41');
INSERT INTO `automate_category` VALUES (9, 'Blood Bank', NULL, '0000-00-00 00:00:00', '2025-06-05 00:12:41');
INSERT INTO `automate_category` VALUES (10, 'HbA1c', 'บังโต ซิลลี่ฟูลส์', '2025-06-05 17:18:36', '2025-06-05 17:18:36');
INSERT INTO `automate_category` VALUES (12, 'Feces', NULL, '0000-00-00 00:00:00', '2025-06-05 00:12:41');

-- ----------------------------
-- Table structure for automate_model
-- ----------------------------
DROP TABLE IF EXISTS `automate_model`;
CREATE TABLE `automate_model`  (
  `atm_model_id` int NOT NULL AUTO_INCREMENT,
  `atm_model_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `ref_atm_category_id` int NOT NULL,
  `ref_atm_status_manual_id` int NOT NULL DEFAULT 2 COMMENT '1=มีคู่มือ, 2=ไม่มีคู่มือ, 3=รออบรม',
  `atm_training_date` date NULL DEFAULT NULL COMMENT 'วันอบรบเครื่องตรวจ',
  `atm_training_timestart` time NULL DEFAULT NULL COMMENT 'เวลาเริ่มอบรม',
  `atm_training_timeend` time NULL DEFAULT NULL COMMENT 'เวลาสิ้นสุดอบรบ',
  `atm_model_updatedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atm_model_updatedAt` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `atm_model_updatedEv` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`atm_model_id`) USING BTREE,
  UNIQUE INDEX `atm_model_name`(`atm_model_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 157 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of automate_model
-- ----------------------------
INSERT INTO `automate_model` VALUES (1, 'DIRUI-BF6800', 2, 2, NULL, NULL, NULL, 'นรวิชญ์ ศิริลักษณมานนท์', '2025-09-26 22:43:23', '2025-09-26 22:43:23');
INSERT INTO `automate_model` VALUES (2, 'QUINTUS', 2, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (3, 'GH900', 10, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (4, 'H9', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 22:22:37', '2026-03-05 22:22:37');
INSERT INTO `automate_model` VALUES (5, 'Q4-LYTE', 5, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-09 08:39:48', '2026-03-09 08:39:48');
INSERT INTO `automate_model` VALUES (6, 'Q4-LYTE EX', 5, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (7, 'LIAISON', 3, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (8, 'GETEIN-1160', 3, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-09 14:38:57', '2026-03-09 14:38:57');
INSERT INTO `automate_model` VALUES (9, 'ERBA LYTE PRO', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 09:02:05', '2026-03-05 09:02:05');
INSERT INTO `automate_model` VALUES (10, 'DIRUI-H500', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-13 17:06:16', '2026-03-13 17:06:16');
INSERT INTO `automate_model` VALUES (11, 'BS-600M', 1, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-03 09:08:26', '2026-03-03 09:08:26');
INSERT INTO `automate_model` VALUES (12, 'DXC700AU', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 22:15:29', '2026-03-05 22:15:29');
INSERT INTO `automate_model` VALUES (13, 'AUTOLUMO A1000', 3, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 21:22:29', '2026-03-05 21:22:29');
INSERT INTO `automate_model` VALUES (14, 'ALINITY C', 1, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-02-26 15:24:31', '2026-02-26 15:24:31');
INSERT INTO `automate_model` VALUES (15, 'RAC-050', 6, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 15:21:26', '2026-03-10 15:21:26');
INSERT INTO `automate_model` VALUES (16, 'EASYSTAT', 7, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 15:32:39', '2026-03-11 15:32:39');
INSERT INTO `automate_model` VALUES (17, 'PKL-175', 6, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 14:12:31', '2026-03-11 14:12:31');
INSERT INTO `automate_model` VALUES (18, 'LIAISON XL', 3, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-09 15:40:01', '2026-03-09 15:40:01');
INSERT INTO `automate_model` VALUES (19, 'XL-1000', 1, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (20, 'LAURA SMART', 8, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (21, 'CA-600', 6, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (22, 'URIT-5250', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 10:13:12', '2026-03-10 10:13:12');
INSERT INTO `automate_model` VALUES (23, 'XN-550', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 11:24:20', '2026-03-10 11:24:20');
INSERT INTO `automate_model` VALUES (24, 'URIT-500B', 8, 2, NULL, NULL, NULL, 'บังโต ซิลลี่ฟูลส์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (25, 'URIT-5380', 2, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (26, 'XL-640', 1, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (27, 'BC120', 4, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 15:38:41', '2026-03-11 15:38:41');
INSERT INTO `automate_model` VALUES (28, 'NEW LAURA', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 16:12:50', '2026-03-11 16:12:50');
INSERT INTO `automate_model` VALUES (29, 'AU480', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 21:26:49', '2026-03-05 21:26:49');
INSERT INTO `automate_model` VALUES (30, 'CA-620', 6, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 14:16:25', '2026-03-11 14:16:25');
INSERT INTO `automate_model` VALUES (31, 'URISCAN PRO', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 14:52:57', '2026-03-10 14:52:57');
INSERT INTO `automate_model` VALUES (32, 'XD697', 5, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 22:33:09', '2026-03-05 22:33:09');
INSERT INTO `automate_model` VALUES (33, 'BM6010', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 21:58:00', '2026-03-05 21:58:00');
INSERT INTO `automate_model` VALUES (34, 'CITEST AUR-100', 8, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (35, 'PT1000', 7, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 14:28:40', '2026-03-11 14:28:40');
INSERT INTO `automate_model` VALUES (36, 'CYBOW R-600S', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-13 09:48:27', '2026-03-13 09:48:27');
INSERT INTO `automate_model` VALUES (37, 'XL-1000 WITH ISE', 1, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (38, 'URIT-BH5390', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 10:22:02', '2026-03-10 10:22:02');
INSERT INTO `automate_model` VALUES (39, 'AUTOMAX-80', 9, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 10:34:23', '2026-03-05 10:34:23');
INSERT INTO `automate_model` VALUES (40, 'XL-921B', 5, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (41, 'XN-350', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 11:28:20', '2026-03-10 11:28:20');
INSERT INTO `automate_model` VALUES (42, 'H8', 10, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 22:20:42', '2026-03-05 22:20:42');
INSERT INTO `automate_model` VALUES (43, 'PREMIER HB9210', 10, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-06 08:51:22', '2026-03-06 08:51:22');
INSERT INTO `automate_model` VALUES (44, 'CL-900I', 3, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 09:40:47', '2026-03-10 09:40:47');
INSERT INTO `automate_model` VALUES (45, 'VITROS 4600 WITH ISE', 1, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-06 16:40:16', '2026-03-06 16:40:16');
INSERT INTO `automate_model` VALUES (46, 'XN-1000', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 11:22:32', '2026-03-10 11:22:32');
INSERT INTO `automate_model` VALUES (47, 'US1680', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 14:54:37', '2026-03-10 14:54:37');
INSERT INTO `automate_model` VALUES (48, 'MAGLUMI 800', 3, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-09 15:42:24', '2026-03-09 15:42:24');
INSERT INTO `automate_model` VALUES (49, 'FUS-1000', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 15:43:38', '2026-03-11 15:43:38');
INSERT INTO `automate_model` VALUES (50, 'MAGLUMI600', 3, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (51, 'BS820M', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 21:36:28', '2026-03-05 21:36:28');
INSERT INTO `automate_model` VALUES (52, 'ARCHITECT CI4100', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-12 17:03:23', '2026-03-12 17:03:23');
INSERT INTO `automate_model` VALUES (53, 'BC760', 3, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 13:18:58', '2026-03-10 13:18:58');
INSERT INTO `automate_model` VALUES (54, 'CS-1600', 6, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (55, 'FECES FA280', 12, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (56, 'ARKRAY HA 8180V', 10, 2, NULL, NULL, NULL, 'บังโต ซิลลี่ฟูลส์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (57, 'COBAS C5800', 3, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (58, 'COBAS PURE E402', 3, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (59, 'IDEN SENT VITEK 2XL', 4, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (60, 'XN-1500', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 11:11:30', '2026-03-10 11:11:30');
INSERT INTO `automate_model` VALUES (61, 'ARCHITECT CI8200', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-13 11:11:11', '2026-03-13 11:11:11');
INSERT INTO `automate_model` VALUES (62, 'ISE6000', 5, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (63, 'HA8380', 10, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-06 20:17:10', '2026-03-06 20:17:10');
INSERT INTO `automate_model` VALUES (64, 'BC5180', 2, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (65, 'ACCESS2', 3, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (66, 'H900', 5, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 22:36:20', '2026-03-05 22:36:20');
INSERT INTO `automate_model` VALUES (67, 'XL-1000 PLUS', 1, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (68, 'BC60', 4, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 15:33:55', '2026-03-11 15:33:55');
INSERT INTO `automate_model` VALUES (69, 'QCR U500', 8, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (70, 'IN4-LYTE', 5, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (71, 'CA-500', 6, 2, NULL, NULL, NULL, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (72, 'BT120', 4, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 15:42:13', '2026-03-11 15:42:13');
INSERT INTO `automate_model` VALUES (73, 'BT-60', 4, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-04 20:22:34', '2026-03-04 20:22:34');
INSERT INTO `automate_model` VALUES (74, 'ALINITY I', 3, 2, NULL, NULL, NULL, 'บังโต ซิลลี่ฟูลส์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (75, 'ALINITY CI', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-09 08:58:14', '2026-03-09 08:58:14');
INSERT INTO `automate_model` VALUES (76, 'XL-640 PLUS', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 22:30:04', '2026-03-05 22:30:04');
INSERT INTO `automate_model` VALUES (77, 'BH-6180', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 11:19:56', '2026-03-10 11:19:56');
INSERT INTO `automate_model` VALUES (78, 'C3100', 6, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 14:27:01', '2026-03-11 14:27:01');
INSERT INTO `automate_model` VALUES (79, 'QUIDELSOFIA', 3, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (80, 'AUTOBIO A1860', 3, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-13 10:33:37', '2026-03-13 10:33:37');
INSERT INTO `automate_model` VALUES (81, 'LAURA XL', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 14:12:26', '2026-03-10 14:12:26');
INSERT INTO `automate_model` VALUES (82, 'SF8050', 6, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 14:21:13', '2026-03-11 14:21:13');
INSERT INTO `automate_model` VALUES (83, 'BT2000', 1, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (84, 'ARES', 6, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (85, 'CYBOW 720', 8, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (86, 'BT3500', 1, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (87, 'MET6000', 1, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (88, 'CM-1000', 1, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (89, 'AU680', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 21:33:30', '2026-03-05 21:33:30');
INSERT INTO `automate_model` VALUES (90, 'URISED2&LABUMAT2', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 14:15:16', '2026-03-10 14:15:16');
INSERT INTO `automate_model` VALUES (91, 'A1CCHEK PRO', 10, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 21:21:00', '2026-03-05 21:21:00');
INSERT INTO `automate_model` VALUES (92, 'RAC-1800', 6, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 16:19:44', '2026-03-10 16:19:44');
INSERT INTO `automate_model` VALUES (93, 'BC6000', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 13:08:02', '2026-03-10 13:08:02');
INSERT INTO `automate_model` VALUES (94, 'TOSOH G8', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-06 08:53:19', '2026-03-06 08:53:19');
INSERT INTO `automate_model` VALUES (95, 'COBAS6000', 1, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (96, 'FUS-3000', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 16:00:26', '2026-03-11 16:00:26');
INSERT INTO `automate_model` VALUES (97, 'TOSOH HLC-723G11', 10, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:51', '2026-02-26 15:19:51');
INSERT INTO `automate_model` VALUES (98, 'PENTRA 80XL', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 13:20:34', '2026-03-10 13:20:34');
INSERT INTO `automate_model` VALUES (99, 'INDIKO PLUS', 1, 1, NULL, NULL, NULL, 'นรวิชญ์ ศิริลักษณมานนท์', '2026-03-06 15:47:04', '2026-03-06 15:47:04');
INSERT INTO `automate_model` VALUES (100, 'URIT-50', 8, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (101, 'BC-5180', 2, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (102, 'BC-700', 2, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (103, 'BC6200', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 13:17:38', '2026-03-10 13:17:38');
INSERT INTO `automate_model` VALUES (104, 'D10', 10, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (105, 'CS-2100I', 6, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (106, 'COBAS PRO', 1, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (107, 'ATELLICA CI', 1, 2, NULL, NULL, NULL, 'ธนาภูมิ วิไลรัตน์', '2025-12-24 12:02:52', '2025-12-24 12:02:52');
INSERT INTO `automate_model` VALUES (108, 'VERSATREK', 4, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (109, 'ATELLICA (CH930+IM1300)', 1, 2, NULL, NULL, NULL, 'ธนาภูมิ วิไลรัตน์', '2025-12-24 12:02:26', '2025-12-24 12:02:26');
INSERT INTO `automate_model` VALUES (110, 'COBAS C503', 1, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (111, 'EU5300', 8, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (112, 'EDENI15', 7, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (113, 'ORTHO VISION', 9, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (114, 'H100', 10, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-05 22:24:32', '2026-03-05 22:24:32');
INSERT INTO `automate_model` VALUES (115, 'US2000C', 8, 2, NULL, NULL, NULL, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (116, 'SA120', 9, 2, NULL, NULL, NULL, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (117, 'COBAS E411', 3, 2, NULL, NULL, NULL, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (118, 'VITROS XT7600', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-13 09:58:44', '2026-03-13 09:58:44');
INSERT INTO `automate_model` VALUES (119, 'CAL6000', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-13 09:34:41', '2026-03-13 09:34:41');
INSERT INTO `automate_model` VALUES (120, 'ACON-U500', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 16:22:53', '2026-03-11 16:22:53');
INSERT INTO `automate_model` VALUES (121, 'ARCHITECT I2000 SR', 3, 2, NULL, NULL, NULL, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (122, 'SEBIA MINI CAP', 2, 2, NULL, NULL, NULL, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (123, 'LB12', 9, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-03 09:08:45', '2026-03-03 09:08:45');
INSERT INTO `automate_model` VALUES (124, 'AU5800', 1, 2, NULL, NULL, NULL, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:51:02', '2025-11-25 16:51:02');
INSERT INTO `automate_model` VALUES (125, 'XL-640 WITH ISE', 1, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 16:51:01', '2025-11-25 16:51:01');
INSERT INTO `automate_model` VALUES (126, 'BC-5600', 2, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2025-11-25 16:50:55', '2025-11-25 16:50:55');
INSERT INTO `automate_model` VALUES (127, 'INTEGRA 400 PLUS', 1, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2025-11-25 16:50:53', '2025-11-25 16:50:53');
INSERT INTO `automate_model` VALUES (128, 'YUMIZEN G800', 6, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2025-11-25 16:50:54', '2025-11-25 16:50:54');
INSERT INTO `automate_model` VALUES (129, 'YUMIZENG800', 6, 2, NULL, NULL, NULL, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:50:52', '2025-11-25 16:50:52');
INSERT INTO `automate_model` VALUES (130, 'C8000', 1, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 16:59:45', '2025-11-25 16:59:45');
INSERT INTO `automate_model` VALUES (131, 'BA400', 1, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2025-11-25 16:50:50', '2025-11-25 16:50:50');
INSERT INTO `automate_model` VALUES (132, 'VITROS 3600', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-12 11:18:45', '2026-03-12 11:18:45');
INSERT INTO `automate_model` VALUES (133, 'YUMIZEN H1500', 2, 2, NULL, NULL, NULL, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:50:47', '2025-11-25 16:50:47');
INSERT INTO `automate_model` VALUES (134, 'HISCL-800', 3, 2, NULL, NULL, NULL, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:51:04', '2025-11-25 16:51:04');
INSERT INTO `automate_model` VALUES (135, 'I2000SR', 3, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 17:01:00', '2025-11-25 17:01:00');
INSERT INTO `automate_model` VALUES (136, 'LD-600', 10, 2, NULL, NULL, NULL, 'ดนุภัทร สังสีแก้ว', '2025-12-05 09:59:53', '2025-12-05 09:59:53');
INSERT INTO `automate_model` VALUES (137, 'XNL-550', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-10 11:27:17', '2026-03-10 11:27:17');
INSERT INTO `automate_model` VALUES (138, 'PREMIER RESOLUTION', 2, 1, NULL, NULL, NULL, 'ณัฐนนท์', '2026-03-11 16:16:34', '2026-03-11 16:16:34');
INSERT INTO `automate_model` VALUES (139, 'DL96A', 4, 2, NULL, NULL, NULL, 'รงค์รวี ศรีกระภา', '2026-01-14 11:20:00', '2026-01-14 11:20:00');
INSERT INTO `automate_model` VALUES (140, 'LB24', 9, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-01-21 19:24:03', '2026-01-21 19:24:03');
INSERT INTO `automate_model` VALUES (141, 'MACCURAH2600', 6, 2, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-01-22 18:35:54', '2026-01-22 18:35:54');
INSERT INTO `automate_model` VALUES (142, 'IRICELL3000', 1, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-11 16:38:51', '2026-03-11 16:38:51');
INSERT INTO `automate_model` VALUES (143, 'MACCURA I1000', 3, 2, NULL, NULL, NULL, 'รงค์รวี ศรีกระภา', '2026-01-29 16:25:16', '2026-01-29 16:25:16');
INSERT INTO `automate_model` VALUES (144, 'BS-620M', 1, 1, NULL, NULL, NULL, 'ธนาภูมิ วิไลรัตน์', '2026-03-05 21:34:34', '2026-03-05 21:34:34');
INSERT INTO `automate_model` VALUES (145, 'SAL6000', 1, 2, NULL, NULL, NULL, 'ธนาภูมิ วิไลรัตน์', '2026-02-06 18:19:04', '2026-02-06 18:19:04');
INSERT INTO `automate_model` VALUES (146, 'KEYU KU-2800', 8, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-12 11:47:18', '2026-03-12 11:47:18');
INSERT INTO `automate_model` VALUES (147, 'US-1800', 8, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2026-02-17 18:00:52', '2026-02-17 18:00:52');
INSERT INTO `automate_model` VALUES (148, 'CA-660', 6, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2026-02-18 12:58:25', '2026-02-18 12:58:25');
INSERT INTO `automate_model` VALUES (149, 'UN-2000', 8, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2026-02-18 12:59:44', '2026-02-18 12:59:44');
INSERT INTO `automate_model` VALUES (150, 'RAPID POINT 500', 7, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2026-02-19 09:49:19', '2026-02-19 09:49:19');
INSERT INTO `automate_model` VALUES (151, 'LABUREADER PLUS2 & URISED MINI', 8, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2026-02-19 13:15:51', '2026-02-19 13:15:51');
INSERT INTO `automate_model` VALUES (152, 'AFR-400S', 3, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2026-02-19 13:17:54', '2026-02-19 13:17:54');
INSERT INTO `automate_model` VALUES (153, 'ZYBIO Q8 PRO', 3, 2, NULL, NULL, NULL, 'พีรณัฐ แสงรัตน์', '2026-02-19 13:19:30', '2026-02-19 13:19:30');
INSERT INTO `automate_model` VALUES (154, 'MACCURA I800', 3, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-12 10:10:18', '2026-03-12 10:10:18');
INSERT INTO `automate_model` VALUES (155, 'ISE ON XL-1000', 5, 2, NULL, NULL, NULL, 'นรภัทร วงษ์สวัสดิ์', '2026-03-09 10:41:33', '2026-03-09 10:41:33');
INSERT INTO `automate_model` VALUES (156, 'KEYU KU-F20', 12, 1, NULL, NULL, NULL, 'ณัฐนนท์ ปราณี', '2026-03-13 08:55:49', '2026-03-13 08:55:49');

-- ----------------------------
-- Table structure for instrument_cable_types
-- ----------------------------
DROP TABLE IF EXISTS `instrument_cable_types`;
CREATE TABLE `instrument_cable_types`  (
  `cable_id` int NOT NULL AUTO_INCREMENT,
  `cable_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cable_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cable_is_active` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`cable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_cable_types
-- ----------------------------
INSERT INTO `instrument_cable_types` VALUES (1, 'RS232 Cross', 'cables/cable_rs232_cross.png', 'Y');
INSERT INTO `instrument_cable_types` VALUES (2, 'RS232 Direct', 'cables/cable_rs232_direct.png', 'Y');
INSERT INTO `instrument_cable_types` VALUES (3, 'LAN', 'cables/cable_lan.png', 'Y');
INSERT INTO `instrument_cable_types` VALUES (4, 'RS232 XL', 'cables/cable_rs232_xl.png', 'Y');
INSERT INTO `instrument_cable_types` VALUES (5, 'RS232 To USB', 'cables/usb_to_rsr232.png', 'Y');
INSERT INTO `instrument_cable_types` VALUES (6, 'RS232 Vitros4600', 'cables/cable_Vitros4600.jpg', 'Y');

-- ----------------------------
-- Table structure for instrument_determination
-- ----------------------------
DROP TABLE IF EXISTS `instrument_determination`;
CREATE TABLE `instrument_determination`  (
  `deter_id` int NOT NULL AUTO_INCREMENT,
  `instrument_id` int UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`deter_id`) USING BTREE,
  INDEX `instrument_id`(`instrument_id` ASC) USING BTREE,
  INDEX `idx_df_instrument_id`(`instrument_id` ASC) USING BTREE,
  CONSTRAINT `instrument_determination_ibfk_1` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`ins_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 77 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_determination
-- ----------------------------
INSERT INTO `instrument_determination` VALUES (2, 73, 'BT60_4321_20260304_004_e6196.zip', 'determination_bt60.zip', NULL);
INSERT INTO `instrument_determination` VALUES (3, 9, 'ERBALYTEPRO_0117_20260305_004_ad944.zip', 'determination_q4lyteex.zip', NULL);
INSERT INTO `instrument_determination` VALUES (4, 39, 'AUTOMAX80_2854_20260305_004_6eb83.zip', 'determination_sa120.zip', NULL);
INSERT INTO `instrument_determination` VALUES (5, 91, 'A1CCHEKPRO_3337_20260305_004_077fc.zip', 'determination_a1ccheckpro.zip', NULL);
INSERT INTO `instrument_determination` VALUES (6, 13, 'AUTOLUMOA1000_6526_20260305_004_f0abf.zip', 'determination_autobio.zip', NULL);
INSERT INTO `instrument_determination` VALUES (7, 29, 'AU480_6262_20260305_004_b1719.zip', 'determination_au480.zip', NULL);
INSERT INTO `instrument_determination` VALUES (8, 89, 'AU680_1328_20260305_004_74108.zip', 'determination_au480.zip', NULL);
INSERT INTO `instrument_determination` VALUES (9, 144, 'BS620M_9750_20260305_004_a3a50.zip', 'determination_bf6800.zip', NULL);
INSERT INTO `instrument_determination` VALUES (10, 51, 'BS820M_5443_20260305_004_d5cec.zip', 'determination_bs820.zip', NULL);
INSERT INTO `instrument_determination` VALUES (11, 33, 'BM6010_1059_20260305_004_485a4.zip', 'determination_bm6010.zip', NULL);
INSERT INTO `instrument_determination` VALUES (12, 12, 'DXC700AU_6703_20260305_004_54305.zip', 'determination_au700.zip', NULL);
INSERT INTO `instrument_determination` VALUES (13, 42, 'H8_1220_20260305_004_ce2ca.zip', 'determination_h8.zip', NULL);
INSERT INTO `instrument_determination` VALUES (14, 4, 'H9_8144_20260305_004_ee4b7.zip', 'determination_gh900.zip', NULL);
INSERT INTO `instrument_determination` VALUES (15, 114, 'H100_4004_20260305_004_700ce.zip', 'determination_h8.zip', NULL);
INSERT INTO `instrument_determination` VALUES (16, 76, 'XL640PLUS_4011_20260305_004_1b116.rar', 'determination_xl1000.rar', NULL);
INSERT INTO `instrument_determination` VALUES (17, 32, 'XD697_1253_20260305_004_a1559.zip', 'determination_xd697.zip', NULL);
INSERT INTO `instrument_determination` VALUES (18, 66, 'H900_3544_20260305_004_bf2fe.zip', 'determination_h900.zip', NULL);
INSERT INTO `instrument_determination` VALUES (19, 43, 'PREMIERHB9210_8049_20260306_004_669f9.zip', 'determination_premier.zip', NULL);
INSERT INTO `instrument_determination` VALUES (20, 94, 'TOSOHG8_2366_20260306_004_14485.zip', 'determination_hlc723g8.zip', NULL);
INSERT INTO `instrument_determination` VALUES (21, 63, 'HA8380_8116_20260306_004_71943.zip', 'determination_ha8380.zip', NULL);
INSERT INTO `instrument_determination` VALUES (23, 45, 'VITROS4600WITHISE_3842_20260306_004_f144c.zip', 'determination_vitros4600.zip', NULL);
INSERT INTO `instrument_determination` VALUES (24, 99, 'INDIKOPLUS_5450_20260306_004_b3eca.zip', 'determination_indiko.zip', NULL);
INSERT INTO `instrument_determination` VALUES (25, 75, 'ALINITYCI_9035_20260306_004_c7554.zip', 'determination_alinity.zip', NULL);
INSERT INTO `instrument_determination` VALUES (26, 8, 'file_073857_8305a.zip', 'determination_getein1160.zip', NULL);
INSERT INTO `instrument_determination` VALUES (27, 18, 'file_084001_d5846.zip', 'determination_liaisonxl.zip', NULL);
INSERT INTO `instrument_determination` VALUES (28, 48, 'file_084224_a034c.zip', 'determination_maglumi800.zip', NULL);
INSERT INTO `instrument_determination` VALUES (29, 44, 'file_024045_56dec.zip', 'determination_cl900i.zip', NULL);
INSERT INTO `instrument_determination` VALUES (30, 22, 'file_031312_99b0a.zip', 'determination_bf6800.zip', NULL);
INSERT INTO `instrument_determination` VALUES (31, 38, 'file_032202_213b9.zip', 'determination_urit5390.zip', NULL);
INSERT INTO `instrument_determination` VALUES (32, 77, 'file_033014_4b4ed.zip', 'determination_bf6800.zip', NULL);
INSERT INTO `instrument_determination` VALUES (33, 60, 'file_041130_2039c.zip', 'determination_xs1000i.zip', NULL);
INSERT INTO `instrument_determination` VALUES (34, 46, 'file_042232_96ab3.zip', 'determination_xs1000i.zip', NULL);
INSERT INTO `instrument_determination` VALUES (35, 23, 'file_042420_1ea2f.zip', 'determination_xs1000i.zip', NULL);
INSERT INTO `instrument_determination` VALUES (36, 137, 'file_042717_386f2.zip', 'determination_xs1000i.zip', NULL);
INSERT INTO `instrument_determination` VALUES (37, 41, 'file_042820_f3739.zip', 'determination_xs1000i.zip', NULL);
INSERT INTO `instrument_determination` VALUES (38, 93, 'file_060802_d9a3b.zip', 'determination_bc5300.zip', NULL);
INSERT INTO `instrument_determination` VALUES (39, 103, 'file_061738_5fa4a.zip', 'determination_bc5300.zip', NULL);
INSERT INTO `instrument_determination` VALUES (40, 53, 'file_061858_eb97c.zip', 'determination_bc5300.zip', NULL);
INSERT INTO `instrument_determination` VALUES (41, 98, 'file_062034_aaefd.zip', 'determination_pentraxl80.zip', NULL);
INSERT INTO `instrument_determination` VALUES (42, 10, 'file_062300_3695a.zip', 'determination_dirui_h500.zip', NULL);
INSERT INTO `instrument_determination` VALUES (43, 81, 'file_071226_cf7db.zip', 'determination_lauraxl.zip', NULL);
INSERT INTO `instrument_determination` VALUES (44, 90, 'file_071513_efe14.zip', 'determination_urised.zip', NULL);
INSERT INTO `instrument_determination` VALUES (45, 31, 'file_075257_81fc2.zip', 'determination_dirui_h500.zip', NULL);
INSERT INTO `instrument_determination` VALUES (46, 47, 'file_075437_d83bb.zip', 'determination_us1600.zip', NULL);
INSERT INTO `instrument_determination` VALUES (47, 15, 'file_082126_8fe37.zip', 'determination_rac050.zip', NULL);
INSERT INTO `instrument_determination` VALUES (48, 92, 'file_091944_a8669.zip', 'determination_rac050.zip', NULL);
INSERT INTO `instrument_determination` VALUES (50, 17, 'file_015806_90df8.zip', 'determination_pkl.zip', NULL);
INSERT INTO `instrument_determination` VALUES (51, 30, 'CA620_0329_20260311_004_7ba7a.zip', 'determination_ca620.zip', NULL);
INSERT INTO `instrument_determination` VALUES (52, 82, 'SF8050_1256_20260311_004_3b32f.zip', 'determination_sf8050.zip', NULL);
INSERT INTO `instrument_determination` VALUES (53, 78, 'C3100_4880_20260311_004_a4687.zip', 'determination_c3100.zip', NULL);
INSERT INTO `instrument_determination` VALUES (54, 35, 'PT1000_8980_20260311_004_82a38.zip', 'determination_pt1000.zip', NULL);
INSERT INTO `instrument_determination` VALUES (55, 16, 'EASYSTAT_0990_20260311_004_c56ff.zip', 'determination_autobio.zip', NULL);
INSERT INTO `instrument_determination` VALUES (56, 68, 'BC60_3916_20260311_004_49aed.zip', 'determination_bc60.zip', NULL);
INSERT INTO `instrument_determination` VALUES (57, 27, 'BC120_2654_20260311_004_13b7d.zip', 'determination_bc120.zip', NULL);
INSERT INTO `instrument_determination` VALUES (58, 72, 'BT120_1978_20260311_004_7cded.zip', 'determination_bt60.zip', NULL);
INSERT INTO `instrument_determination` VALUES (59, 49, 'FUS1000_6454_20260311_004_5fcea.zip', 'determination_fus100.zip', NULL);
INSERT INTO `instrument_determination` VALUES (60, 96, 'FUS3000_2105_20260311_004_2dac7.zip', 'determination_fus100.zip', NULL);
INSERT INTO `instrument_determination` VALUES (61, 28, 'NEWLAURA_9150_20260311_004_76317.zip', 'determination_microalbu.zip', NULL);
INSERT INTO `instrument_determination` VALUES (62, 138, 'PREMIERRESOLUTION_9244_20260311_004_6790f.zip', 'determination_premier.zip', NULL);
INSERT INTO `instrument_determination` VALUES (63, 120, 'ACONU500_3477_20260311_004_3200f.zip', 'determination_dirui_h500.zip', NULL);
INSERT INTO `instrument_determination` VALUES (64, 142, 'IRICELL3000_1376_20260311_004_ecfe7.zip', 'determination_iricell3000.zip', NULL);
INSERT INTO `instrument_determination` VALUES (65, 154, 'MACCURAI800_2824_20260312_004_8b325.zip', 'determination_maccurah2600.zip', NULL);
INSERT INTO `instrument_determination` VALUES (66, 132, 'VITROS3600_8339_20260312_004_9d01f.zip', 'determination_vitros4600.zip', NULL);
INSERT INTO `instrument_determination` VALUES (67, 146, 'KEYUKU2800_0120_20260312_004_4f0cb.zip', 'determination_ku2800.zip', NULL);
INSERT INTO `instrument_determination` VALUES (68, 52, 'ARCHITECTCI4100_9211_20260312_004_71749.zip', 'determination_architectci4100.zip', NULL);
INSERT INTO `instrument_determination` VALUES (70, 156, 'KEYUKUF20_3344_20260313_004_236d6.zip', 'determination_kuf20.zip', NULL);
INSERT INTO `instrument_determination` VALUES (71, 119, 'CAL6000_8328_20260313_004_6024a.zip', 'determination_bc5300.zip', NULL);
INSERT INTO `instrument_determination` VALUES (72, 36, 'CYBOWR600S_2333_20260313_004_03204.zip', 'determination_dirui_h500.zip', NULL);
INSERT INTO `instrument_determination` VALUES (73, 118, 'VITROSXT7600_7947_20260313_004_9166b.zip', 'determination_vitros4600.zip', NULL);
INSERT INTO `instrument_determination` VALUES (74, 118, 'VITROSXT7600_1981_20260313_004_9f0c7.pdf', 'Maptest vitros-4600.pdf', NULL);
INSERT INTO `instrument_determination` VALUES (75, 80, 'AUTOBIOA1860_7375_20260313_004_a311e.zip', 'determination_autobio.zip', NULL);
INSERT INTO `instrument_determination` VALUES (76, 61, 'ARCHITECTCI8200_5040_20260313_004_43346.zip', 'determination_architectci4100.zip', NULL);

-- ----------------------------
-- Table structure for instrument_run_images
-- ----------------------------
DROP TABLE IF EXISTS `instrument_run_images`;
CREATE TABLE `instrument_run_images`  (
  `run_id` int NOT NULL AUTO_INCREMENT,
  `instrument_id` int UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `sort_order` int NULL DEFAULT 0,
  PRIMARY KEY (`run_id`) USING BTREE,
  INDEX `instrument_id`(`instrument_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_run_images
-- ----------------------------
INSERT INTO `instrument_run_images` VALUES (4, 13, 'AUTOLUMOA1000_3299_20260305_003_b22a7.jpg', '2026-03-05 21:24:02', 0);
INSERT INTO `instrument_run_images` VALUES (5, 13, 'AUTOLUMOA1000_3299_20260305_003_b2eb4.jpg', '2026-03-05 21:24:02', 1);
INSERT INTO `instrument_run_images` VALUES (6, 144, 'BS620M_5576_20260305_003_a8560.jpg', '2026-03-05 21:35:49', 0);
INSERT INTO `instrument_run_images` VALUES (7, 12, 'DXC700AU_1903_20260305_003_c0e80.jpg', '2026-03-05 22:17:22', 0);
INSERT INTO `instrument_run_images` VALUES (8, 12, 'DXC700AU_1903_20260305_003_c136f.jpg', '2026-03-05 22:17:22', 1);
INSERT INTO `instrument_run_images` VALUES (9, 12, 'DXC700AU_1903_20260305_003_c18b3.jpg', '2026-03-05 22:17:22', 2);
INSERT INTO `instrument_run_images` VALUES (10, 12, 'DXC700AU_1903_20260305_003_c1f13.jpg', '2026-03-05 22:17:22', 3);
INSERT INTO `instrument_run_images` VALUES (11, 77, 'BH6180_20260310_042140_run_1cdca.jpg', '2026-03-10 11:21:40', 0);
INSERT INTO `instrument_run_images` VALUES (12, 16, 'EASYSTAT_9964_20260311_003_519e7.jpg', '2026-03-11 15:18:26', 0);
INSERT INTO `instrument_run_images` VALUES (13, 16, 'EASYSTAT_9964_20260311_003_524be.jpg', '2026-03-11 15:18:26', 1);
INSERT INTO `instrument_run_images` VALUES (14, 154, 'MACCURAI800_8708_20260312_003_d681b.jpg', '2026-03-12 11:14:06', 0);
INSERT INTO `instrument_run_images` VALUES (15, 30, 'CA620_3356_20260312_003_723a3.jpg', '2026-03-12 11:26:33', 0);
INSERT INTO `instrument_run_images` VALUES (16, 30, 'CA620_3356_20260312_003_72a47.jpg', '2026-03-12 11:26:33', 1);
INSERT INTO `instrument_run_images` VALUES (17, 8, 'GETEIN1160_2204_20260312_003_2ede7.jpg', '2026-03-12 11:27:58', 0);

-- ----------------------------
-- Table structure for instrument_setup_images
-- ----------------------------
DROP TABLE IF EXISTS `instrument_setup_images`;
CREATE TABLE `instrument_setup_images`  (
  `setup_id` int NOT NULL AUTO_INCREMENT,
  `instrument_id` int UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NULL DEFAULT 0,
  PRIMARY KEY (`setup_id`) USING BTREE,
  INDEX `instrument_id`(`instrument_id` ASC) USING BTREE,
  INDEX `idx_si_instrument_id`(`instrument_id` ASC) USING BTREE,
  CONSTRAINT `instrument_setup_images_ibfk_1` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`ins_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 557 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_setup_images
-- ----------------------------
INSERT INTO `instrument_setup_images` VALUES (1, 10, 'DIRUIH500_5743_20260303_002_32908.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (2, 10, 'DIRUIH500_5743_20260303_002_32fd3.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (3, 10, 'DIRUIH500_5743_20260303_002_336ac.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (4, 10, 'DIRUIH500_5743_20260303_002_33efe.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (5, 10, 'DIRUIH500_5743_20260303_002_3446a.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (6, 73, 'BT60_7021_20260304_002_4eb57.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (7, 73, 'BT60_7021_20260304_002_4f0cb.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (8, 73, 'BT60_7021_20260304_002_4f87c.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (9, 73, 'BT60_7021_20260304_002_5001a.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (10, 73, 'BT60_7021_20260304_002_5074e.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (11, 9, 'ERBALYTEPRO_6159_20260305_002_151e4.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (12, 9, 'ERBALYTEPRO_6159_20260305_002_1582d.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (13, 9, 'ERBALYTEPRO_6159_20260305_002_16032.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (14, 39, 'AUTOMAX80_7857_20260305_002_4131a.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (15, 39, 'AUTOMAX80_7857_20260305_002_41b5c.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (16, 39, 'AUTOMAX80_7857_20260305_002_42334.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (17, 91, 'A1CCHEKPRO_0639_20260305_002_bfac7.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (18, 91, 'A1CCHEKPRO_0639_20260305_002_c0239.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (19, 91, 'A1CCHEKPRO_0639_20260305_002_c0a79.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (20, 91, 'A1CCHEKPRO_0639_20260305_002_c1179.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (21, 91, 'A1CCHEKPRO_0639_20260305_002_c19e5.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (22, 91, 'A1CCHEKPRO_0639_20260305_002_c2064.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (23, 13, 'AUTOLUMOA1000_3299_20260305_002_ad87f.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (24, 13, 'AUTOLUMOA1000_3299_20260305_002_ae1c3.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (25, 13, 'AUTOLUMOA1000_3299_20260305_002_ae995.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (26, 13, 'AUTOLUMOA1000_3299_20260305_002_af09f.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (27, 13, 'AUTOLUMOA1000_3299_20260305_002_af826.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (28, 13, 'AUTOLUMOA1000_3299_20260305_002_aff82.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (29, 13, 'AUTOLUMOA1000_3299_20260305_002_b0774.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (30, 13, 'AUTOLUMOA1000_3299_20260305_002_b0f04.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (31, 13, 'AUTOLUMOA1000_3299_20260305_002_b1672.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (32, 13, 'AUTOLUMOA1000_3299_20260305_002_b1d85.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (33, 29, 'AU480_8192_20260305_002_b5157.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (34, 29, 'AU480_8192_20260305_002_b5a45.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (35, 29, 'AU480_8192_20260305_002_b6386.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (36, 29, 'AU480_8192_20260305_002_b6b6c.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (37, 29, 'AU480_8192_20260305_002_b73da.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (38, 29, 'AU480_8192_20260305_002_b7c57.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (39, 29, 'AU480_8192_20260305_002_b85b8.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (40, 29, 'AU480_8192_20260305_002_b8d89.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (41, 29, 'AU480_8192_20260305_002_b95f6.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (42, 29, 'AU480_8192_20260305_002_b9e71.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (43, 29, 'AU480_8192_20260305_002_ba62c.jpg', 11);
INSERT INTO `instrument_setup_images` VALUES (44, 29, 'AU480_8192_20260305_002_baad3.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (45, 144, 'BS620M_5576_20260305_002_a60b8.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (46, 144, 'BS620M_5576_20260305_002_a67fb.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (47, 144, 'BS620M_5576_20260305_002_a6fd7.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (48, 144, 'BS620M_5576_20260305_002_a753f.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (49, 144, 'BS620M_5576_20260305_002_a7a6e.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (50, 144, 'BS620M_5576_20260305_002_a8031.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (51, 51, 'BS820M_4902_20260305_002_5e717.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (52, 51, 'BS820M_4902_20260305_002_5eefd.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (53, 51, 'BS820M_4902_20260305_002_5f722.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (54, 51, 'BS820M_4902_20260305_002_60086.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (55, 33, 'BM6010_2265_20260305_002_60d79.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (56, 33, 'BM6010_2265_20260305_002_614ab.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (57, 33, 'BM6010_2265_20260305_002_61c9f.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (58, 33, 'BM6010_2265_20260305_002_62175.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (59, 33, 'BM6010_2265_20260305_002_626c3.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (60, 33, 'BM6010_2265_20260305_002_62bef.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (61, 12, 'DXC700AU_1903_20260305_002_bb226.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (62, 12, 'DXC700AU_1903_20260305_002_bba86.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (63, 12, 'DXC700AU_1903_20260305_002_bc242.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (64, 12, 'DXC700AU_1903_20260305_002_bcad0.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (65, 12, 'DXC700AU_1903_20260305_002_bd440.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (66, 12, 'DXC700AU_1903_20260305_002_bdbcb.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (67, 12, 'DXC700AU_1903_20260305_002_be390.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (68, 12, 'DXC700AU_1903_20260305_002_beb40.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (69, 12, 'DXC700AU_1903_20260305_002_bf244.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (70, 12, 'DXC700AU_1903_20260305_002_bf9a6.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (71, 12, 'DXC700AU_1903_20260305_002_c00f0.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (72, 12, 'DXC700AU_1903_20260305_002_c07f5.jpg', 11);
INSERT INTO `instrument_setup_images` VALUES (73, 42, 'H8_0747_20260305_002_33d11.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (74, 42, 'H8_0747_20260305_002_3456f.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (75, 42, 'H8_0747_20260305_002_34f2e.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (76, 4, 'H9_6513_20260305_002_bb037.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (77, 4, 'H9_6513_20260305_002_bb6cc.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (78, 4, 'H9_6513_20260305_002_bbc6f.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (79, 114, 'H100_0476_20260305_002_6c6ec.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (80, 114, 'H100_0476_20260305_002_6d37c.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (81, 114, 'H100_0476_20260305_002_6dea7.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (82, 76, 'XL640PLUS_4621_20260305_002_55135.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (83, 76, 'XL640PLUS_4621_20260305_002_5596b.png', 2);
INSERT INTO `instrument_setup_images` VALUES (84, 76, 'XL640PLUS_4621_20260305_002_5677f.png', 3);
INSERT INTO `instrument_setup_images` VALUES (85, 76, 'XL640PLUS_4621_20260305_002_57465.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (86, 32, 'XD697_9590_20260305_002_436ce.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (87, 32, 'XD697_9590_20260305_002_43eb0.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (88, 32, 'XD697_9590_20260305_002_447c0.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (89, 32, 'XD697_9590_20260305_002_4505d.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (90, 32, 'XD697_9590_20260305_002_45822.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (91, 32, 'XD697_9590_20260305_002_46051.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (92, 32, 'XD697_9590_20260305_002_46845.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (93, 32, 'XD697_9590_20260305_002_47112.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (94, 66, 'H900_0180_20260305_002_79544.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (95, 66, 'H900_0180_20260305_002_79dbd.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (96, 66, 'H900_0180_20260305_002_7a68a.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (97, 89, 'AU680_9167_20260306_002_8489d.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (98, 89, 'AU680_9167_20260306_002_850a9.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (99, 89, 'AU680_9167_20260306_002_857fb.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (100, 89, 'AU680_9167_20260306_002_85f6b.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (101, 89, 'AU680_9167_20260306_002_866bb.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (102, 89, 'AU680_9167_20260306_002_86d07.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (103, 89, 'AU680_9167_20260306_002_8737e.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (104, 89, 'AU680_9167_20260306_002_87a2f.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (105, 89, 'AU680_9167_20260306_002_882ed.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (106, 89, 'AU680_9167_20260306_002_889e0.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (107, 89, 'AU680_9167_20260306_002_88ff4.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (108, 43, 'PREMIERHB9210_2739_20260306_002_dad41.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (109, 43, 'PREMIERHB9210_2739_20260306_002_db5a8.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (110, 43, 'PREMIERHB9210_2739_20260306_002_dbe0a.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (111, 43, 'PREMIERHB9210_2739_20260306_002_dc69c.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (112, 43, 'PREMIERHB9210_2739_20260306_002_dce59.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (113, 43, 'PREMIERHB9210_2739_20260306_002_dd6e3.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (114, 94, 'TOSOHG8_7500_20260306_002_7c053.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (115, 94, 'TOSOHG8_7500_20260306_002_7c889.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (116, 94, 'TOSOHG8_7500_20260306_002_7d06b.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (117, 94, 'TOSOHG8_7500_20260306_002_7d854.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (118, 94, 'TOSOHG8_7500_20260306_002_7e0c6.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (119, 63, 'HA8380_2731_20260306_002_f1354.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (120, 63, 'HA8380_2731_20260306_002_f1bb4.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (121, 63, 'HA8380_2731_20260306_002_f24b6.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (122, 63, 'HA8380_2731_20260306_002_f2bf1.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (123, 63, 'HA8380_2731_20260306_002_f3329.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (124, 63, 'HA8380_2731_20260306_002_f398e.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (125, 63, 'HA8380_2731_20260306_002_f4055.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (126, 63, 'HA8380_2731_20260306_002_00434.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (127, 63, 'HA8380_2731_20260306_002_009e9.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (128, 63, 'HA8380_2731_20260306_002_01020.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (129, 63, 'HA8380_2731_20260306_002_01626.jpg', 11);
INSERT INTO `instrument_setup_images` VALUES (130, 63, 'HA8380_2731_20260306_002_01be8.jpg', 12);
INSERT INTO `instrument_setup_images` VALUES (131, 63, 'HA8380_2731_20260306_002_0211f.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (132, 45, 'VITROS4600WITHISE_6142_20260306_002_d87a0.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (133, 45, 'VITROS4600WITHISE_6142_20260306_002_d9133.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (134, 45, 'VITROS4600WITHISE_6142_20260306_002_d9b51.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (135, 45, 'VITROS4600WITHISE_6142_20260306_002_da2e4.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (136, 45, 'VITROS4600WITHISE_6142_20260306_002_dab81.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (137, 45, 'VITROS4600WITHISE_6142_20260306_002_db455.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (138, 45, 'VITROS4600WITHISE_6142_20260306_002_dbb56.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (139, 45, 'VITROS4600WITHISE_6142_20260306_002_dc25c.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (140, 45, 'VITROS4600WITHISE_6142_20260306_002_dcb11.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (141, 99, 'INDIKOPLUS_7182_20260306_002_9c405.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (142, 99, 'INDIKOPLUS_7182_20260306_002_9ca33.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (143, 99, 'INDIKOPLUS_7182_20260306_002_9cf9b.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (144, 99, 'INDIKOPLUS_7182_20260306_002_9d4bb.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (146, 3, 'GH900_20260306_132208_setup_c6c09.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (147, 75, 'ALINITYCI_20260309_020838_setup_e0396.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (148, 75, 'ALINITYCI_20260309_020838_setup_e0e22.png', 1);
INSERT INTO `instrument_setup_images` VALUES (149, 75, 'ALINITYCI_20260309_020838_setup_e144e.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (150, 75, 'ALINITYCI_20260309_020838_setup_e1e72.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (151, 75, 'ALINITYCI_20260309_020838_setup_e262c.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (152, 75, 'ALINITYCI_20260309_020838_setup_e3055.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (153, 8, 'GETEIN1160_20260309_073927_setup_b457b.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (154, 8, 'GETEIN1160_20260309_073927_setup_b4e8a.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (155, 8, 'GETEIN1160_20260309_073927_setup_b5565.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (156, 8, 'GETEIN1160_20260309_073927_setup_b5cae.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (157, 8, 'GETEIN1160_20260309_073927_setup_b6496.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (158, 8, 'GETEIN1160_20260309_073927_setup_b6c43.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (159, 8, 'GETEIN1160_20260309_073927_setup_b73a4.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (160, 8, 'GETEIN1160_20260309_073927_setup_b7a5b.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (161, 8, 'GETEIN1160_20260309_073927_setup_b8245.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (162, 8, 'GETEIN1160_20260309_073927_setup_b897f.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (163, 8, 'GETEIN1160_20260309_073927_setup_b907a.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (164, 18, 'LIAISONXL_20260309_084033_setup_7e2cf.png', 0);
INSERT INTO `instrument_setup_images` VALUES (165, 18, 'LIAISONXL_20260309_084033_setup_7e9b7.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (166, 18, 'LIAISONXL_20260309_084033_setup_7f16d.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (167, 18, 'LIAISONXL_20260309_084033_setup_7f99e.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (168, 18, 'LIAISONXL_20260309_084033_setup_800a1.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (169, 18, 'LIAISONXL_20260309_084033_setup_806b4.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (170, 48, 'MAGLUMI800_20260310_023926_setup_9193c.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (171, 48, 'MAGLUMI800_20260310_023926_setup_9219b.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (172, 48, 'MAGLUMI800_20260310_023926_setup_92982.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (173, 48, 'MAGLUMI800_20260310_023926_setup_93032.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (174, 48, 'MAGLUMI800_20260310_023926_setup_937e9.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (175, 48, 'MAGLUMI800_20260310_023926_setup_93f9b.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (176, 48, 'MAGLUMI800_20260310_023926_setup_94636.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (177, 44, 'CL900I_20260310_031145_setup_cdb4b.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (178, 44, 'CL900I_20260310_031145_setup_ce28c.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (179, 44, 'CL900I_20260310_031145_setup_cec73.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (180, 44, 'CL900I_20260310_031145_setup_cf463.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (181, 44, 'CL900I_20260310_031145_setup_cfb25.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (182, 22, 'URIT5250_20260310_031340_setup_ba6b1.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (183, 22, 'URIT5250_20260310_031340_setup_baeff.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (184, 22, 'URIT5250_20260310_031340_setup_bb68b.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (185, 22, 'URIT5250_20260310_031340_setup_bbde8.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (186, 22, 'URIT5250_20260310_031340_setup_bc5c7.png', 4);
INSERT INTO `instrument_setup_images` VALUES (187, 22, 'URIT5250_20260310_031340_setup_bcd4a.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (188, 22, 'URIT5250_20260310_031340_setup_bd7a6.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (189, 22, 'URIT5250_20260310_031340_setup_be2f6.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (190, 22, 'URIT5250_20260310_031340_setup_bec56.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (191, 38, 'URITBH5390_20260310_032736_setup_44fe7.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (192, 38, 'URITBH5390_20260310_032736_setup_459da.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (193, 38, 'URITBH5390_20260310_032736_setup_46163.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (194, 60, 'XN1500_20260310_041622_setup_8e253.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (195, 60, 'XN1500_20260310_041622_setup_8ea06.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (196, 60, 'XN1500_20260310_041622_setup_8f0a9.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (197, 60, 'XN1500_20260310_041622_setup_8f88b.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (198, 60, 'XN1500_20260310_041622_setup_8fed3.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (199, 60, 'XN1500_20260310_041622_setup_90431.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (200, 60, 'XN1500_20260310_041622_setup_9094f.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (201, 60, 'XN1500_20260310_041622_setup_911ab.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (202, 60, 'XN1500_20260310_041622_setup_91a0c.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (203, 60, 'XN1500_20260310_041622_setup_92203.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (204, 60, 'XN1500_20260310_041622_setup_92818.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (205, 77, 'BH6180_20260310_041946_setup_eb668.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (206, 77, 'BH6180_20260310_041946_setup_ebe38.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (207, 77, 'BH6180_20260310_041946_setup_ec3ff.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (208, 77, 'BH6180_20260310_041946_setup_ec9c2.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (209, 77, 'BH6180_20260310_041946_setup_ecee0.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (211, 77, 'BH6180_20260310_041946_setup_edc0c.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (212, 77, 'BH6180_20260310_041946_setup_ee2db.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (213, 46, 'XN1000_20260310_042252_setup_4cafc.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (214, 46, 'XN1000_20260310_042252_setup_4d231.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (215, 46, 'XN1000_20260310_042252_setup_4d9e6.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (216, 46, 'XN1000_20260310_042252_setup_4e0c0.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (217, 46, 'XN1000_20260310_042252_setup_4e7f4.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (218, 46, 'XN1000_20260310_042252_setup_4ee0d.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (219, 46, 'XN1000_20260310_042252_setup_4f6d0.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (220, 46, 'XN1000_20260310_042252_setup_4fe7c.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (221, 23, 'XN550_20260310_042443_setup_86e02.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (222, 23, 'XN550_20260310_042443_setup_87774.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (223, 23, 'XN550_20260310_042443_setup_880d2.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (224, 23, 'XN550_20260310_042443_setup_8891a.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (225, 23, 'XN550_20260310_042443_setup_88f7a.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (226, 23, 'XN550_20260310_042443_setup_895d7.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (227, 23, 'XN550_20260310_042443_setup_89e77.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (228, 23, 'XN550_20260310_042443_setup_8a66a.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (229, 23, 'XN550_20260310_042443_setup_8b138.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (230, 23, 'XN550_20260310_042443_setup_8bacd.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (231, 23, 'XN550_20260310_042443_setup_8c1fc.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (232, 23, 'XN550_20260310_042443_setup_8cbc4.jpg', 11);
INSERT INTO `instrument_setup_images` VALUES (233, 23, 'XN550_20260310_042443_setup_8d3c0.jpg', 12);
INSERT INTO `instrument_setup_images` VALUES (234, 23, 'XN550_20260310_042443_setup_8dc10.jpg', 13);
INSERT INTO `instrument_setup_images` VALUES (235, 23, 'XN550_20260310_042443_setup_8e4b0.jpg', 14);
INSERT INTO `instrument_setup_images` VALUES (236, 23, 'XN550_20260310_042443_setup_8eac5.jpg', 15);
INSERT INTO `instrument_setup_images` VALUES (237, 23, 'XN550_20260310_042443_setup_8f04a.jpg', 16);
INSERT INTO `instrument_setup_images` VALUES (238, 23, 'XN550_20260310_042443_setup_8f78f.jpg', 17);
INSERT INTO `instrument_setup_images` VALUES (239, 23, 'XN550_20260310_042443_setup_900a0.jpg', 18);
INSERT INTO `instrument_setup_images` VALUES (240, 137, 'XNL550_20260310_042743_setup_636f9.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (241, 137, 'XNL550_20260310_042743_setup_64034.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (242, 137, 'XNL550_20260310_042743_setup_64959.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (243, 137, 'XNL550_20260310_042743_setup_6525e.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (244, 137, 'XNL550_20260310_042743_setup_65865.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (245, 137, 'XNL550_20260310_042743_setup_65fa7.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (246, 137, 'XNL550_20260310_042743_setup_6698a.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (247, 137, 'XNL550_20260310_042743_setup_671c7.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (248, 137, 'XNL550_20260310_042743_setup_67a6d.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (249, 137, 'XNL550_20260310_042743_setup_68325.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (250, 137, 'XNL550_20260310_042743_setup_68ba3.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (251, 137, 'XNL550_20260310_042743_setup_69442.jpg', 11);
INSERT INTO `instrument_setup_images` VALUES (252, 137, 'XNL550_20260310_042743_setup_69d4d.jpg', 12);
INSERT INTO `instrument_setup_images` VALUES (253, 137, 'XNL550_20260310_042743_setup_6a58c.jpg', 13);
INSERT INTO `instrument_setup_images` VALUES (254, 137, 'XNL550_20260310_042743_setup_6ac8d.jpg', 14);
INSERT INTO `instrument_setup_images` VALUES (255, 137, 'XNL550_20260310_042743_setup_6b390.jpg', 15);
INSERT INTO `instrument_setup_images` VALUES (256, 137, 'XNL550_20260310_042743_setup_6b9cc.jpg', 16);
INSERT INTO `instrument_setup_images` VALUES (257, 137, 'XNL550_20260310_042743_setup_6bf96.jpg', 17);
INSERT INTO `instrument_setup_images` VALUES (258, 137, 'XNL550_20260310_042743_setup_6c5c7.jpg', 18);
INSERT INTO `instrument_setup_images` VALUES (259, 41, 'XN350_20260310_043436_setup_164b8.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (260, 41, 'XN350_20260310_043436_setup_16ee9.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (261, 41, 'XN350_20260310_043436_setup_178cd.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (262, 41, 'XN350_20260310_043436_setup_18143.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (263, 41, 'XN350_20260310_043436_setup_18914.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (264, 41, 'XN350_20260310_043436_setup_190ad.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (265, 41, 'XN350_20260310_043436_setup_19a16.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (266, 41, 'XN350_20260310_043436_setup_1a409.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (267, 41, 'XN350_20260310_043436_setup_1ad4b.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (268, 41, 'XN350_20260310_043436_setup_1b684.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (269, 41, 'XN350_20260310_043436_setup_1bfa0.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (270, 41, 'XN350_20260310_043436_setup_1c86f.jpg', 11);
INSERT INTO `instrument_setup_images` VALUES (271, 41, 'XN350_20260310_043436_setup_1d198.jpg', 12);
INSERT INTO `instrument_setup_images` VALUES (272, 41, 'XN350_20260310_043436_setup_1d9e2.jpg', 13);
INSERT INTO `instrument_setup_images` VALUES (273, 41, 'XN350_20260310_043436_setup_1e1fc.jpg', 14);
INSERT INTO `instrument_setup_images` VALUES (274, 41, 'XN350_20260310_043436_setup_1e869.jpg', 15);
INSERT INTO `instrument_setup_images` VALUES (275, 41, 'XN350_20260310_043436_setup_1eec1.jpg', 16);
INSERT INTO `instrument_setup_images` VALUES (276, 41, 'XN350_20260310_043436_setup_1f4bd.jpg', 17);
INSERT INTO `instrument_setup_images` VALUES (277, 41, 'XN350_20260310_043436_setup_1fa05.jpg', 18);
INSERT INTO `instrument_setup_images` VALUES (278, 93, 'BC6000_20260310_060825_setup_8f6fd.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (279, 93, 'BC6000_20260310_060825_setup_901e0.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (280, 93, 'BC6000_20260310_060825_setup_90aeb.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (281, 93, 'BC6000_20260310_060825_setup_9154a.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (282, 93, 'BC6000_20260310_060825_setup_91fbb.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (283, 93, 'BC6000_20260310_060825_setup_929d9.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (284, 93, 'BC6000_20260310_060825_setup_932aa.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (285, 93, 'BC6000_20260310_060825_setup_93cca.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (286, 103, 'BC6200_20260310_061755_setup_1bae8.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (287, 103, 'BC6200_20260310_061755_setup_1c524.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (288, 103, 'BC6200_20260310_061755_setup_1ced7.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (289, 103, 'BC6200_20260310_061755_setup_1d897.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (290, 103, 'BC6200_20260310_061755_setup_1e2ed.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (291, 103, 'BC6200_20260310_061755_setup_1ec38.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (292, 103, 'BC6200_20260310_061755_setup_1f602.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (293, 103, 'BC6200_20260310_061755_setup_1fe80.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (294, 53, 'BC760_20260310_061928_setup_de075.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (295, 53, 'BC760_20260310_061928_setup_de880.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (296, 53, 'BC760_20260310_061928_setup_def1f.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (297, 53, 'BC760_20260310_061928_setup_df5e7.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (298, 53, 'BC760_20260310_061928_setup_dfcb7.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (299, 53, 'BC760_20260310_061928_setup_e0594.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (300, 98, 'PENTRA80XL_20260310_062052_setup_92afe.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (301, 98, 'PENTRA80XL_20260310_062052_setup_932ca.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (302, 98, 'PENTRA80XL_20260310_062052_setup_93aad.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (303, 98, 'PENTRA80XL_20260310_062052_setup_943b9.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (304, 98, 'PENTRA80XL_20260310_062052_setup_94d67.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (305, 98, 'PENTRA80XL_20260310_062052_setup_95690.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (306, 98, 'PENTRA80XL_20260310_062052_setup_95ebe.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (307, 98, 'PENTRA80XL_20260310_062052_setup_9648b.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (308, 98, 'PENTRA80XL_20260310_062052_setup_96d0c.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (309, 81, 'LAURAXL_20260310_071333_setup_452e8.png', 0);
INSERT INTO `instrument_setup_images` VALUES (310, 81, 'LAURAXL_20260310_071333_setup_459d9.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (311, 81, 'LAURAXL_20260310_071333_setup_45f2d.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (312, 81, 'LAURAXL_20260310_071333_setup_46551.png', 3);
INSERT INTO `instrument_setup_images` VALUES (313, 90, 'URISED2LABUMAT2_20260310_071544_setup_aa5ba.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (314, 90, 'URISED2LABUMAT2_20260310_071544_setup_aad03.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (315, 90, 'URISED2LABUMAT2_20260310_071544_setup_ab601.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (316, 90, 'URISED2LABUMAT2_20260310_071544_setup_abdac.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (317, 90, 'URISED2LABUMAT2_20260310_071544_setup_ac6f1.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (318, 90, 'URISED2LABUMAT2_20260310_071544_setup_ad067.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (319, 90, 'URISED2LABUMAT2_20260310_071544_setup_ad91d.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (320, 31, 'URISCANPRO_20260310_075321_setup_cfa9e.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (321, 31, 'URISCANPRO_20260310_075321_setup_d02d7.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (322, 31, 'URISCANPRO_20260310_075321_setup_d0a7d.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (323, 31, 'URISCANPRO_20260310_075321_setup_d11f3.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (324, 31, 'URISCANPRO_20260310_075321_setup_d19e2.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (325, 31, 'URISCANPRO_20260310_075321_setup_d2116.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (326, 31, 'URISCANPRO_20260310_075321_setup_d2afe.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (327, 31, 'URISCANPRO_20260310_075321_setup_d3342.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (328, 47, 'US1680_20260310_075454_setup_238ad.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (329, 47, 'US1680_20260310_075454_setup_242b3.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (330, 47, 'US1680_20260310_075454_setup_24cfa.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (331, 15, 'RAC050_20260310_091904_setup_11db7.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (332, 15, 'RAC050_20260310_091904_setup_125e1.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (333, 15, 'RAC050_20260310_091904_setup_12d43.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (334, 15, 'RAC050_20260310_091904_setup_132b8.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (335, 15, 'RAC050_20260310_091904_setup_1378a.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (336, 15, 'RAC050_20260310_091904_setup_13e2b.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (337, 15, 'RAC050_20260310_091904_setup_1430b.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (338, 15, 'RAC050_20260310_091904_setup_1480a.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (339, 15, 'RAC050_20260310_091904_setup_14db5.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (340, 15, 'RAC050_20260310_091904_setup_1544b.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (341, 15, 'RAC050_20260310_091904_setup_15d6a.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (342, 92, 'RAC1800_20260310_092004_setup_3939d.png', 1);
INSERT INTO `instrument_setup_images` VALUES (343, 92, 'RAC1800_20260310_092004_setup_399a5.png', 2);
INSERT INTO `instrument_setup_images` VALUES (344, 92, 'RAC1800_20260310_092004_setup_39f94.png', 3);
INSERT INTO `instrument_setup_images` VALUES (345, 92, 'RAC1800_20260310_092004_setup_3a504.png', 4);
INSERT INTO `instrument_setup_images` VALUES (346, 92, 'RAC1800_20260310_092004_setup_3ab29.png', 0);
INSERT INTO `instrument_setup_images` VALUES (359, 17, 'PKL175_6348_20260311_002_2d379.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (360, 17, 'PKL175_6348_20260311_002_2dae5.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (361, 17, 'PKL175_6348_20260311_002_2e21e.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (362, 17, 'PKL175_6348_20260311_002_2e7d3.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (363, 17, 'PKL175_6348_20260311_002_2ed40.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (364, 30, 'CA620_2908_20260311_002_3450c.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (365, 30, 'CA620_2908_20260311_002_34e02.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (366, 30, 'CA620_2908_20260311_002_356f1.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (367, 30, 'CA620_2908_20260311_002_35f33.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (368, 30, 'CA620_2908_20260311_002_36780.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (369, 30, 'CA620_2908_20260311_002_3704b.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (370, 30, 'CA620_2908_20260311_002_378ed.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (371, 30, 'CA620_2908_20260311_002_37f2b.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (372, 30, 'CA620_2908_20260311_002_3857f.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (373, 82, 'SF8050_1800_20260311_002_1b708.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (374, 82, 'SF8050_1800_20260311_002_1bfdc.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (375, 82, 'SF8050_1800_20260311_002_1c8be.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (376, 82, 'SF8050_1800_20260311_002_1d1a4.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (377, 82, 'SF8050_1800_20260311_002_1d872.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (378, 82, 'SF8050_1800_20260311_002_1e11e.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (379, 82, 'SF8050_1800_20260311_002_1e8be.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (380, 78, 'C3100_7945_20260311_002_2db19.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (381, 78, 'C3100_7945_20260311_002_2e233.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (382, 78, 'C3100_7945_20260311_002_2eae4.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (383, 35, 'PT1000_3288_20260311_002_9ba4f.png', 0);
INSERT INTO `instrument_setup_images` VALUES (384, 35, 'PT1000_3288_20260311_002_9c047.png', 1);
INSERT INTO `instrument_setup_images` VALUES (385, 35, 'PT1000_3288_20260311_002_9cc2f.png', 2);
INSERT INTO `instrument_setup_images` VALUES (386, 35, 'PT1000_3288_20260311_002_9d801.png', 3);
INSERT INTO `instrument_setup_images` VALUES (387, 35, 'PT1000_3288_20260311_002_9e449.png', 4);
INSERT INTO `instrument_setup_images` VALUES (388, 35, 'PT1000_3288_20260311_002_9eff5.png', 5);
INSERT INTO `instrument_setup_images` VALUES (389, 35, 'PT1000_3288_20260311_002_9fb26.png', 6);
INSERT INTO `instrument_setup_images` VALUES (390, 16, 'EASYSTAT_7468_20260311_002_5cbff.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (391, 16, 'EASYSTAT_7468_20260311_002_5d375.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (392, 16, 'EASYSTAT_7468_20260311_002_5d9f1.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (393, 16, 'EASYSTAT_7468_20260311_002_5df67.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (394, 16, 'EASYSTAT_7468_20260311_002_5ea0e.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (395, 16, 'EASYSTAT_7468_20260311_002_5f23d.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (396, 16, 'EASYSTAT_7468_20260311_002_5faff.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (397, 16, 'EASYSTAT_7468_20260311_002_602e1.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (398, 16, 'EASYSTAT_7468_20260311_002_60a3c.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (399, 16, 'EASYSTAT_7468_20260311_002_61198.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (400, 16, 'EASYSTAT_7468_20260311_002_61843.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (401, 16, 'EASYSTAT_7468_20260311_002_61e4f.jpg', 11);
INSERT INTO `instrument_setup_images` VALUES (402, 16, 'EASYSTAT_7468_20260311_002_6272d.jpg', 12);
INSERT INTO `instrument_setup_images` VALUES (403, 68, 'BC60_0661_20260311_002_bbde8.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (404, 68, 'BC60_0661_20260311_002_bc64e.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (405, 68, 'BC60_0661_20260311_002_bcd9e.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (406, 68, 'BC60_0661_20260311_002_bd5ff.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (407, 68, 'BC60_0661_20260311_002_bdf96.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (408, 27, 'BC120_0094_20260311_002_c76c8.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (409, 27, 'BC120_0094_20260311_002_c7f3a.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (410, 27, 'BC120_0094_20260311_002_c86c2.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (411, 27, 'BC120_0094_20260311_002_c8df2.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (412, 27, 'BC120_0094_20260311_002_c9607.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (413, 27, 'BC120_0094_20260311_002_c9cc2.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (414, 72, 'BT120_9481_20260311_002_2b33d.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (415, 72, 'BT120_9481_20260311_002_2bb36.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (416, 72, 'BT120_9481_20260311_002_2c0f3.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (417, 72, 'BT120_9481_20260311_002_2c656.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (418, 72, 'BT120_9481_20260311_002_2cc61.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (419, 49, 'FUS1000_9960_20260311_002_3a632.png', 1);
INSERT INTO `instrument_setup_images` VALUES (420, 49, 'FUS1000_9960_20260311_002_3ad69.png', 2);
INSERT INTO `instrument_setup_images` VALUES (421, 49, 'FUS1000_9960_20260311_002_3b4eb.png', 3);
INSERT INTO `instrument_setup_images` VALUES (422, 49, 'FUS1000_9960_20260311_002_3bc93.png', 0);
INSERT INTO `instrument_setup_images` VALUES (423, 49, 'FUS1000_9960_20260311_002_3c2f3.png', 4);
INSERT INTO `instrument_setup_images` VALUES (424, 49, 'FUS1000_9960_20260311_002_3cad0.png', 5);
INSERT INTO `instrument_setup_images` VALUES (425, 96, 'FUS3000_6902_20260311_002_efbee.png', 0);
INSERT INTO `instrument_setup_images` VALUES (426, 96, 'FUS3000_6902_20260311_002_f032a.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (427, 96, 'FUS3000_6902_20260311_002_f0e0d.png', 2);
INSERT INTO `instrument_setup_images` VALUES (428, 96, 'FUS3000_6902_20260311_002_f13d9.png', 3);
INSERT INTO `instrument_setup_images` VALUES (429, 96, 'FUS3000_6902_20260311_002_f1a87.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (430, 96, 'FUS3000_6902_20260311_002_f254c.png', 5);
INSERT INTO `instrument_setup_images` VALUES (431, 28, 'NEWLAURA_8010_20260311_002_45ad7.png', 0);
INSERT INTO `instrument_setup_images` VALUES (432, 28, 'NEWLAURA_8010_20260311_002_462e4.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (433, 28, 'NEWLAURA_8010_20260311_002_4694a.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (434, 28, 'NEWLAURA_8010_20260311_002_46f9d.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (435, 28, 'NEWLAURA_8010_20260311_002_47687.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (436, 28, 'NEWLAURA_8010_20260311_002_47d2b.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (437, 28, 'NEWLAURA_8010_20260311_002_4824d.png', 6);
INSERT INTO `instrument_setup_images` VALUES (438, 138, 'PREMIERRESOLUTION_7711_20260311_002_5f4ab.png', 0);
INSERT INTO `instrument_setup_images` VALUES (439, 138, 'PREMIERRESOLUTION_7711_20260311_002_5fc2b.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (440, 138, 'PREMIERRESOLUTION_7711_20260311_002_602a0.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (441, 138, 'PREMIERRESOLUTION_7711_20260311_002_608ee.png', 3);
INSERT INTO `instrument_setup_images` VALUES (442, 138, 'PREMIERRESOLUTION_7711_20260311_002_60f3a.png', 4);
INSERT INTO `instrument_setup_images` VALUES (443, 120, 'ACONU500_5363_20260311_002_b4910.png', 0);
INSERT INTO `instrument_setup_images` VALUES (444, 120, 'ACONU500_5363_20260311_002_b50af.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (445, 120, 'ACONU500_5363_20260311_002_b5b3a.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (446, 120, 'ACONU500_5363_20260311_002_b617e.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (447, 120, 'ACONU500_5363_20260311_002_b678d.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (448, 120, 'ACONU500_5363_20260311_002_b6cbb.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (449, 142, 'IRICELL3000_1931_20260311_002_2b9a9.png', 0);
INSERT INTO `instrument_setup_images` VALUES (450, 142, 'IRICELL3000_1931_20260311_002_2c16d.png', 1);
INSERT INTO `instrument_setup_images` VALUES (451, 142, 'IRICELL3000_1931_20260311_002_2c912.png', 2);
INSERT INTO `instrument_setup_images` VALUES (452, 142, 'IRICELL3000_1931_20260311_002_2cfab.png', 3);
INSERT INTO `instrument_setup_images` VALUES (453, 142, 'IRICELL3000_1931_20260311_002_2d54d.png', 4);
INSERT INTO `instrument_setup_images` VALUES (454, 142, 'IRICELL3000_1931_20260311_002_2db75.png', 5);
INSERT INTO `instrument_setup_images` VALUES (455, 142, 'IRICELL3000_1931_20260311_002_2e124.png', 6);
INSERT INTO `instrument_setup_images` VALUES (456, 142, 'IRICELL3000_1931_20260311_002_2e7c9.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (457, 154, 'MACCURAI800_8708_20260312_002_d4a82.png', 0);
INSERT INTO `instrument_setup_images` VALUES (458, 154, 'MACCURAI800_8708_20260312_002_d522a.png', 1);
INSERT INTO `instrument_setup_images` VALUES (459, 154, 'MACCURAI800_8708_20260312_002_d5892.png', 2);
INSERT INTO `instrument_setup_images` VALUES (460, 154, 'MACCURAI800_8708_20260312_002_d5dd1.png', 3);
INSERT INTO `instrument_setup_images` VALUES (461, 154, 'MACCURAI800_8708_20260312_002_d62d0.png', 4);
INSERT INTO `instrument_setup_images` VALUES (462, 132, 'VITROS3600_9095_20260312_002_a5aaf.png', 0);
INSERT INTO `instrument_setup_images` VALUES (463, 132, 'VITROS3600_9095_20260312_002_a6187.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (464, 132, 'VITROS3600_9095_20260312_002_a6b21.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (465, 132, 'VITROS3600_9095_20260312_002_a7439.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (466, 132, 'VITROS3600_9095_20260312_002_a7c16.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (467, 132, 'VITROS3600_9095_20260312_002_a83bf.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (468, 132, 'VITROS3600_9095_20260312_002_a8a5f.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (469, 132, 'VITROS3600_9095_20260312_002_a92ef.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (470, 132, 'VITROS3600_9095_20260312_002_a99f7.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (471, 146, 'KEYUKU2800_9397_20260312_002_536a2.png', 0);
INSERT INTO `instrument_setup_images` VALUES (472, 146, 'KEYUKU2800_9397_20260312_002_53cf9.png', 1);
INSERT INTO `instrument_setup_images` VALUES (473, 146, 'KEYUKU2800_9397_20260312_002_54465.png', 2);
INSERT INTO `instrument_setup_images` VALUES (474, 146, 'KEYUKU2800_9397_20260312_002_54e40.png', 3);
INSERT INTO `instrument_setup_images` VALUES (475, 146, 'KEYUKU2800_9397_20260312_002_556b0.png', 4);
INSERT INTO `instrument_setup_images` VALUES (485, 52, 'ARCHITECTCI4100_4016_20260312_002_a891e.png', 0);
INSERT INTO `instrument_setup_images` VALUES (486, 52, 'ARCHITECTCI4100_4016_20260312_002_a8fa3.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (487, 52, 'ARCHITECTCI4100_4016_20260312_002_a9ec1.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (488, 52, 'ARCHITECTCI4100_4016_20260312_002_aaca4.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (489, 52, 'ARCHITECTCI4100_4016_20260312_002_ab983.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (490, 52, 'ARCHITECTCI4100_4756_20260312_002_efea6.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (491, 52, 'ARCHITECTCI4100_6407_20260312_002_745d2.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (492, 52, 'ARCHITECTCI4100_1656_20260312_002_8f965.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (493, 52, 'ARCHITECTCI4100_4041_20260312_002_7e130.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (494, 52, 'ARCHITECTCI4100_5765_20260312_002_a79bd.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (495, 52, 'ARCHITECTCI4100_5709_20260312_002_c3e1b.jpg', 10);
INSERT INTO `instrument_setup_images` VALUES (496, 156, 'KEYUKUF20_4944_20260313_002_ce224.png', 0);
INSERT INTO `instrument_setup_images` VALUES (497, 156, 'KEYUKUF20_4944_20260313_002_ce922.png', 1);
INSERT INTO `instrument_setup_images` VALUES (498, 156, 'KEYUKUF20_4944_20260313_002_cf14b.png', 2);
INSERT INTO `instrument_setup_images` VALUES (499, 119, 'CAL6000_6368_20260313_002_d1a22.png', 0);
INSERT INTO `instrument_setup_images` VALUES (500, 119, 'CAL6000_6368_20260313_002_d219f.png', 1);
INSERT INTO `instrument_setup_images` VALUES (501, 119, 'CAL6000_6368_20260313_002_d2958.png', 2);
INSERT INTO `instrument_setup_images` VALUES (502, 36, 'CYBOWR600S_6380_20260313_002_33c27.png', 0);
INSERT INTO `instrument_setup_images` VALUES (503, 36, 'CYBOWR600S_6380_20260313_002_3445b.png', 1);
INSERT INTO `instrument_setup_images` VALUES (504, 36, 'CYBOWR600S_6380_20260313_002_353b5.png', 2);
INSERT INTO `instrument_setup_images` VALUES (505, 36, 'CYBOWR600S_6380_20260313_002_361f2.png', 3);
INSERT INTO `instrument_setup_images` VALUES (506, 118, 'VITROSXT7600_8810_20260313_002_0798c.png', 0);
INSERT INTO `instrument_setup_images` VALUES (508, 118, 'VITROSXT7600_8810_20260313_002_08791.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (509, 118, 'VITROSXT7600_8810_20260313_002_09097.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (510, 118, 'VITROSXT7600_8810_20260313_002_09a88.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (511, 118, 'VITROSXT7600_8810_20260313_002_0a3eb.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (512, 118, 'VITROSXT7600_8810_20260313_002_0ad1f.png', 9);
INSERT INTO `instrument_setup_images` VALUES (513, 118, 'VITROSXT7600_8810_20260313_002_0b2df.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (514, 118, 'VITROSXT7600_8810_20260313_002_0bb3d.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (515, 118, 'VITROSXT7600_8810_20260313_002_0c327.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (516, 118, 'VITROSXT7600_8810_20260313_002_0ce39.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (517, 80, 'AUTOBIOA1860_2309_20260313_002_e5148.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (518, 80, 'AUTOBIOA1860_2309_20260313_002_e58fb.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (519, 80, 'AUTOBIOA1860_2309_20260313_002_e5eb3.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (520, 80, 'AUTOBIOA1860_2309_20260313_002_e65e7.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (521, 80, 'AUTOBIOA1860_2309_20260313_002_e6be8.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (522, 80, 'AUTOBIOA1860_2309_20260313_002_e7314.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (523, 80, 'AUTOBIOA1860_2309_20260313_002_e7a04.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (524, 80, 'AUTOBIOA1860_2309_20260313_002_e826f.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (530, 61, 'ARCHITECTCI8200_1644_20260313_002_d8a52.png', 0);
INSERT INTO `instrument_setup_images` VALUES (531, 61, 'ARCHITECTCI8200_1644_20260313_002_d9100.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (532, 61, 'ARCHITECTCI8200_1644_20260313_002_d99b7.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (533, 61, 'ARCHITECTCI8200_1644_20260313_002_da220.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (534, 61, 'ARCHITECTCI8200_1644_20260313_002_da91b.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (535, 61, 'ARCHITECTCI8200_1644_20260313_002_db271.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (536, 61, 'ARCHITECTCI8200_1644_20260313_002_dbaee.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (537, 61, 'ARCHITECTCI8200_1644_20260313_002_dc32e.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (538, 61, 'ARCHITECTCI8200_1644_20260313_002_dca16.jpg', 8);
INSERT INTO `instrument_setup_images` VALUES (539, 61, 'ARCHITECTCI8200_1644_20260313_002_dd24d.jpg', 9);
INSERT INTO `instrument_setup_images` VALUES (540, 61, 'ARCHITECTCI8200_1644_20260313_002_dda72.jpg', 10);

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

-- ----------------------------
-- Table structure for instruments
-- ----------------------------
DROP TABLE IF EXISTS `instruments`;
CREATE TABLE `instruments`  (
  `ins_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `tmpname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cable_type_id` int NOT NULL,
  `equipment_image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `config_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `live_event` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ins_id`) USING BTREE,
  INDEX `cable_type_id`(`cable_type_id` ASC) USING BTREE,
  INDEX `idx_cable`(`cable_type_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 157 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instruments
-- ----------------------------
INSERT INTO `instruments` VALUES (1, 'DIRUI-BF6800', 0, 'DIRUIBF6800_7410_20260316_main_5d9af.jpg', NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-16 10:11:20', 'ณัฐนนท์', '2026-03-16 10:11:20');
INSERT INTO `instruments` VALUES (2, 'QUINTUS', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (3, 'GH900', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, 'ณัฐนนท์ ปราณี', NULL);
INSERT INTO `instruments` VALUES (4, 'H9', 2, 'H9_6513_20260305_001.jpeg', 'H9_COMPort=COM6\r\nH9_BaudRate=9700', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (5, 'Q4-LYTE', 1, NULL, '', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, 'ณัฐนนท์ ปราณี', NULL);
INSERT INTO `instruments` VALUES (6, 'Q4-LYTE EX', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (7, 'LIAISON', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (8, 'GETEIN-1160', 3, 'GETEIN1160_20260309_073927_cover.png', 'GETEIN1160_TCP_IP=192.168.253.241\r\nGETEIN1160_TCP_PORT=8001\r\nGETEIN1160_NAME=GT1160\r\nGETEIN1160_TIME=500', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-12 11:27:58', 'ณัฐนนท์ ปราณี', '2026-03-12 11:27:58');
INSERT INTO `instruments` VALUES (9, 'ERBA LYTE PRO', 1, 'ERBALYTEPRO_1358_20260305_001.png', 'Q4-LYTE-EX_COMPort=COM10\r\nQ4-LYTE-EX_NAME=ErbaLytePro\r\nQ4-LYTE-EX_BaudRate=19200\r\nQ4-LYTE-EX-2_COMPort=\r\nQ4-LYTE-EX-2_BaudRate=19200', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์ ปราณี', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (10, 'DIRUI-H500', 1, 'DIRUIH500_5743_20260303_001.png', 'DIRUIH500_COMPort=\r\nDIRUIH500-2_COMPort=\r\nDIRUIH500_BaudRate=9600\r\nDIRUIH500_NAME=H500\r\nDIRUIH500_NAME-2=Uritscanpro\r\nDIRUIH500_TIME_READ=5000\r\nDIRUIH500_INSTRUMENT=instrument H500\r\nDIRUIH500Neg=Negative\r\nDIRUIH500Pos=Positive\r\nDIRUIH500error1=NC\r\nDIRUIH500Pos_Neg=Trace\r\nDIRUIH500Normal=Negative\r\nDIRUIH500norm=Normal\r\nDIRUIH500_+1=1+\r\nDIRUIH500_+2=2++\r\nDIRUIH500_+3=3+\r\nDIRUIH500_+4=4+\r\nDIRUIH500_NOT_SYMBOL=Y\r\nDIRUIH500MA_0=Negative\r\nDIRUIH500MA_100=Positive\r\nDIRUIH500MA_ADD=\r\nDIRUIH500AC-\r\nDIRUIH500AC30-300=Trace\r\nDIRUIH500AC>300=>300 (Hight Abnormal)\r\nDIRUIH500_43CODE=		      \r\nDIRUIH500_UBG-USE-NUMBER=\r\nDIRUIH500_Full-Positive=\r\nDIRUIH500_A:C=DOWN\r\nDIRUIH500ACHighAbnormal=High Abnormal\r\nDIRUIH500ACDiluteNormal=Normal\r\nDIRUIH500ACNormal=AbNormal\r\nDIRUIH500RecollectHighAbnormal=High Abnormal\r\nDIRUIH500RecollectDiluteNormal=Normal\r\nDIRUIH500RecollectNormal=AbNormal\r\nDIRUIH500_pH-USE-NUMBER=Y\r\nDIRUIH500_SG-USE-NUMBER=Y\r\nDIRUIH500_ALB-USE-NUMBER=Y\r\nDIRUIH500_CRE-USE-NUMBER=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์ ปราณี', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (11, 'BS-600M', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (12, 'DXC700AU', 1, 'DXC700AU_1903_20260305_001.png', 'AU700_COMPort=\r\nAU700_NAME=AU700\r\nAU700_TEST_POS=3\r\nAU700_TIME=2000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (13, 'AUTOLUMO A1000', 3, 'AUTOLUMOA1000_3299_20260305_001.png', 'AutoBIO_TCP_PORT=\r\nAutoBIO_NAME=Auto1000\r\nAutoBIO_TIME=1000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (14, 'ALINITY C', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (15, 'RAC-050', 3, 'RAC050_20260310_091904_cover.png', 'RAC050_TCP_IP=192.168.253.***\r\nRAC050_DELAY_MINUTE=1\r\nRAC050_TCP_PORT=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 16:19:04', 'ณัฐนนท์ ปราณี', '2026-03-10 16:19:04');
INSERT INTO `instruments` VALUES (16, 'EASYSTAT', 1, 'EASYSTAT_7468_20260311_main_5ca4b.png', 'AutoBIO_TCP_PORT=\r\nAutoBIO_NAME=Auto1000\r\nAutoBIO_TIME=1000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 15:32:39', 'ณัฐนนท์', '2026-03-11 15:32:39');
INSERT INTO `instruments` VALUES (17, 'PKL-175', 3, 'PKL175_7422_20260311_main_d5e6b.png', 'PKL_TCP_PORT=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 14:12:31', 'ณัฐนนท์', '2026-03-11 14:12:31');
INSERT INTO `instruments` VALUES (18, 'LIAISON XL', 1, 'LIAISONXL_20260309_084033_cover.png', 'LIAISONXL_COMPort=\r\nLIAISONXL_>=\r\nLIAISONXL_>=\r\nLIAISONXL_TIME=300000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-09 15:40:33', 'ณัฐนนท์ ปราณี', '2026-03-09 15:40:33');
INSERT INTO `instruments` VALUES (19, 'XL-1000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (20, 'LAURA SMART', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (21, 'CA-600', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (22, 'URIT-5250', 3, 'URIT5250_20260310_031340_cover.png', 'BF6800_TCP_IP=192.168.253.242\r\nBF6800_TCP_PORT=7810\r\nBF6800_NAME=URIT5250\r\nBC5300_TCP_PORT=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 10:13:40', 'ณัฐนนท์ ปราณี', '2026-03-10 10:13:40');
INSERT INTO `instruments` VALUES (23, 'XN-550', 3, 'XN550_20260310_042443_cover.png', 'XS1000i_TCP_PORT=5555\r\nXS1000i_Cal_Overpoint=\r\nXS1000i_TCP_NAME=XN-550\r\nXS1000i_ITEMS_MALARIA=312\r\nXS1000i_ITEMS_MALARIA_ONLY=312\r\nXS1000i_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis,Thrombocytopenia\r\n/XS1000i_PATH=X:\r\nXS1000i_TIME=1000\r\nXS1000i-2_TCP_PORT=6666\r\nXS1000i-2_TCP_NAME=XS-2\r\nXS1000i-2_Cal_Overpoint=\r\nXS1000i-2_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis,Thrombocytopenia\r\nXS1000i-2_PATH=X:\r\nXS1000i-2_TIME=1000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 11:24:43', 'ณัฐนนท์ ปราณี', '2026-03-10 11:24:43');
INSERT INTO `instruments` VALUES (24, 'URIT-500B', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (25, 'URIT-5380', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (26, 'XL-640', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (27, 'BC120', 3, 'BC120_0094_20260311_main_c7516.png', 'BC120_TCP_IP=127.0.0.1\r\nBC120_TCP_PORT=\r\nBC120_TIME=2000\r\nBC120_DAY=2\r\nBC120-2_DAY=5\r\nBC120_RESULT_DAY=negative\r\nBC120-2_RESULT_DAY=negative\r\nBC120_RESULT_POSITION=9', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 15:39:03', 'ณัฐนนท์', '2026-03-11 15:39:03');
INSERT INTO `instruments` VALUES (28, 'NEW LAURA', 2, 'NEWLAURA_9789_20260311_main_3d13f.png', 'MICROALBU_COMPort=\r\nMICROALBU-2_COMPort=\r\nMICROALBU_BaudRate=19200\r\nMICROALBU_43CODE=MIC\r\n/MICROALBU_43CODE=MIC,RATIO\r\nMICROALBU_AC_CHAR=N\r\nMICROALBU_CUT_<>=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 16:12:50', 'ณัฐนนท์', '2026-03-11 16:12:50');
INSERT INTO `instruments` VALUES (29, 'AU480', 1, 'AU480_8192_20260305_001.png', 'AU480_COMPort=\r\nAU480_NAME=AU680\r\nAU480_TIME=2000\r\nAU480_TEST_POS=3\r\nAU480_TG=\r\nAU480_LDLC=\r\nAU480_PATIENT_NOT_SENT=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (30, 'CA-620', 1, 'CA620_2908_20260311_main_343f8.png', 'CA620_COMPort=\r\nCA620_BaudRate=9600\r\nCA620_NAME=CA620', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-12 11:26:33', 'ณัฐนนท์ ปราณี', '2026-03-12 11:26:33');
INSERT INTO `instruments` VALUES (31, 'URISCAN PRO', 2, 'URISCANPRO_20260310_075321_cover.png', 'DIRUIH500_COMPort=\r\nDIRUIH500-2_COMPort=\r\nDIRUIH500_BaudRate=9600\r\nDIRUIH500_NAME=H500\r\nDIRUIH500_NAME-2=Uritscanpro\r\nDIRUIH500_TIME_READ=5000\r\nDIRUIH500_INSTRUMENT=instrument H500\r\nDIRUIH500Neg=Negative\r\nDIRUIH500Pos=Positive\r\nDIRUIH500error1=NC\r\nDIRUIH500Pos_Neg=Trace\r\nDIRUIH500Normal=Negative\r\nDIRUIH500norm=Normal\r\nDIRUIH500_+1=1+\r\nDIRUIH500_+2=2++\r\nDIRUIH500_+3=3+\r\nDIRUIH500_+4=4+\r\nDIRUIH500_NOT_SYMBOL=Y\r\nDIRUIH500MA_0=Negative\r\nDIRUIH500MA_100=Positive\r\nDIRUIH500MA_ADD=\r\n/DIRUIH500AC<30=<30 (Normal)\r\n/DIRUIH500AC30-300=Trace\r\n/DIRUIH500AC>300=>300 (Hight Abnormal)\r\nDIRUIH500_43CODE=		      \r\nDIRUIH500_UBG-USE-NUMBER=\r\nDIRUIH500_Full-Positive=\r\nDIRUIH500_A:C=DOWN\r\nDIRUIH500ACHighAbnormal=High Abnormal\r\nDIRUIH500ACDiluteNormal=Normal\r\nDIRUIH500ACNormal=AbNormal\r\nDIRUIH500RecollectHighAbnormal=High Abnormal\r\nDIRUIH500RecollectDiluteNormal=Normal\r\nDIRUIH500RecollectNormal=AbNormal\r\nDIRUIH500_pH-USE-NUMBER=Y\r\nDIRUIH500_SG-USE-NUMBER=Y\r\nDIRUIH500_ALB-USE-NUMBER=Y\r\nDIRUIH500_CRE-USE-NUMBER=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 14:53:21', 'ณัฐนนท์ ปราณี', '2026-03-10 14:53:21');
INSERT INTO `instruments` VALUES (32, 'XD697', 1, 'XD697_4055_20260305_001.jpg', 'XD697_COMPort=\r\nXD697_BaudRate=9600\r\nXD697_NANE=697', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (33, 'BM6010', 1, 'BM6010_2265_20260305_001.jpg', 'BM6010_COMPort=\r\nBM6010_NAME=BM6010\r\nBM6010_BaudRate=9600\r\nBM6010_TIME=2000\r\nBM6010ENQ_TIME=500', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (34, 'CITEST AUR-100', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (35, 'PT1000', 3, 'PT1000_5654_20260311_main_1890e.png', 'PT1000_TCP_IP=192.168.253.252\r\nPT1000_TCP_PORT=\r\nPT1000_NAME=PT1000\r\nPT1000_TIME=2000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 15:12:12', 'ณัฐนนท์', '2026-03-11 15:12:12');
INSERT INTO `instruments` VALUES (36, 'CYBOW R-600S', 1, 'CYBOWR600S_6380_20260313_main_33b0b.jpg', 'DIRUIH500_COMPort=\r\nDIRUIH500-2_COMPort=\r\nDIRUIH500_BaudRate=9600\r\nDIRUIH500_NAME=H500\r\nDIRUIH500_NAME-2=Uritscanpro\r\nDIRUIH500_TIME_READ=5000\r\nDIRUIH500_INSTRUMENT=instrument H500\r\nDIRUIH500Neg=Negative\r\nDIRUIH500Pos=Positive\r\nDIRUIH500error1=NC\r\nDIRUIH500Pos_Neg=Trace\r\nDIRUIH500Normal=Negative\r\nDIRUIH500norm=Normal\r\nDIRUIH500_+1=1+\r\nDIRUIH500_+2=2++\r\nDIRUIH500_+3=3+\r\nDIRUIH500_+4=4+\r\nDIRUIH500_NOT_SYMBOL=Y\r\nDIRUIH500MA_0=Negative\r\nDIRUIH500MA_100=Positive\r\nDIRUIH500MA_ADD=\r\n/DIRUIH500AC<30=<30 (Normal)\r\n/DIRUIH500AC30-300=Trace\r\n/DIRUIH500AC>300=>300 (Hight Abnormal)\r\nDIRUIH500_43CODE=		      \r\nDIRUIH500_UBG-USE-NUMBER=\r\nDIRUIH500_Full-Positive=\r\nDIRUIH500_A:C=DOWN\r\nDIRUIH500ACHighAbnormal=High Abnormal\r\nDIRUIH500ACDiluteNormal=Normal\r\nDIRUIH500ACNormal=AbNormal\r\nDIRUIH500RecollectHighAbnormal=High Abnormal\r\nDIRUIH500RecollectDiluteNormal=Normal\r\nDIRUIH500RecollectNormal=AbNormal\r\nDIRUIH500_pH-USE-NUMBER=Y\r\nDIRUIH500_SG-USE-NUMBER=Y\r\nDIRUIH500_ALB-USE-NUMBER=Y\r\nDIRUIH500_CRE-USE-NUMBER=Y\r\nDIRUIH800_COMPort=\r\nDIRUIH800_NAME=H800\r\nDIRUIH800_TIME=5000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-13 09:48:45', 'ณัฐนนท์ ปราณี', '2026-03-13 09:48:45');
INSERT INTO `instruments` VALUES (37, 'XL-1000 WITH ISE', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (38, 'URIT-BH5390', 3, 'URITBH5390_20260310_032736_cover.png', 'Urit5390_TCP_PORT=\r\nUrit5390-2_TCP_PORT=\r\nUrit5390_DELAY_MINUTE=1\r\nUrit5390-2_DELAY_MINUTE=1\r\nUrit5390_VER=1\r\nUrit5390_TIME=500', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 10:27:36', 'ณัฐนนท์ ปราณี', '2026-03-10 10:27:36');
INSERT INTO `instruments` VALUES (39, 'AUTOMAX-80', 3, 'AUTOMAX80_2823_20260305_001.png', 'SA120_TCP_IP=192.168.253.240\r\nSA120_TCP_PORT=8888\r\nSA120_NAME=AUTOMAX80\r\nSA120_TIME=200\r\nSA120_BLG_NEXT=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์ ปราณี', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (40, 'XL-921B', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (41, 'XN-350', 3, 'XN350_20260310_060715_cover.png', 'XS1000i_TCP_PORT=5555\r\nXS1000i_Cal_Overpoint=\r\nXS1000i_TCP_NAME=XN-350\r\nXS1000i_ITEMS_MALARIA=312\r\nXS1000i_ITEMS_MALARIA_ONLY=312\r\nXS1000i_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis,Thrombocytopenia\r\n/XS1000i_PATH=X:\r\nXS1000i_TIME=1000\r\nXS1000i-2_TCP_PORT=6666\r\nXS1000i-2_TCP_NAME=XS-2\r\nXS1000i-2_Cal_Overpoint=\r\nXS1000i-2_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis,Thrombocytopenia\r\nXS1000i-2_PATH=X:\r\nXS1000i-2_TIME=1000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 13:07:15', 'ณัฐนนท์ ปราณี', '2026-03-10 13:07:15');
INSERT INTO `instruments` VALUES (42, 'H8', 1, 'H8_0747_20260305_001.png', 'H8_TCP_PORT=\r\nH8_NAME=H8', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (43, 'PREMIER HB9210', 1, 'PREMIERHB9210_2739_20260306_001.png', 'PREMIER_COMPort=\r\nPREMIER_BaudRate=9600\r\nPREMIER_NAME=HB9210\r\nPREMIER_PATH=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (44, 'CL-900I', 3, 'CL900I_20260310_031145_cover.jpg', 'CL900I_TCP_PORT=\r\nCL900I_NAME=CL9\r\nCL900I_TIME=200\r\nCL900I_USE_QUEUE=N', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 10:11:45', 'ณัฐนนท์ ปราณี', '2026-03-10 10:11:45');
INSERT INTO `instruments` VALUES (45, 'VITROS 4600 WITH ISE', 6, 'VITROS4600WITHISE_1585_20260306_001.png', 'VITROS4600_COMPort=\r\nVITROS4600_TIME=500\r\nVITROS4600_BaudRate=9600\r\nVITROS4600_NAME=Vit7600', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์ ปราณี', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (46, 'XN-1000', 3, 'XN1000_20260310_042252_cover.jpg', 'XS1000i_TCP_PORT=5000\r\nXS1000i_Cal_Overpoint=Y\r\nXS1000i_TCP_NAME=XN1000\r\nXS1000i_ITEMS_MALARIA=\r\nXS1000i_ITEMS_MALARIA_ONLY=\r\nXS1000i_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis\r\nXS1000i_PATH=\\\\10.0.24.241\\PNG\r\nXS1000i-2_TCP_PORT=\r\nXS1000i-2_TCP_NAME=XS-2\r\nXS1000i-2_Cal_Overpoint=\r\nXS1000i-2_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis\r\nXS1000i-2_PATH=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 11:22:52', 'ณัฐนนท์ ปราณี', '2026-03-10 11:22:52');
INSERT INTO `instruments` VALUES (47, 'US1680', 3, 'US1680_20260310_075454_cover.png', 'US1600_TCP_IP=192.168.253.2\r\nUS1600_TCP_PORT=\r\nUS1600_NAME=US1680\r\nUS1600_INSTRUMENT=US1680 instrument 1\r\nUS1600Neg=Negative\r\nUS1600Pos=Positive\r\nUS1600error=NC\r\nUS1600Pos_Neg=Trace\r\nUS1600Normal=Normal\r\nUS1600_+1=1+\r\nUS1600_+2=2++\r\nUS1600_+3=3+\r\nUS1600_+4=4+\r\nUS1600_symbol=\r\nUS1600_TIME=100', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 14:54:54', 'ณัฐนนท์ ปราณี', '2026-03-10 14:54:54');
INSERT INTO `instruments` VALUES (48, 'MAGLUMI 800', 3, 'MAGLUMI800_20260310_023926_cover.jpg', 'MAGLUMI800_COMPort=\r\nMAGLUMI800_BaudRate=9600\r\nMAGLUMI800_NAME=MAG', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 09:39:26', 'ณัฐนนท์ ปราณี', '2026-03-10 09:39:26');
INSERT INTO `instruments` VALUES (49, 'FUS-1000', 3, 'FUS1000_9960_20260311_main_3a2dc.png', 'FUS100_TCP_IP=192.168.253.252\r\nFUS100_TCP_PORT=\r\nFUS100_NAME=FUS3000\r\nFUS100Neg=Negative\r\nFUS100Pos=Positive\r\nFUS100error=NC\r\nFUS100Pos_Neg=Trace\r\nFUS100Normal=Normal\r\nFUS100_+1=1+\r\nFUS100_+2=2+\r\nFUS100_+3=3+\r\nFUS100_DELAY_MINUTE=1\r\nFUS100_CODE=Urine\r\nFUS100_NOT_JOB=Y=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 15:43:55', 'ณัฐนนท์', '2026-03-11 15:43:55');
INSERT INTO `instruments` VALUES (50, 'MAGLUMI600', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (51, 'BS820M', 1, 'BS820M_4902_20260305_001.png', 'BS820_TCP_IP=192.168.253.252\r\nBS820_TCP_PORT=\r\nBS820_NAME=BS820\r\nBS820_TIME=5000\r\nBS820_USE_QUEUE=N\r\nBS820_NoProcessSendCal=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (52, 'ARCHITECT CI4100', 1, 'ARCHITECTCI4100_0026_20260313_main_8b6fe.png', 'ARCHITECTCI4100_COMPort=\r\nARCHITECTCI4100_NAME=ci8200\r\nARCHITECTCI4100=Y\r\nARCHITECTCI4100_TIME=100\r\nARCHITECTCI4100_NOT_RECIVE=Y\r\nARCHITECTCI4100_CHECK_RESULT=Y\r\nARCHITECTCI4100_INSTRUMENT=ci8200', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-13 08:51:21', 'ณัฐนนท์ ปราณี', '2026-03-13 08:51:21');
INSERT INTO `instruments` VALUES (53, 'BC760', 3, 'BC760_20260310_061928_cover.jpg', 'BC5300_TCP_IP=192.168.253.3\r\nBC5300_TCP_PORT=\r\nBC5300_NAME=BC760', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 13:19:28', 'ณัฐนนท์ ปราณี', '2026-03-10 13:19:28');
INSERT INTO `instruments` VALUES (54, 'CS-1600', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (55, 'FECES FA280', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (56, 'ARKRAY HA 8180V', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (57, 'COBAS C5800', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (58, 'COBAS PURE E402', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (59, 'IDEN SENT VITEK 2XL', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (60, 'XN-1500', 3, 'XN1500_20260310_041614_cover.jpg', 'XS1000i_TCP_PORT=5555\r\nXS1000i_Cal_Overpoint=\r\nXS1000i_TCP_NAME=XN1500\r\nXS1000i_ITEMS_MALARIA=312\r\nXS1000i_ITEMS_MALARIA_ONLY=312\r\nXS1000i_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis,Thrombocytopenia\r\n/XS1000i_PATH=X:\r\nXS1000i_TIME=1000\r\nXS1000i-2_TCP_PORT=6666\r\nXS1000i-2_TCP_NAME=XS-2\r\nXS1000i-2_Cal_Overpoint=\r\nXS1000i-2_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis,Thrombocytopenia\r\nXS1000i-2_PATH=X:\r\nXS1000i-2_TIME=1000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 11:16:22', 'ณัฐนนท์ ปราณี', '2026-03-10 11:16:22');
INSERT INTO `instruments` VALUES (61, 'ARCHITECT CI8200', 1, 'ARCHITECTCI8200_9909_20260313_main_c04a4.webp', 'ARCHITECTCI4100_COMPort=\r\nARCHITECTCI4100_NAME=ci8200\r\nARCHITECTCI4100=Y\r\nARCHITECTCI4100_TIME=100\r\nARCHITECTCI4100_NOT_RECIVE=Y\r\nARCHITECTCI4100_CHECK_RESULT=Y\r\nARCHITECTCI4100_INSTRUMENT=ci8200', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-13 11:29:57', 'ณัฐนนท์ ปราณี', '2026-03-13 11:29:57');
INSERT INTO `instruments` VALUES (62, 'ISE6000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (63, 'HA8380', 1, 'HA8380_2731_20260306_001.jpg', 'HA8380_COMPort=COM1\r\nHA8380_NAME=HA1\r\nHA8380_TIME=1000\r\nHA8380_INSTRUMENT=HA1', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์ ปราณี', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (64, 'BC5180', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (65, 'ACCESS2', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (66, 'H900', 1, 'H900_0180_20260305_001.png', 'H900_COMPort=\r\nH900_BaudRate=9600\r\nH900_NAME=H999\r\nH900_TIME=1000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (67, 'XL-1000 PLUS', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (68, 'BC60', 1, 'BC60_0661_20260311_main_bbc20.png', 'BC60_COMPort=\r\nBC60_BaudRate=9600\r\nBC60_NAME=BC60\r\nBC60_TIME=500\r\nBC60N=Negative\r\nBC60P=Positive\r\nBC60_DAY=3\r\nBC60-2_DAY=5\r\nBC60_RESULT_DAY=Negative1\r\nBC60-2_RESULT_DAY=Negative2', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 15:34:53', 'ณัฐนนท์', '2026-03-11 15:34:53');
INSERT INTO `instruments` VALUES (69, 'QCR U500', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (70, 'IN4-LYTE', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (71, 'CA-500', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (72, 'BT120', 3, 'BT120_9481_20260311_main_2a964.png', 'BT60_HOST=192.168.1.68\r\nBT60_DATABASE=bloodorm\r\nBT60_USER=root\r\nBT60_PASSWORD=123456\r\nBT60_PORT=3306\r\nBT60_0=Invalid\r\nBT60_1=Empty bottle\r\nBT60_2=No growth after 3 days\r\nBT60_3=Positive\r\nBT60_4=No growth after 5 days\r\nBT60_5=Anonymous positive\r\nBT60_6=Anonymous negative\r\nBT60_TIME=1\r\nBT60_DAY=3\r\n##BT60_DAY2=5\r\nBT60_RESULT_DAY=No growth after 3 days\r\n##BT60_RESULT_DAY2=No Growth After 5 Day', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 15:42:27', 'ณัฐนนท์', '2026-03-11 15:42:27');
INSERT INTO `instruments` VALUES (73, 'BT-60', 3, 'BT60_2411_20260311_main_0a15c.png', 'BT60_HOST=192.168.1.68\r\nBT60_DATABASE=bloodorm\r\nBT60_USER=root\r\nBT60_PASSWORD=123456\r\nBT60_PORT=3306\r\nBT60_0=Invalid\r\nBT60_1=Empty bottle\r\nBT60_2=No growth after 3 days\r\nBT60_3=Positive\r\nBT60_4=No growth after 5 days\r\nBT60_5=Anonymous positive\r\nBT60_6=Anonymous negative\r\nBT60_TIME=1\r\nBT60_DAY=3\r\n##BT60_DAY2=5\r\nBT60_RESULT_DAY=No growth after 3 days\r\n##BT60_RESULT_DAY2=No Growth After 5 Day', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 15:41:17', 'ณัฐนนท์', '2026-03-11 15:41:17');
INSERT INTO `instruments` VALUES (74, 'ALINITY I', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (75, 'ALINITY CI', 3, 'ALINITYCI_20260309_021519_cover.jpg', 'ALINITY_TCP_IP=192.168.101.5\r\nALINITY_TCP_PORT=\r\nALINITY_NAME=ALINIYT CI\r\nALINITY_TIME=200', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-09 09:15:19', 'ณัฐนนท์ ปราณี', '2026-03-09 09:15:19');
INSERT INTO `instruments` VALUES (76, 'XL-640 PLUS', 4, 'XL640PLUS_4621_20260305_001.png', 'XL_COMPort=COM2\r\nXL-2_COMPort=\r\nXL_TIME=100\r\nXL-2_TIME=200\r\nXL1000_NOENQ5MIN=\r\nXL1000=Y\r\nXL1000-2=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (77, 'BH-6180', 3, 'BH6180_20260310_041650_cover.jpg', 'BH6180_TCP_IP=192.168.253.20\r\nBH6180_TCP_PORT=6666\r\nBH6180_TIME=200\r\nBH6180_DELAY_MINUTE=1\r\nBH6180_NAME=BH6180', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 11:21:40', 'ณัฐนนท์ ปราณี', '2026-03-10 11:21:40');
INSERT INTO `instruments` VALUES (78, 'C3100', 3, 'C3100_7945_20260311_main_2d9e6.png', 'C3100_COMPort=\r\nC3100_NAME=C3100\r\nC3100_BaudRate=9600\r\nC3100_TIME=200', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 14:27:17', 'ณัฐนนท์', '2026-03-11 14:27:17');
INSERT INTO `instruments` VALUES (79, 'QUIDELSOFIA', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (80, 'AUTOBIO A1860', 3, 'AUTOBIOA1860_1048_20260313_main_4f799.png', 'AutoBIO_TCP_PORT=\r\nAutoBIO_NAME=Auto1860\r\nAutoBIO_TIME=1000\r\nAutoBIO_NUMERIC()=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-13 10:45:39', 'ณัฐนนท์ ปราณี', '2026-03-13 10:45:39');
INSERT INTO `instruments` VALUES (81, 'LAURA XL', 3, 'LAURAXL_20260310_071333_cover.jpg', 'LAURAXL_TCP_IP=192.168.253.252\r\nLAURAXL_TCP_PORT=\r\nLAURAXL_NAME=LRXL\r\nLAURAXL_TIME=200\r\nLAURAXL_Norm.=Normal\r\nLAURAXL_Pos.=Positive\r\nLAURAXL_Neg.=Negative\r\nLAURAXL_-1=0\r\nLAURAXL_-=Negative\r\nLAURAXL_+=1+\r\nLAURAXL_++=2+\r\nLAURAXL_+++=3+\r\nLAURAXL_++++=4+', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 14:13:33', 'ณัฐนนท์ ปราณี', '2026-03-10 14:13:33');
INSERT INTO `instruments` VALUES (82, 'SF8050', 1, 'SF8050_1800_20260311_main_1b5b8.png', 'SF8050_COMPort=\r\nSF8050_BaudRate=9600\r\nSF8050_NAME=SF8050', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 14:22:44', 'ณัฐนนท์', '2026-03-11 14:22:44');
INSERT INTO `instruments` VALUES (83, 'BT2000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (84, 'ARES', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (85, 'CYBOW 720', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (86, 'BT3500', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (87, 'MET6000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (88, 'CM-1000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (89, 'AU680', 1, 'AU680_0026_20260305_001.png', 'AU480_COMPort=\r\nAU480_NAME=AU680\r\nAU480_TIME=2000\r\nAU480_TEST_POS=3\r\nAU480_TG=\r\nAU480_LDLC=\r\nAU480_PATIENT_NOT_SENT=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (90, 'URISED2&LABUMAT2', 3, 'URISED2LABUMAT2_20260310_071544_cover.jpg', 'URISED_TCP_IP=127.0.0.1\r\nURISED_TCP_PORT=\r\n/URISED_COMPort=\r\n/URISED_BaudRate=115200\r\nURISED_NAME=URISED\r\nURISED_BI-DIRECT=N\r\nURISED_PREVIOUS_DAY=0\r\nURISED_RESULT_TIME=6000\r\nURISEDNeg=Negative\r\nURISEDPos=Positive\r\nURISED(+)=Trace', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 14:15:44', 'ณัฐนนท์ ปราณี', '2026-03-10 14:15:44');
INSERT INTO `instruments` VALUES (91, 'A1CCHEK PRO', 3, 'A1CCHEKPRO_0639_20260305_001.png', 'A1CCHECKPRO_TCP_PORT=\r\nA1CCHECKPRO_TIME=200\r\nA1CCHECKPRO_NAME=a1c', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (92, 'RAC-1800', 3, 'RAC1800_20260310_092004_cover.png', 'RAC050_TCP_IP=192.168.253.250\r\nRAC050_DELAY_MINUTE=1\r\nRAC050_TCP_PORT=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 16:20:04', 'ณัฐนนท์ ปราณี', '2026-03-10 16:20:04');
INSERT INTO `instruments` VALUES (93, 'BC6000', 1, 'BC6000_20260310_061357_cover.jpg', 'BC5300_TCP_IP=192.168.253.3\r\nBC5300_TCP_PORT=\r\nBC5300_NAME=BC760', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 13:13:57', 'ณัฐนนท์ ปราณี', '2026-03-10 13:13:57');
INSERT INTO `instruments` VALUES (94, 'TOSOH G8', 4, 'TOSOHG8_7500_20260306_001.png', 'HLC723G8_COMPort=\r\nHLC723G8_NAME=G11\r\nHLC723G8_BaudRate=9600\r\nHLC723G8_TIME=200', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (95, 'COBAS6000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (96, 'FUS-3000', 3, 'FUS3000_6902_20260311_main_ef8eb.png', 'FUS100_TCP_IP=192.168.253.252\r\nFUS100_TCP_PORT=\r\nFUS100_NAME=FUS3000\r\nFUS100Neg=Negative\r\nFUS100Pos=Positive\r\nFUS100error=NC\r\nFUS100Pos_Neg=Trace\r\nFUS100Normal=Normal\r\nFUS100_+1=1+\r\nFUS100_+2=2+\r\nFUS100_+3=3+\r\nFUS100_DELAY_MINUTE=1\r\nFUS100_CODE=Urine\r\nFUS100_NOT_JOB=Y=', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 16:00:53', 'ณัฐนนท์', '2026-03-11 16:00:53');
INSERT INTO `instruments` VALUES (97, 'TOSOH HLC-723G11', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (98, 'PENTRA 80XL', 1, 'PENTRA80XL_20260310_062052_cover.png', 'PENTRA60_COMPort=\r\nPENTRA60_NAME=pentra60\r\nPENTRA80_COMPort=\r\nPENTRA80_NAME=pentra800', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 13:20:52', 'ณัฐนนท์ ปราณี', '2026-03-10 13:20:52');
INSERT INTO `instruments` VALUES (99, 'INDIKO PLUS', 1, 'INDIKOPLUS_7182_20260306_001.png', 'INDIKO_COMPort=\r\nINDIKO_NAME=6001\r\nINDIKO_TIME=100', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (100, 'URIT-50', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (101, 'BC-5180', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (102, 'BC-700', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (103, 'BC6200', 3, 'BC6200_20260310_061755_cover.jpg', 'BC5300_TCP_IP=192.168.253.3\r\nBC5300_TCP_PORT=\r\nBC5300_NAME=BC760', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 13:17:55', 'ณัฐนนท์ ปราณี', '2026-03-10 13:17:55');
INSERT INTO `instruments` VALUES (104, 'D10', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (105, 'CS-2100I', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (106, 'COBAS PRO', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (107, 'ATELLICA CI', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (108, 'VERSATREK', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (109, 'ATELLICA (CH930+IM1300)', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (110, 'COBAS C503', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (111, 'EU5300', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (112, 'EDENI15', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (113, 'ORTHO VISION', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (114, 'H100', 3, 'H100_0476_20260305_001.png', 'H8_TCP_PORT=\r\nH8_NAME=H100', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (115, 'US2000C', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (116, 'SA120', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (117, 'COBAS E411', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (118, 'VITROS XT7600', 6, 'VITROSXT7600_8810_20260313_main_07861.png', 'VITROS4600_COMPort=\r\nVITROS4600_TIME=500\r\nVITROS4600_BaudRate=9600\r\nVITROS4600_NAME=Vit7600', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-13 10:02:49', 'ณัฐนนท์ ปราณี', '2026-03-13 10:02:49');
INSERT INTO `instruments` VALUES (119, 'CAL6000', 3, 'CAL6000_6368_20260313_main_d1965.jpg', 'BC5300_TCP_IP=192.168.253.3\r\nBC5300_TCP_PORT=\r\nBC5300_NAME=BC760', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-13 09:35:06', 'ณัฐนนท์ ปราณี', '2026-03-13 09:35:06');
INSERT INTO `instruments` VALUES (120, 'ACON-U500', 1, 'ACONU500_5363_20260311_main_b47e4.png', 'DIRUIH500_COMPort=\r\nDIRUIH500-2_COMPort=\r\nDIRUIH500_BaudRate=9600\r\nDIRUIH500_NAME=H500\r\nDIRUIH500_NAME-2=Uritscanpro\r\nDIRUIH500_TIME_READ=5000\r\nDIRUIH500_INSTRUMENT=instrument H500\r\nDIRUIH500Neg=Negative\r\nDIRUIH500Pos=Positive\r\nDIRUIH500error1=NC\r\nDIRUIH500Pos_Neg=Trace\r\nDIRUIH500Normal=Negative\r\nDIRUIH500norm=Normal\r\nDIRUIH500_+1=1+\r\nDIRUIH500_+2=2++\r\nDIRUIH500_+3=3+\r\nDIRUIH500_+4=4+\r\nDIRUIH500_NOT_SYMBOL=Y\r\nDIRUIH500MA_0=Negative\r\nDIRUIH500MA_100=Positive\r\nDIRUIH500MA_ADD=\r\n/DIRUIH500AC<30=<30 (Normal)\r\n/DIRUIH500AC30-300=Trace\r\n/DIRUIH500AC>300=>300 (Hight Abnormal)\r\nDIRUIH500_43CODE=		      \r\nDIRUIH500_UBG-USE-NUMBER=\r\nDIRUIH500_Full-Positive=\r\nDIRUIH500_A:C=DOWN\r\nDIRUIH500ACHighAbnormal=High Abnormal\r\nDIRUIH500ACDiluteNormal=Normal\r\nDIRUIH500ACNormal=AbNormal\r\nDIRUIH500RecollectHighAbnormal=High Abnormal\r\nDIRUIH500RecollectDiluteNormal=Normal\r\nDIRUIH500RecollectNormal=AbNormal\r\nDIRUIH500_pH-USE-NUMBER=Y\r\nDIRUIH500_SG-USE-NUMBER=Y\r\nDIRUIH500_ALB-USE-NUMBER=Y\r\nDIRUIH500_CRE-USE-NUMBER=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 16:24:27', 'ณัฐนนท์', '2026-03-11 16:24:27');
INSERT INTO `instruments` VALUES (121, 'ARCHITECT I2000 SR', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (122, 'SEBIA MINI CAP', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (123, 'LB12', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (124, 'AU5800', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (125, 'XL-640 WITH ISE', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (126, 'BC-5600', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (127, 'INTEGRA 400 PLUS', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (128, 'YUMIZEN G800', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (129, 'YUMIZENG800', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (130, 'C8000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (131, 'BA400', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (132, 'VITROS 3600', 6, 'VITROS3600_0796_20260312_main_1f708.png', 'VITROS4600_COMPort=\r\nVITROS4600_TIME=500\r\nVITROS4600_BaudRate=9600\r\nVITROS4600_NAME=Vit7600', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-12 11:24:48', 'ณัฐนนท์ ปราณี', '2026-03-12 11:24:48');
INSERT INTO `instruments` VALUES (133, 'YUMIZEN H1500', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (134, 'HISCL-800', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (135, 'I2000SR', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (136, 'LD-600', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (137, 'XNL-550', 3, 'XNL550_20260310_042743_cover.png', 'XS1000i_TCP_PORT=5555\r\nXS1000i_Cal_Overpoint=\r\nXS1000i_TCP_NAME=XN-550\r\nXS1000i_ITEMS_MALARIA=312\r\nXS1000i_ITEMS_MALARIA_ONLY=312\r\nXS1000i_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis,Thrombocytopenia\r\n/XS1000i_PATH=X:\r\nXS1000i_TIME=1000\r\nXS1000i-2_TCP_PORT=6666\r\nXS1000i-2_TCP_NAME=XS-2\r\nXS1000i-2_Cal_Overpoint=\r\nXS1000i-2_FLAG=Microcytosis,Anemia,Left_Shift?,Anisocytosis,Atypical_Lympho?,Blasts/Abn_Lympho?,NRBC?,RBC_Agglutination?,Turbidity/HGB_Interference?,Iron_Deficiency?,HGB_Defect?,Fragments?,PLT_Clumps?,Blasts?,Lymphopenia,PLT_Abn_Distribution,Immature_Gran?,RBC_Lyse_Resistance?,Abn_Lympho/Blasts?,Positive_Diff,Positive_Morph,Positive_Count,Neutrophilia,Leukocytosis,Thrombocytosis,Thrombocytopenia\r\nXS1000i-2_PATH=X:\r\nXS1000i-2_TIME=1000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-10 11:27:43', 'ณัฐนนท์ ปราณี', '2026-03-10 11:27:43');
INSERT INTO `instruments` VALUES (138, 'PREMIER RESOLUTION', 1, 'PREMIERRESOLUTION_8332_20260311_main_3aaf2.jpg', 'PREMIER_COMPort=\r\nPREMIER_BaudRate=9600\r\nPREMIER_NAME=PRA11\r\nPREMIER_PATH=\\\\sharefile ต่อสายเเลนวง Host', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 16:20:00', 'ณัฐนนท์', '2026-03-11 16:20:00');
INSERT INTO `instruments` VALUES (139, 'DL96A', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (140, 'LB24', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (141, 'MACCURAH2600', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (142, 'IRICELL3000', 2, 'IRICELL3000_1931_20260311_main_2b87c.png', 'IRICELL3000_COMPort=\r\nIRICELL3000_NAME=ir200\r\nIRICELL3000_TIME=500\r\nIRICELL3000_BaudRate=9600', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-11 16:38:51', 'ณัฐนนท์ ปราณี', '2026-03-11 16:38:51');
INSERT INTO `instruments` VALUES (143, 'MACCURA I1000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (144, 'BS-620M', 3, 'BS620M_5576_20260305_001.avif', 'BS600M_TCP_IP=127.0.0.1\r\nBS600M_TCP_PORT=\r\nBS600M-2_TCP_PORT=\r\nBS600M_NAME=BS600M\r\nBS600M_TIME=500\r\nBS600M_USE_QUEUE=N\r\nBS600M_LOOK_JOBPROCESS=Y', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-06 16:54:11', 'ณัฐนนท์', '2026-03-06 16:54:11');
INSERT INTO `instruments` VALUES (145, 'SAL6000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (146, 'KEYU KU-2800', 3, 'KEYUKU2800_0004_20260312_main_be1da.png', 'KU2800_TCP_IP=192.168.253.252\r\nKU2800_TCP_PORT=\r\nKU2800_NAME=KU2800\r\nKU2800Neg=Negative\r\nKU2800Pos=Positive\r\nKU2800error=NC\r\nKU2800Pos_Neg=Trace\r\nKU2800Normal=Normal\r\nKU2800_+=1+\r\nKU2800_++=2+\r\nKU2800_+++=3+\r\nKU2800_++++=4+\r\nKU2800_+1=1+\r\nKU2800_+2=2+\r\nKU2800_+3=3+\r\nKU2800_+4=4+\r\nKU2800_TIME=2000\r\nKU2800_INSTRUMENT=KU2800', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-12 11:49:31', 'ณัฐนนท์ ปราณี', '2026-03-12 11:49:31');
INSERT INTO `instruments` VALUES (147, 'US-1800', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (148, 'CA-660', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (149, 'UN-2000', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (150, 'RAPID POINT 500', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (151, 'LABUREADER PLUS2 & URISED MINI', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (152, 'AFR-400S', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (153, 'ZYBIO Q8 PRO', 0, NULL, NULL, '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (154, 'MACCURA I800', 3, 'MACCURAI800_8708_20260312_main_d45e2.png', 'MACCURAH2600_COMPort=\r\nMACCURAH2600-BaudRate=9600\r\nMACCURAH2600_NAME=MACU2600\r\nMACCURAH2600_TIME=1000', '2026-02-28 18:37:04', 'ผู้ดูแลระบบ', '2026-03-12 11:14:06', 'ณัฐนนท์ ปราณี', '2026-03-12 11:14:06');
INSERT INTO `instruments` VALUES (155, 'ISE ON XL-1000', 0, NULL, NULL, '2026-03-09 10:41:33', 'นรภัทร วงษ์สวัสดิ์', NULL, NULL, NULL);
INSERT INTO `instruments` VALUES (156, 'KEYU KU-F20', 3, 'KEYUKUF20_4944_20260313_main_ce13f.webp', 'FS205_TCP_IP=192.168.253.252\r\nFS205_TCP_PORT=\r\nFS205_NAME=FS205\r\nFS205_TIME=500\r\nFS205_PositionResult=1', '2026-03-12 10:08:45', 'รงค์รวี ศรีกระภา', '2026-03-13 09:03:19', 'ณัฐนนท์ ปราณี', '2026-03-13 09:03:19');

SET FOREIGN_KEY_CHECKS = 1;
