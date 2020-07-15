INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'rowlock', '开启行锁', '0', 'system');

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'notice_login', '登录参数', '', 'system');

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 15, 'auto_logic', '自动分单逻辑', 'radio', '{&quot;\\u968f\\u673a&quot;:&quot;0&quot;,&quot;\\u5e73\\u5747&quot;:&quot;1&quot;}', '', '', 0, 7, 0, 1, 1, 0),
(NULL, 15, 'auto', '开启自动分单', 'radio', '{&quot;\\u5173\\u95ed&quot;:&quot;0&quot;,&quot;\\u5f00\\u542f&quot;:&quot;1&quot;}', '', '', 1, 7, 1, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_auto_logic` TINYINT(1) NOT NULL AFTER `ticket_model_title_description`, ADD `ticket_model_auto` TINYINT(1) NOT NULL AFTER `ticket_model_auto_logic`;

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 15, 'close_type', '自动关闭类型', 'checkbox', '{&quot;\\u5f85\\u89e3\\u51b3&quot;:&quot;0&quot;,&quot;\\u5f85\\u56de\\u590d&quot;:&quot;2&quot;}', '', '', 0, 16, 0, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_close_type` VARCHAR(16) NOT NULL;

UPDATE `pes_ticket_model` SET `ticket_model_close_type` = '0';

UPDATE `pes_field` SET `field_type` = 'checkbox', `field_explain` = '此选项，若您没有类似VIP客户可见需求，不要勾选上述客户组。否则非登陆状态，且非此组的客户账号，将无法看到本工单。' WHERE `field_model_id` = 15 AND `field_name` = 'organize_id';
