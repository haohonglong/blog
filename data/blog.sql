-- creat dataBase
DROP DATABASE IF EXISTS `blog`;
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blog`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user`(
	`id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
	`name`  	VARCHAR(255) NOT NULL COMMENT '用户注册名是唯一的 只能是邮箱名称',
	`password` 	VARCHAR (100) NOT NULL COMMENT '用户密码',
	`cdate`      datetime NOT NULL DEFAULT NOW() COMMENT '注册日期',
	`udate`      datetime NOT NULL DEFAULT NOW() COMMENT '注册日期',
  `role`     	TINYINT(3) DEFAULT 0 NOT NULL COMMENT '用户级别： 默认0 没有管理权限一般用户 ，1:普通管理员，2:二级管理员，3:超级管理员',
  `ip`        bigint(14) NOT NULL COMMENT '用bigint来记录inet_aton值 。最后一次登陆ip',
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '用户表';


DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'the membership id of blog',
  `title` varchar(255) DEFAULT NULL COMMENT 'the title of article',
  `content` text NOT NULL COMMENT 'the content of article',
  `cdate` datetime NOT NULL DEFAULT NOW() COMMENT 'create time',
  `udate` datetime NOT NULL DEFAULT NOW() COMMENT 'update time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'the article table';


DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `p_userid` int(11) unsigned NOT NULL COMMENT 'the membership id of blog',
  `content` text NOT NULL COMMENT 'the content of posts',
  `date` datetime NOT NULL,
  `ip`        bigint(14) NOT NULL COMMENT 'ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'the posts table';

