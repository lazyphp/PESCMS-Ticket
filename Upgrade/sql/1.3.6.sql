CREATE TABLE `pes_certificate` (
  `certificate_id` int(11) NOT NULL,
  `certificate_value` varchar(128) NOT NULL,
  `certificate_openid` varchar(128) NOT NULL COMMENT '微信用户ID',
  `certificate_token` varchar(128) NOT NULL COMMENT 'token',
  `certificate_systeminfo` text NOT NULL COMMENT '系统信息',
  `certificate_time` int(11) NOT NULL COMMENT '有效期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `pes_certificate`
  ADD PRIMARY KEY (`certificate_id`),
  ADD KEY `certificate_value` (`certificate_value`),
  ADD KEY `certificate_token` (`certificate_token`),
  ADD KEY `openid` (`certificate_openid`);

ALTER TABLE `pes_certificate`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(NULL, 20, 'wxapp', '微信小程序用户ID', 'text', '', '', '', 0, 11, 0, 1, 1, 1);

ALTER TABLE `pes_member` ADD `member_wxapp` VARCHAR(255) NULL COMMENT '小程序用户ID';
ALTER TABLE `pes_member` ADD `member_avatar` VARCHAR(255) NOT NULL COMMENT '用户头像';

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES (NULL, '17', 'wxapp_template_id', '微信小程序模板ID', 'text', '', '', '', '0', '7', '0', '1', '1', '0');

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES (NULL, '17', 'wxapp_template', '微信小程序模板内容', 'textarea', '', '请按照微信小程序选择模板的格式填写对应的参数。', '', '0', '8', '0', '1', '1', '0');

ALTER TABLE `pes_mail_template` ADD `mail_template_wxapp_template_id` VARCHAR(128) NOT NULL AFTER `mail_template_weixin_template`, ADD `mail_template_wxapp_template` TEXT NOT NULL AFTER `mail_template_wxapp_template_id`;


UPDATE `pes_field` SET `field_option` = '{&quot;\\u90ae\\u4ef6&quot;:&quot;1&quot;,&quot;\\u624b\\u673a\\u53f7\\u7801&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;,&quot;\\u5fae\\u4fe1\\u5c0f\\u7a0b\\u5e8f&quot;:&quot;6&quot;}' WHERE `pes_field`.`field_model_id` = 15 AND field_name = 'contact';

UPDATE `pes_field` SET `field_option` = '{&quot;\\u90ae\\u4ef6&quot;:&quot;1&quot;,&quot;\\u624b\\u673a\\u53f7\\u7801&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;,&quot;\\u5fae\\u4fe1\\u5c0f\\u7a0b\\u5e8f&quot;:&quot;6&quot;}' WHERE `pes_field`.`field_model_id` = 15 AND field_name = 'contact_default';

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'wxapp_api', '微信接口', '{\"appID\":\"\",\"appsecret\":\"\"}', 'system');

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '客户管理', 0, 0, '', 'GET', 'Member', '', 0, 4);

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '客户列表列表', LAST_INSERT_ID(), 1, '', 'GET', 'index', 'TicketGETMemberindex', LAST_INSERT_ID(), 10),
(NULL, '新增/编辑客户', LAST_INSERT_ID(), 1, '', 'GET', 'action', 'TicketGETMemberaction', LAST_INSERT_ID(), 20),
(NULL, '提交新增客户', LAST_INSERT_ID(), 1, '', 'POST', 'action', 'TicketPOSTMemberaction', LAST_INSERT_ID(), 30),
(NULL, '提交更新客户', LAST_INSERT_ID(), 1, '', 'PUT', 'action', 'TicketPUTMemberaction', LAST_INSERT_ID(), 40),
(NULL, '提交删除客户', LAST_INSERT_ID(), 1, '', 'DELETE', 'action', 'TicketDELETEMemberaction', LAST_INSERT_ID(), 50),
(NULL, '创建工单', 2, 1, '', 'GET', 'issue', 'TicketGETMemberissue', LAST_INSERT_ID(), 50),
(NULL, '创建工单-登录客户账号', 2, 1, '', 'GET', 'issueLogin', 'TicketGETMemberissueLogin', LAST_INSERT_ID(), 50);

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '客户分组管理', 0, 0, '', 'GET', 'Member_organize', '', 0, 4);

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '客户分组列表列表', LAST_INSERT_ID(), 1, '', 'GET', 'index', 'TicketGETMember_organizeindex', LAST_INSERT_ID(), 10),
(NULL, '新增/编辑客户分组', LAST_INSERT_ID(), 1, '', 'GET', 'action', 'TicketGETMember_organizeaction', LAST_INSERT_ID(), 20),
(NULL, '提交新增客户分组', LAST_INSERT_ID(), 1, '', 'POST', 'action', 'TicketPOSTMember_organizeaction', LAST_INSERT_ID(), 30),
(NULL, '提交更新客户分组', LAST_INSERT_ID(), 1, '', 'PUT', 'action', 'TicketPUTMember_organizeaction', LAST_INSERT_ID(), 40),
(NULL, '提交删除客户分组', LAST_INSERT_ID(), 1, '', 'DELETE', 'action', 'TicketDELETEMember_organizeaction', LAST_INSERT_ID(), 50);