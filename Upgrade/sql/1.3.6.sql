SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

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
COMMIT;

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
