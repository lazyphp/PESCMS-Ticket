CREATE TABLE IF NOT EXISTS `pes_ticket_status_line` (
  `status_line_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `ticket_status` int(11) NOT NULL COMMENT '工单状态',
  `member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `display_name` VARCHAR(255) NOT NULL COMMENT '显示名称',
  `status_line_time` int(11) NOT NULL COMMENT '生成时的时间',
  PRIMARY KEY (`status_line_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='工单状态线';

ALTER TABLE `pes_ticket` ADD `ticket_close_reason` VARCHAR(255) NOT NULL COMMENT '工单关闭理由' AFTER `ticket_close`;

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'ticket_read', '是否开启工单已读标识', '0', 'system');

ALTER TABLE `pes_ticket_chat` ADD `ticket_chat_read` TINYINT(1) NOT NULL COMMENT '工单沟通内容是否已读';
