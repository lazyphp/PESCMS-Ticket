UPDATE `pes_menu` SET menu_link = 'Ticket-Application-shop' WHERE `menu_link` LIKE 'Ticket-Application-index';

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'sms_login', '开启手机验证码登录', '0', 'system'),
(NULL, 'sms_verify_template', '手机验证码模板', '您的验证码是:{sms_code}，有效期十分钟。若非本人操作，请忽略本短信。', 'sms');

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'resend_time', '重新发送消息间隔(秒)', '60', 'system'),
(NULL, 'send_limit_count', '1小时发送限制', '5', 'system');


INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'enable_proxy', '是否开启代理', '0', 'system'),
(NULL, 'REMOTE_ADDR', 'HTTP头信息传递的IP信息', 'HTTP_X_FORWARDED_FOR', 'system');

CREATE TABLE IF NOT EXISTS `pes_send_limit` (
  `send_limit_id` int(11) NOT NULL AUTO_INCREMENT,
  `send_limit_account` varchar(255) NOT NULL COMMENT '发送账号',
  `send_limit_ip` varchar(255) NOT NULL COMMENT '发送者IP',
  `send_limit_type` int(11) NOT NULL COMMENT '发送类型 | 参考工单发送类型。0为注册类的验证码',
  `send_limit_time` int(11) NOT NULL COMMENT '发送时间',
  PRIMARY KEY (`send_limit_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='发送限制';

CREATE TABLE IF NOT EXISTS `pes_sms_code` (
  `sms_code_id` int(11) NOT NULL AUTO_INCREMENT,
  `sms_code_phone` varchar(32) NOT NULL COMMENT '接收短信的手机号码',
  `sms_code` varchar(16) NOT NULL COMMENT '验证码',
  `sms_code_used` int(11) NOT NULL COMMENT '是否已使用 0:未 1:已用',
  `sms_code_send_time` int(11) NOT NULL COMMENT '发送时间',
  PRIMARY KEY (`sms_code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '删除回复的工单内容', 2, 1, '您没有权限删除对话内容', 'DELETE', 'action', 'TicketDELETETicketchat', 2, 6);
