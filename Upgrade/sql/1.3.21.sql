ALTER TABLE `pes_user` ADD `user_bind_mid` INT NOT NULL COMMENT '绑定的用户ID';

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '对客服账号绑定指定的前台账号', 21, 1, NULL, 'GET', 'bind', 'TicketGETMemberbind', 129, 200),
(NULL, '保存客服账号绑定指定前台账号', 21, 1, NULL, 'PUT', 'bind', 'TicketPUTMemberbind', 129, 210),
(NULL, '解除指定客服账号绑定前台账号', 21, 1, NULL, 'PUT', 'unbind', 'TicketPUTMemberunbind', 129, 220);