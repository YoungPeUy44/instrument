/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100507 (10.5.7-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : automate_manual_db_new

 Target Server Type    : MySQL
 Target Server Version : 100507 (10.5.7-MariaDB)
 File Encoding         : 65001

 Date: 22/03/2026 23:50:17
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
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `automate_category` VALUES (11, 'Biochemistry & Immunology', 'บังโต ซิลลี่ฟูลส์', '2025-06-05 17:19:06', '2025-06-05 17:19:06');
INSERT INTO `automate_category` VALUES (12, 'Feces', NULL, '0000-00-00 00:00:00', '2025-06-05 00:12:41');

-- ----------------------------
-- Table structure for automate_model
-- ----------------------------
DROP TABLE IF EXISTS `automate_model`;
CREATE TABLE `automate_model`  (
  `atm_model_id` int NOT NULL AUTO_INCREMENT,
  `atm_model_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `ref_atm_category_id` int NOT NULL,
  `ref_atm_status_manual_id` int NOT NULL DEFAULT 2,
  `atm_model_updatedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atm_model_updatedAt` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `atm_model_updatedEv` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`atm_model_id`) USING BTREE,
  UNIQUE INDEX `atm_model_name`(`atm_model_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 156 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of automate_model
-- ----------------------------
INSERT INTO `automate_model` VALUES (1, 'DIRUI-BF6800', 1, 3, 'System', '2026-03-22 23:41:11', '2026-03-22 23:41:11');
INSERT INTO `automate_model` VALUES (2, 'QUINTUS', 2, 1, 'System', '2026-03-12 16:33:49', '2026-03-12 16:33:49');
INSERT INTO `automate_model` VALUES (3, 'GH900', 10, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (4, 'H9', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:02', '2026-02-26 15:22:02');
INSERT INTO `automate_model` VALUES (5, 'Q4-LYTE', 5, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (6, 'Q4-LYTE EX', 5, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (7, 'LIAISON', 3, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (8, 'GETEIN-1160', 3, 1, 'ณัฐนนท์ ปราณี', '2026-02-28 10:01:32', '2026-02-28 10:01:32');
INSERT INTO `automate_model` VALUES (9, 'ERBA LYTE PRO', 1, 1, 'ณัฐนนท์ ปราณี', '2026-02-28 10:17:29', '2026-02-28 10:17:29');
INSERT INTO `automate_model` VALUES (10, 'DIRUI-H500', 8, 1, 'ณัฐนนท์ ปราณี', '2026-02-28 10:24:44', '2026-02-28 10:24:44');
INSERT INTO `automate_model` VALUES (11, 'BS-600M', 1, 1, 'ณัฐนนท์ ปราณี', '2026-02-28 10:34:36', '2026-02-28 10:34:36');
INSERT INTO `automate_model` VALUES (12, 'DXC700AU', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:06', '2026-02-26 15:23:06');
INSERT INTO `automate_model` VALUES (13, 'AUTOLUMO A1000', 3, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:31', '2026-02-26 15:23:31');
INSERT INTO `automate_model` VALUES (14, 'ALINITY C', 1, 3, 'ณัฐนนท์ ปราณี', '2026-03-16 12:28:35', '2026-03-16 12:28:35');
INSERT INTO `automate_model` VALUES (15, 'RAC-050', 6, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:37', '2026-02-26 15:23:37');
INSERT INTO `automate_model` VALUES (16, 'EASYSTAT', 7, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:23', '2026-02-26 15:23:23');
INSERT INTO `automate_model` VALUES (17, 'PKL-175', 6, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:41', '2026-02-26 15:23:41');
INSERT INTO `automate_model` VALUES (18, 'LIAISON XL', 3, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:18', '2026-02-26 15:23:18');
INSERT INTO `automate_model` VALUES (19, 'XL-1000', 1, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (20, 'LAURA SMART', 8, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (21, 'CA-600', 6, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (22, 'URIT-5250', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:45', '2026-02-26 15:23:45');
INSERT INTO `automate_model` VALUES (23, 'XN-550', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:12', '2026-02-26 15:22:12');
INSERT INTO `automate_model` VALUES (24, 'URIT-500B', 8, 2, 'บังโต ซิลลี่ฟูลส์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (25, 'URIT-5380', 2, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (26, 'XL-640', 1, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (27, 'BC120', 4, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:14', '2026-02-26 15:19:14');
INSERT INTO `automate_model` VALUES (28, 'NEW LAURA', 8, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (29, 'AU480', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:34', '2026-02-26 15:20:34');
INSERT INTO `automate_model` VALUES (30, 'CA-620', 6, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:21:44', '2026-02-26 15:21:44');
INSERT INTO `automate_model` VALUES (31, 'URISCAN PRO', 8, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:43', '2026-02-26 15:19:43');
INSERT INTO `automate_model` VALUES (32, 'XD697', 5, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:38', '2026-02-26 15:19:38');
INSERT INTO `automate_model` VALUES (33, 'BM6010', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:47', '2026-02-26 15:20:47');
INSERT INTO `automate_model` VALUES (34, 'CITEST AUR-100', 8, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (35, 'PT1000', 7, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:51', '2026-02-26 15:23:51');
INSERT INTO `automate_model` VALUES (36, 'CYBOW R-600S', 8, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (37, 'XL-1000 WITH ISE', 1, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (38, 'URIT-BH5390', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:21:21', '2026-02-26 15:21:21');
INSERT INTO `automate_model` VALUES (39, 'AUTOMAX-80', 9, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:57', '2026-02-26 15:23:57');
INSERT INTO `automate_model` VALUES (40, 'XL-921B', 5, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (41, 'XN-350', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:07', '2026-02-26 15:22:07');
INSERT INTO `automate_model` VALUES (42, 'H8', 10, 1, 'ณัฐนนท์ ปราณี', '2026-02-28 11:01:08', '2026-02-28 11:01:08');
INSERT INTO `automate_model` VALUES (43, 'PREMIER HB9210', 10, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:34', '2026-02-26 15:22:34');
INSERT INTO `automate_model` VALUES (44, 'CL-900I', 3, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:54', '2026-02-26 15:20:54');
INSERT INTO `automate_model` VALUES (45, 'VITROS 4600 WITH ISE', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:33', '2026-02-26 15:19:33');
INSERT INTO `automate_model` VALUES (46, 'XN-1000', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:14', '2026-02-26 15:23:14');
INSERT INTO `automate_model` VALUES (47, 'US1680', 8, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:04', '2026-02-26 15:19:04');
INSERT INTO `automate_model` VALUES (48, 'MAGLUMI 800', 3, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:21:05', '2026-02-26 15:21:05');
INSERT INTO `automate_model` VALUES (49, 'FUS-1000', 8, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:51', '2026-02-26 15:22:51');
INSERT INTO `automate_model` VALUES (50, 'MAGLUMI600', 3, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (51, 'BS820M', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:18:51', '2026-02-26 15:18:51');
INSERT INTO `automate_model` VALUES (52, 'ARCHITECT CI4100', 1, 3, NULL, '2026-03-16 12:28:35', '2026-03-16 12:28:35');
INSERT INTO `automate_model` VALUES (53, 'BC760', 3, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:21:51', '2026-02-26 15:21:51');
INSERT INTO `automate_model` VALUES (54, 'CS-1600', 6, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (55, 'FECES FA280', 12, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (56, 'ARKRAY HA 8180V', 10, 2, 'บังโต ซิลลี่ฟูลส์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (57, 'COBAS C5800', 3, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (58, 'COBAS PURE E402', 3, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (59, 'IDEN SENT VITEK 2XL', 4, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (60, 'XN-1500', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:21:29', '2026-02-26 15:21:29');
INSERT INTO `automate_model` VALUES (61, 'ARCHITECT CI8200', 1, 3, NULL, '2026-03-16 12:28:35', '2026-03-16 12:28:35');
INSERT INTO `automate_model` VALUES (62, 'ISE6000', 5, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (63, 'HA8380', 10, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:28', '2026-02-26 15:20:29');
INSERT INTO `automate_model` VALUES (64, 'BC5180', 2, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (65, 'ACCESS2', 3, 3, NULL, '2026-03-16 12:28:35', '2026-03-16 12:28:35');
INSERT INTO `automate_model` VALUES (66, 'H900', 5, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:40', '2026-02-26 15:22:40');
INSERT INTO `automate_model` VALUES (67, 'XL-1000 PLUS', 1, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (68, 'BC60', 4, 1, 'ณัฐนนท์ ปราณี', '2026-02-28 10:48:13', '2026-02-28 10:48:13');
INSERT INTO `automate_model` VALUES (69, 'QCR U500', 8, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (70, 'IN4-LYTE', 5, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (71, 'CA-500', 6, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (72, 'BT120', 1, 1, 'ณัฐนนท์ ปราณี', '2026-03-03 09:58:06', '2026-03-03 09:58:06');
INSERT INTO `automate_model` VALUES (73, 'BT-60', 4, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:01', '2026-02-26 15:20:01');
INSERT INTO `automate_model` VALUES (74, 'ALINITY I', 3, 3, 'บังโต ซิลลี่ฟูลส์', '2026-03-16 11:20:00', '2026-03-16 11:20:00');
INSERT INTO `automate_model` VALUES (75, 'ALINITY CI', 1, 3, 'ธนาภูมิ วิไลรัตน์', '2026-03-16 12:28:35', '2026-03-16 12:28:35');
INSERT INTO `automate_model` VALUES (76, 'XL-640 PLUS', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:58', '2026-02-26 15:22:58');
INSERT INTO `automate_model` VALUES (77, 'BH-6180', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:23:27', '2026-02-26 15:23:27');
INSERT INTO `automate_model` VALUES (78, 'C3100', 6, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:20', '2026-02-26 15:19:20');
INSERT INTO `automate_model` VALUES (79, 'QUIDELSOFIA', 3, 2, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (80, 'AUTOBIO A1860', 3, 2, 'ธนาภูมิ วิไลรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (81, 'LAURA XL', 8, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:46', '2026-02-26 15:22:46');
INSERT INTO `automate_model` VALUES (82, 'SF8050', 6, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:26', '2026-02-26 15:19:26');
INSERT INTO `automate_model` VALUES (83, 'BT2000', 1, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (84, 'ARES', 6, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (85, 'CYBOW 720', 8, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (86, 'BT3500', 1, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (87, 'MET6000', 1, 2, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (88, 'CM-1000', 1, 2, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (89, 'AU680', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:26', '2026-02-26 15:22:26');
INSERT INTO `automate_model` VALUES (90, 'URISED2&LABUMAT2', 8, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:22:20', '2026-02-26 15:22:20');
INSERT INTO `automate_model` VALUES (91, 'A1CCHEK PRO', 10, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:21:14', '2026-02-26 15:21:14');
INSERT INTO `automate_model` VALUES (92, 'RAC-1800', 6, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:58', '2026-02-26 15:20:58');
INSERT INTO `automate_model` VALUES (93, 'BC6000', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:56', '2026-02-26 15:19:56');
INSERT INTO `automate_model` VALUES (94, 'TOSOH G8', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:40', '2026-02-26 15:20:40');
INSERT INTO `automate_model` VALUES (95, 'COBAS6000', 1, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (96, 'FUS-3000', 8, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:22', '2026-02-26 15:20:22');
INSERT INTO `automate_model` VALUES (97, 'TOSOH HLC-723G11', 10, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:51', '2026-02-26 15:19:51');
INSERT INTO `automate_model` VALUES (98, 'PENTRA 80XL', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:11', '2026-02-26 15:20:11');
INSERT INTO `automate_model` VALUES (99, 'INDIKO PLUS', 1, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:18:58', '2026-02-26 15:18:58');
INSERT INTO `automate_model` VALUES (100, 'URIT-50', 8, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (101, 'BC-5180', 2, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (102, 'BC-700', 2, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (103, 'BC6200', 2, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:21:56', '2026-02-26 15:21:56');
INSERT INTO `automate_model` VALUES (104, 'D10', 10, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (105, 'CS-2100I', 6, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (106, 'COBAS PRO', 1, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (107, 'ATELLICA CI', 1, 3, 'ธนาภูมิ วิไลรัตน์', '2026-03-16 12:27:56', '2026-03-16 12:27:56');
INSERT INTO `automate_model` VALUES (108, 'VERSATREK', 4, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (109, 'ATELLICA (CH930+IM1300)', 1, 2, 'ธนาภูมิ วิไลรัตน์', '2025-12-24 12:02:26', '2025-12-24 12:02:26');
INSERT INTO `automate_model` VALUES (110, 'COBAS C503', 1, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (111, 'EU5300', 8, 2, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (112, 'EDENI15', 7, 2, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (113, 'ORTHO VISION', 9, 2, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (114, 'H100', 10, 2, 'ณัฐนนท์ ปราณี', '2026-02-26 15:20:05', '2026-02-26 15:20:05');
INSERT INTO `automate_model` VALUES (115, 'US2000C', 8, 2, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (116, 'SA120', 9, 2, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (117, 'COBAS E411', 3, 2, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (118, 'VITROS XT7600', 1, 2, 'ธนาภูมิ วิไลรัตน์', '2025-12-24 12:02:13', '2025-12-24 12:02:13');
INSERT INTO `automate_model` VALUES (119, 'CAL6000', 2, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (120, 'ACON-U500', 8, 3, 'นรวิชญ์ ศิริลักษณมานนท์', '2026-03-16 11:20:00', '2026-03-16 11:20:00');
INSERT INTO `automate_model` VALUES (121, 'ARCHITECT I2000 SR', 3, 3, 'รงค์รวี ศรีกระภา', '2026-03-16 11:20:00', '2026-03-16 11:20:00');
INSERT INTO `automate_model` VALUES (122, 'SEBIA MINI CAP', 2, 2, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model` VALUES (123, 'LB12', 9, 1, 'ณัฐนนท์ ปราณี', '2026-02-28 09:24:53', '2026-02-28 09:24:53');
INSERT INTO `automate_model` VALUES (124, 'AU5800', 1, 2, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:51:02', '2025-11-25 16:51:02');
INSERT INTO `automate_model` VALUES (125, 'XL-640 WITH ISE', 1, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 16:51:01', '2025-11-25 16:51:01');
INSERT INTO `automate_model` VALUES (126, 'BC-5600', 2, 2, 'ณัฐนนท์ ปราณี', '2025-11-25 16:50:55', '2025-11-25 16:50:55');
INSERT INTO `automate_model` VALUES (127, 'INTEGRA 400 PLUS', 1, 2, 'ณัฐนนท์ ปราณี', '2025-11-25 16:50:53', '2025-11-25 16:50:53');
INSERT INTO `automate_model` VALUES (128, 'YUMIZEN G800', 6, 2, 'ณัฐนนท์ ปราณี', '2025-11-25 16:50:54', '2025-11-25 16:50:54');
INSERT INTO `automate_model` VALUES (129, 'YUMIZENG800', 6, 2, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:50:52', '2025-11-25 16:50:52');
INSERT INTO `automate_model` VALUES (130, 'C8000', 1, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 16:59:45', '2025-11-25 16:59:45');
INSERT INTO `automate_model` VALUES (131, 'BA400', 1, 2, 'ณัฐนนท์ ปราณี', '2025-11-25 16:50:50', '2025-11-25 16:50:50');
INSERT INTO `automate_model` VALUES (132, 'VITROS 3600', 1, 2, 'ธนาภูมิ วิไลรัตน์', '2025-12-24 12:01:43', '2025-12-24 12:01:43');
INSERT INTO `automate_model` VALUES (133, 'YUMIZEN H1500', 2, 2, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:50:47', '2025-11-25 16:50:47');
INSERT INTO `automate_model` VALUES (134, 'HISCL-800', 3, 2, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:51:04', '2025-11-25 16:51:04');
INSERT INTO `automate_model` VALUES (135, 'I2000SR', 3, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 17:01:00', '2025-11-25 17:01:00');
INSERT INTO `automate_model` VALUES (136, 'LD-600', 10, 2, 'ดนุภัทร สังสีแก้ว', '2025-12-05 09:59:53', '2025-12-05 09:59:53');
INSERT INTO `automate_model` VALUES (137, 'XNL-550', 2, 2, 'ณัฐนนท์ ปราณี', '2025-12-23 14:02:36', '2025-12-23 14:02:36');
INSERT INTO `automate_model` VALUES (138, 'PREMIER RESOLUTION', 2, 2, 'พีรณัฐ แสงรัตน์', '2025-12-23 14:40:36', '2025-12-23 14:40:36');
INSERT INTO `automate_model` VALUES (139, 'DL96A', 4, 2, 'รงค์รวี ศรีกระภา', '2026-01-14 11:20:00', '2026-01-14 11:20:00');
INSERT INTO `automate_model` VALUES (140, 'LB24', 9, 2, 'ณัฐนนท์ ปราณี', '2026-01-21 19:24:03', '2026-01-21 19:24:03');
INSERT INTO `automate_model` VALUES (141, 'MACCURAH2600', 6, 2, 'ณัฐนนท์ ปราณี', '2026-01-22 18:35:54', '2026-01-22 18:35:54');
INSERT INTO `automate_model` VALUES (142, 'IRICELL3000', 1, 2, 'ณัฐนนท์ ปราณี', '2026-01-22 18:38:26', '2026-01-22 18:38:26');
INSERT INTO `automate_model` VALUES (143, 'MACCURA I1000', 3, 2, 'รงค์รวี ศรีกระภา', '2026-01-29 16:25:16', '2026-01-29 16:25:16');
INSERT INTO `automate_model` VALUES (144, 'BS-620M', 1, 2, 'ธนาภูมิ วิไลรัตน์', '2026-02-06 18:15:40', '2026-02-06 18:15:40');
INSERT INTO `automate_model` VALUES (145, 'SAL6000', 1, 2, 'ธนาภูมิ วิไลรัตน์', '2026-02-06 18:19:04', '2026-02-06 18:19:04');
INSERT INTO `automate_model` VALUES (146, 'KEYU KU-2800', 8, 2, 'ธนาภูมิ วิไลรัตน์', '2026-02-06 18:26:53', '2026-02-06 18:26:53');
INSERT INTO `automate_model` VALUES (147, 'US-1800', 8, 2, 'พีรณัฐ แสงรัตน์', '2026-02-17 18:00:52', '2026-02-17 18:00:52');
INSERT INTO `automate_model` VALUES (148, 'CA-660', 6, 2, 'พีรณัฐ แสงรัตน์', '2026-02-18 12:58:25', '2026-02-18 12:58:25');
INSERT INTO `automate_model` VALUES (149, 'UN-2000', 8, 2, 'พีรณัฐ แสงรัตน์', '2026-02-18 12:59:44', '2026-02-18 12:59:44');
INSERT INTO `automate_model` VALUES (150, 'RAPID POINT 500', 7, 2, 'พีรณัฐ แสงรัตน์', '2026-02-19 09:49:19', '2026-02-19 09:49:19');
INSERT INTO `automate_model` VALUES (151, 'LABUREADER PLUS2 & URISED MINI', 8, 2, 'พีรณัฐ แสงรัตน์', '2026-02-19 13:15:51', '2026-02-19 13:15:51');
INSERT INTO `automate_model` VALUES (152, 'AFR-400S', 3, 3, 'พีรณัฐ แสงรัตน์', '2026-03-16 12:28:35', '2026-03-16 12:28:35');
INSERT INTO `automate_model` VALUES (153, 'ZYBIO Q8 PRO', 3, 2, 'พีรณัฐ แสงรัตน์', '2026-02-19 13:19:30', '2026-02-19 13:19:30');
INSERT INTO `automate_model` VALUES (154, 'MACCURA I800', 3, 1, 'พีรณัฐ แสงรัตน์', '2026-03-05 10:03:26', '2026-03-05 10:03:26');
INSERT INTO `automate_model` VALUES (155, 'TEST', 0, 2, NULL, '2026-03-12 11:09:43', '2026-03-12 11:09:43');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_cable_types
-- ----------------------------
INSERT INTO `instrument_cable_types` VALUES (1, 'RS232 Cross', NULL, 'Y');
INSERT INTO `instrument_cable_types` VALUES (2, 'RS232 Direct', NULL, 'Y');
INSERT INTO `instrument_cable_types` VALUES (3, 'LAN', 'cables/cable_lan.png', 'Y');
INSERT INTO `instrument_cable_types` VALUES (4, 'RS232 XL', NULL, 'Y');

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_determination
-- ----------------------------
INSERT INTO `instrument_determination` VALUES (2, 72, 'BT120_8300_20260302_004_b60ea.zip', 'determination_sa120.zip', NULL);
INSERT INTO `instrument_determination` VALUES (5, 9, 'ERBALYTEPRO_3952_20260305_004_de55e.zip', 'determination_q4lyteex.zip', NULL);
INSERT INTO `instrument_determination` VALUES (6, 1, 'DIRUIBF6800_2674_20260319_004_12172.zip', 'determination_bc5300.zip', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_run_images
-- ----------------------------
INSERT INTO `instrument_run_images` VALUES (1, 72, 'BT120_8465_20260302_003_2634f.jpg', '2026-03-02 15:45:01', 0);
INSERT INTO `instrument_run_images` VALUES (2, 154, 'MACCURAI800_4831_20260305_003_93ce4.jpg', '2026-03-05 09:57:51', 0);
INSERT INTO `instrument_run_images` VALUES (3, 153, 'ZYBIOQ8PRO_20260311_033147_run_af1ec.jpg', '2026-03-11 09:31:47', 0);
INSERT INTO `instrument_run_images` VALUES (5, 1, 'DIRUIBF6800_1950_20260319_003_7ca76.jpg', '2026-03-19 21:01:16', 0);
INSERT INTO `instrument_run_images` VALUES (6, 1, 'DIRUIBF6800_3973_20260319_003_dfb04.png', '2026-03-19 21:10:10', 1);

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
) ENGINE = InnoDB AUTO_INCREMENT = 81 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_setup_images
-- ----------------------------
INSERT INTO `instrument_setup_images` VALUES (1, 72, 'BT120_8465_20260302_002_24ae5.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (3, 72, 'BT120_8465_20260302_002_25acb.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (4, 72, 'BT120_8465_20260302_002_25fa9.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (6, 154, 'MACCURAI800_4245_20260305_002_4af22.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (7, 154, 'MACCURAI800_4245_20260305_002_4b522.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (8, 154, 'MACCURAI800_7222_20260305_002_3142e.png', 0);
INSERT INTO `instrument_setup_images` VALUES (27, 153, 'ZYBIOQ8PRO_2950_20260311_002_0145e.jpg', 0);
INSERT INTO `instrument_setup_images` VALUES (28, 153, 'ZYBIOQ8PRO_2950_20260311_002_02127.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (29, 153, 'ZYBIOQ8PRO_2950_20260311_002_02bcd.jpg', 2);
INSERT INTO `instrument_setup_images` VALUES (30, 153, 'ZYBIOQ8PRO_5432_20260311_002_64e81.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (31, 153, 'ZYBIOQ8PRO_5432_20260311_002_655fd.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (32, 153, 'ZYBIOQ8PRO_5432_20260311_002_65a25.jpg', 5);
INSERT INTO `instrument_setup_images` VALUES (33, 153, 'ZYBIOQ8PRO_5432_20260311_002_65dbc.jpg', 6);
INSERT INTO `instrument_setup_images` VALUES (34, 153, 'ZYBIOQ8PRO_5432_20260311_002_66214.jpg', 7);
INSERT INTO `instrument_setup_images` VALUES (75, 1, 'DIRUIBF6800_9019_20260313_002_82d5c.png', 0);
INSERT INTO `instrument_setup_images` VALUES (76, 1, 'DIRUIBF6800_9019_20260313_002_832d1.jpg', 3);
INSERT INTO `instrument_setup_images` VALUES (77, 1, 'DIRUIBF6800_9019_20260313_002_836e3.jpg', 4);
INSERT INTO `instrument_setup_images` VALUES (78, 1, 'DIRUIBF6800_9019_20260313_002_83afb.jpg', 1);
INSERT INTO `instrument_setup_images` VALUES (79, 1, 'DIRUIBF6800_9019_20260313_002_83fa3.jpg', 2);

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_training
-- ----------------------------
INSERT INTO `instrument_training` VALUES (1, 'ทดสอบ', 'ห้องเเล็บ', '2026-03-16 11:17:00', '2026-03-16 00:17:00', '', 1, 0, '2026-03-16 11:20:00', '2026-03-16 11:20:00');
INSERT INTO `instrument_training` VALUES (2, 'test', 'teattt', '2026-03-16 12:27:00', '2026-03-16 14:27:00', '', 1, 0, '2026-03-16 12:27:56', '2026-03-16 12:27:56');
INSERT INTO `instrument_training` VALUES (3, 'tetttttttttt', 'ฟฟฟฟฟฟฟฟฟฟฟฟ', '2026-03-16 12:28:00', '2026-03-16 13:28:00', '', 1, 0, '2026-03-16 12:28:35', '2026-03-16 12:28:35');

-- ----------------------------
-- Table structure for instrument_training_items
-- ----------------------------
DROP TABLE IF EXISTS `instrument_training_items`;
CREATE TABLE `instrument_training_items`  (
  `training_item_id` int NOT NULL AUTO_INCREMENT,
  `training_id` int NULL DEFAULT NULL,
  `instrument_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`training_item_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrument_training_items
-- ----------------------------
INSERT INTO `instrument_training_items` VALUES (1, 1, 120);
INSERT INTO `instrument_training_items` VALUES (2, 1, 74);
INSERT INTO `instrument_training_items` VALUES (3, 1, 121);
INSERT INTO `instrument_training_items` VALUES (4, 2, 107);
INSERT INTO `instrument_training_items` VALUES (5, 3, 65);
INSERT INTO `instrument_training_items` VALUES (6, 3, 120);
INSERT INTO `instrument_training_items` VALUES (7, 3, 152);
INSERT INTO `instrument_training_items` VALUES (8, 3, 14);
INSERT INTO `instrument_training_items` VALUES (9, 3, 75);
INSERT INTO `instrument_training_items` VALUES (10, 3, 74);
INSERT INTO `instrument_training_items` VALUES (11, 3, 52);
INSERT INTO `instrument_training_items` VALUES (12, 3, 61);

-- ----------------------------
-- Table structure for instruments
-- ----------------------------
DROP TABLE IF EXISTS `instruments`;
CREATE TABLE `instruments`  (
  `ins_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `tmpname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cable_type_id` int NOT NULL,
  `equipment_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `config_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `live_event` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ins_id`) USING BTREE,
  INDEX `cable_type_id`(`cable_type_id` ASC) USING BTREE,
  INDEX `idx_cable`(`cable_type_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 256 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instruments
-- ----------------------------
INSERT INTO `instruments` VALUES (1, 'DIRUI-BF6800', 1, 'DIRUIBF6800_3122_20260313_main_9d012.jpg', '', '2026-02-28 18:37:04', '2026-03-22 23:41:11', 'System', '2026-03-22 23:41:11');
INSERT INTO `instruments` VALUES (2, 'QUINTUS', 1, 'QUINTUS_1123_20260312_main_b1411.png', '', '2026-02-28 18:37:04', '2026-03-12 16:34:29', 'System', '2026-03-12 16:34:29');
INSERT INTO `instruments` VALUES (3, 'GH900', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (4, 'H9', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (5, 'Q4-LYTE', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (6, 'Q4-LYTE EX', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (7, 'LIAISON', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (8, 'GETEIN-1160', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (9, 'ERBA LYTE PRO', 1, 'ERBALYTEPRO_1067_20260305_001.png', 'Q4-LYTE-EX_COMPort=COM10\r\nQ4-LYTE-EX_NAME=ErbaLytePro\r\nQ4-LYTE-EX_BaudRate=19200\r\nQ4-LYTE-EX-2_COMPort=\r\nQ4-LYTE-EX-2_BaudRate=19200', '2026-02-28 18:37:04', '2026-03-12 16:26:41', 'System', '2026-03-05 10:48:48');
INSERT INTO `instruments` VALUES (10, 'DIRUI-H500', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (11, 'BS-600M', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (12, 'DXC700AU', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (13, 'AUTOLUMO A1000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (14, 'ALINITY C', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (15, 'RAC-050', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (16, 'EASYSTAT', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (17, 'PKL-175', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (18, 'LIAISON XL', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (19, 'XL-1000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (20, 'LAURA SMART', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (21, 'CA-600', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (22, 'URIT-5250', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (23, 'XN-550', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (24, 'URIT-500B', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (25, 'URIT-5380', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (26, 'XL-640', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (27, 'BC120', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (28, 'NEW LAURA', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (29, 'AU480', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (30, 'CA-620', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (31, 'URISCAN PRO', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (32, 'XD697', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (33, 'BM6010', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (34, 'CITEST AUR-100', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (35, 'PT1000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (36, 'CYBOW R-600S', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (37, 'XL-1000 WITH ISE', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (38, 'URIT-BH5390', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (39, 'AUTOMAX-80', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (40, 'XL-921B', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (41, 'XN-350', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (42, 'H8', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (43, 'PREMIER HB9210', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (44, 'CL-900I', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (45, 'VITROS 4600 WITH ISE', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (46, 'XN-1000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (47, 'US1680', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (48, 'MAGLUMI 800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (49, 'FUS-1000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (50, 'MAGLUMI600', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (51, 'BS820M', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (52, 'ARCHITECT CI4100', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (53, 'BC760', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (54, 'CS-1600', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (55, 'FECES FA280', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (56, 'ARKRAY HA 8180V', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (57, 'COBAS C5800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (58, 'COBAS PURE E402', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (59, 'IDEN SENT VITEK 2XL', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (60, 'XN-1500', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (61, 'ARCHITECT CI8200', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (62, 'ISE6000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (63, 'HA8380', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (64, 'BC5180', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (65, 'ACCESS2', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (66, 'H900', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (67, 'XL-1000 PLUS', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (68, 'BC60', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (69, 'QCR U500', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (70, 'IN4-LYTE', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (71, 'CA-500', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (72, 'BT120', 0, 'BT120_8251_20260303_001.png', '', '2026-02-28 18:37:04', '2026-03-12 16:26:41', 'System', '2026-03-03 10:24:33');
INSERT INTO `instruments` VALUES (73, 'BT-60', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (74, 'ALINITY I', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (75, 'ALINITY CI', 0, 'ALINITYCI_20260309_034904_cover.jpg', NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', 'System', '2026-03-09 09:49:04');
INSERT INTO `instruments` VALUES (76, 'XL-640 PLUS', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (77, 'BH-6180', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (78, 'C3100', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (79, 'QUIDELSOFIA', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (80, 'AUTOBIO A1860', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (81, 'LAURA XL', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (82, 'SF8050', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (83, 'BT2000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (84, 'ARES', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (85, 'CYBOW 720', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (86, 'BT3500', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (87, 'MET6000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (88, 'CM-1000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (89, 'AU680', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (90, 'URISED2&LABUMAT2', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (91, 'A1CCHEK PRO', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (92, 'RAC-1800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (93, 'BC6000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (94, 'TOSOH G8', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (95, 'COBAS6000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (96, 'FUS-3000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (97, 'TOSOH HLC-723G11', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (98, 'PENTRA 80XL', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (99, 'INDIKO PLUS', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (100, 'URIT-50', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (101, 'BC-5180', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (102, 'BC-700', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (103, 'BC6200', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (104, 'D10', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (105, 'CS-2100I', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (106, 'COBAS PRO', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (107, 'ATELLICA CI', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (108, 'VERSATREK', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (109, 'ATELLICA (CH930+IM1300)', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (110, 'COBAS C503', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (111, 'EU5300', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (112, 'EDENI15', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (113, 'ORTHO VISION', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (114, 'H100', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (115, 'US2000C', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (116, 'SA120', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (117, 'COBAS E411', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (118, 'VITROS XT7600', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (119, 'CAL6000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (120, 'ACON-U500', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (121, 'ARCHITECT I2000 SR', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (122, 'SEBIA MINI CAP', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (123, 'LB12', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (124, 'AU5800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (125, 'XL-640 WITH ISE', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (126, 'BC-5600', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (127, 'INTEGRA 400 PLUS', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (128, 'YUMIZEN G800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (129, 'YUMIZENG800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (130, 'C8000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (131, 'BA400', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (132, 'VITROS 3600', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (133, 'YUMIZEN H1500', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (134, 'HISCL-800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (135, 'I2000SR', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (136, 'LD-600', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (137, 'XNL-550', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (138, 'PREMIER RESOLUTION', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (139, 'DL96A', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (140, 'LB24', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (141, 'MACCURAH2600', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (142, 'IRICELL3000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (143, 'MACCURA I1000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (144, 'BS-620M', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (145, 'SAL6000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (146, 'KEYU KU-2800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (147, 'US-1800', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (148, 'CA-660', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (149, 'UN-2000', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (150, 'RAPID POINT 500', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (151, 'LABUREADER PLUS2 & URISED MINI', 0, NULL, NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', NULL, '2026-02-28 18:37:04');
INSERT INTO `instruments` VALUES (152, 'AFR-400S', 0, 'AFR400S_4892_20260311_main_de652.png', NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', 'System', '2026-03-11 14:08:07');
INSERT INTO `instruments` VALUES (153, 'ZYBIO Q8 PRO', 0, 'ZYBIOQ8PRO_9086_20260311_main_aca3b.jpg', NULL, '2026-02-28 18:37:04', '2026-03-12 16:26:41', 'System', '2026-03-11 13:58:27');
INSERT INTO `instruments` VALUES (154, 'MACCURA I800', 1, 'MACCURAI800_3034_20260305_001.png', 'dawdawdadas', '2026-02-28 18:37:04', '2026-03-12 16:26:41', 'System', '2026-03-05 10:11:14');
INSERT INTO `instruments` VALUES (155, 'TEST', 0, NULL, NULL, '2026-03-12 11:10:41', '2026-03-12 16:26:41', NULL, '2026-03-12 11:10:44');

SET FOREIGN_KEY_CHECKS = 1;
