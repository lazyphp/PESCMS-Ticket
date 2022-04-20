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


