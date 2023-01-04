CREATE TABLE IF NOT EXISTS   `sms`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL COMMENT '接收者',  
    `body` TEXT NULL COMMENT '消息内容',  
    `status` TINYINT(1) NULL DEFAULT '0' COMMENT '状态',
    `created_at` DATETIME NOT NULL COMMENT '发送时间',
    `updated_at` DATETIME NOT NULL COMMENT '更新时间',
    PRIMARY KEY(`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
