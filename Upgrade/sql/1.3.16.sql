UPDATE `pes_field` SET `field_explain` = '1. 默认留空单号规则随机生成。2. 只填写{X}则用雪花ID规则。3. 关键词{Y}是年，{M}是月，{D}是日，{Z}是当前工单模型提交的工单总数量，{A}是今天工单模型提交工单数量，{S}是五位数的随机值。' WHERE `pes_field`.`field_id` = 283;

CREATE TABLE IF NOT EXISTS `pes_qrcode` (
    `qrcode_id` int(11) NOT NULL AUTO_INCREMENT,
    `qrcode_key` varchar(128) NOT NULL COMMENT '二维码key值',
    `qrcode_value` varchar(64) NOT NULL COMMENT '二维码内容值',
    `qrcode_status` int(1) NOT NULL COMMENT '二维码使用状态 1:已使用',
    `qrcode_createtime` int(11) NOT NULL COMMENT '二维码生成时间',
    PRIMARY KEY (`qrcode_id`),
    KEY `qrcode_value` (`qrcode_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='二维码状态表';