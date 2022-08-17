UPDATE `pes_node`
SET `node_check_value` = 'TicketGETBulletinindex'
WHERE `pes_node`.`node_id` = 116;

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`,`node_value`, `node_check_value`, `node_controller`, `node_listsort`)
VALUES (NULL, '应用商店', '0', '0', NULL, 'GET', 'Application', '', '0', '2800');

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`)
VALUES
(NULL, '打开应用商店', LAST_INSERT_ID(), '0', NULL, 'GET', 'index', 'TicketGETApplicationindex', LAST_INSERT_ID(), '0'),
(NULL, '打开本地应用', LAST_INSERT_ID(), '0', NULL, 'GET', 'index', 'TicketGETApplicationlocal', LAST_INSERT_ID(), '0'),
(NULL, '安装应用', LAST_INSERT_ID(), '0', NULL, 'GET', 'index', 'TicketGETApplicationinstall', LAST_INSERT_ID(), '0'),
(NULL, '更新应用', LAST_INSERT_ID(), '0', NULL, 'GET', 'index', 'TicketGETApplicationupgrade', LAST_INSERT_ID(), '0');

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`,`node_value`, `node_check_value`, `node_controller`, `node_listsort`)
VALUES (NULL, '前台菜单', '0', '0', NULL, 'GET', 'Form_menu', '', '0', '2900');
INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(NULL, '前台菜单列表', LAST_INSERT_ID(), 0, NULL, 'GET', 'index', 'TicketGETForm_menuindex', LAST_INSERT_ID(), 0),
(NULL, '新增/编辑前台菜单', LAST_INSERT_ID(), 0, NULL, 'GET', 'action', 'TicketGETForm_menuaction', LAST_INSERT_ID(), 1),
(NULL, '请求新增前台菜单', LAST_INSERT_ID(), 0, NULL, 'POST', 'action', 'TicketPOSTForm_menuaction', LAST_INSERT_ID(), 2),
(NULL, '请求更新前台菜单', LAST_INSERT_ID(), 0, NULL, 'PUT', 'action', 'TicketPUTForm_menuaction', LAST_INSERT_ID(), 3),
(NULL, '排序前台菜单', LAST_INSERT_ID(), 0, NULL, 'PUT', 'listsort', 'TicketPUTForm_menulistsort', LAST_INSERT_ID(), 3),
(NULL, '请求删除前台菜单', LAST_INSERT_ID(), 0, NULL, 'DELETE', 'action', 'TicketDELETEForm_menuaction', LAST_INSERT_ID(), 4);

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`,`node_value`, `node_check_value`, `node_controller`, `node_listsort`)
VALUES (NULL, '模板商店', '0', '0', NULL, 'GET', 'Theme', '', '0', '2800');

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`)
VALUES
(NULL, '打开模板商店', LAST_INSERT_ID(), '0', NULL, 'GET', 'index', 'TicketGETThemeshop', LAST_INSERT_ID(), '0'),
(NULL, '模板列表', LAST_INSERT_ID(), '0', NULL, 'GET', 'index', 'TicketGETThemeindex', LAST_INSERT_ID(), '0'),
(NULL, '安装模板', LAST_INSERT_ID(), '0', NULL, 'GET', 'index', 'TicketGETThemeinstall', LAST_INSERT_ID(), '0'),
(NULL, '更新模板', LAST_INSERT_ID(), '0', NULL, 'GET', 'index', 'TicketGETThemeupgrade', LAST_INSERT_ID(), '0'),
(NULL, '切换模板', LAST_INSERT_ID(), '0', NULL, 'PUT', 'index', 'TicketGETThemecall', LAST_INSERT_ID(), '0');

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
(NULL, '日志快查', 9, 'am-icon-ambulance', 'Ticket-Log-index', 90, 0);
