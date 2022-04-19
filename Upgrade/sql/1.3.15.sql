UPDATE `pes_option` SET `value` = '[{\"color\":\"#dd514c\",\"name\":\"\\u65b0\\u5de5\\u5355\"},{\"color\":\"#F37B1D\",\"name\":\"\\u53d7\\u7406\\u4e2d\"},{\"color\":\"#3bb4f2\",\"name\":\"\\u5f85\\u56de\\u590d\"},{\"color\":\"#5eb95e\",\"name\":\"\\u5b8c\\u6210\"}]' WHERE `pes_option`.`id` = 5;


ALTER TABLE `pes_field` ADD `field_only` INT(11) NOT NULL , ADD `field_action` VARCHAR(255) NOT NULL;

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES (NULL, 2, 'only', '唯一', 'radio', '{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}', '', '', 1, 12, 1, 1, 1, 0, 0, 'POST,PUT'),(NULL, 2, 'action', '行为', 'checkbox', '{&quot;\\u65b0\\u589e&quot;:&quot;POST&quot;,&quot;\\u66f4\\u65b0&quot;:&quot;PUT&quot;}', '', '', 0, 13, 1, 1, 1, 0, 0, 'POST,PUT');

UPDATE `pes_field` SET `field_action` = 'POST,PUT';


INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
    (NULL, 20, 'requisition', '允许客服登录', 'radio', '{&quot;\\u7981\\u6b62&quot;:&quot;0&quot;,&quot;\\u5141\\u8bb8&quot;:&quot;1&quot;}', '', '', 1, 90, 1, 1, 1, 0, 0, 'POST,PUT');

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

