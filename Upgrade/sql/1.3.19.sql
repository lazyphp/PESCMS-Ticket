INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 16, 'default', '表单默认值', 'textarea', '', '若您的工单表单需要设置默认值，可以在这里填写对应的数值。页面渲染时会自动填充。<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注意：部分表单类型可能不起效', '', 0, 15, 0, 1, 1, 0, 0, 'POST,PUT');

ALTER TABLE `pes_ticket_form` ADD `ticket_form_default` TEXT NOT NULL COMMENT '工单表单默认值';