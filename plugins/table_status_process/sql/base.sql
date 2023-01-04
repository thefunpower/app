CREATE TABLE IF NOT EXISTS `table_status_process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) DEFAULT NULL COMMENT '表ID值',
  `name` varchar(255) DEFAULT NULL COMMENT '表名称',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `next_user_id` int(11) DEFAULT '0' COMMENT '下一位审核员ID',
  `status` varchar(100) DEFAULT NULL COMMENT '状态',
  `body` text COMMENT '审核或申请说明',
  `desc` varchar(255) DEFAULT NULL COMMENT '说明',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `step` varchar(10) DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `table_status_process_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `name` varchar(255) DEFAULT NULL COMMENT '表名',
  `created_at` date DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `table_status_process_set_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `user_id` int(11) DEFAULT NULL COMMENT '审核员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;