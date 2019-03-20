-- 短信设置相关SQL
INSERT INTO `pes_option` (`option_name`, `name`, `value`, `option_range`) VALUES
('sms', '短信接口', '', 'system');

ALTER TABLE `pes_mail_template` ADD `mail_template_sms` VARCHAR(500) NOT NULL DEFAULT '' ;

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(17, 'sms', '短信模板内容', 'textarea', '', '在短信模板内容，输入如下变量可以动态输出对应的值：{number}为工单号码，{view}为工单查询的链接地址。另外请到短信平台按照要求添加一致的模板。', '', 1, 4, 0, 1, 1, 0);

UPDATE `pes_mail_template` SET `mail_template_sms` = '我们已经收到您提交的工单，我们将尽快安排人员为您解疑释惑。您的工单编号为：{number}。请不要把工单号码泄露给其他人。' WHERE `pes_mail_template`.`mail_template_type` = 1;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您的工单已经受理，我们将会尽快解决您的问题，请耐心等待。 查看工单进度，可以点击如下链接访问：{view}' WHERE `pes_mail_template`.`mail_template_type` = 2;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您好，您的工单:{number} 有新的回复。点击如下链接可以查看工单的进度:{view}' WHERE `pes_mail_template`.`mail_template_type` = 3;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您好，您的工单{number}需要转交客服处理，请耐心等待。' WHERE `pes_mail_template`.`mail_template_type` = 4;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您好，您的工单:{number}已经被客服标记为完成状态。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的耐心等待。' WHERE `pes_mail_template`.`mail_template_type` = 5;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您好，非常抱歉地告诉您，您的工单:{number}已经被客服标关闭。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的反馈。' WHERE `pes_mail_template`.`mail_template_type` = 6;

-- 回复短语相关SQL
CREATE TABLE IF NOT EXISTS `pes_phrase` (
  `phrase_id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase_listsort` int(11) NOT NULL DEFAULT '0',
  `phrase_name` varchar(255) NOT NULL DEFAULT '',
  `phrase_content` text NOT NULL,
  `phrase_user_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`phrase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`) VALUES
(22, 'Phrase', '回复短语', 1, 0, 2);

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(221, 22, 'listsort', '排序', 'text', '', '', '', 0, 98, 1, 1, 1, 0),
(223, 22, 'name', '短语名称', 'text', '', '', '', 0, 1, 1, 1, 1, 0),
(224, 22, 'content', '内容', 'editor', '', '', '', 1, 2, 0, 1, 1, 0),
(225, 22, 'user_id', '所属者', 'text', '', '', '', 0, 90, 0, 0, 1, 0);

-- FQA相关SQL
UPDATE `pes_field` SET `field_option` = '{"\\u5206\\u7c7b":"category","\\u5355\\u884c\\u8f93\\u5165\\u6846":"text","\\u591a\\u884c\\u8f93\\u5165\\u6846":"textarea","\\u5355\\u9009\\u6309\\u94ae":"radio","\\u590d\\u9009\\u6846":"checkbox","\\u5355\\u9009\\u4e0b\\u62c9\\u6846":"select","\\u591a\\u9009\\u4e0b\\u62c9\\u6846":"multiple","\\u7f16\\u8f91\\u5668":"editor","\\u7565\\u7f29\\u56fe":"thumb","\\u4e0a\\u4f20\\u56fe\\u7ec4":"img","\\u4e0a\\u4f20\\u6587\\u4ef6":"file","\\u65e5\\u671f":"date","\\u5de5\\u5355\\u6a21\\u578b":"ticket","\\u7c7b\\u578b":"types"}' WHERE `pes_field`.`field_id` = 7;

CREATE TABLE IF NOT EXISTS `pes_fqa` (
  `fqa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fqa_listsort` int(11) NOT NULL DEFAULT '0',
  `fqa_status` tinyint(4) NOT NULL DEFAULT '0',
  `fqa_url` varchar(255) NOT NULL DEFAULT '',
  `fqa_createtime` int(11) NOT NULL DEFAULT '0',
  `fqa_ticket_model_id` int(11) NOT NULL DEFAULT '0',
  `fqa_title` varchar(255) NOT NULL DEFAULT '',
  `fqa_content` text NOT NULL,
  PRIMARY KEY (`fqa_id`),
  KEY `fqa_ticket_model_id` (`fqa_ticket_model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`) VALUES
(23, 'Fqa', '常见问题解答', 1, 1, 1);


INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(23, 'status', '状态', 'radio', '{"\\u7981\\u7528":"0","\\u542f\\u7528":"1"}', '', '1', 1, 100, 1, 1, 1, 0),
(23, 'listsort', '排序', 'text', '', '', '', 0, 98, 1, 1, 1, 0),
(23, 'createtime', '创建时间', 'date', '', '', '', 0, 99, 1, 1, 1, 0),
(23, 'ticket_model_id', '对应工单', 'ticket', '', '', '', 1, 1, 1, 1, 1, 0),
(23, 'title', '标题', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(23, 'content', '详细内容', 'editor', '', '', '', 1, 3, 0, 1, 1, 0);

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(84, '常见问题', 11, 1, '', 'GET', 'Fqa', '', 0, 8),
(85, 'FQA列表', 7, 1, '', 'GET', 'index', 'TicketGETFqaindex', 84, 110),
(86, 'FQA编辑', 7, 1, '', 'GET', 'action', 'TicketGETFqaaction', 84, 111),
(87, 'FQA添加', 7, 1, '', 'POST', 'action', 'TicketPOSTFqaaction', 84, 112),
(88, 'FQA更新', 7, 1, '', 'PUT', 'action', 'TicketPUTFqaaction', 84, 113),
(89, 'FQA删除', 7, 1, '', 'DELETE', 'action', 'TicketDELETEFqaaction', 84, 114);

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
(32, '常见问题解答', 1, 'am-icon-question-circle', 'Ticket-Fqa-index', 20, 0);

