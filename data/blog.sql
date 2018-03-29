-- creat dataBase
DROP DATABASE IF EXISTS `blog`;
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blog`;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户注册名是唯一的 只能是邮箱名称',
  `password` varchar(100) NOT NULL COMMENT '用户密码',
  `cdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册日期',
  `udate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册日期',
  `role` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户级别： 默认0 没有管理权限一般用户 ，1:普通管理员，2:二级管理员，3:超级管理员',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用bigint来记录inet_aton值 。最后一次登陆ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';


DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT 'the title of article',
  `content` text NOT NULL COMMENT 'the content of article',
  `cdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time',
  `udate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'update time',
  `isshow` CHAR NOT NULL DEFAULT '1' COMMENT '是否显示 默认是1 显示，0 ： 不显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the article table';


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) unsigned NOT NULL COMMENT 'the id of article',
  `content` text NOT NULL COMMENT 'the content of posts',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time ',
  `ip` VARCHAR (15) NOT NULL COMMENT 'ip',
  `isshow` CHAR NOT NULL DEFAULT '1' COMMENT '是否显示 默认是1 显示，0 ： 不显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the posts table';


