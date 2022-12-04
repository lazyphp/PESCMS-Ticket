INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 16, 'default', '表单默认值', 'textarea', '', '若您的工单表单需要设置默认值，可以在这里填写对应的数值。页面渲染时会自动填充。<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注意：部分表单类型可能不起效', '', 0, 15, 0, 1, 1, 0, 0, 'POST,PUT');

ALTER TABLE `pes_ticket_form` ADD `ticket_form_default` TEXT NOT NULL COMMENT '工单表单默认值';

ALTER TABLE `pes_user` ADD `user_ticket_status` VARCHAR(10) NOT NULL DEFAULT '' COMMENT '客服设置列表默认打开的工单筛选状态';

UPDATE `pes_option` SET `value` = '{\"accept\":{\"title\":\"\\u5de5\\u5355\\u53d7\\u7406\\u56de\\u590d\",\"content\":\"\\u5df2\\u6536\\u5230\\u60a8\\u7684\\u5de5\\u5355\\uff0c\\u6211\\u4eec\\u5c06\\u4f1a\\u5c3d\\u5feb\\u5b89\\u6392\\u4eba\\u624b\\u8fdb\\u884c\\u5904\\u7406\\u3002\"},\"assign\":{\"title\":\"\\u5de5\\u5355\\u8f6c\\u6d3e\\u56de\\u590d\",\"content\":\"\\u5f53\\u524d\\u95ee\\u9898\\u9700\\u8981\\u79fb\\u4ea4\\u7ed9\\u5176\\u4ed6\\u5ba2\\u670d\\u4eba\\u5458\\uff0c\\u8bf7\\u8010\\u5fc3\\u7b49\\u5f85\\u3002\"},\"complete\":{\"title\":\"\\u5de5\\u5355\\u5b8c\\u6210\\u56de\\u590d\",\"content\":\"\\u5ba2\\u670d\\u5df2\\u7ecf\\u5c06\\u672c\\u5de5\\u5355\\u7ed3\\u675f\\uff0c\\u5982\\u6709\\u7591\\u95ee\\u8bf7\\u91cd\\u65b0\\u53d1\\u8d77\\u5de5\\u5355\\u54a8\\u8be2\\uff0c\\u8c22\\u8c22!\"},\"close\":{\"title\":\"\\u5de5\\u5355\\u5173\\u95ed\\u56de\\u590d\",\"content\":\"\\u5de5\\u5355\\u5df2\\u5173\\u95ed\\uff0c\\u82e5\\u8fd8\\u6709\\u7591\\u95ee\\uff0c\\u8bf7\\u91cd\\u65b0\\u53d1\\u8868\\u5de5\\u5355\\u54a8\\u8be2!\"},\"recovery\":{\"title\":\"\\u5de5\\u5355\\u72b6\\u6001\\u91cd\\u7f6e\\u56de\\u590d\",\"content\":\"\\u56e0\\u4e1a\\u52a1\\u9700\\u8981\\uff0c\\u5ba2\\u670d\\u5df2\\u5c06\\u672c\\u5de5\\u5355\\u72b6\\u6001\\u91cd\\u7f6e\\u3002\"}}' WHERE `option_name` LIKE 'cs_text';

ALTER TABLE `pes_ticket_model` ADD `ticket_model_recovery_day` INT NOT NULL DEFAULT '7' COMMENT '工单模型恢复期限';

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 15, 'recovery_day', '工单恢复期限', 'text', '', '一般工单结束后，客户可以在7天内手动恢复功能。修改本参数可以调整对应的恢复期限。', '7', 0, 65, 1, 1, 1, 0, 0, 'POST,PUT');

UPDATE `pes_field` SET `field_listsort` = '9999' WHERE `field_model_id` = 15 AND field_name = 'status' ;

ALTER TABLE `pes_ticket` ADD `ticket_close_time` INT NOT NULL COMMENT '工单关闭时间' AFTER `ticket_close`;