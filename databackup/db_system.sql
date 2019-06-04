/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50714
 Source Host           : localhost:3306
 Source Schema         : db_system

 Target Server Type    : MySQL
 Target Server Version : 50714
 File Encoding         : 65001

 Date: 04/06/2019 20:45:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for db_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `db_admin_user`;
CREATE TABLE `db_admin_user`  (
  `id` int(10) NOT NULL COMMENT '用户id',
  `user_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `user_pass` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登陆密码',
  `explan` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '说明',
  `last_login_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '最后一次登陆ip',
  `last_login_time` int(11) NOT NULL COMMENT '最后一次登陆时间',
  `user_out_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '外部id识别',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_admin_user
-- ----------------------------
INSERT INTO `db_admin_user` VALUES (0, 'admin', 'd6bf4bb9a66419380a7e8b034270d381', '超级管理员', '127.0.0.1', 1559636488, '');

-- ----------------------------
-- Table structure for db_customer
-- ----------------------------
DROP TABLE IF EXISTS `db_customer`;
CREATE TABLE `db_customer`  (
  `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '留言数据Id',
  `customer_name` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客户姓名',
  `customer_phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客户电话',
  `customer_wx` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客户微信或qq',
  `customer_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客户访问ip',
  `customer_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客户访问url',
  `customer_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户留言',
  `admin_id` int(12) NOT NULL COMMENT '所属用户Id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_customer
-- ----------------------------
INSERT INTO `db_customer` VALUES (1, '王测试', '18588888888', 'wx_fdfin', '', '', '', 1);

SET FOREIGN_KEY_CHECKS = 1;
