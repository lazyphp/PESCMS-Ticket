--
-- 自动关闭工单
--
INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 15, 'open_close', '是否自动关闭工单', 'radio', '{&quot;\\u7981\\u7528&quot;:&quot;0&quot;,&quot;\\u5f00\\u542f&quot;:&quot;1&quot;}', '开启此选项后，当工单状态为0，即没有客服处理，在达到设定的时间后，将会自动关闭。', '', 1, 15, 1, 1, 1, 0),
(NULL, 15, 'close_time', '自动关闭时长(分钟)', 'text', '', '', '', 0, 16, 0, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_open_close` TINYINT(1) NOT NULL COMMENT '是否开启自动关闭工单', ADD `ticket_model_close_time` INT(11) NOT NULL COMMENT '自动关闭工单时长';


--
-- 自定义内部消息模板
--

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'cs_text', '工单回复文本', '{\"accept\":{\"title\":\"\\u5de5\\u5355\\u53d7\\u7406\\u56de\\u590d\",\"content\":\"\\u5df2\\u6536\\u5230\\u60a8\\u7684\\u5de5\\u5355\\uff0c\\u6211\\u4eec\\u5c06\\u4f1a\\u5c3d\\u5feb\\u5b89\\u6392\\u4eba\\u624b\\u8fdb\\u884c\\u5904\\u7406\\u3002\"},\"assign\":{\"title\":\"\\u5de5\\u5355\\u8f6c\\u6d3e\\u56de\\u590d\",\"content\":\"\\u5f53\\u524d\\u95ee\\u9898\\u9700\\u8981\\u79fb\\u4ea4\\u7ed9\\u5176\\u4ed6\\u5ba2\\u670d\\u4eba\\u5458\\uff0c\\u8bf7\\u8010\\u5fc3\\u7b49\\u5f85\\u3002\"},\"complete\":{\"title\":\"\\u5de5\\u5355\\u5b8c\\u6210\\u56de\\u590d\",\"content\":\"\\u5ba2\\u670d\\u5df2\\u7ecf\\u5c06\\u672c\\u5de5\\u5355\\u7ed3\\u675f\\uff0c\\u5982\\u6709\\u7591\\u95ee\\u8bf7\\u91cd\\u65b0\\u53d1\\u8d77\\u5de5\\u5355\\u54a8\\u8be2\\uff0c\\u8c22\\u8c22!\"},\"close\":{\"title\":\"\\u5de5\\u5355\\u5173\\u95ed\\u56de\\u590d\",\"content\":\"\\u5de5\\u5355\\u5df2\\u5173\\u95ed\\uff0c\\u82e5\\u8fd8\\u6709\\u7591\\u95ee\\uff0c\\u8bf7\\u91cd\\u65b0\\u53d1\\u8868\\u5de5\\u5355\\u54a8\\u8be2!\"}}', 'cs_text');

INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`, `model_page`) VALUES
(25, 'cssend_template', '客服消息模板', 1, 0, 2, 10);

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 25, 'type', '类型', 'select', '{&quot;\\u65b0\\u5de5\\u5355\\u63d0\\u9192&quot;:&quot;1&quot;,&quot;\\u5ba2\\u6237\\u56de\\u590d\\u5de5\\u5355\\u63d0\\u9192&quot;:&quot;3&quot;,&quot;\\u5de5\\u5355\\u8f6c\\u4ea4\\u901a\\u77e5&quot;:&quot;4&quot;,&quot;\\u5de5\\u5355\\u8d85\\u65f6\\u63d0\\u9192&quot;:&quot;504&quot;}', '', '', 1, 1, 1, 1, 1, 0),
(NULL, 25, 'title', '模板标题', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(NULL, 25, 'content', '模板内容', 'editor', '', '', '', 1, 3, 0, 1, 1, 0);

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
(NULL, '客服消息模板', 9, 'am-icon-phone-square', 'Ticket-Cssend_template-index', 6, 0);

CREATE TABLE `pes_cssend_template` (
  `cssend_template_id` int(11) NOT NULL,
  `cssend_template_type` int(11) NOT NULL DEFAULT '0',
  `cssend_template_title` varchar(255) NOT NULL DEFAULT '',
  `cssend_template_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `pes_cssend_template` ADD PRIMARY KEY (`cssend_template_id`);

INSERT INTO `pes_cssend_template` (`cssend_template_id`, `cssend_template_type`, `cssend_template_title`, `cssend_template_content`) VALUES
(1, 1, '新工单提醒', '有新工单发起，单号为：{ticket_number} ，请及时处理! 详情: {handle_link}'),
(2, 3, '客户回复工单提醒', '&lt;p&gt;工单单号{ticket_number}有新回复，请及时跟进处理。&lt;/p&gt;&lt;p&gt;详情: {handle_link}&lt;/p&gt;'),
(3, 4, '工单转交通知', '{user_name}将工单号为{ticket_number}指派给了您，请您协助他/她尽快解决该工单问题。详情: {handle_link}'),
(4, 504, '工单超时提醒', '工单号为：{ticket_number}已在{time_out}分钟内无人受理，请您收到本消息后，尽快处理客户提交的问题。详情: {handle_link}');


--
-- 专属客服工单
--

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 15, 'exclusive', '允许指定客服受理', 'radio', '{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}', '开启此功能后，客户在提交工单时，将直接分配给填入名称的客服帐号。', '', 0, 17, 0, 1, 1, 0),
(NULL, 7, 'job_number', '工号', 'text', '', '', '', 1, 2, 1, 1, 1, 0);
ALTER TABLE `pes_ticket_model` ADD `ticket_model_exclusive` TINYINT(1) NOT NULL COMMENT '允许指定客服受理';

ALTER TABLE `pes_user` ADD `user_job_number` VARCHAR(255) NULL DEFAULT '' COMMENT '工号';

ALTER TABLE `pes_ticket` ADD `ticket_exclusive` TINYINT(1) NOT NULL COMMENT '专属工单标记';

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '发送列表', 11, 0, NULL, 'GET', 'Send', '', 0, 10),
(NULL, '清空发送列表', 43, 1, NULL, 'DELETE', 'truncate', 'TicketDELETESendtruncate', 99, 180);

--
-- 客户分组
--

INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`, `model_page`) VALUES
(26, 'member_organize', '客户分组', 1, 0, 2, 10);

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 26, 'name', '分组名称', 'text', '', '', '', 1, 1, 1, 1, 1, 0),
(NULL, 20, 'organize_id', '所属分组', 'select', '{\"\\u9ed8\\u8ba4\\u5206\\u7ec4\":\"1\"}', '', '', 1, 1, 1, 1, 1, 0),
(NULL, 15, 'organize_id', '指定客户分组可见', 'multiple', '{\"\\u9ed8\\u8ba4\\u5206\\u7ec4\":\"1\"}', '若您需要指定客户才可以见到此工单，那么请选择该客户对应的客户分组。', '', 0, 98, 0, 1, 1, 0);

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
(36, '客户分组', 3, 'am-icon-user-secret', 'Ticket-Member_organize-index', 5, 0);

CREATE TABLE `pes_member_organize` (
  `member_organize_id` int(11) NOT NULL,
  `member_organize_name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `pes_member_organize` ADD PRIMARY KEY (`member_organize_id`);

INSERT INTO `pes_member_organize` (`member_organize_id`, `member_organize_name`) VALUES
(1, '默认分组');

ALTER TABLE `pes_member` ADD `member_organize_id` INT NOT NULL;

ALTER TABLE `pes_ticket_model` ADD `ticket_model_organize_id` TEXT NOT NULL;

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES (NULL, '模板管理', '9', 'am-icon-magic', 'Ticket-Theme-index', '10', '0');

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'tipsManual', '首次按照提醒指引', '1', 'system');

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'ticketModel', '工单模型提醒', '1', 'system');