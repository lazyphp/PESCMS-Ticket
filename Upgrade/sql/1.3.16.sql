UPDATE `pes_field` SET `field_explain` = '1. 默认留空单号规则随机生成。2. 只填写{X}则用雪花ID规则。3. 关键词{Y}是年，{M}是月，{D}是日，{Z}是当前工单模型提交的工单总数量，{A}是今天工单模型提交工单数量，{S}是五位数的随机值。' WHERE `pes_field`.`field_id` = 283;
