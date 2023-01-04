CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键', 
  `title` varchar(255) NOT NULL COMMENT '标题',  
  `body` TEXT   NULL DEFAULT NULL COMMENT '内容',  
  `status` int(11) NULL DEFAULT 1 COMMENT '',  
  `sort` int(11) NULL COMMENT '',  
  `type_id` int(11)   NULL DEFAULT NULL COMMENT '分类', 
  `user_id` int(11)   NULL DEFAULT NULL COMMENT '发布者', 
  `created_at` varchar(255) NOT NULL COMMENT '',  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='文章';


CREATE TABLE IF NOT EXISTS `article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键', 
  `title` varchar(255) NOT NULL COMMENT '标题',    
  `status` int(11) NULL DEFAULT 1 COMMENT '',  
  `sort` int(11) NULL COMMENT '', 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='文章分类';