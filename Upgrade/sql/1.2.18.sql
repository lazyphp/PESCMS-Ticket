INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(15, 'postscript', '页内指引', 'editor', '', '填写此项，在工单提交内页顶部将显示这部分填写的内容。', '', 0, 11, 0, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_postscript` TEXT NOT NULL COMMENT '工单页内指引' ;

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES (16, 'postscript', '工单表单详细说明', 'editor', '', '若需要对当前表单字段有更加完整的说明，请在此处填写。', '', 0, 5, 0, 1, 1, 0);

ALTER TABLE `pes_ticket_form` ADD `ticket_form_postscript` TEXT NOT NULL COMMENT '工单表单详细说明' ;


INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(15, 'default_send', '默认发送通知', 'radio', '{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}', '选择是，则当前工单模型的工单处理过程，默认发送通知复选框会勾上。', '', 0, 20, 0, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_default_send` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '默认发送通知' ;
