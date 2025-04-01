UPDATE `pes_field` SET `field_explain` = '1. 默认留空单号规则随机生成。<br/>2. 只填写{X}则用雪花ID规则。<br/>3. 关键词{Y}是年，{M}是月，{D}是日，{His}是时分秒，{Z}是当前工单模型提交的工单总数量，{A}是今天工单模型提交工单数量，{S}是五位数的随机值。<br/>4.<strong style="color:red">自定义单号规则请尽量带上{His}或者{S}</strong>，避免出现工单无法打开的问题。' WHERE `pes_field`.`field_model_id` = 15 AND `field_name` = 'custom_no';
UPDATE `pes_cssend_template` SET `cssend_template_content` = '{old_user_name}将工单号为{ticket_number}指派给了您，请您协助他/她尽快解决该工单问题。详情: {handle_link}' WHERE `pes_cssend_template`.`cssend_template_id` = 3;

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'job_number_format', '客服工号格式', 'PT%05d', 'cs');

UPDATE `pes_option` SET `value` = '{\"accept\":{\"title\":\"\\u5de5\\u5355\\u53d7\\u7406\\u56de\\u590d\",\"content\":\"\\u60a8\\u597d\\uff0c\\u60a8\\u7684\\u5de5\\u5355\\u5df2\\u6210\\u529f\\u53d7\\u7406\\uff08\\u53d7\\u7406\\u5ba2\\u670d\\u5de5\\u53f7\\uff1a{job_number}\\uff09\\u3002\\u6211\\u4eec\\u7684\\u5ba2\\u670d\\u56e2\\u961f\\u5c06\\u5c3d\\u5feb\\u5b89\\u6392\\u4eba\\u5458\\u5904\\u7406\\uff0c\\u611f\\u8c22\\u60a8\\u7684\\u8010\\u5fc3\\u7b49\\u5f85\\u3002\\u5982\\u6709\\u4efb\\u4f55\\u95ee\\u9898\\uff0c\\u6b22\\u8fce\\u968f\\u65f6\\u8054\\u7cfb\\u3002\"},\"assign\":{\"title\":\"\\u5de5\\u5355\\u8f6c\\u6d3e\\u56de\\u590d\",\"content\":\"\\u5f53\\u524d\\u95ee\\u9898\\u9700\\u8981\\u79fb\\u4ea4\\u7ed9\\u5176\\u4ed6\\u5ba2\\u670d\\u4eba\\u5458\\u5904\\u7406\\uff0c\\u8bf7\\u60a8\\u8010\\u5fc3\\u7b49\\u5f85\\uff0c\\u6211\\u4eec\\u5c06\\u5c3d\\u5feb\\u4e3a\\u60a8\\u5b89\\u6392\\u3002\\u5982\\u6709\\u7591\\u95ee\\uff0c\\u6b22\\u8fce\\u968f\\u65f6\\u8054\\u7cfb\\u3002\"},\"complete\":{\"title\":\"\\u5de5\\u5355\\u5b8c\\u6210\\u56de\\u590d\",\"content\":\"\\u60a8\\u7684\\u5de5\\u5355\\u5df2\\u5904\\u7406\\u5b8c\\u6bd5\\uff0c\\u5df2\\u7531\\u5ba2\\u670d\\u5de5\\u53f7{job_number}\\u7ed3\\u675f\\u3002\\u5982\\u679c\\u60a8\\u8fd8\\u6709\\u4efb\\u4f55\\u7591\\u95ee\\uff0c\\u8bf7\\u91cd\\u65b0\\u53d1\\u8d77\\u5de5\\u5355\\u54a8\\u8be2\\u3002\\u611f\\u8c22\\u60a8\\u7684\\u652f\\u6301\\u4e0e\\u7406\\u89e3\\u3002\"},\"close\":{\"title\":\"\\u5de5\\u5355\\u5173\\u95ed\\u56de\\u590d\",\"content\":\"\\u60a8\\u7684\\u5de5\\u5355\\u5df2\\u5173\\u95ed\\uff08\\u5904\\u7406\\u5ba2\\u670d\\u5de5\\u53f7\\uff1a{job_number}\\uff09\\u3002\\u82e5\\u60a8\\u6709\\u4efb\\u4f55\\u7591\\u95ee\\u6216\\u9700\\u8981\\u8fdb\\u4e00\\u6b65\\u5e2e\\u52a9\\uff0c\\u8bf7\\u91cd\\u65b0\\u53d1\\u8d77\\u5de5\\u5355\\u54a8\\u8be2\\u3002\\u611f\\u8c22\\u60a8\\u7684\\u7406\\u89e3\\u4e0e\\u652f\\u6301\\uff01\"},\"recovery\":{\"title\":\"\\u5de5\\u5355\\u72b6\\u6001\\u91cd\\u7f6e\\u56de\\u590d\",\"content\":\"\\u56e0\\u4e1a\\u52a1\\u9700\\u6c42\\uff0c\\u5ba2\\u670d\\u5de5\\u53f7{job_number}\\u5df2\\u5c06\\u60a8\\u7684\\u5de5\\u5355\\u72b6\\u6001\\u91cd\\u7f6e\\u3002\\u5982\\u6709\\u4efb\\u4f55\\u7591\\u95ee\\uff0c\\u6b22\\u8fce\\u968f\\u65f6\\u8054\\u7cfb\\u3002\\u611f\\u8c22\\u60a8\\u7684\\u7406\\u89e3\\u4e0e\\u652f\\u6301\\uff01\"}}' WHERE `option_name` = 'cs_text';

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'doc', '文档系统API设置', '{\"url\":\"\",\"authorization\":\"\"}', 'doc');

UPDATE `pes_field` SET `field_listsort` = '10' WHERE `pes_field`.`field_id` = 230;
UPDATE `pes_field` SET `field_listsort` = '30', `field_required` = 0 WHERE `pes_field`.`field_id` = 231;

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`, `field_only`, `field_action`) VALUES
(NULL, 23, 'type', '文章类型', 'radio', '{&quot;站内文章&quot;:&quot;0&quot;,&quot;站外文章&quot;:&quot;1&quot;}', '', '0', 1, 2, 1, 1, 1, 0, 0, 'POST,PUT'),
(NULL, 23, 'link', '外链地址', 'text', '', '', '', 0, 3, 0, 1, 1, 0, 0, 'POST,PUT');

ALTER TABLE `pes_fqa` ADD `fqa_type` INT NOT NULL COMMENT 'FQA文章类型' AFTER `fqa_content`, ADD `fqa_link` VARCHAR(255) NOT NULL COMMENT 'FQA外链地址' AFTER `fqa_type`;

ALTER TABLE `pes_fqa` ADD `fqa_is_doc` INT NOT NULL COMMENT '判断是否doc文档';
