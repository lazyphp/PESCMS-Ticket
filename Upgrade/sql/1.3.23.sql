ALTER TABLE `pes_category` ADD `category_img` VARCHAR(255) NOT NULL;
INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 18, 'img', '工单分类图标', 'thumb', '', '', '', 0, 3, 0, 1, 1, 0, 0, 'POST,PUT');
UPDATE `pes_field` SET `field_listsort` = '4' WHERE `field_model_id` = 18 AND field_name = 'description';

ALTER TABLE `pes_ticket_model` ADD `ticket_model_img` VARCHAR(255) NOT NULL;
INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 15, 'img', '工单模型图标', 'thumb', '', '', '', 0, 66, 0, 1, 1, 0, 0, 'POST,PUT');

UPDATE `pes_field` SET `field_option` = '{&quot;分类&quot;:&quot;category&quot;,&quot;单行输入框&quot;:&quot;text&quot;,&quot;多行输入框&quot;:&quot;textarea&quot;,&quot;单选按钮&quot;:&quot;radio&quot;,&quot;复选框&quot;:&quot;checkbox&quot;,&quot;单选下拉框&quot;:&quot;select&quot;,&quot;多选下拉框&quot;:&quot;multiple&quot;,&quot;编辑器&quot;:&quot;editor&quot;,&quot;上传单图&quot;:&quot;thumb&quot;,&quot;上传多图&quot;:&quot;img&quot;,&quot;上传文件&quot;:&quot;file&quot;,&quot;上传视频&quot;:&quot;video&quot;,&quot;日期&quot;:&quot;date&quot;,&quot;工单模型&quot;:&quot;ticket&quot;,&quot;类型&quot;:&quot;types&quot;,&quot;选项值&quot;:&quot;option&quot;}' WHERE `pes_field`.`field_id` = 7;

ALTER TABLE `pes_field` CHANGE `field_explain` `field_explain` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

UPDATE `pes_field` SET `field_explain` = '若您的工单表单需要设置默认值，可以在这里填写对应的数值。页面渲染时会自动填充。<br/>部分表单类型默认值的作用说明：<a href=\"https://document.pescms.com/article/3/552003742304567296.html\" target="_blank">「编辑器作用说明」</a> <a href=\"https://document.pescms.com/article/3/649484225052934144.html\" target="_blank">「上传组件作用说明」</a> <br/>注意：部分表单类型可能不起效' WHERE `pes_field`.`field_id` = 295;

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES (NULL, '查看模板首页设置', '144', '0', NULL, 'GET', 'index', 'TicketGETThemesetting', '144', '9');

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES (NULL, '更新模板首页设置', '144', '0', NULL, 'PUT', 'index', 'TicketPUTThemesetting', '144', '10');

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '查看发送列表', 11, 1, NULL, 'GET', 'index', 'TicketGETSendindex', 99, 9900),
(NULL, '新增/编辑发送消息', 11, 1, NULL, 'GET', 'action', 'TicketGETSendaction', 99, 9901),
(NULL, '新增发送消息', 11, 1, NULL, 'POST', 'action', 'TicketPOSTSendaction', 99, 9902),
(NULL, '更新发送消息', 11, 1, NULL, 'PUT', 'action', 'TicketPUTSendaction', 99, 9903),
(NULL, '删除发送记录', 11, 1, NULL, 'DELETE', 'action', 'TicketDELETESendaction', 99, 9904),
(NULL, '重新发送发送记录', 11, 1, NULL, 'PUT', 'refresh', 'TicketPUTSendrefresh', 99, 9905);


INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '查看客服消息模板列表', 11, 1, NULL, 'GET', 'index', 'TicketGETCssend_templateindex', 99, 9920),
(NULL, '新增/编辑客服消息模板', 11, 1, NULL, 'GET', 'action', 'TicketGETCssend_templateaction', 99, 9921),
(NULL, '新增客服消息模板', 11, 1, NULL, 'POST', 'action', 'TicketPOSTCssend_templateaction', 99, 9922),
(NULL, '更新客服消息模板', 11, 1, NULL, 'PUT', 'action', 'TicketPUTCssend_templateaction', 99, 9923),
(NULL, '删除客服消息模板', 11, 1, NULL, 'DELETE', 'action', 'TicketDELETECssend_templateaction', 99, 9924);

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES (NULL, '本地应用', '9', 'am-icon-sliders', 'Ticket-Application-local', '3', '0');

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES (NULL, '模板商店', '9', 'am-icon-shopping-bag', 'Ticket-Theme-shop', '10', '0');

ALTER TABLE `pes_menu` CHANGE `menu_listsort` `menu_listsort` INT(11) NOT NULL DEFAULT '0';
