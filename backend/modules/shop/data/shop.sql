
USE `blog`;


DROP TABLE IF EXISTS `shop_`;
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



