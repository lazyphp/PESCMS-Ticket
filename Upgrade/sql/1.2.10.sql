-- noinspection SqlNoDataSourceInspectionForFile

-- noinspection SqlDialectInspectionForFile

INSERT INTO `pes_field` ( `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(1, 'page', '分页数', 'text', '', '', '10', 1, 5, 1, 1, 1, 0);
ALTER TABLE `pes_model` ADD `model_page` INT NOT NULL;

UPDATE `pes_model` SET `model_page` = '10';

INSERT INTO `pes_option` (`option_name`, `name`, `value`, `option_range`) VALUES
('member_review', '审核设置', '1', 'system');