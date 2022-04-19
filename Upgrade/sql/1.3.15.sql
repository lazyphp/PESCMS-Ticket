UPDATE `pes_option` SET `value` = '[{\"color\":\"#dd514c\",\"name\":\"\\u65b0\\u5de5\\u5355\"},{\"color\":\"#F37B1D\",\"name\":\"\\u53d7\\u7406\\u4e2d\"},{\"color\":\"#3bb4f2\",\"name\":\"\\u5f85\\u56de\\u590d\"},{\"color\":\"#5eb95e\",\"name\":\"\\u5b8c\\u6210\"}]' WHERE `pes_option`.`id` = 5;

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
    (NULL, 20, 'requisition', '允许客服登录', 'radio', '{&quot;\\u7981\\u6b62&quot;:&quot;0&quot;,&quot;\\u5141\\u8bb8&quot;:&quot;1&quot;}', '', '', 1, 90, 1, 1, 1, 0);

ALTER TABLE `pes_member` ADD `member_requisition` INT NOT NULL;