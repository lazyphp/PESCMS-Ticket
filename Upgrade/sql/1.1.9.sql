
INSERT INTO `pes_option` (option_name`, `name`, `value`, `option_range`) VALUES
('sms', '短信接口', '', 'system');

ALTER TABLE `pes_mail_template` ADD `mail_template_sms` VARCHAR(500) NOT NULL DEFAULT '' ;

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(17, 'sms', '短信模板内容', 'textarea', '', '在短信模板内容，输入如下变量可以动态输出对应的值：{number}为工单号码，{content}为工单回复的内容，{view}为工单查询的链接地址。另外请到短信平台按照要求添加一致的模板。', '', 1, 4, 0, 1, 1, 0);