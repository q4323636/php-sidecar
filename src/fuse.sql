/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sidecar

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-15 18:41:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for fuse
-- ----------------------------
DROP TABLE IF EXISTS `fuse`;
CREATE TABLE `fuse` (
  `id` varchar(50) NOT NULL DEFAULT '' COMMENT '主键：MD5 url的到的',
  `status` int(11) DEFAULT '0' COMMENT '默认0，如果是时间戳就说明断开，并通过尝试进行打开为0',
  `open_time` int(11) DEFAULT '0' COMMENT '最后一次访问开始的时间',
  `close_times` int(11) DEFAULT '0' COMMENT '最后一次访问结束的时间',
  `success_times` int(11) DEFAULT '0' COMMENT '短时时间内成功的次数',
  `fail_times` int(11) DEFAULT '0' COMMENT '短时间内失败的次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='id就是url的MD5生成的。\r\nopen_time访问开始会填写开始时间，\r\nclose_times访问结束会填写结束时间，\r\nsuccess_times如果成功则不会增加成功的次数\r\nfail_times如果失败则增加失败的次数\r\nstatus如果发现有失败的次数，并且上次时间在10秒以内，\r\n        中间有成功则增加成功次数，失败增加失败次数。\r\n        若达到失败3次以上，则打开state，将其设置为时间戳，在30秒后重试，期间直接返回失败。\r\n';

-- ----------------------------
-- Records of fuse
-- ----------------------------
INSERT INTO `fuse` VALUES ('6b82469cfb3df2b862c3a0fc9796386f', '0', '1552646044', '1552646047', '0', '0');
INSERT INTO `fuse` VALUES ('f482acd84e43d61a25432b29bced6908', '0', '1552646299', '1552646305', '0', '0');
