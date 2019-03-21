
INSERT INTO `pes_option` (option_name`, `name`, `value`, `option_range`) VALUES
('sms', '短信接口', '', 'system');

ALTER TABLE `pes_mail_template` ADD `mail_template_sms` VARCHAR(500) NOT NULL DEFAULT '' ;

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(17, 'sms', '短信模板内容', 'textarea', '', '在短信模板内容，输入如下变量可以动态输出对应的值：{number}为工单号码，{view}为工单查询的链接地址。另外请到短信平台按照要求添加一致的模板。', '', 1, 4, 0, 1, 1, 0);

UPDATE `pes_mail_template` SET `mail_template_sms` = '我们已经收到您提交的工单，我们将尽快安排人员为您解疑释惑。您的工单编号为：{number}。请不要把验证码泄露给其他人。' WHERE `pes_mail_template`.`mail_template_type` = 1;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您的工单已经受理，我们将会尽快解决您的问题，请耐心等待。 查看工单进度，可以点击如下链接访问：{view}' WHERE `pes_mail_template`.`mail_template_type` = 2;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您好，您的工单:{number} 有新的回复。点击如下链接可以查看工单的进度:{view}' WHERE `pes_mail_template`.`mail_template_type` = 3;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您好，您的工单{number}需要转交客服处理，请耐心等待。' WHERE `pes_mail_template`.`mail_template_type` = 4;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您好，您的工单:{number}已经被客服标记为完成状态。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的耐心等待。' WHERE `pes_mail_template`.`mail_template_type` = 5;

UPDATE `pes_mail_template` SET `mail_template_sms` = '您好，非常抱歉地告诉您，您的工单:{number}已经被客服标关闭。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的反馈。' WHERE `pes_mail_template`.`mail_template_type` = 6;

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
