INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'siteTongji', '网站统计代码', '', 'system');
INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'weixinRegister', '微信公众号注册需要填写完整的用户资料', '0', 'system');
ALTER TABLE `pes_user_group` ADD `user_group_view_type` TINYINT(1) NOT NULL ;

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(6, 'view_type', '允许查看所有用户', 'radio', '{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}', '若您希望本用户组的用户可以查看所有用户信息，请勾选是。', '', 1, 2, 1, 1, 1, 0);

ALTER TABLE `pes_ticket` ADD `ticket_remark` VARCHAR(64) NOT NULL DEFAULT '' COMMENT '工单备注说明' ;