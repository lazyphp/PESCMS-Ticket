INSERT INTO `pes_field` ( `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(1, 'page', '分页数', 'text', '', '', '10', 1, 5, 1, 1, 1, 0);
ALTER TABLE `pes_model` ADD `model_page` INT(11) NOT NULL DEFAULT '10';

UPDATE `pes_model` SET `model_page` = '10';

INSERT INTO `pes_option` (`option_name`, `name`, `value`, `option_range`) VALUES
('member_review', '审核设置', '1', 'system');

INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(15, 'time_out', '工单超时时长(分钟)', 'text', '', '有新工单提交后，在指定时间内无人受理工单，系统将发送通知给工单所在的管辖组成员。', '10', 1, 8, 1, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_time_out` INT(11) NOT NULL DEFAULT '10' COMMENT '工单超时提醒设置' ;

UPDATE `pes_ticket_model` SET `ticket_model_time_out` = '10';


INSERT INTO `pes_field` (`field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(15, 'time_out_sequence', '超时提醒次数', 'text', '', '工单无人受理超时通知次数，系统将按照工单超时时长的间隔进行重复通知。', '1', 1, 9, 0, 1, 1, 0);

ALTER TABLE `pes_ticket_model` ADD `ticket_model_time_out_sequence` INT(11) NOT NULL DEFAULT '1' COMMENT '超时提醒次数';

UPDATE `pes_ticket_model` SET `ticket_model_time_out_sequence` = '1';

ALTER TABLE `pes_ticket` ADD `ticket_time_out_sequence` INT(11) NOT NULL DEFAULT '0' COMMENT '已通知超时次数' AFTER `ticket_comment`;