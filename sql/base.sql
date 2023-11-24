CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='配置';


CREATE TABLE `plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '唯一值',
  `version` varchar(255) DEFAULT NULL COMMENT '版本',
  `title` varchar(255) NOT NULL COMMENT '插件名',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `data` json DEFAULT NULL COMMENT '数据',
  `level` int(11) DEFAULT NULL COMMENT '级别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='插件';