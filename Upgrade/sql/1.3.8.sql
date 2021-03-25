INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(NULL, 'register_form', '注册填写选项', '{\"email\":\"email\",\"account\":\"account\",\"phone\":\"phone\"}', 'system');
ALTER TABLE `pes_ticket` ADD `old_user_id` INT NOT NULL COMMENT '上一任的负责人ID' AFTER `user_id`;
