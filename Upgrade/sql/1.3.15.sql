UPDATE `pes_option` SET `value` = '[{\"color\":\"#dd514c\",\"name\":\"\\u65b0\\u5de5\\u5355\"},{\"color\":\"#F37B1D\",\"name\":\"\\u53d7\\u7406\\u4e2d\"},{\"color\":\"#3bb4f2\",\"name\":\"\\u5f85\\u56de\\u590d\"},{\"color\":\"#5eb95e\",\"name\":\"\\u5b8c\\u6210\"}]' WHERE `pes_option`.`id` = 5;


ALTER TABLE `pes_field` ADD `field_only` INT(11) NOT NULL , ADD `field_action` VARCHAR(255) NOT NULL;

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES (NULL, 2, 'only', '唯一', 'radio', '{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}', '', '', 1, 12, 1, 1, 1, 0, 0, 'POST,PUT'),(NULL, 2, 'action', '行为', 'checkbox', '{&quot;\\u65b0\\u589e&quot;:&quot;POST&quot;,&quot;\\u66f4\\u65b0&quot;:&quot;PUT&quot;}', '', '', 0, 13, 1, 1, 1, 0, 0, 'POST,PUT');

UPDATE `pes_field` SET `field_action` = 'POST,PUT';


INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
    (NULL, 20, 'requisition', '允许客服登录', 'radio', '{&quot;\\u7981\\u6b62&quot;:&quot;0&quot;,&quot;\\u5141\\u8bb8&quot;:&quot;1&quot;}', '', '', 1, 90, 1, 1, 1, 0, 0, 'POST,PUT');

ALTER TABLE `pes_member` ADD `member_wxWork` VARCHAR(255) NULL DEFAULT NULL, ADD UNIQUE (`member_wxWork`);
ALTER TABLE `pes_member` ADD `member_dingtalk` VARCHAR(255) NULL DEFAULT NULL, ADD UNIQUE (`member_dingtalk`);

ALTER TABLE `pes_member` ADD `member_requisition` INT NOT NULL;

-- 更新唯一属性
UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 73;
UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 76;
UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 217;
UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 259;
UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 265;

UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 239;
UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 207;
UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 210;
UPDATE `pes_field` SET `field_only` = '1' WHERE `pes_field`.`field_id` = 235;

UPDATE `pes_option` SET `value` = '[{\"title\":\"\\u7535\\u5b50\\u90ae\\u4ef6\",\"key\":\"1\",\"field\":\"member_email\"},{\"title\":\"\\u624b\\u673a\\u53f7\\u7801\",\"key\":\"2\",\"field\":\"member_phone\"},{\"title\":\"\\u5fae\\u4fe1\",\"key\":\"3\",\"field\":\"member_weixin\"},{\"title\":\"\\u4f01\\u4e1a\\u5fae\\u4fe1\",\"key\":\"4\",\"field\":\"member_wxWork\"},{\"title\":\"\\u9489\\u9489\",\"key\":\"5\",\"field\":\"member_dingtalk\"},{\"title\":\"\\u5fae\\u4fe1\\u5c0f\\u7a0b\\u5e8f\",\"key\":\"6\",\"field\":\"member_wxapp\"}]' WHERE `pes_option`.`id` = 41;

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'disturb', '勿扰时段', '', 'system');

ALTER TABLE `pes_user` ADD `user_browser_msg` INT NOT NULL COMMENT '是否启用浏览器通知', ADD `user_browser_msg_time` INT NOT NULL DEFAULT '1' COMMENT '默认浏览器通知间隔 1分钟';

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
    (NULL, 15, 'custom_no', '自定义工单单号格式', 'text', '', '1. 默认留空单号规则随机生成。2. 只填写X则用雪花ID规则。3. 关键词Y是年，M是月，D是日，Z是当前工单模型提交的工单总数量，A是今天工单模型提交工单数量。', '', 0, 4, 0, 1, 1, 0, 0, 'POST,PUT');

ALTER TABLE `pes_ticket_model` ADD `ticket_model_custom_no` VARCHAR(255) NOT NULL;

