INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'rowlock', '开启行锁', '0', 'system');

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'notice_login', '登录参数', '', 'system');

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 15, 'auto_logic', '自动分单逻辑', 'radio', '{&quot;\\u968f\\u673a&quot;:&quot;0&quot;,&quot;\\u5e73\\u5747&quot;:&quot;1&quot;}', '', '', 0, 7, 0, 1, 1, 0),
(NULL, 15, 'auto', '开启自动分单', 'radio', '{&quot;\\u5173\\u95ed&quot;:&quot;0&quot;,&quot;\\u5f00\\u542f&quot;:&quot;1&quot;}', '', '', 1, 7, 1, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_auto_logic` TINYINT(1) NOT NULL AFTER `ticket_model_title_description`, ADD `ticket_model_auto` TINYINT(1) NOT NULL AFTER `ticket_model_auto_logic`;