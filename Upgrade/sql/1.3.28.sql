UPDATE `pes_field` SET `field_explain` = '1. 默认留空单号规则随机生成。<br/>2. 只填写{X}则用雪花ID规则。<br/>3. 关键词{Y}是年，{M}是月，{D}是日，{His}是时分秒，{Z}是当前工单模型提交的工单总数量，{A}是今天工单模型提交工单数量，{S}是五位数的随机值。<br/>4.<strong style="color:red">自定义单号规则请尽量带上{His}或者{S}</strong>，避免出现工单无法打开的问题。' WHERE `pes_field`.`field_model_id` = 15 AND `field_name` = 'custom_no';
UPDATE `pes_cssend_template` SET `cssend_template_content` = '{old_user_name}将工单号为{ticket_number}指派给了您，请您协助他/她尽快解决该工单问题。详情: {handle_link}' WHERE `pes_cssend_template`.`cssend_template_id` = 3;

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'job_number_format', '客服工号格式', 'PT%05d', 'cs');