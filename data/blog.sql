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


DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '',
  `password_reset_token` varchar(100) NOT NULL UNIQUE COMMENT '',
  `auth_key` varchar(32) NOT NULL UNIQUE COMMENT 'cookie验证auth_key',
  `email` varchar(255) NOT NULL UNIQUE COMMENT '用户邮箱',
  `avatar` varchar(255)  COMMENT '用户头像url',
  `phone` varchar(255) NOT NULL UNIQUE COMMENT '注册手机号',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可见 默认是1 显示，0 ： 不显示',
  `ip` varchar(15) NOT NULL DEFAULT '0' COMMENT '用bigint来记录inet_aton值 。最后一次登陆ip',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';


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
  PRIMARY KEY (`id`),
  FOREIGN KEY KF_ID (article_id) REFERENCES article(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the posts table';

ALTER TABLE posts ADD CONSTRAINT KF_ID FOREIGN KEY (article_id) REFERENCES article(id);


DROP TABLE IF EXISTS `sorts`;
CREATE TABLE `sorts` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pid` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT 'the parent id of sorts',
  `name` VARCHAR(11)  NOT NULL COMMENT 'the name of sort',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the sort table';
insert into `blog`.`sorts` (id,name) (select id,name from `management_of_system`.`sorts`)

DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL COMMENT '投票的类型 1：差；2：一般；3：好',
  `article_id` int(11) unsigned NOT NULL COMMENT 'the id of article',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time',
  `ip` varchar(15) NOT NULL DEFAULT '0' COMMENT '投票用户的ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the vote table';


DROP TABLE IF EXISTS `url`;
CREATE TABLE IF NOT EXISTS `url` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(516) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time ',
  `sorts_id` tinyint(3) unsigned NOT NULL COMMENT '当前信息属于哪个类别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '资讯图片',
  `author` varchar(100) NOT NULL,
  `pv`  int(10) COMMENT '资讯访问量',
  `content` text COMMENT '资讯内容',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMMENT='资讯';



insert into `blog`.`linkAddress` (name,url,info,date,sorts_id) (select name,url,info,date,sortsId from `management_of_system`.`video_addres`);
ALTER TABLE linkAddress ADD CONSTRAINT SORTS_ID FOREIGN KEY (sorts_id) REFERENCES sorts(id);


--============================================================================================
--视频
--============================================================================================

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video`(
	`id`     	INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`title`  	VARCHAR(500) NOT NULL COMMENT '标题',
	`source` 	text NOT NULL COMMENT '嵌入视频的源码',
	`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '存储视频表';

-- https://www.rr33tt.com/mobile/list/1-0.html
DROP TABLE IF EXISTS `rr33tt_title`;
CREATE TABLE IF NOT EXISTS `rr33tt_title`(
	`id`     	INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`title`  	VARCHAR(255) NOT NULL COMMENT '标题',
	`href` 	VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'href',
	`create_by` int NOT NULL COMMENT 'the created time',
	PRIMARY KEY(`id`),
	UNIQUE (`title`,`href`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '';

DROP TABLE IF EXISTS `rr33tt_list`;
CREATE TABLE IF NOT EXISTS `rr33tt_list`(
	`id`     	INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`sid` INT UNSIGNED NOT NULL,
	`title`  	VARCHAR(255) NOT NULL COMMENT '标题',
	`href` 	VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'href',
	`img` 	VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'img',
	`create_by` int NOT NULL COMMENT 'the created time',
	PRIMARY KEY(`id`),
	UNIQUE (`href`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '';

DROP TABLE IF EXISTS `shop`;
CREATE TABLE IF NOT EXISTS `shop`(
	`id`     	INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name`  	VARCHAR(255) NOT NULL COMMENT '商店名称',
	PRIMARY KEY(`id`),
	UNIQUE (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商店';

DROP TABLE IF EXISTS `goods`;
CREATE TABLE IF NOT EXISTS `goods`(
	`id`     	INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`uid`     INT UNSIGNED NOT NULL,
	`shop_id` INT UNSIGNED NOT NULL COMMENT '超市id',
	`bill_id` VARCHAR(23) NOT NULL DEFAULT '' COMMENT '账单号',
	`name`  	VARCHAR(255) NOT NULL COMMENT '名称',
	`number`  	INT UNSIGNED NOT NULL DEFAULT 1 COMMENT '数量',
	`weight` INT UNSIGNED NOT NULL COMMENT '重量',
	`single_price` DECIMAL(5,2) NOT NULL COMMENT '单价',
	`final_price` DECIMAL(5,2) NOT NULL COMMENT '商品结算价格',
	`create_by` int NOT NULL COMMENT '',
	`update_by` int NOT NULL COMMENT '',
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '购物清单';

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills`(
	`bill_id`  VARCHAR(23) NOT NULL  COMMENT '账单号',
	`shop_id`  INT UNSIGNED NOT NULL COMMENT '超市id',
	`discount` DECIMAL(5,2) NOT NULL DEFAULT '0' COMMENT '折扣',
	`price`    DECIMAL(5,2) NOT NULL DEFAULT '0' COMMENT '账单价格',
	`create_at` int NOT NULL COMMENT '',
	`update_at` int NOT NULL COMMENT '',
	PRIMARY KEY(`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '账单';
