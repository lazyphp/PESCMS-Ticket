ALTER TABLE `pes_ticket` ADD `ticket_appointment_time` INT NOT NULL COMMENT '预约工单时间';
ALTER TABLE `pes_ticket` ADD INDEX(`ticket_model_id`);
ALTER TABLE `pes_ticket` ADD INDEX(`ticket_appointment_time`);


UPDATE `pes_field` SET `field_explain` = '若您的工单表单需要设置默认值，可以在这里填写对应的数值。页面渲染时会自动填充。<br/>部分表单类型默认值的作用说明：<a href=\"https://document.pescms.com/article/3/552003742304567296.html\" target=\"_blank\">「编辑器作用说明」</a> <a href=\"https://document.pescms.com/article/3/649484225052934144.html\" target=\"_blank\">「上传组件作用说明」</a> <br/>注意：部分表单类型可能不起效' WHERE `pes_field`.`field_id` = 294;

UPDATE `pes_field` SET `field_display_name` = '工单恢复期限（天）', `field_explain` = '默认工单模型有7天反悔期，前台和后台标记完成后，只要在标记完成即日起不超过预设的天数即可恢复工单为受理状态。' WHERE `pes_field`.`field_id` = 295;

UPDATE `pes_field` SET `field_listsort` = '-1' WHERE `pes_field`.`field_id` = 153;
UPDATE `pes_field` SET `field_listsort` = '70' WHERE `pes_field`.`field_id` = 283;
UPDATE `pes_field` SET `field_listsort` = '2' WHERE `pes_field`.`field_id` = 186;
UPDATE `pes_field` SET `field_listsort` = '5' WHERE `pes_field`.`field_id` = 154;
UPDATE `pes_field` SET `field_listsort` = '40' WHERE `pes_field`.`field_id` = 291;
UPDATE `pes_field` SET `field_listsort` = '20' WHERE `pes_field`.`field_id` = 168;
UPDATE `pes_field` SET `field_listsort` = '30' WHERE `pes_field`.`field_id` = 169;


UPDATE `pes_field` SET `field_default` = '0' WHERE `pes_field`.`field_id` = 268;
UPDATE `pes_field` SET `field_default` = '0' WHERE `pes_field`.`field_id` = 267;

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 15, 'is_appointment', '是否预约工单', 'radio', '{&quot;普通工单&quot;:&quot;0&quot;,&quot;预约工单&quot;:&quot;1&quot;}', '', '0', 0, 10, 1, 1, 1, 0, 0, 'POST,PUT');

ALTER TABLE `pes_ticket_model` ADD `ticket_model_is_appointment` INT NOT NULL COMMENT '是否预约工单';
ALTER TABLE `pes_ticket_model` ADD `ticket_model_appointment_config` TEXT NOT NULL COMMENT '预约配置信息' AFTER `ticket_model_is_appointment`;