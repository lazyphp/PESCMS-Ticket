INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'register_form', '注册填写选项', '{\"email\":\"email\",\"account\":\"account\",\"phone\":\"phone\"}', 'system');
ALTER TABLE `pes_ticket` ADD `old_user_id` INT NOT NULL COMMENT '上一任的负责人ID' AFTER `user_id`;

CREATE TABLE `pes_csnotice` (
  `csnotice_id` int(11) NOT NULL,
  `ticket_number` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `csnotice_type` int(11) NOT NULL,
  `csnotice_time` int(11) NOT NULL,
  `csnotice_read` tinyint(1) NOT NULL COMMENT '是否标记已读',
  `csnotice_read_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客服站内消息';

ALTER TABLE `pes_csnotice`
  ADD PRIMARY KEY (`csnotice_id`);
ALTER TABLE `pes_csnotice`
  MODIFY `csnotice_id` int(11) NOT NULL AUTO_INCREMENT;

UPDATE `pes_field` SET `field_option` = '{\"\\u65b0\\u7684\\u5de5\\u5355\":\"1\",\"\\u5de5\\u5355\\u56de\\u590d\":\"3\",\"\\u5de5\\u5355\\u8f6c\\u4ea4\":\"4\",\"\\u5de5\\u5355\\u8d85\\u65f6\":\"504\"}' WHERE `field_id` = 255;

--
-- 公告栏
--
CREATE TABLE `pes_bulletin` (
  `bulletin_id` int(11) NOT NULL,
  `bulletin_listsort` int(11) NOT NULL DEFAULT '0',
  `bulletin_status` tinyint(4) NOT NULL DEFAULT '0',
  `bulletin_createtime` int(11) NOT NULL DEFAULT '0',
  `bulletin_title` varchar(255) NOT NULL DEFAULT '',
  `bulletin_group_id` varchar(255) NOT NULL DEFAULT '',
  `bulletin_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `pes_bulletin`
  ADD PRIMARY KEY (`bulletin_id`);
ALTER TABLE `pes_bulletin`
  MODIFY `bulletin_id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`, `model_page`) VALUES
(NULL, 'Bulletin', '公告栏', 1, 0, 2, 10);

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, LAST_INSERT_ID(), 'status', '状态', 'radio', '{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}', '', '1', 1, 100, 1, 1, 1, 0),
(NULL, LAST_INSERT_ID(), 'listsort', '排序', 'text', '', '', '', 0, 98, 1, 1, 1, 0),
(NULL, LAST_INSERT_ID(), 'createtime', '创建时间', 'date', '', '', '', 0, 99, 1, 1, 1, 0),
(NULL, LAST_INSERT_ID(), 'title', '标题', 'text', '', '', '', 1, 1, 1, 1, 1, 0),
(NULL, LAST_INSERT_ID(), 'group_id', '可见客服分组', 'multiple', '', '', '', 0, 2, 1, 1, 1, 0),
(NULL, LAST_INSERT_ID(), 'description', '内容', 'editor', '', '', '', 1, 3, 0, 1, 1, 0);

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '公告栏', 0, 0, NULL, 'GET', 'Bulletin', '', 0, 2700);

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '公告栏列表', LAST_INSERT_ID(), 0, NULL, 'GET', 'index', 'TicketGETBulletinaction', LAST_INSERT_ID(), 0),
(NULL, '新增/编辑公告栏', LAST_INSERT_ID(), 0, NULL, 'GET', 'action', 'TicketGETBulletinaction', LAST_INSERT_ID(), 1),
(NULL, '请求新增公告栏', LAST_INSERT_ID(), 0, NULL, 'POST', 'action', 'TicketPOSTBulletinaction', LAST_INSERT_ID(), 2),
(NULL, '请求更新公告栏', LAST_INSERT_ID(), 0, NULL, 'PUT', 'action', 'TicketPUTBulletinaction', LAST_INSERT_ID(), 3),
(NULL, '请求删除公告栏', LAST_INSERT_ID(), 0, NULL, 'DELETE', 'action', 'TicketDELETEBulletinaction', LAST_INSERT_ID(), 4);

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
(NULL, '公告栏', 9, 'am-icon-building', 'Ticket-Bulletin-index', 11, 0);