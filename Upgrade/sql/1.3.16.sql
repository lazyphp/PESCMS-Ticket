UPDATE `pes_field` SET `field_explain` = '1. 默认留空单号规则随机生成。2. 只填写{X}则用雪花ID规则。3. 关键词{Y}是年，{M}是月，{D}是日，{Z}是当前工单模型提交的工单总数量，{A}是今天工单模型提交工单数量，{S}是五位数的随机值。' WHERE `pes_field`.`field_id` = 283;

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 15, 'fqa_tips', 'FQA指引', 'radio', '{&quot;\\u5f00\\u542f&quot;:&quot;0&quot;,&quot;\\u5173\\u95ed&quot;:&quot;1&quot;}', '默认开启FQA指引，客户提交工单时，若当前工单模型存在FQA文档，则弹出FQA指引列表和工单提交按钮。', '0', 1, 7, 0, 1, 1, 0, 0, 'POST,PUT');

CREATE TABLE IF NOT EXISTS `pes_qrcode` (
    `qrcode_id` int(11) NOT NULL AUTO_INCREMENT,
    `qrcode_key` varchar(128) NOT NULL COMMENT '二维码key值',
    `qrcode_value` varchar(64) NOT NULL COMMENT '二维码内容值',
    `qrcode_status` int(1) NOT NULL COMMENT '二维码使用状态 1:已使用',
    `qrcode_createtime` int(11) NOT NULL COMMENT '二维码生成时间',
    PRIMARY KEY (`qrcode_id`),
    KEY `qrcode_value` (`qrcode_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='二维码状态表';

ALTER TABLE `pes_ticket_model` ADD `ticket_model_fqa_tips` TINYINT(1) NOT NULL COMMENT 'FQA指引';

ALTER TABLE `pes_user` ADD `user_suspension_button` TINYINT(1) NOT NULL COMMENT '是否关闭悬浮按钮' AFTER `user_browser_msg_time`;

UPDATE `pes_field` SET `field_option` = '{&quot;\\u663e\\u793a&quot;:&quot;1&quot;,&quot;\\u9690\\u85cf&quot;:&quot;0&quot;,&quot;\\u4ec5\\u540e\\u53f0&quot;:&quot;2&quot;}' WHERE `pes_field`.`field_id` = 15;
UPDATE `pes_field` SET `field_form` = '2' WHERE `pes_field`.`field_id` = 235;
UPDATE `pes_field` SET `field_form` = '2' WHERE `pes_field`.`field_id` = 270;
UPDATE `pes_field` SET `field_form` = '2' WHERE `pes_field`.`field_id` = 273;
UPDATE `pes_field` SET `field_form` = '2' WHERE `pes_field`.`field_id` = 281;