INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'indexStyle', '首页样式', '0', 'system');

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'member_login', '客户登陆方式', '0', 'system');

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(20, 'account', '账号', 'text', '', '', '', 1, 1, 1, 1, 1, 0);

ALTER TABLE `pes_member` ADD `member_account` VARCHAR(255) NOT NULL;

ALTER TABLE `pes_member` ADD INDEX(`member_account`);

ALTER TABLE `pes_member` ADD INDEX(`member_phone`);