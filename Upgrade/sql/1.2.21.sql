UPDATE `pes_field` SET `field_option` = '{"\\u5206\\u7c7b":"category","\\u5355\\u884c\\u8f93\\u5165\\u6846":"text","\\u591a\\u884c\\u8f93\\u5165\\u6846":"textarea","\\u5355\\u9009\\u6309\\u94ae":"radio","\\u590d\\u9009\\u6846":"checkbox","\\u5355\\u9009\\u4e0b\\u62c9\\u6846":"select","\\u591a\\u9009\\u4e0b\\u62c9\\u6846":"multiple","\\u7f16\\u8f91\\u5668":"editor","\\u7f29\\u7565\\u56fe":"thumb","\\u4e0a\\u4f20\\u56fe\\u7ec4":"img","\\u4e0a\\u4f20\\u6587\\u4ef6":"file","\\u65e5\\u671f":"date","\\u5de5\\u5355\\u6a21\\u578b":"ticket","\\u7c7b\\u578b":"types","\\u9009\\u9879\\u503c":"option"}' WHERE `field_id` = 7;

UPDATE `pes_field` SET `field_type` = 'option', `field_explain` = '目前选项适用于单选，复选，下拉菜单。其余功能填写也不会产生任何实际效果。' WHERE `field_id` = 161;

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'max_upload_size', '上传大小', '1', 'upload');

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'siteStyle', '自定义样式', '', 'system');

UPDATE `pes_field` SET `field_list` = '0' WHERE `field_id` = 154;