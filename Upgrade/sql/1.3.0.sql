
INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 15, 'open_close', '是否自动关闭工单', 'radio', '{&quot;\\u7981\\u7528&quot;:&quot;0&quot;,&quot;\\u5f00\\u542f&quot;:&quot;1&quot;}', '开启此选项后，当工单状态为0，即没有客服处理，在达到设定的时间后，将会自动关闭。', '', 1, 15, 1, 1, 1, 0),
(NULL, 15, 'close_time', '自动关闭时长(分钟)', 'text', '', '', '', 0, 16, 0, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_open_close` TINYINT(1) NOT NULL COMMENT '是否开启自动关闭工单', ADD `ticket_model_close_time` INT(11) NOT NULL COMMENT '自动关闭工单时长';