INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 21, 'status', '发送状态', 'select', '{&quot;\\u672a\\u53d1\\u9001&quot;:&quot;0&quot;,&quot;\\u53d1\\u9001\\u5931\\u8d25&quot;:&quot;1&quot;,&quot;\\u53d1\\u9001\\u6210\\u529f&quot;:&quot;2&quot;}', '', '', 1, 6, 1, 1, 1, 0),
(NULL, 21, 'sequence', '发送次数', 'text', '', '', '', 0, 7, 1, 1, 1, 0);

UPDATE `pes_field` SET `field_required` = '0' WHERE `field_model_id` = 21 AND field_name = 'result';

ALTER TABLE `pes_send` ADD `send_status` INT NOT NULL , ADD `send_sequence` INT NOT NULL;

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'dingtalk', '钉钉接口', '', 'system');

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 7, 'dingtalk', '钉钉企业ID', 'text', '', '', '', 0, 8, 1, 1, 1, 1);

ALTER TABLE `pes_user` ADD `user_dingtalk` VARCHAR(255) NULL DEFAULT NULL AFTER `user_weixinWork`, ADD UNIQUE (`user_dingtalk`);

CREATE TABLE `pes_member_activation` (
  `activation_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `activation_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='账号激活表';

ALTER TABLE `pes_member_activation`
  ADD PRIMARY KEY (`activation_id`);