ALTER TABLE `pes_ticket_chat` ADD `ticket_chat_delete` INT NOT NULL COMMENT '是否被删除 0 正常 1被删除';

INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`, `model_page`) VALUES
    (28, 'form_menu', '前台菜单', 1, 0, 1, 999);

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 28, 'status', '状态', 'radio', '{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}', '', '1', 1, 100, 1, 1, 1, 0, 0, 'POST,PUT'),
(NULL, 28, 'listsort', '排序', 'text', '', '', '', 0, 98, 1, 1, 1, 0, 0, 'POST,PUT'),
(NULL, 28, 'createtime', '创建时间', 'date', '', '', '', 0, 99, 1, 1, 1, 0, 0, 'POST,PUT'),
(NULL, 28, 'name', '菜单名称', 'text', '', '', '', 1, 1, 1, 1, 1, 0, 0, 'POST,PUT'),
(NULL, 28, 'type', '菜单类型', 'radio', '{&quot;\\u7ad9\\u5185\\u94fe\\u63a5&quot;:&quot;0&quot;,&quot;\\u7ad9\\u5916\\u94fe\\u63a5&quot;:&quot;1&quot;}', '', '', 1, 2, 1, 1, 1, 0, 0, 'POST,PUT'),
(NULL, 28, 'link', '菜单地址', 'text', '', '', '', 1, 3, 1, 1, 1, 0, 0, 'POST,PUT'),
(NULL, 28, 'icon', '菜单图标', 'text', '', '', '', 0, 4, 0, 1, 1, 0, 0, 'POST,PUT');


CREATE TABLE IF NOT EXISTS `pes_form_menu` (
  `form_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_menu_listsort` int(11) NOT NULL DEFAULT '0',
  `form_menu_status` tinyint(4) NOT NULL DEFAULT '0',
  `form_menu_createtime` int(11) NOT NULL DEFAULT '0',
  `form_menu_name` varchar(255) NOT NULL DEFAULT '',
  `form_menu_type` int(11) NOT NULL DEFAULT '0',
  `form_menu_link` varchar(255) NOT NULL DEFAULT '',
  `form_menu_icon` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`form_menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `pes_form_menu`
--

INSERT INTO `pes_form_menu` (`form_menu_id`, `form_menu_listsort`, `form_menu_status`, `form_menu_createtime`, `form_menu_name`, `form_menu_type`, `form_menu_link`, `form_menu_icon`) VALUES
(1, 1, 1, 1652840160, '网站首页', 1, '/', ''),
(2, 2, 1, 1652840160, '提交工单', 0, 'Category-index', ''),
(3, 3, 1, 1652840160, '常见问题', 0, 'Fqa-list', ''),
(4, 4, 1, 1652840160, '我的工单', 0, 'Member-ticket', '');

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
(NULL, '前台菜单', 9, 'am-icon-map-signs', 'Ticket-Form_menu-index', 12, 0);


INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '前台菜单管理', 0, 0, '', 'GET', 'Form_menu', '', 0, 7);

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '前台菜单列表', LAST_INSERT_ID(), 1, '', 'GET', 'index', 'TicketGETForm_menuindex', LAST_INSERT_ID(), 10),
(NULL, '新增/编辑前台菜单', LAST_INSERT_ID(), 1, '', 'GET', 'action', 'TicketGETForm_menuaction', LAST_INSERT_ID(), 20),
(NULL, '提交新增前台菜单', LAST_INSERT_ID(), 1, '', 'POST', 'action', 'TicketPOSTForm_menuaction', LAST_INSERT_ID(), 30),
(NULL, '提交更新前台菜单', LAST_INSERT_ID(), 1, '', 'PUT', 'action', 'TicketPUTForm_menuaction', LAST_INSERT_ID(), 40),
(NULL, '提交删除前台菜单', LAST_INSERT_ID(), 1, '', 'DELETE', 'action', 'TicketDELETEForm_menuaction', LAST_INSERT_ID(), 50);
(NULL, '排序前台菜单', LAST_INSERT_ID(), 1, '', 'PUT', 'action', 'TicketPUTForm_menulistsort', LAST_INSERT_ID(), 60),
