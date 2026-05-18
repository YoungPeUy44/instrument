/*
 Navicat Premium Dump SQL

 Source Server         : localhost_3306_1
 Source Server Type    : MySQL
 Source Server Version : 100507 (10.5.7-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : automate_manual_db_new

 Target Server Type    : MySQL
 Target Server Version : 100507 (10.5.7-MariaDB)
 File Encoding         : 65001

 Date: 18/05/2026 07:31:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for automate_model_time
-- ----------------------------
DROP TABLE IF EXISTS `automate_model_time`;
CREATE TABLE `automate_model_time`  (
  `atm_model_id` int NOT NULL AUTO_INCREMENT,
  `atm_model_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `ref_atm_status_manual_id` int NOT NULL DEFAULT 2 COMMENT '1=มีคู่มือ, 2=ไม่มีคู่มือ, 3=รออบรม',
  `setup_comfirmed_tmp` tinyint NOT NULL DEFAULT 1 COMMENT '0=ข้อมูลไม่ครบ, 1=ข้อมูลครบ',
  `ref_instrument_training` int NULL DEFAULT NULL COMMENT 'เลขไอดีการอบรม',
  `ref_atm_category_id` int NOT NULL,
  `atm_model_updatedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `atm_model_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP,
  `atm_model_updatedEv` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`atm_model_id`) USING BTREE,
  UNIQUE INDEX `atm_model_name`(`atm_model_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 195 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of automate_model_time
-- ----------------------------
INSERT INTO `automate_model_time` VALUES (1, 'DIRUI-BF6800', 2, 0, NULL, 2, 'ปกรณ์ พุฒิไพรีพ่าย', '2026-04-28 12:47:49', '2026-04-28 12:47:49');
INSERT INTO `automate_model_time` VALUES (2, 'QUINTUS', 2, 0, NULL, 2, NULL, '2026-04-29 10:12:48', '2026-04-29 10:12:48');
INSERT INTO `automate_model_time` VALUES (3, 'GH900', 2, 0, NULL, 10, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (4, 'H9', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-29 10:42:39', '2026-04-29 10:42:39');
INSERT INTO `automate_model_time` VALUES (5, 'Q4-LYTE', 2, 0, NULL, 5, 'ณัฐนนท์ ปราณี', '2026-03-09 08:39:48', '2026-03-09 08:39:48');
INSERT INTO `automate_model_time` VALUES (6, 'Q4-LYTE EX', 2, 0, NULL, 5, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (7, 'LIAISON', 2, 0, NULL, 3, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (8, 'GETEIN-1160', 1, 1, NULL, 3, 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-04-06 16:15:04', '2026-04-06 16:15:04');
INSERT INTO `automate_model_time` VALUES (9, 'ERBA LYTE PRO', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-05 09:02:05', '2026-03-05 09:02:05');
INSERT INTO `automate_model_time` VALUES (10, 'DIRUI-H500', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-03-21 00:18:00', '2026-03-21 00:18:00');
INSERT INTO `automate_model_time` VALUES (11, 'BS-600M', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-29 10:42:36', '2026-04-29 10:42:36');
INSERT INTO `automate_model_time` VALUES (12, 'DXC700AU', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-05 22:15:29', '2026-03-05 22:15:29');
INSERT INTO `automate_model_time` VALUES (13, 'AUTOLUMO A1000', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-03-05 21:22:29', '2026-03-05 21:22:29');
INSERT INTO `automate_model_time` VALUES (14, 'ALINITY C', 2, 0, NULL, 1, 'ปกรณ์ พุฒิไพรีพ่าย', '2026-04-28 12:30:52', '2026-04-28 12:30:52');
INSERT INTO `automate_model_time` VALUES (15, 'RAC-050', 1, 1, NULL, 6, 'ณัฐนนท์ ปราณี', '2026-03-10 15:21:26', '2026-03-10 15:21:26');
INSERT INTO `automate_model_time` VALUES (16, 'EASYSTAT', 1, 1, NULL, 7, 'System', '2026-04-08 15:50:39', '2026-04-08 15:50:39');
INSERT INTO `automate_model_time` VALUES (17, 'PKL-175', 1, 1, NULL, 6, 'ณัฐนนท์', '2026-03-11 14:12:31', '2026-03-11 14:12:31');
INSERT INTO `automate_model_time` VALUES (18, 'LIAISON XL', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-03-09 15:40:01', '2026-03-09 15:40:01');
INSERT INTO `automate_model_time` VALUES (19, 'XL-1000', 2, 0, NULL, 1, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (20, 'LAURA SMART', 2, 0, NULL, 8, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (21, 'CA-600', 1, 1, NULL, 6, 'ณัฐนนท์ ปราณี', '2026-04-21 13:50:57', '2026-04-21 13:50:57');
INSERT INTO `automate_model_time` VALUES (22, 'URIT-5250', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 10:13:12', '2026-03-10 10:13:12');
INSERT INTO `automate_model_time` VALUES (23, 'XN-550', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 11:24:20', '2026-03-10 11:24:20');
INSERT INTO `automate_model_time` VALUES (24, 'URIT-500B', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-20 14:59:57', '2026-04-20 14:59:57');
INSERT INTO `automate_model_time` VALUES (25, 'URIT-5380', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-04-20 14:30:05', '2026-04-20 14:30:05');
INSERT INTO `automate_model_time` VALUES (26, 'XL-640', 2, 0, NULL, 1, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (27, 'BC120', 1, 1, NULL, 4, 'ณัฐนนท์ ปราณี', '2026-03-25 14:41:01', '2026-03-25 14:41:01');
INSERT INTO `automate_model_time` VALUES (28, 'NEW LAURA', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-30 15:51:28', '2026-04-30 15:51:28');
INSERT INTO `automate_model_time` VALUES (29, 'AU480', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-05 21:26:49', '2026-03-05 21:26:49');
INSERT INTO `automate_model_time` VALUES (30, 'CA-620', 1, 1, NULL, 6, 'ณัฐนนท์ ปราณี', '2026-04-21 13:43:42', '2026-04-21 13:43:42');
INSERT INTO `automate_model_time` VALUES (31, 'URISCAN PRO', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-03-10 14:52:57', '2026-03-10 14:52:57');
INSERT INTO `automate_model_time` VALUES (32, 'XD697', 1, 1, NULL, 5, 'ณัฐนนท์ ปราณี', '2026-03-05 22:33:09', '2026-03-05 22:33:09');
INSERT INTO `automate_model_time` VALUES (33, 'BM6010', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-05 21:58:00', '2026-03-05 21:58:00');
INSERT INTO `automate_model_time` VALUES (34, 'CITEST AUR-100', 2, 0, NULL, 8, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (35, 'PT1000', 1, 1, NULL, 7, 'ณัฐนนท์', '2026-03-11 14:28:40', '2026-03-11 14:28:40');
INSERT INTO `automate_model_time` VALUES (36, 'CYBOW R-600S', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-03-13 09:48:27', '2026-03-13 09:48:27');
INSERT INTO `automate_model_time` VALUES (37, 'XL-1000 WITH ISE', 2, 0, NULL, 1, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (38, 'URIT-BH5390', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 10:22:02', '2026-03-10 10:22:02');
INSERT INTO `automate_model_time` VALUES (39, 'AUTOMAX-80', 1, 1, NULL, 9, 'ณัฐนนท์ ปราณี', '2026-03-05 10:34:23', '2026-03-05 10:34:23');
INSERT INTO `automate_model_time` VALUES (40, 'XL-921B', 2, 0, NULL, 5, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (41, 'XN-350', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 11:28:20', '2026-03-10 11:28:20');
INSERT INTO `automate_model_time` VALUES (42, 'H8', 1, 1, NULL, 10, 'ณัฐนนท์ ปราณี', '2026-03-05 22:20:42', '2026-03-05 22:20:42');
INSERT INTO `automate_model_time` VALUES (43, 'PREMIER HB9210', 1, 1, NULL, 10, 'ณัฐนนท์ ปราณี', '2026-03-06 08:51:22', '2026-03-06 08:51:22');
INSERT INTO `automate_model_time` VALUES (44, 'CL-900I', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-03-10 09:40:47', '2026-03-10 09:40:47');
INSERT INTO `automate_model_time` VALUES (45, 'VITROS 4600 WITH ISE', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-28 16:49:46', '2026-03-28 16:49:46');
INSERT INTO `automate_model_time` VALUES (46, 'XN-1000', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 11:22:32', '2026-03-10 11:22:32');
INSERT INTO `automate_model_time` VALUES (47, 'US1680', 1, 1, NULL, 8, 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-04-06 16:15:04', '2026-04-06 16:15:04');
INSERT INTO `automate_model_time` VALUES (48, 'MAGLUMI 800', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-03-09 15:42:24', '2026-03-09 15:42:24');
INSERT INTO `automate_model_time` VALUES (49, 'FUS-1000', 1, 1, NULL, 8, 'ณัฐนนท์', '2026-03-11 15:43:38', '2026-03-11 15:43:38');
INSERT INTO `automate_model_time` VALUES (50, 'MAGLUMI600', 2, 0, NULL, 3, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (51, 'BS820M', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-05 21:36:28', '2026-03-05 21:36:28');
INSERT INTO `automate_model_time` VALUES (52, 'ARCHITECT CI4100', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-12 17:03:23', '2026-03-12 17:03:23');
INSERT INTO `automate_model_time` VALUES (53, 'BC760', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-03-10 13:18:58', '2026-03-10 13:18:58');
INSERT INTO `automate_model_time` VALUES (54, 'CS-1600', 2, 0, NULL, 6, 'ปกรณ์ พุฒิไพรีพ่าย', '2026-05-16 16:05:15', '2026-05-16 16:05:15');
INSERT INTO `automate_model_time` VALUES (55, 'FECES FA280', 2, 0, NULL, 12, 'ณัฐนนท์ ปราณี', '2026-04-07 15:21:16', '2026-04-07 15:21:16');
INSERT INTO `automate_model_time` VALUES (56, 'ARKRAY HA 8180V', 2, 0, NULL, 10, 'บังโต ซิลลี่ฟูลส์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (57, 'COBAS C5800', 2, 0, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-05-16 15:45:02', '2026-05-16 15:45:02');
INSERT INTO `automate_model_time` VALUES (58, 'COBAS PURE E402', 2, 0, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-07 15:21:50', '2026-04-07 15:21:50');
INSERT INTO `automate_model_time` VALUES (59, 'IDEN SENT VITEK 2XL', 2, 0, NULL, 4, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (60, 'XN-1500', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 11:11:30', '2026-03-10 11:11:30');
INSERT INTO `automate_model_time` VALUES (61, 'ARCHITECT CI8200', 1, 1, NULL, 1, 'นรวิชญ์ ศิริลักษณมานนท์', '2026-03-28 15:54:44', '2026-03-28 15:54:44');
INSERT INTO `automate_model_time` VALUES (62, 'ISE6000', 2, 0, NULL, 5, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (63, 'HA8380', 1, 1, NULL, 10, 'ณัฐนนท์ ปราณี', '2026-03-06 20:17:10', '2026-03-06 20:17:10');
INSERT INTO `automate_model_time` VALUES (64, 'BC5180', 2, 0, NULL, 2, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (65, 'ACCESS2', 2, 0, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-25 14:32:35', '2026-04-25 14:32:35');
INSERT INTO `automate_model_time` VALUES (66, 'H900', 1, 1, NULL, 5, 'ณัฐนนท์ ปราณี', '2026-03-05 22:36:20', '2026-03-05 22:36:20');
INSERT INTO `automate_model_time` VALUES (67, 'XL-1000 PLUS', 2, 0, NULL, 1, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (68, 'BC60', 1, 1, NULL, 4, 'ณัฐนนท์', '2026-03-11 15:33:55', '2026-03-11 15:33:55');
INSERT INTO `automate_model_time` VALUES (69, 'QCR U500', 2, 0, NULL, 8, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (70, 'IN4-LYTE', 2, 0, NULL, 5, NULL, '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (71, 'CA-500', 1, 1, NULL, 6, 'ณัฐนนท์ ปราณี', '2026-04-21 14:01:55', '2026-04-21 14:01:55');
INSERT INTO `automate_model_time` VALUES (72, 'BT120', 1, 1, NULL, 4, 'ณัฐนนท์', '2026-03-11 15:42:13', '2026-03-11 15:42:13');
INSERT INTO `automate_model_time` VALUES (73, 'BT-60', 1, 1, NULL, 4, 'ณัฐนนท์ ปราณี', '2026-03-04 20:22:34', '2026-03-04 20:22:34');
INSERT INTO `automate_model_time` VALUES (74, 'ALINITY I', 2, 0, NULL, 3, 'ปกรณ์ พุฒิไพรีพ่าย', '2026-04-28 12:18:08', '2026-04-28 12:18:08');
INSERT INTO `automate_model_time` VALUES (75, 'ALINITY CI', 1, 1, NULL, 1, 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-04-06 16:15:04', '2026-04-06 16:15:04');
INSERT INTO `automate_model_time` VALUES (76, 'XL-640 PLUS', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-05 22:30:04', '2026-03-05 22:30:04');
INSERT INTO `automate_model_time` VALUES (77, 'BH-6180', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 11:19:56', '2026-03-10 11:19:56');
INSERT INTO `automate_model_time` VALUES (78, 'C3100', 1, 1, NULL, 6, 'ณัฐนนท์', '2026-03-11 14:27:01', '2026-03-11 14:27:01');
INSERT INTO `automate_model_time` VALUES (79, 'QUIDELSOFIA', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-20 14:44:29', '2026-04-20 14:44:29');
INSERT INTO `automate_model_time` VALUES (80, 'AUTOBIO A1860', 1, 1, NULL, 3, 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-04-06 16:15:04', '2026-04-06 16:15:04');
INSERT INTO `automate_model_time` VALUES (81, 'LAURA XL', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-03-10 14:12:26', '2026-03-10 14:12:26');
INSERT INTO `automate_model_time` VALUES (82, 'SF8050', 1, 1, NULL, 6, 'ณัฐนนท์', '2026-03-11 14:21:13', '2026-03-11 14:21:13');
INSERT INTO `automate_model_time` VALUES (83, 'BT2000', 2, 0, NULL, 1, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (84, 'ARES', 2, 0, NULL, 6, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (85, 'CYBOW 720', 2, 0, NULL, 8, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (86, 'BT3500', 2, 0, NULL, 1, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (87, 'METIS6000', 3, 1, 6, 1, 'วีระยุทธ เนืองกัลยา', '2026-05-11 16:57:00', '2026-05-11 16:57:00');
INSERT INTO `automate_model_time` VALUES (88, 'CM-1000', 2, 0, NULL, 1, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (89, 'AU680', 1, 1, NULL, 1, 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-04-06 16:15:04', '2026-04-06 16:15:04');
INSERT INTO `automate_model_time` VALUES (90, 'URISED2&LABUMAT2', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-03-10 14:15:16', '2026-03-10 14:15:16');
INSERT INTO `automate_model_time` VALUES (91, 'A1CCHEK PRO', 2, 0, NULL, 10, 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-04-25 14:32:35', '2026-04-25 14:32:35');
INSERT INTO `automate_model_time` VALUES (92, 'RAC-1800', 1, 1, NULL, 6, 'ณัฐนนท์ ปราณี', '2026-03-10 16:19:44', '2026-03-10 16:19:44');
INSERT INTO `automate_model_time` VALUES (93, 'BC6000', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 13:08:02', '2026-03-10 13:08:02');
INSERT INTO `automate_model_time` VALUES (94, 'TOSOH G8', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-06 08:53:19', '2026-03-06 08:53:19');
INSERT INTO `automate_model_time` VALUES (95, 'COBAS6000', 2, 0, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-05-16 15:45:17', '2026-05-16 15:45:17');
INSERT INTO `automate_model_time` VALUES (96, 'FUS-3000', 1, 1, NULL, 8, 'ณัฐนนท์', '2026-03-11 16:00:26', '2026-03-11 16:00:26');
INSERT INTO `automate_model_time` VALUES (97, 'TOSOH HLC-723G11', 2, 0, NULL, 10, 'ณัฐนนท์ ปราณี', '2026-02-26 15:19:51', '2026-02-26 15:19:51');
INSERT INTO `automate_model_time` VALUES (98, 'PENTRA 80XL', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 13:20:34', '2026-03-10 13:20:34');
INSERT INTO `automate_model_time` VALUES (99, 'INDIKO PLUS', 1, 1, NULL, 1, 'นรวิชญ์ ศิริลักษณมานนท์', '2026-03-06 15:47:04', '2026-03-06 15:47:04');
INSERT INTO `automate_model_time` VALUES (100, 'URIT-50', 2, 0, NULL, 8, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (101, 'BC-5180', 2, 0, NULL, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (102, 'BC-700', 2, 0, NULL, 2, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (103, 'BC6200', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 13:17:38', '2026-03-10 13:17:38');
INSERT INTO `automate_model_time` VALUES (104, 'D10', 1, 1, NULL, 10, 'ณัฐนนท์ ปราณี', '2026-04-21 09:45:59', '2026-04-21 09:45:59');
INSERT INTO `automate_model_time` VALUES (105, 'CS-2100I', 2, 0, NULL, 6, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (106, 'COBAS PRO', 2, 0, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-05-16 15:45:40', '2026-05-16 15:45:40');
INSERT INTO `automate_model_time` VALUES (107, 'ATELLICA CI', 2, 0, NULL, 1, 'ธนาภูมิ วิไลรัตน์', '2025-12-24 12:02:52', '2025-12-24 12:02:52');
INSERT INTO `automate_model_time` VALUES (108, 'VERSATREK', 2, 0, NULL, 4, 'นรภัทร วงษ์สวัสดิ์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (109, 'ATELLICA (CH930+IM1300)', 2, 0, NULL, 1, 'ธนาภูมิ วิไลรัตน์', '2025-12-24 12:02:26', '2025-12-24 12:02:26');
INSERT INTO `automate_model_time` VALUES (110, 'COBAS C503', 2, 0, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-07 15:21:27', '2026-04-07 15:21:27');
INSERT INTO `automate_model_time` VALUES (111, 'EU5300', 2, 0, NULL, 8, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (112, 'EDENI15', 2, 0, NULL, 7, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (113, 'ORTHO VISION', 2, 0, NULL, 9, 'พีรณัฐ แสงรัตน์', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (114, 'H100', 1, 1, NULL, 10, 'ณัฐนนท์ ปราณี', '2026-03-05 22:24:32', '2026-03-05 22:24:32');
INSERT INTO `automate_model_time` VALUES (115, 'US2000C', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-22 13:42:38', '2026-04-22 13:42:38');
INSERT INTO `automate_model_time` VALUES (116, 'SA120', 2, 0, NULL, 9, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (117, 'COBAS E411', 2, 0, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-05-16 15:45:49', '2026-05-16 15:45:49');
INSERT INTO `automate_model_time` VALUES (118, 'VITROS XT7600', 1, 1, NULL, 1, 'นรวิชญ์ ศิริลักษณมานนท์', '2026-03-16 12:53:59', '2026-03-16 12:53:59');
INSERT INTO `automate_model_time` VALUES (119, 'CAL6000', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-13 09:34:41', '2026-03-13 09:34:41');
INSERT INTO `automate_model_time` VALUES (120, 'ACON-U500', 2, 0, NULL, 8, 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-04-25 14:32:35', '2026-04-25 14:32:35');
INSERT INTO `automate_model_time` VALUES (121, 'ARCHITECT I2000 SR', 2, 0, NULL, 3, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (122, 'SEBIA MINI CAP', 2, 0, NULL, 2, 'รงค์รวี ศรีกระภา', '2025-09-26 22:41:50', '2025-09-26 22:41:50');
INSERT INTO `automate_model_time` VALUES (123, 'LB12', 1, 1, NULL, 9, 'ณัฐนนท์ ปราณี', '2026-05-16 15:46:04', '2026-05-16 15:46:04');
INSERT INTO `automate_model_time` VALUES (124, 'AU5800', 2, 0, NULL, 1, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:51:02', '2025-11-25 16:51:02');
INSERT INTO `automate_model_time` VALUES (125, 'XL-640 WITH ISE', 2, 0, NULL, 1, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 16:51:01', '2025-11-25 16:51:01');
INSERT INTO `automate_model_time` VALUES (126, 'BC-5600', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-04-20 11:59:36', '2026-04-20 11:59:36');
INSERT INTO `automate_model_time` VALUES (127, 'INTEGRA 400 PLUS', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-21 12:10:16', '2026-04-21 12:10:16');
INSERT INTO `automate_model_time` VALUES (128, 'YUMIZEN G800', 1, 1, NULL, 6, 'ณัฐนนท์ ปราณี', '2026-04-20 08:46:37', '2026-04-20 08:46:37');
INSERT INTO `automate_model_time` VALUES (129, 'YUMIZENG800', 2, 0, NULL, 6, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:50:52', '2025-11-25 16:50:52');
INSERT INTO `automate_model_time` VALUES (130, 'C8000', 2, 0, NULL, 1, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 16:59:45', '2025-11-25 16:59:45');
INSERT INTO `automate_model_time` VALUES (131, 'BA400', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-20 10:19:36', '2026-04-20 10:19:36');
INSERT INTO `automate_model_time` VALUES (132, 'VITROS 3600', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-12 11:18:45', '2026-03-12 11:18:45');
INSERT INTO `automate_model_time` VALUES (133, 'YUMIZEN H1500', 2, 0, NULL, 2, 'ธนาภูมิ วิไลรัตน์', '2025-11-25 16:50:47', '2025-11-25 16:50:47');
INSERT INTO `automate_model_time` VALUES (134, 'HISCL-800', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-20 14:15:24', '2026-04-20 14:15:24');
INSERT INTO `automate_model_time` VALUES (135, 'I2000SR', 2, 0, NULL, 3, 'นรภัทร วงษ์สวัสดิ์', '2025-11-25 17:01:00', '2025-11-25 17:01:00');
INSERT INTO `automate_model_time` VALUES (136, 'LD-600', 2, 0, NULL, 10, 'ดนุภัทร สังสีแก้ว', '2025-12-05 09:59:53', '2025-12-05 09:59:53');
INSERT INTO `automate_model_time` VALUES (137, 'XNL-550', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-03-10 11:27:17', '2026-03-10 11:27:17');
INSERT INTO `automate_model_time` VALUES (138, 'PREMIER RESOLUTION', 1, 1, NULL, 2, 'ณัฐนนท์', '2026-03-11 16:16:34', '2026-03-11 16:16:34');
INSERT INTO `automate_model_time` VALUES (139, 'DL96A', 3, 1, 6, 4, 'วีระยุทธ เนืองกัลยา', '2026-05-11 16:57:00', '2026-05-11 16:57:00');
INSERT INTO `automate_model_time` VALUES (140, 'LB24', 2, 0, NULL, 9, 'ณัฐนนท์ ปราณี', '2026-01-21 19:24:03', '2026-01-21 19:24:03');
INSERT INTO `automate_model_time` VALUES (141, 'MACCURAH2600', 1, 1, NULL, 6, 'ณัฐนนท์ ปราณี', '2026-03-30 09:01:07', '2026-03-30 09:01:07');
INSERT INTO `automate_model_time` VALUES (142, 'IRICELL3000', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-03-11 16:38:51', '2026-03-11 16:38:51');
INSERT INTO `automate_model_time` VALUES (143, 'MACCURA I1000', 2, 0, NULL, 3, 'รงค์รวี ศรีกระภา', '2026-01-29 16:25:16', '2026-01-29 16:25:16');
INSERT INTO `automate_model_time` VALUES (144, 'BS-620M', 1, 1, NULL, 1, 'ธนาภูมิ วิไลรัตน์', '2026-03-05 21:34:34', '2026-03-05 21:34:34');
INSERT INTO `automate_model_time` VALUES (145, 'SAL6000', 2, 0, NULL, 1, 'ธนาภูมิ วิไลรัตน์', '2026-02-06 18:19:04', '2026-02-06 18:19:04');
INSERT INTO `automate_model_time` VALUES (146, 'KEYU KU-2800', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-03-12 11:47:18', '2026-03-12 11:47:18');
INSERT INTO `automate_model_time` VALUES (147, 'US-1800', 2, 0, NULL, 8, 'พีรณัฐ แสงรัตน์', '2026-02-17 18:00:52', '2026-02-17 18:00:52');
INSERT INTO `automate_model_time` VALUES (148, 'CA-660', 1, 1, NULL, 6, 'ณัฐนนท์ ปราณี', '2026-05-16 16:05:18', '2026-05-16 16:05:18');
INSERT INTO `automate_model_time` VALUES (149, 'UN-2000', 2, 0, NULL, 8, 'พีรณัฐ แสงรัตน์', '2026-02-18 12:59:44', '2026-02-18 12:59:44');
INSERT INTO `automate_model_time` VALUES (150, 'RAPID POINT 500', 1, 1, NULL, 7, 'ณัฐนนท์ ปราณี', '2026-04-22 10:39:58', '2026-04-22 10:39:58');
INSERT INTO `automate_model_time` VALUES (151, 'LABUREADER PLUS2 & URISED MINI', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-20 16:27:19', '2026-04-20 16:27:19');
INSERT INTO `automate_model_time` VALUES (152, 'AFR-400S', 2, 0, NULL, 3, 'พีรณัฐ แสงรัตน์', '2026-02-19 13:17:54', '2026-02-19 13:17:54');
INSERT INTO `automate_model_time` VALUES (153, 'ZYBIO Q8 PRO', 2, 0, NULL, 3, 'พีรณัฐ แสงรัตน์', '2026-02-19 13:19:30', '2026-02-19 13:19:30');
INSERT INTO `automate_model_time` VALUES (154, 'MACCURA I800', 1, 1, NULL, 3, 'ผู้ปฏิบัติ (ข้ามแผนก)', '2026-04-06 16:15:04', '2026-04-06 16:15:04');
INSERT INTO `automate_model_time` VALUES (155, 'ISE ON XL-1000', 2, 0, NULL, 5, 'นรภัทร วงษ์สวัสดิ์', '2026-03-09 10:41:33', '2026-03-09 10:41:33');
INSERT INTO `automate_model_time` VALUES (156, 'KEYU KU-F20', 1, 1, NULL, 12, 'ณัฐนนท์ ปราณี', '2026-03-13 08:55:49', '2026-03-13 08:55:49');
INSERT INTO `automate_model_time` VALUES (157, 'XR3000', 2, 0, NULL, 2, 'ปกรณ์ พุฒิไพรีพ่าย', '2026-05-14 19:50:48', '2026-05-14 19:50:48');
INSERT INTO `automate_model_time` VALUES (158, 'ABL 90', 3, 1, 6, 7, 'วีระยุทธ เนืองกัลยา', '2026-05-11 16:57:00', '2026-05-11 16:57:00');
INSERT INTO `automate_model_time` VALUES (159, 'SENSITITRE ARIS2X', 2, 0, NULL, 8, 'มูฮัมหมัด หะยีสะอุ', '2026-03-31 16:49:19', '2026-03-31 16:49:19');
INSERT INTO `automate_model_time` VALUES (160, 'RX IMOLA', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-20 09:03:07', '2026-04-20 09:03:07');
INSERT INTO `automate_model_time` VALUES (161, 'BX4000', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-20 10:11:13', '2026-04-20 10:11:13');
INSERT INTO `automate_model_time` VALUES (162, 'URIT-910PLUS', 1, 1, NULL, 7, 'ณัฐนนท์ ปราณี', '2026-04-20 10:44:32', '2026-04-20 10:44:32');
INSERT INTO `automate_model_time` VALUES (163, 'BX3010', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-20 11:13:39', '2026-04-20 11:13:39');
INSERT INTO `automate_model_time` VALUES (164, 'URISCAN PRO II', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-20 11:24:06', '2026-04-20 11:24:06');
INSERT INTO `automate_model_time` VALUES (165, 'ARCHITECT PLUS I1000 SR', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-20 12:35:18', '2026-04-20 12:35:18');
INSERT INTO `automate_model_time` VALUES (166, 'DIMENSION EXL 200', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-20 12:45:46', '2026-04-20 12:45:46');
INSERT INTO `automate_model_time` VALUES (167, 'ADVIA CENTAUR XPT', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-22 10:33:46', '2026-04-22 10:33:46');
INSERT INTO `automate_model_time` VALUES (168, 'UN2000', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-20 13:33:33', '2026-04-20 13:33:33');
INSERT INTO `automate_model_time` VALUES (169, 'GEM3000', 1, 1, NULL, 7, 'ณัฐนนท์ ปราณี', '2026-04-20 14:38:50', '2026-04-20 14:38:50');
INSERT INTO `automate_model_time` VALUES (170, 'COBAS C501', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-20 14:54:13', '2026-04-20 14:54:13');
INSERT INTO `automate_model_time` VALUES (171, 'PENTRA 60', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-04-20 15:06:32', '2026-04-20 15:06:32');
INSERT INTO `automate_model_time` VALUES (172, 'GETEIN-1600', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-20 15:19:03', '2026-04-20 15:19:03');
INSERT INTO `automate_model_time` VALUES (173, 'AUDICOM', 1, 1, NULL, 5, 'ณัฐนนท์ ปราณี', '2026-04-20 15:27:01', '2026-04-20 15:27:01');
INSERT INTO `automate_model_time` VALUES (174, 'CYBOW 300', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-20 15:59:33', '2026-04-20 15:59:33');
INSERT INTO `automate_model_time` VALUES (175, 'DIRUI-H800', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-20 16:20:53', '2026-04-20 16:20:53');
INSERT INTO `automate_model_time` VALUES (176, 'AIA 360', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-21 09:55:04', '2026-04-21 09:55:04');
INSERT INTO `automate_model_time` VALUES (177, 'KONELAB 30', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-21 10:04:39', '2026-04-21 10:04:39');
INSERT INTO `automate_model_time` VALUES (178, 'CYAN MINI', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-21 10:29:32', '2026-04-21 10:29:32');
INSERT INTO `automate_model_time` VALUES (179, 'DXH600', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-04-21 10:43:17', '2026-04-21 10:43:17');
INSERT INTO `automate_model_time` VALUES (180, 'DXH500', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-04-21 10:58:55', '2026-04-21 10:58:55');
INSERT INTO `automate_model_time` VALUES (181, 'BC5300', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-04-21 11:15:04', '2026-04-21 11:15:04');
INSERT INTO `automate_model_time` VALUES (182, 'BS6000', 1, 1, NULL, 1, 'ณัฐนนท์ ปราณี', '2026-04-21 12:21:34', '2026-04-21 12:21:34');
INSERT INTO `automate_model_time` VALUES (183, 'FUS-100', 1, 1, NULL, 8, 'ณัฐนนท์ ปราณี', '2026-04-21 14:14:06', '2026-04-21 14:14:06');
INSERT INTO `automate_model_time` VALUES (184, 'XI-931BT', 1, 1, NULL, 5, 'ณัฐนนท์ ปราณี', '2026-04-21 14:42:14', '2026-04-21 14:42:14');
INSERT INTO `automate_model_time` VALUES (185, 'M2000', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-22 10:07:55', '2026-04-22 10:07:55');
INSERT INTO `automate_model_time` VALUES (186, 'ADVIA CENTAUR', 2, 0, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-25 14:32:35', '2026-04-25 14:32:35');
INSERT INTO `automate_model_time` VALUES (187, 'AE-180', 1, 1, NULL, 3, 'ณัฐนนท์ ปราณี', '2026-04-22 13:07:13', '2026-04-22 13:07:13');
INSERT INTO `automate_model_time` VALUES (188, 'ELITE 580', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-04-22 13:18:25', '2026-04-22 13:18:25');
INSERT INTO `automate_model_time` VALUES (189, 'URIT-8280', 1, 1, NULL, 2, 'ณัฐนนท์ ปราณี', '2026-04-22 13:54:54', '2026-04-22 13:54:54');
INSERT INTO `automate_model_time` VALUES (190, 'AUTOBIO AUTOMIC-I600', 2, 0, NULL, 13, 'รงค์รวี ศรีกระภา', '2026-04-30 15:03:58', '2026-04-30 15:03:58');
INSERT INTO `automate_model_time` VALUES (191, 'MAGICL6000', 3, 1, 6, 3, 'วีระยุทธ เนืองกัลยา', '2026-05-11 16:57:00', '2026-05-11 16:57:00');
INSERT INTO `automate_model_time` VALUES (192, 'CL1000 PRO', 3, 1, 6, 6, 'วีระยุทธ เนืองกัลยา', '2026-05-11 16:57:00', '2026-05-11 16:57:00');
INSERT INTO `automate_model_time` VALUES (193, 'DHX900', 2, 0, NULL, 2, 'พีรณัฐ แสงรัตน์', '2026-05-15 09:20:40', '2026-05-15 09:20:40');
INSERT INTO `automate_model_time` VALUES (194, 'RICELL IRIS 3000', 2, 0, NULL, 8, 'พีรณัฐ แสงรัตน์', '2026-05-15 09:36:14', '2026-05-15 09:36:14');

SET FOREIGN_KEY_CHECKS = 1;
