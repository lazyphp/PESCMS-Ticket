INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`, `model_page`) VALUES
(24, 'attachment', '附件管理', 1, 0, 2, 30);


INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(24, 'status', '状态', 'radio', '{"\\u7981\\u7528":"0","\\u542f\\u7528":"1"}', '', '1', 1, 100, 1, 1, 1, 0),
(24, 'createtime', '创建时间', 'date', '', '', '', 0, 99, 1, 1, 1, 0),
(24, 'name', '附件名称', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(24, 'path', '附件地址', 'text', '', '', '', 1, 3, 1, 1, 1, 0),
(24, 'path_type', '存储位置', 'radio', '{&quot;\\u672c\\u5730\\u786c\\u76d8&quot;:&quot;0&quot;}', '', '', 1, 4, 1, 1, 1, 0),
(24, 'type', '附件类型', 'radio', '{&quot;\\u56fe\\u7247&quot;:&quot;0&quot;,&quot;\\u6587\\u4ef6&quot;:&quot;1&quot;,&quot;\\u591a\\u5a92\\u4f53&quot;:&quot;3&quot;}', '', '', 1, 1, 1, 1, 1, 0),
(24, 'owner', '上传方', 'radio', '{&quot;\\u524d\\u53f0\\u7528\\u6237&quot;:&quot;0&quot;,&quot;\\u540e\\u53f0\\u7ba1\\u7406&quot;:&quot;1&quot;}', '', '', 1, 94, 1, 1, 1, 0);

CREATE TABLE IF NOT EXISTS `pes_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `attachment_status` tinyint(4) NOT NULL DEFAULT '0',
  `attachment_path` varchar(1000) NOT NULL DEFAULT '',
  `attachment_createtime` int(11) NOT NULL DEFAULT '0',
  `attachment_name` varchar(255) NOT NULL DEFAULT '',
  `attachment_path_type` int(11) NOT NULL DEFAULT '0',
  `attachment_type` int(11) NOT NULL DEFAULT '0',
  `attachment_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '后台上传用户ID',
  `attachment_member_id` int(11) NOT NULL DEFAULT '-1' COMMENT '前台上传用户ID -1 为匿名',
  `attachment_owner` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `pes_menu` (`menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
('附件管理', 9, 'am-icon-suitcase', 'Ticket-Attachment-index', 6, 0);


INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(93, '附件管理', 11, 1, '', 'GET', 'Attachment', '', 0, 9),
(94, '附件列表', 43, 1, '', 'GET', 'index', 'TicketGETAttachmentindex', 93, 130),
(95, '附件编辑', 43, 1, '', 'GET', 'action', 'TicketGETAttachmentaction', 93, 140),
(96, '附件添加', 43, 1, '', 'POST', 'action', 'TicketPOSTAttachmentaction', 93, 150),
(97, '附件更新', 43, 1, '', 'PUT', 'action', 'TicketPUTAttachmentaction', 93, 160),
(98, '附件删除', 43, 1, '', 'DELETE', 'action', 'TicketDELETEAttachmentaction', 93, 170);

