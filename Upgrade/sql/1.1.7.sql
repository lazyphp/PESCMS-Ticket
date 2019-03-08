INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'weixinWork_api', '企业微信接口', '', 'system');
UPDATE `pes_field` SET `field_option` = '{&quot;\\u5206\\u7c7b&quot;:&quot;category&quot;,&quot;\\u5355\\u884c\\u8f93\\u5165\\u6846&quot;:&quot;text&quot;,&quot;\\u591a\\u884c\\u8f93\\u5165\\u6846&quot;:&quot;textarea&quot;,&quot;\\u5355\\u9009\\u6309\\u94ae&quot;:&quot;radio&quot;,&quot;\\u590d\\u9009\\u6846&quot;:&quot;checkbox&quot;,&quot;\\u5355\\u9009\\u4e0b\\u62c9\\u6846&quot;:&quot;select&quot;,&quot;\\u591a\\u9009\\u4e0b\\u62c9\\u6846&quot;:&quot;multiple&quot;,&quot;\\u7f16\\u8f91\\u5668&quot;:&quot;editor&quot;,&quot;\\u7565\\u7f29\\u56fe&quot;:&quot;thumb&quot;,&quot;\\u4e0a\\u4f20\\u56fe\\u7ec4&quot;:&quot;img&quot;,&quot;\\u4e0a\\u4f20\\u6587\\u4ef6&quot;:&quot;file&quot;,&quot;\\u65e5\\u671f&quot;:&quot;date&quot;,&quot;\\u7c7b\\u578b&quot;:&quot;types&quot;}' WHERE `field_model_id` = 2 AND `field_name` = 'type';
INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`) VALUES
  ( 15, 'group_id', '管辖用户组', 'multiple', '', '绑定对应的用户组，当前工单模型有新工单，将会发送通知给该用户组下的所有成员。', '', 1, 7, 1, 1, 1);
ALTER TABLE `pes_ticket_model` ADD `ticket_model_group_id` VARCHAR(255) NOT NULL DEFAULT '' ;

INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`) VALUES (21, 'Send', '发送列表', '1', '1', '1');

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`) VALUES
  (21, 'account', '接收帐号', 'text', '', '', '', 1, 1, 1, 1, 1),
  (21, 'title', '发送标题', 'text', '', '', '', 1, 2, 1, 1, 1),
  (21, 'content', '发送内容', 'editor', '', '', '', 1, 3, 0, 1, 1),
  (21, 'time', '生成时间', 'date', '', '', '', 1, 5, 1, 1, 1),
  (21, 'type', '发送方式', 'select', '{&quot;\\u90ae\\u7bb1&quot;:&quot;1&quot;,&quot;\\u624b\\u673a&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;,&quot;\\u4f01\\u4e1a\\u5fae\\u4fe1&quot;:&quot;4&quot;}', '', '', 1, 4, 1, 1, 1);


INSERT INTO `pes_menu` ( `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
  ('发送列表', 9, 'am-icon-send', 'Ticket-Send-index', 5, 0);


INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`) VALUES
  (7, 'weixinWork', '企业微信ID', 'text', '', '', '', 0, 6, 1, 1, 1);

ALTER TABLE `pes_user` ADD `user_weixinWork` VARCHAR(255) NULL DEFAULT NULL , ADD UNIQUE (`user_weixinWork`) ;



INSERT INTO `pes_option` (`option_name`, `name`, `value`, `option_range`) VALUES
  ('login_verify', '登录验证码', '["1"]', 'system');


INSERT INTO `pes_option` (`option_name`, `name`, `value`, `option_range`) VALUES
  ('cs_notice_type', '客服人员接收通知方式', '{"1":"1"}', 'system');

INSERT INTO `pes_node` (`node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
  ('删除工单', 2, 1, '当前权限不足，无法删除工单。', 'DELETE', 'action', 'TicketDELETETicketaction', 2, 5);


