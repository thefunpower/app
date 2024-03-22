#  Framework

1.把`config.ini.dist.php` 改为`config.ini.php`

2.修改其中的参数

3.配置Nginx重写
 
## 重写

~~~
location ~.*\.(sql|pem|md|php) {
  deny all;
}  
location ^~ /theme/ {
    location ~* \.php$ {
        deny all;
    }
}
location / {
    if (!-e $request_filename){
        rewrite ^(.*)$ /index.php last;
    }  
}
location /uploads/ {
    try_files $uri /image_cache/index.php/$uri;
}
~~~
 

### SQL 

- 必须

~~~
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='配置';
~~~

- 非必须

> 需要理解`auth`包
> 主要支持权限管理、上传功能

~~~
CREATE TABLE `upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `url` varchar(255) NOT NULL COMMENT 'URL',
  `hash` varchar(255) NOT NULL COMMENT '唯一值',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `mime` varchar(255) NOT NULL COMMENT '类型',
  `size` decimal(20,2) NOT NULL COMMENT '大小',
  `ext` varchar(10) NOT NULL COMMENT '后缀',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `name` varchar(255) DEFAULT NULL COMMENT '文件名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='上传文件';

CREATE TABLE `sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '接收者',
  `body` text COMMENT '消息内容',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `created_at` datetime NOT NULL COMMENT '发送时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `unionid` varchar(255) DEFAULT NULL COMMENT 'unionid',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `type` varchar(255) NOT NULL DEFAULT 'wx_xcx' COMMENT '类型',
  `avatar_url` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `session_key` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='第三方登录信息';

CREATE TABLE `login_his` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='登录记录';

CREATE TABLE `login_visite_his` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问记录';

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

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user` varchar(255) NOT NULL COMMENT '登录帐号',
  `pwd` varchar(100) DEFAULT NULL COMMENT '密码',
  `acl` json DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `tag` varchar(255) DEFAULT 'user' COMMENT '标签，默认是会员',
  `group_id` int(11) DEFAULT '0' COMMENT '所属组',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `email` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '状态，1在职，-1离职',
  `active_time` datetime DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL COMMENT '性别',
  `birthday` varchar(255) DEFAULT NULL COMMENT '生日',
  `job` varchar(255) DEFAULT NULL COMMENT '岗位',
  `health_control` varchar(255) DEFAULT NULL COMMENT '纳入健康管理',
  `need_change` varchar(255) DEFAULT NULL COMMENT '有值时需要修改密码',
  `is_sale` tinyint(1) DEFAULT NULL COMMENT '是否是销售',
  `third_id` varchar(255) DEFAULT NULL,
  `third_name` varchar(255) DEFAULT NULL,
  `unionid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='用户';

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '组名',
  `pid` int(11) DEFAULT '0' COMMENT '上一级',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1可用，-1不可用',
  `acl` json DEFAULT NULL COMMENT '权限',
  `third_id` varchar(255) DEFAULT NULL,
  `third_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='管理组';

CREATE TABLE `user_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL COMMENT '帐号',
  `time` int(11) NOT NULL COMMENT '登录时间',
  `ip` varchar(255) NOT NULL COMMENT 'IP',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1登录成功，-1登录失败',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `title` varchar(255) NOT NULL COMMENT '字段名',
  `value` text COMMENT '字段值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='用户扩展字段 ';

~~~


# PHP文档

[文档](http://framework-api-doc.qihetaiji.com/)
