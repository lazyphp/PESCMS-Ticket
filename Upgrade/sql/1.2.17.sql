INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(15, 'contact', '联系方式', 'checkbox', '{&quot;\\u90ae\\u4ef6&quot;:&quot;1&quot;,&quot;\\u624b\\u673a\\u53f7\\u7801&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;}', '', '', 1, 11, 1, 1, 1, 0),
(15, 'contact_default', '默认联系方式', 'radio', '{&quot;\\u90ae\\u4ef6&quot;:&quot;1&quot;,&quot;\\u624b\\u673a\\u53f7\\u7801&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;}', '', '', 1, 12, 0, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_contact` VARCHAR(64) NOT NULL DEFAULT '' , ADD `ticket_model_contact_default` INT(11) NOT NULL DEFAULT '0' ;

UPDATE `pes_ticket_model` SET `ticket_model_contact` = '1,2,3',  `ticket_model_contact_default` = '1';