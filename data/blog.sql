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
  `ip` varchar(15) NOT NULL DEFAULT '0' COMMENT '用bigint来记录inet_aton值 。最后一次登陆ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';


DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `sorts_id` int(11) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT 'the title of article',
  `content` LONGTEXT NOT NULL COMMENT 'the content of article',
  `cdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time',
  `udate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'update time',
  `is_show` CHAR NOT NULL DEFAULT '1' COMMENT '是否显示 默认是1 显示，0 ： 不显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the article table';


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) unsigned NOT NULL COMMENT 'the id of article',
  `posts_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '对应回复的帖子',
  `content` text NOT NULL COMMENT 'the content of posts',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time ',
  `ip` VARCHAR (15) NOT NULL DEFAULT '0' COMMENT 'ip',
  `is_show` CHAR NOT NULL DEFAULT '1' COMMENT '是否显示 默认是1 显示，0 ： 不显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the posts table';


DROP TABLE IF EXISTS `sorts`;
CREATE TABLE `sorts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(11)  NOT NULL COMMENT 'the name of sort',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the sort table';

DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL COMMENT '投票的类型 1：差；2：一般；3：好',
  `article_id` int(11) unsigned NOT NULL COMMENT 'the id of article',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time',
  `ip` varchar(15) NOT NULL DEFAULT '0' COMMENT '投票用户的ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the vote table';


