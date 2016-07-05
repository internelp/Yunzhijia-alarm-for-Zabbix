/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.1.73 : Database - alarm_yzj
*********************************************************************
*/
 
 
/*!40101 SET NAMES utf8 */;
 
/*!40101 SET SQL_MODE=''*/;
 
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`alarm_yzj` /*!40100 DEFAULT CHARACTER SET utf8 */;
 
USE `alarm_yzj`;
 
/*Table structure for table `alarm` */
 
DROP TABLE IF EXISTS `alarm`;
 
CREATE TABLE `alarm` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `from` tinyint(3) unsigned NOT NULL COMMENT '来源，哪个系统的报警。',
  `from_server` char(20) DEFAULT '' COMMENT '来源机器名称，可空。',
  `create_time` int(11) unsigned NOT NULL COMMENT '消息创建时间',
  `to` tinyint(3) unsigned NOT NULL COMMENT '接收方的ID。',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '警报的级别：1通知，2警告，3严重，4非常严重，5灾难。',
  `msg` text NOT NULL COMMENT '消息内容，由报警方提出。',
  `msg_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '消息类型（普通消息为1，故障后需要恢复的消息请使用2和3）：1消息，2故障，3恢复',
  `sent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未发送，1已发送。',
  `sent_response` text COMMENT '发消息进程发送消息后的返回值，只用于发送消息后的update操作。',
  `sent_time` int(11) NOT NULL DEFAULT '0' COMMENT '发送消息的时间。',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;