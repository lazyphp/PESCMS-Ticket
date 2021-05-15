ALTER TABLE `pes_ticket_content` ADD `ticket_form_option_name` VARCHAR(255) NOT NULL COMMENT '工单字段记录的选项名称' AFTER `ticket_form_content`;
INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'ticket_contact', '全局工单联系方式', '[{\"title\":\"\\u7535\\u5b50\\u90ae\\u4ef6\",\"key\":\"1\",\"field\":\"member_email\"},{\"title\":\"\\u624b\\u673a\\u53f7\\u7801\",\"key\":\"2\",\"field\":\"member_phone\"},{\"title\":\"\\u5fae\\u4fe1\",\"key\":\"3\",\"field\":\"member_weixin\"},{\"title\":\"\\u5fae\\u4fe1\\u5c0f\\u7a0b\\u5e8f\",\"key\":\"6\",\"field\":\"member_wxapp\"}]', '');

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES (NULL, '变更工单模型', '2', '1', '您没有权限变更工单模型', 'PUT', 'changeTicketModel', 'TicketPUTTicketchangeTicketModel', '2', '6');

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 7, 'vacation', '休假', 'radio', '{&quot;\\u5de5\\u4f5c&quot;:&quot;0&quot;,&quot;\\u4f11\\u5047&quot;:&quot;1&quot;}', '', '1', 1, 98, 1, 1, 1, 0);

ALTER TABLE `pes_user` ADD `user_vacation` TINYINT(1) NOT NULL COMMENT '是否休假中';

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES (NULL, '工单标记完成', '2', '1', '您没有工单完成的权限 ', 'PUT', 'complete', 'TicketPUTTicketcomplete', '2', '7');

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES (NULL, '工单介入处理', '2', '1', '您没有工单介入处理权限', 'PUT', 'intervene', 'TicketPUTTicketintervene', '2', '8');

ALTER TABLE `pes_ticket` ADD `ticket_top` TINYINT(1) NOT NULL COMMENT '个人置顶工单' AFTER `ticket_exclusive`;

ALTER TABLE `pes_ticket` ADD `ticket_top_list` TINYINT(1) NOT NULL COMMENT '列表置顶工单' AFTER `ticket_top`;

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES (NULL, '列表置顶工单', '2', '1', '您没有权限置顶列表工单', 'PUT', 'setListTop', 'TicketPUTTicketsetListTop', '2', '9');

