ALTER TABLE `pes_field` ADD `field_is_null` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否为空' ;

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(2, 'is_null', '是否为空', 'radio', '{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}', '', '', 0, 7, 1, 1, 1, 0);

UPDATE `pes_field` SET `field_is_null` = '1' WHERE `field_model_id` = 7 AND field_name = 'weixinWork';