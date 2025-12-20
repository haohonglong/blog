-- creat dataBase
DROP DATABASE IF EXISTS `blog`;
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blog`;


DROP TABLE IF EXISTS `_user`;
CREATE TABLE `_user` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户注册名是唯一的 只能是邮箱名称',
  `password` varchar(100) NOT NULL COMMENT '用户密码',
  `active` varchar(32)  COMMENT '邮箱激活码',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册日期',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册日期',
  `role` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户级别： 默认0 没有管理权限一般用户 ，1:普通管理员，2:二级管理员，3:超级管理员',
  `ip` varchar(15) NOT NULL DEFAULT '0' COMMENT '用bigint来记录inet_aton值 。最后一次登陆ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';



DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '',
  `password_reset_token` varchar(100) NOT NULL UNIQUE COMMENT '',
  `auth_key` varchar(32) NOT NULL UNIQUE COMMENT 'cookie验证auth_key',
  `email` varchar(255) NOT NULL UNIQUE COMMENT '用户邮箱',
  `active` CHAR(32)  COMMENT '激活码',
  `avatar` varchar(255)  COMMENT '用户头像url',
  `phone` varchar(255) NOT NULL UNIQUE COMMENT '注册手机号',
  `wallet` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '钱包',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可见 默认是1 显示，0 ： 不显示',
  `ip` varchar(15) NOT NULL DEFAULT '0' COMMENT '用bigint来记录inet_aton值 。最后一次登陆ip',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY(email)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';
ALTER TABLE `user` ADD `wallet` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '钱包' AFTER `phone`;

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL COMMENT '角色名',
  `role_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '角色描述',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色表';

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) COMMENT '用户id',
  `role_id` int(10) COMMENT '角色id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户关联角色表';






DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `sorts_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT 'the title of article',
  `content` LONGTEXT NOT NULL COMMENT 'the content of article',
  `cdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time',
  `udate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'update time',
  `is_show` CHAR NOT NULL DEFAULT '1' COMMENT '是否显示 默认是1 显示，0 ： 不显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the article table';


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) UNSIGNED NOT NULL COMMENT 'the id of article',
  `posts_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '对应回复的帖子',
  `content` text NOT NULL COMMENT 'the content of posts',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time ',
  `ip` VARCHAR (15) NOT NULL DEFAULT '0' COMMENT 'ip',
  `is_show` CHAR NOT NULL DEFAULT '1' COMMENT '是否显示 默认是1 显示，0 ： 不显示',
  PRIMARY KEY (`id`),
  FOREIGN KEY (article_id) REFERENCES article(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the posts table';



DROP TABLE IF EXISTS `sorts`;
CREATE TABLE `sorts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int UNSIGNED NOT NULL DEFAULT 0 COMMENT 'the parent id of sorts',
  `name` VARCHAR(100)  NOT NULL COMMENT 'the name of sort',
  `code` VARCHAR(15) COMMENT '类别编号',
  PRIMARY KEY (`id`),
  UNIQUE (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the sort table';

ALTER TABLE `sorts` ADD `code` VARCHAR(15) COMMENT '类别编号' AFTER `name`;
insert into `blog`.`sorts` (id,name) (select id,name from `management_of_system`.`sorts`)

DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) UNSIGNED NOT NULL COMMENT '投票的类型 1：差；2：一般；3：好',
  `article_id` int(11) UNSIGNED NOT NULL COMMENT 'the id of article',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time',
  `ip` varchar(15) NOT NULL DEFAULT '0' COMMENT '投票用户的ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the vote table';


DROP TABLE IF EXISTS `url`;
CREATE TABLE IF NOT EXISTS `url` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(516) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'create time ',
  `sorts_id` tinyint(3) UNSIGNED NOT NULL COMMENT '当前信息属于哪个类别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `points`  INT(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分',
	PRIMARY KEY(`id`),
	UNIQUE (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商店';
ALTER TABLE `shop` ADD `points` INT(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分' AFTER `name`;

DROP TABLE IF EXISTS `goods`;
CREATE TABLE IF NOT EXISTS `goods`(
	`id`     	INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`uid`     INT UNSIGNED NOT NULL,
	`shop_id` INT UNSIGNED NOT NULL COMMENT '超市id',
	`bill_id` VARCHAR(23) NOT NULL DEFAULT '' COMMENT '账单号',
	`name`  	VARCHAR(255) NOT NULL COMMENT '名称',
  `goodsname_id` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品名id',
  `code` VARCHAR(23) COMMENT '商品条形码号' AFTER `name`,
	`number`  	INT UNSIGNED NOT NULL DEFAULT 1 COMMENT '数量',
	`weight` INT UNSIGNED NOT NULL COMMENT '重量',
  `unit_id` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '计量单位id',
	`single_price` DECIMAL(19,2) NOT NULL COMMENT '单价',
	`final_price` DECIMAL(19,2) NOT NULL COMMENT '商品结算价格',
	`create_by` int NOT NULL COMMENT '',
	`update_by` int NOT NULL COMMENT '',
	PRIMARY KEY(`id`),
  FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (`goodsname_id`) REFERENCES `goodsname` (`goodsname_id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '购物清单';
ALTER TABLE `goods` ADD `unit_id` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '计量单位id' AFTER `weight`;
ALTER TABLE `goods` ADD `goodsname_id` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品名id' AFTER `name`;
ALTER TABLE `goods` ADD `code` VARCHAR(23) COMMENT '商品条形码号' AFTER `name`;
ALTER TABLE `goods` ADD FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `goods` ADD FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `goods` ADD FOREIGN KEY (`goodsname_id`) REFERENCES `goodsname` (`goodsname_id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `goods` ADD FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`) ON UPDATE CASCADE ON DELETE RESTRICT;

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills`(
	`bill_id`  VARCHAR(23) NOT NULL  COMMENT '账单号',
	`shop_id`  INT UNSIGNED NOT NULL COMMENT '超市id',
	`discount` DECIMAL(19,2) NOT NULL DEFAULT '0' COMMENT '折扣',
	`price`    DECIMAL(19,2) NOT NULL DEFAULT '0' COMMENT '账单价格',
  `points` FLOAT UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分',
	`create_at` int NOT NULL COMMENT '',
	`update_at` int NOT NULL COMMENT '',
	PRIMARY KEY(`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '账单';

-- 会议记录管理
DROP TABLE IF EXISTS `meeting_info`;
CREATE TABLE IF NOT EXISTS `meeting_info`(
	`meeting_id`  VARCHAR(23) PRIMARY KEY NOT NULL COMMENT '会议编号',
  `meeting_name` VARCHAR(12) NOT NULL COMMENT '会议名称',
  `meeting_place` VARCHAR(32) NOT NULL COMMENT '会议地点',
  `meeting_anchor` VARCHAR(12) NOT NULL COMMENT '会议主持人',
  `meeting_recorder` VARCHAR(12) NOT NULL COMMENT '会议记录人',
  `meeting_present` VARCHAR(12) NOT NULL COMMENT '会议出席人员',
  `meeting_abstract` VARCHAR(256) NOT NULL COMMENT '会议摘要',
  `meeting_doc_addres` VARCHAR(23) COMMENT '文档地址',
	`meeting_create_at` int NOT NULL COMMENT '',
	`meeting_update_at` int NOT NULL COMMENT ''
	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '会议信息';

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department`(
	`department_id`  VARCHAR(23) PRIMARY KEY NOT NULL COMMENT '部门ID',
  `department_name` VARCHAR(12) NOT NULL COMMENT '部门名称'
	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '部门信息';


DROP TABLE IF EXISTS `diary`;
CREATE TABLE IF NOT EXISTS `diary`(
	`id` int(23) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL COMMENT '',
  `content` VARCHAR(500) NOT NULL COMMENT '',
  `created_at` int(11) NOT NULL COMMENT '',
  `updated_at` int(11) NOT NULL COMMENT '',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可见 默认是1 显示，0 ： 不显示',
  PRIMARY KEY(`id`)
	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '记事簿';

DROP TABLE IF EXISTS `mindmaps`;
CREATE TABLE IF NOT EXISTS `mindmaps`(
  `id` int(23) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(23) UNIQUE NOT NULL COMMENT '',
  `name` varchar(23) UNIQUE NOT NULL COMMENT '',
  `thumbnail` varchar(500) DEFAULT '' COMMENT '缩略图',
  `content` text NOT NULL COMMENT 'json 数据',
  `remark` varchar(1000) DEFAULT '' COMMENT '备注',
  `created_at` int(11) NOT NULL COMMENT '',
  `updated_at` int(11) NOT NULL COMMENT '',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可见 默认是1 显示，0 ： 不显示',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '思维导图';




-- mall

DROP TABLE IF EXISTS `tb_item`;
CREATE TABLE IF NOT EXISTS `tb_item`(
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `sell_point` varchar(500) DEFAULT NULL COMMENT '卖点',
  `price` bigint(20) NOT NULL COMMENT '单位：分',
  `num` int(10) NOT NULL COMMENT '库存数量',
  `barcode` varchar(30) DEFAULT NULL COMMENT '商品条形码',
  `image` varchar(500) DEFAULT NULL COMMENT '商品图片，逗号分隔多张',
  `cid` bigint(10) NOT NULL COMMENT '商品类别',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品状态, 1:正常，2:下架，3:删除',
  `created` datetime NOT NULL COMMENT '创建时间',
  `updated` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY(`id`),
  KEY `status` (`status`),
  KEY `updated` (`updated`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品表';



DROP TABLE IF EXISTS `tb_item_cat`;
CREATE TABLE IF NOT EXISTS `tb_item_cat`(
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) DEFAULT NULL COMMENT '父类目id=0时，代表是一级类目',
  `name` varchar(50) DEFAULT NULL COMMENT '',
  `status` int(1) DEFAULT '1' COMMENT '1:正常，2:删除',
  `sort_order` int(4) DEFAULT NULL COMMENT '序列号，同级类目的展现次序，如果值相等则按名称次序排列',
  `is_parent` tinyint(1) DEFAULT '1' COMMENT '该类目是否为父类目，1:true, 0:false',
  `created` datetime NOT NULL COMMENT '创建时间',
  `updated` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY(`id`),
  KEY `parent_id` (`parent_id`, `status`) USING BTREE,
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品类目表';

DROP TABLE IF EXISTS `tb_item_desc`;
CREATE TABLE IF NOT EXISTS `tb_item_desc`(
  `item_id` bigint(20) UNSIGNED NOT NULL COMMENT '商品id',
  `item_desc` text COMMENT '商品描述',
  `created` datetime NOT NULL COMMENT '创建时间',
  `updated` datetime NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品描述表';


DROP TABLE IF EXISTS `tb_item_param`;
CREATE TABLE IF NOT EXISTS `tb_item_param`(
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_cat_id` bigint(20) DEFAULT NULL COMMENT '商品类目ID',
  `param_data` text COMMENT '参数数据 json格式',
  `created` datetime NOT NULL COMMENT '创建时间',
  `updated` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY(`id`),
  KEY `item_cat_id` (`item_cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品规格参数表';

DROP TABLE IF EXISTS `tb_item_param_item`;
CREATE TABLE IF NOT EXISTS `tb_item_param_item`(
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) DEFAULT NULL COMMENT '商品id',
  `param_data` text COMMENT '参数数据 json格式',
  `created` datetime NOT NULL COMMENT '创建时间',
  `updated` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY(`id`),
  KEY `item_id` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品规格参数和商品的关系表';


DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks`(
	`id`     	INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`title`  	VARCHAR(255) NOT NULL COMMENT '',
  `content` VARCHAR(500) NOT NULL COMMENT '',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '',
  `done_at` int(11) NOT NULL DEFAULT '0' COMMENT '',
	`status` 	tinyint(1) NOT NULL DEFAULT '0' COMMENT '任务状态  未完成：0 ，完成：1',
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '计划任务';


DROP TABLE IF EXISTS `goodsname`;
CREATE TABLE `goodsname` (
  `goodsname_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `goodsname` VARCHAR(64)  NOT NULL COMMENT 'the name of the goods',
  PRIMARY KEY (`goodsname_id`),
  UNIQUE (`goodsname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='the goodsname table';

DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `unit_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `unit_name` VARCHAR(11)  NOT NULL COMMENT 'the name of the unit',
  PRIMARY KEY (`unit_id`),
  UNIQUE (`unit_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='计量单位';

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `stock_id` VARCHAR(12) NOT NULL,
  `stock_code` VARCHAR(12) NOT NULL COMMENT 'the code of the stock',
  `stock_name` VARCHAR(128)  NOT NULL COMMENT 'the name of the stock',
  `stock_price` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '最新股票价格',
  `bought` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '买入时的价格',
  `cost` DECIMAL(19,4) COMMENT '成本',
  `tax` DECIMAL(19,3) NOT NULL DEFAULT '5.00' COMMENT '税',
  `stock_number` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '持有股票的数量',
  `open` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天开盘价',
  `close` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '收盘价',
  `lup` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '涨停',
  `ldown` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '跌停',
  `hight` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天最高价',
  `low` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天最低价',
  `average` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天均价',
  `change` DECIMAL(19,2) NOT NULL DEFAULT '0.00' COMMENT '换手率unit:%',
  `amplitude` DECIMAL(19,2) NOT NULL DEFAULT '0.00' COMMENT '振幅率unit:%',
  `volume` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '成交量',
  `amount` DECIMAL(19,2) NOT NULL DEFAULT '0' COMMENT '成交额',
  `stock_remark` varchar(1000) DEFAULT '' COMMENT '备注',
  `level` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '星级推荐',
  `flag` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '1: testing',
  `created_at` DATETIME NOT NULL DEFAULT '1970-01-01 00:00:01' COMMENT '',
  `updated_at` DATETIME NOT NULL DEFAULT '1970-01-01 00:00:01' COMMENT '',
  PRIMARY KEY (`stock_id`),
  UNIQUE (`stock_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='股票';
ALTER TABLE `stock` 
ADD `cost` DECIMAL(19,4) COMMENT '成本' AFTER `bought`,
ADD `tax` DECIMAL(19,3) NOT NULL DEFAULT '5.00' COMMENT '税' AFTER `cost`,
ADD `flag` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '1: testing' AFTER `level`,
ADD `stock_code` VARCHAR(12) NOT NULL COMMENT 'the code of the stock' AFTER `stock_id`;


DROP TABLE IF EXISTS `stock_daily`;
CREATE TABLE `stock_daily` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_date_at` DATE NOT NULL COMMENT '每天股价的日期',
  `stock_id` VARCHAR(12) NOT NULL COMMENT '',
  `stock_price` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每股价格',
  `open` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天开盘价',
  `close` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '收盘价',
  `lup` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '涨停',
  `ldown` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '跌停',
  `hight` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天最高价',
  `low` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天最低价',
  `average` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天均价',
  `change` DECIMAL(19,2) NOT NULL DEFAULT '0.00' COMMENT '换手率unit:%',
  `amplitude` DECIMAL(19,2) NOT NULL DEFAULT '0.00' COMMENT '振幅率unit:%',
  `volume` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '成交量',
  `amount` DECIMAL(19,2) NOT NULL DEFAULT '0' COMMENT '成交额',
  `created_at` DATETIME NOT NULL COMMENT '',
  `updated_at` DATETIME NOT NULL COMMENT '',
  PRIMARY KEY (`id`),
  UNIQUE INDEX uk_stock_id_stock_date_at (stock_id, stock_date_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='股票每日的相关信息';
ALTER TABLE `stock_daily` 
ADD UNIQUE INDEX uk_stock_id_stock_date_at (stock_id, stock_date_at),
ADD `volume` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '成交量' AFTER `amplitude`,
ADD `amount` DECIMAL(19,2) NOT NULL DEFAULT '0' COMMENT '成交额' AFTER `volume`;
ADD `stock_price` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每股价格' AFTER `stock_id`;


DROP TABLE IF EXISTS `stock_detail`;
CREATE TABLE `stock_detail` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_id` VARCHAR(12) NOT NULL,
  `stock_price` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每股价格',
  `stock_deal_total` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '成交的数量',
  `stock_type` 	tinyint(1) DEFAULT '0' COMMENT '交易类别: 1买入,2卖出',
  `stock_number` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '持有股票的数量的历史记录',
  `stock_date_at` DATE NOT NULL COMMENT 'date',
  `stock_time_at` TIME NOT NULL COMMENT 'time',
  `created_at` DATETIME NOT NULL COMMENT '',
  `open` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天开盘价',
  `close` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '收盘价',
  `lup` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '涨停',
  `ldown` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '跌停',
  `hight` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天最高价',
  `low` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天最低价',
  `average` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '每天均价',
  `change` DECIMAL(19,2) NOT NULL DEFAULT '0.00' COMMENT '换手率unit:%',
  `amplitude` DECIMAL(19,2) NOT NULL DEFAULT '0.00' COMMENT '振幅率unit:%',
  `volume` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '成交量',
  `amount` DECIMAL(19,2) NOT NULL DEFAULT '0' COMMENT '成交额',
  `profit` DECIMAL(19,2) NOT NULL DEFAULT '0' COMMENT '利润',
  `gone` 	tinyint(1) DEFAULT '0' COMMENT '是否清仓: 0否,1是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='股票实时价格流水';
ALTER TABLE `stock_detail` 
ADD `gone` 	tinyint(1) DEFAULT '0' COMMENT '是否清仓: 0否,1是' AFTER `profit`,
MODIFY `volume` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '成交量',
ADD `profit` DECIMAL(19,2) NOT NULL DEFAULT '0.00' COMMENT '利润' AFTER `amount`;

-- 核心查询索引
ALTER TABLE `stock_detail` ADD INDEX `idx_stock_id_type` (`stock_id`, `stock_type`);
ALTER TABLE `stock_detail` ADD INDEX `idx_stock_id_gone` (`stock_id`, `gone`);
ALTER TABLE `stock_detail` ADD INDEX `idx_stock_id_created` (`stock_id`, `created_at`);
ALTER TABLE `stock_detail` ADD INDEX `idx_stock_date` (`stock_date_at`);
-- 复合索引用于复杂查询
ALTER TABLE `stock_detail` ADD INDEX `idx_stock_id_type_gone` (`stock_id`, `stock_type`, `gone`);
ALTER TABLE `stock_detail` ADD INDEX `idx_stock_id_created_gone` (`stock_id`, `created_at`, `gone`);




DROP TABLE IF EXISTS `stock_history`;
CREATE TABLE `stock_history` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `userid` int(11) UNSIGNED NOT NULL COMMENT '',
  `stock_id` VARCHAR(12) NOT NULL,
  `stock_detail_id` INT UNSIGNED NOT NULL COMMENT '流水ID',
  `stock_price` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '成交价',
  `cost` decimal(19,4) COMMENT '成本',
  `tax` DECIMAL(19,3) COMMENT '税',
  `stock_deal_total` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '成交数量',
  `stock_remain` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '剩余股票的数量',
  `stock_type` 	tinyint(1) DEFAULT '1' COMMENT '交易类别: 1买入,2卖出',
  `gone` 	tinyint(1) DEFAULT '0' COMMENT '是否清仓: 0否,1是',
  `stock_remark` varchar(1000) DEFAULT '' COMMENT '备注',
  `created_at` DATETIME NOT NULL COMMENT '交易日期',
  `updated_at` DATETIME NOT NULL COMMENT '成本设定日期',
  PRIMARY KEY (`id`),
  UNIQUE (`stock_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='交易历史';
ALTER TABLE `stock_history` 
ADD `gone` 	tinyint(1) DEFAULT '0' COMMENT '是否清仓: 0否,1是' AFTER `stock_type`,
ADD `stock_remain` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '剩余股票的数量' AFTER `stock_deal_total`,
ADD `tax` DECIMAL(19,3) NOT NULL DEFAULT '5.00' COMMENT '税' AFTER `stock_price`,
ADD `stock_detail_id` INT UNSIGNED COMMENT '流水ID' AFTER `stock_id`,
-- ADD UNIQUE (stock_detail_id),
ADD `cost` DECIMAL(19,3) COMMENT '成本' AFTER `stock_detail_id`;


DROP TABLE IF EXISTS `user_stock`;
CREATE TABLE `user_stock` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `userid` int(11) UNSIGNED NOT NULL COMMENT '',
  `stock_id` VARCHAR(12) NOT NULL,
  `bought` DECIMAL(19,3) NOT NULL DEFAULT '0.000' COMMENT '买入时的价格',
  `cost` DECIMAL(19,4) COMMENT '成本',
  `tax` DECIMAL(19,3) NOT NULL DEFAULT '5.00' COMMENT '税',
  `stock_deal_total` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '成交数量',
  `stock_remain` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '剩余股票的数量',
  `flag` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '1: testing',
  `gone` 	tinyint(1) DEFAULT '0' COMMENT '是否清仓: 0否,1是',
  `created_at` DATETIME NOT NULL COMMENT '',
  `updated_at` DATETIME NOT NULL COMMENT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_userid_stock_id` (`userid`,`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户与股票关联表';
ALTER TABLE `user_stock`
ADD `flag` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '1: testing' AFTER `stock_remain`

