CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '真实姓名',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `email` varchar(60) NOT NULL COMMENT '邮件',
  `abc_first` varchar(200) NOT NULL COMMENT '姓名首字母',
  `abc_full` varchar(200) NOT NULL COMMENT '姓名全拼',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属组织',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1在职、-1离职',
  `created_at` datetime NOT NULL COMMENT '创建时间 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '组织名',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上一级',
  `user_id` int(11) DEFAULT '0' COMMENT '主管人员',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `created_at` datetime NOT NULL COMMENT '创建时间 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

