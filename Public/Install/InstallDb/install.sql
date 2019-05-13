-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-05-13 01:28:02
-- 服务器版本： 5.6.25-log
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ticket`
--

-- --------------------------------------------------------

--
-- 表的结构 `pes_category`
--

CREATE TABLE IF NOT EXISTS `pes_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_listsort` int(11) NOT NULL DEFAULT '0',
  `category_status` tinyint(4) NOT NULL DEFAULT '0',
  `category_name` varchar(255) NOT NULL DEFAULT '',
  `category_parent` int(11) NOT NULL DEFAULT '0',
  `category_description` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_field`
--

CREATE TABLE IF NOT EXISTS `pes_field` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_model_id` int(11) NOT NULL,
  `field_name` varchar(128) NOT NULL DEFAULT '',
  `field_display_name` varchar(128) NOT NULL DEFAULT '',
  `field_type` varchar(128) NOT NULL DEFAULT '',
  `field_option` text NOT NULL,
  `field_explain` varchar(128) NOT NULL DEFAULT '',
  `field_default` varchar(128) NOT NULL DEFAULT '',
  `field_required` tinyint(4) NOT NULL DEFAULT '0',
  `field_listsort` int(11) NOT NULL DEFAULT '0',
  `field_list` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示于列表',
  `field_form` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示于表单 0:否 1:显示',
  `field_status` tinyint(4) NOT NULL DEFAULT '0',
  `field_is_null` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为空',
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `modle_id` (`field_model_id`,`field_name`),
  KEY `field_name` (`field_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240 ;

--
-- 转存表中的数据 `pes_field`
--

INSERT INTO `pes_field` (`field_id`, `field_model_id`, `field_name`, `field_display_name`, `field_type`, `field_option`, `field_explain`, `field_default`, `field_required`, `field_listsort`, `field_list`, `field_form`, `field_status`, `field_is_null`) VALUES
(1, 1, 'name', '模型名称', 'text', '', '', '', 1, 1, 1, 1, 1, 0),
(2, 1, 'title', '显示名称', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(3, 1, 'search', '允许搜索', 'radio', '{"\\u5173\\u95ed":"0","\\u5f00\\u542f":"1"}', '', '', 1, 3, 1, 1, 1, 0),
(4, 1, 'attr', '模型属性', 'radio', '{"\\u524d\\u53f0":"1","\\u540e\\u53f0":"2"}', '', '', 1, 4, 1, 1, 1, 0),
(5, 1, 'status', '模型状态', 'radio', '{"\\u542f\\u7528":"1","\\u7981\\u7528":"0"}', '', '', 1, 5, 1, 1, 1, 0),
(6, 2, 'model_id', '模型ID', 'text', '', '', '', 1, 0, 0, 0, 1, 0),
(7, 2, 'type', '字段类型', 'select', '{"\\u5206\\u7c7b":"category","\\u5355\\u884c\\u8f93\\u5165\\u6846":"text","\\u591a\\u884c\\u8f93\\u5165\\u6846":"textarea","\\u5355\\u9009\\u6309\\u94ae":"radio","\\u590d\\u9009\\u6846":"checkbox","\\u5355\\u9009\\u4e0b\\u62c9\\u6846":"select","\\u591a\\u9009\\u4e0b\\u62c9\\u6846":"multiple","\\u7f16\\u8f91\\u5668":"editor","\\u7565\\u7f29\\u56fe":"thumb","\\u4e0a\\u4f20\\u56fe\\u7ec4":"img","\\u4e0a\\u4f20\\u6587\\u4ef6":"file","\\u65e5\\u671f":"date","\\u5de5\\u5355\\u6a21\\u578b":"ticket","\\u7c7b\\u578b":"types"}', '', '', 1, 1, 1, 1, 1, 0),
(8, 2, 'name', '字段名称', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(9, 2, 'display_name', '显示名称', 'text', '', '', '', 1, 3, 1, 1, 1, 0),
(10, 2, 'option', '选项值', 'textarea', '', '选填， 选填， 此处若没有特殊说明，必须 名称|值 填写、且一行一个选项值，否则将导致数据异常!  注意:目前选项适用于单选，复选，下拉菜单。其余功能填写也不会产生任何实际效果。', '', 0, 4, 0, 1, 1, 0),
(11, 2, 'explain', '字段说明', 'textarea', '', '', '', 0, 5, 0, 1, 1, 0),
(12, 2, 'default', '默认值', 'text', '', '', '', 0, 6, 0, 1, 1, 0),
(13, 2, 'required', '是否必填', 'radio', '{"\\u662f":"1","\\u5426":"0"}', '', '', 1, 7, 1, 1, 1, 0),
(14, 2, 'list', '显示列表', 'radio', '{"\\u663e\\u793a":"1","\\u9690\\u85cf":"0"}', '', '', 1, 8, 1, 1, 1, 0),
(15, 2, 'form', '显示表单', 'radio', '{"\\u663e\\u793a":"1","\\u9690\\u85cf":"0"}', '', '', 1, 9, 1, 1, 1, 0),
(16, 2, 'status', '字段状态', 'radio', '{"\\u542f\\u7528":"1","\\u7981\\u7528":"0"}', '', '', 1, 11, 1, 1, 1, 0),
(17, 2, 'listsort', '排序', 'text', '', '', '', 0, 99, 0, 1, 1, 0),
(18, 3, 'name', '菜单名称', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(19, 3, 'pid', '菜单层级', 'select', '', '', '', 1, 1, 1, 1, 1, 0),
(20, 3, 'icon', '菜单图标', 'text', '', '', '', 1, 5, 1, 1, 1, 0),
(21, 3, 'link', '菜单地址', 'text', '{&quot;\\u82e5\\u9009\\u62e9\\u7ad9\\u5185\\u94fe\\u63a5\\uff0c\\u8bf7\\u4ee5\\u7ec4-\\u63a7\\u5236\\u5668-\\u65b9\\u6cd5\\u5f62\\u5f0f\\u586b\\u5199\\u3002&quot;:&quot;&quot;}', '', '', 0, 4, 1, 1, 1, 0),
(22, 3, 'listsort', '排序', 'text', '', '', '', 0, 6, 1, 1, 1, 0),
(67, 6, 'status', '状态', 'radio', '{"\\u7981\\u7528":"0","\\u542f\\u7528":"1"}', '', '1', 1, 100, 1, 1, 1, 0),
(69, 6, 'createtime', '发布时间', 'date', '', '', '', 0, 99, 0, 0, 0, 0),
(70, 7, 'status', '状态', 'radio', '{"\\u7981\\u7528":"0","\\u542f\\u7528":"1"}', '', '1', 1, 100, 1, 1, 1, 0),
(73, 7, 'account', '会员帐号', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(75, 7, 'password', '会员密码', 'text', '', '新增用户时,密码为必填.编辑用户时为空则表示不修改密码', '', 0, 3, 0, 1, 1, 0),
(76, 7, 'mail', '邮箱地址', 'text', '', '', '', 1, 4, 1, 1, 1, 0),
(77, 7, 'name', '会员名称', 'text', '', '', '', 1, 5, 1, 1, 1, 0),
(78, 7, 'group_id', '用户组', 'select', '{"\\u7ba1\\u7406\\u5458":"1","\\u5ba2\\u670d\\u4eba\\u5458":"2","\\u6295\\u8bc9\\u53cd\\u9988":"3"}', '', '', 1, 1, 1, 1, 1, 0),
(79, 6, 'name', '用户组名称', 'text', '', '', '', 1, 1, 1, 1, 1, 0),
(136, 13, 'name', '节点名称', 'text', '', '', '', 1, 3, 0, 1, 1, 0),
(137, 13, 'parent', '所属菜单', 'select', '{"\\u8bf7\\u9009\\u62e9":"","\\u9876\\u5c42\\u83dc\\u5355":"0","\\u9996\\u9875":"1","\\u5de5\\u5355\\u5217\\u8868":"2","\\u5de5\\u5355\\u8bbe\\u7f6e":"7","\\u7528\\u6237\\u7ba1\\u7406":"21","\\u5206\\u7c7b\\u7ba1\\u7406":"76","\\u7cfb\\u7edf\\u8bbe\\u7f6e":"43","\\u6a21\\u578b\\u7ba1\\u7406":"58","\\u6742\\u9879\\u8282\\u70b9":"11"}', '本选项仅用于布置当前权限节点显示于何方。', '', 1, 1, 0, 1, 1, 0),
(138, 13, 'verify', '是否验证', 'radio', '{&quot;\\u4e0d\\u9a8c\\u8bc1&quot;:&quot;0&quot;,&quot;\\u9a8c\\u8bc1&quot;:&quot;1&quot;}', '', '', 0, 4, 0, 1, 1, 0),
(139, 13, 'msg', '提示信息', 'text', '', '', '', 0, 5, 0, 1, 1, 0),
(140, 13, 'method_type', '请求方法', 'select', '{&quot;GET&quot;:&quot;GET&quot;,&quot;POST&quot;:&quot;POST&quot;,&quot;PUT&quot;:&quot;PUT&quot;,&quot;DELETE&quot;:&quot;DELETE&quot;}', '', '', 0, 6, 0, 1, 1, 0),
(141, 13, 'value', '节点匹配值', 'text', '', '若选择父类节点为控制器，请填写控制器名称。反之填写方法名。区分大小写', '', 0, 7, 0, 1, 1, 0),
(142, 13, 'check_value', '验证值', 'text', '', '', '', 0, 8, 0, 0, 1, 0),
(151, 15, 'status', '状态', 'radio', '{"\\u7981\\u7528":"0","\\u542f\\u7528":"1"}', '', '1', 1, 6, 1, 1, 1, 0),
(153, 15, 'number', '工单ID', 'text', '', '', '', 1, 2, 1, 0, 1, 0),
(154, 15, 'name', '工单名称', 'text', '', '', '', 1, 3, 1, 1, 1, 0),
(155, 16, 'model_id', '工单模型ID', 'text', '', '', '', 1, 2, 0, 0, 1, 0),
(156, 16, 'name', '工单表单字段名称', 'text', '', '建议以英语字母下划线填写！否则容易引起工单内容提交丢失的现象。', '', 1, 2, 0, 1, 1, 0),
(157, 16, 'description', '工单字段显示名称', 'text', '', '告诉用户该表单的作用', '', 1, 3, 1, 1, 1, 0),
(158, 16, 'explain', '工单表单说明', 'text', '', '非必填，告诉用户此工单表单的作用', '', 0, 4, 0, 1, 1, 0),
(159, 16, 'msg', '工单提示信息', 'text', '', '非必填，提交失败返回的显示信息', '', 0, 5, 0, 1, 1, 0),
(160, 16, 'type', '工单表单类型', 'select', '', '', '', 1, 6, 1, 1, 1, 0),
(161, 16, 'option', '工单表单的选项值', 'textarea', '', '非必填，此处若没有特殊说明，必须 名称|值 填写、且一行一个选项值，否则将导致数据异常! \r\n注意:目前选项适用于单选，复选，下拉菜单。其余功能填写也不会产生任何实际效果。', '', 0, 7, 0, 1, 1, 0),
(162, 16, 'verify', '工单表单验证类型', 'select', '', '', '', 0, 8, 1, 1, 1, 0),
(163, 16, 'required', '工单表单是否必填', 'radio', '{"\\u975e\\u5fc5\\u586b":"0","\\u5fc5\\u586b":"1"}', '', '', 1, 9, 1, 1, 1, 0),
(164, 16, 'status', '工单表单启用状态', 'radio', '{"\\u7981\\u7528":"0","\\u542f\\u7528":"1"}', '', '', 1, 10, 1, 1, 1, 0),
(165, 16, 'listsort', '工单表单排序值', 'text', '', '升序', '', 0, 11, 0, 1, 1, 0),
(166, 16, 'bind', '联动显示', 'select', '', '若需联动显示，请设置绑定的表单选项，当用户选择该选项时会触发本表单的显示。\r\n注：仅限单选、单选下拉框。', '', 0, 1, 0, 1, 1, 0),
(167, 16, 'bind_value', '联动触发值', 'checkbox', '', '此处填写用户选择了绑定的表单的触发值。', '', 0, 1, 0, 1, 1, 0),
(168, 15, 'login', '登录验证', 'radio', '{&quot;\\u4e0d\\u9a8c\\u8bc1&quot;:&quot;0&quot;,&quot;\\u9a8c\\u8bc1&quot;:&quot;1&quot;}', '', '1', 1, 4, 1, 1, 1, 0),
(169, 15, 'verify', '开启验证码', 'radio', '{"\\u5173\\u95ed":"0","\\u5f00\\u542f":"1"}', '', '1', 1, 5, 1, 1, 1, 0),
(170, 4, 'controller', '路由控制器', 'text', '', '控制器填写以‘-’为分隔符，分别以：组-控制器名称-方法 形式填写。若是默认组的控制器，那么可以忽略填写组参数。', '', 1, 2, 1, 1, 1, 0),
(171, 4, 'param', '显式参数', 'text', '', '若URL存在GET参数，填写上该参数，以半角逗号隔开。如有三个参数a，b，c。那么填写为：a,b,c', '', 0, 3, 1, 1, 1, 0),
(172, 4, 'rule', '路由规则', 'text', '', '若链接中存在显式参数，那么用左右大括号包围着。如参数number，那么路由规则这样写：route/{number}。同时规则开头不要添加任何字符，且分隔符只能为''/''', '', 1, 4, 1, 1, 1, 0),
(173, 4, 'title', '路由名称', 'text', '', '建议填写，以免路由规则过多时，自己也不清楚谁是他的爹。', '', 0, 1, 1, 1, 1, 0),
(174, 4, 'hash', '路由哈希值', 'text', '', '', '', 1, 99, 0, 0, 1, 0),
(175, 4, 'listsort', '排序', 'text', '', '', '', 0, 100, 1, 1, 1, 0),
(176, 4, 'status', '启用状态', 'radio', '{&quot;\\u542f\\u7528&quot;:&quot;1&quot;,&quot;\\u7981\\u7528&quot;:&quot;0&quot;}', '', '', 1, 7, 1, 1, 1, 0),
(177, 13, 'controller', '父类节点', 'select', '{"\\u8bf7\\u9009\\u62e9":"","\\u9876\\u5c42\\u8282\\u70b9":"0","\\u975e\\u6743\\u9650\\u8282\\u70b9":"-1","\\u5b57\\u6bb5\\u7ba1\\u7406":"59","\\u5de5\\u5355\\u6a21\\u578b":"8","\\u5de5\\u5355\\u8868\\u5355":"9","\\u5de5\\u5355\\u5217\\u8868":"2","\\u7528\\u6237\\u7ec4":"22","\\u8282\\u70b9\\u7ba1\\u7406":"23","\\u7528\\u6237\\u7ba1\\u7406":"21","\\u5206\\u7c7b\\u7ba1\\u7406":"76","\\u83dc\\u5355\\u8bbe\\u7f6e":"46","\\u8def\\u7531\\u89c4\\u5219":"52","\\u7cfb\\u7edf\\u8bbe\\u7f6e":"43","\\u90ae\\u4ef6\\u6a21\\u677f":"70","\\u5e38\\u89c1\\u95ee\\u9898":"84","\\u6a21\\u578b\\u7ba1\\u7406":"58"}', '', '', 1, 2, 1, 1, 1, 0),
(178, 13, 'listsort', '排序', 'text', '', '', '', 0, 99, 1, 1, 1, 0),
(179, 3, 'type', '链接类型', 'radio', '{&quot;\\u7ad9\\u5185\\u94fe\\u63a5&quot;:&quot;0&quot;,&quot;\\u7ad9\\u5916\\u8fde\\u63a5&quot;:&quot;1&quot;}', '', '', 1, 3, 1, 1, 1, 0),
(183, 17, 'type', '模板类型', 'select', '{&quot;\\u65b0\\u5de5\\u5355&quot;:&quot;1&quot;,&quot;\\u53d7\\u7406\\u5de5\\u5355&quot;:&quot;2&quot;,&quot;\\u56de\\u590d\\u5de5\\u5355&quot;:&quot;3&quot;,&quot;\\u8f6c\\u4ea4\\u5ba2\\u670d&quot;:&quot;4&quot;,&quot;\\u5de5\\u5355\\u5b8c\\u6210&quot;:&quot;5&quot;,&quot;\\u5de5\\u5355\\u5173\\u95ed&quot;:&quot;6&quot;}', '', '', 1, 1, 1, 1, 1, 0),
(184, 17, 'title', '邮件标题', 'text', '', '标题输入框可以填写{number}变量，动态输出当时的工单号码。', '', 1, 2, 1, 1, 1, 0),
(185, 17, 'content', '邮件模板内容', 'textarea', '', '在模板内容，输入如下变量可以动态输出对应的值：{number}为工单号码，{user}为客户名称，{view}为工单查询的链接地址', '', 1, 3, 0, 1, 1, 0),
(186, 15, 'cid', '所属分类', 'category', '', '', '', 1, 1, 1, 1, 1, 0),
(187, 18, 'status', '状态', 'radio', '{&quot;\\u7981\\u7528&quot;:&quot;0&quot;,&quot;\\u542f\\u7528&quot;:&quot;1&quot;}', '', '1', 1, 100, 1, 1, 1, 0),
(188, 18, 'listsort', '排序', 'text', '', '', '', 0, 98, 1, 1, 1, 0),
(190, 18, 'name', '分类名称', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(191, 18, 'parent', '所属父类', 'select', '', '', '', 1, 1, 1, 1, 1, 0),
(192, 18, 'description', '分类描述', 'textarea', '', '', '', 1, 3, 1, 1, 1, 0),
(193, 15, 'listsort', '排序值', 'text', '', '', '', 0, 99, 1, 1, 1, 0),
(194, 15, 'explain', '工单说明', 'editor', '', '', '', 0, 10, 0, 1, 1, 0),
(204, 20, 'status', '状态', 'radio', '{"\\u7981\\u7528":"0","\\u542f\\u7528":"1"}', '', '1', 1, 100, 1, 1, 1, 0),
(206, 20, 'createtime', '创建时间', 'date', '', '', '', 0, 99, 1, 1, 1, 0),
(207, 20, 'email', '邮箱地址', 'text', '', '', '', 1, 1, 1, 1, 1, 0),
(208, 20, 'password', '用户密码', 'text', '', '', '', 0, 2, 0, 1, 1, 0),
(209, 20, 'name', '用户名称', 'text', '', '', '', 1, 3, 1, 1, 1, 0),
(210, 20, 'phone', '手机号码', 'text', '', '', '', 1, 4, 1, 1, 1, 1),
(211, 15, 'group_id', '管辖用户组', 'multiple', '{"\\u7ba1\\u7406\\u5458":"1","\\u5ba2\\u670d\\u4eba\\u5458":"2","\\u6295\\u8bc9\\u53cd\\u9988":"3"}', '绑定对应的用户组，当前工单模型有新工单，将会发送通知给该用户组下的所有成员。', '', 1, 7, 1, 1, 1, 0),
(212, 21, 'account', '接收帐号', 'text', '', '', '', 1, 1, 1, 1, 1, 0),
(213, 21, 'title', '发送标题', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(214, 21, 'content', '发送内容', 'editor', '', '', '', 1, 3, 0, 1, 1, 0),
(215, 21, 'time', '生成时间', 'date', '', '', '', 1, 5, 1, 1, 1, 0),
(216, 21, 'type', '发送方式', 'select', '{&quot;\\u90ae\\u7bb1&quot;:&quot;1&quot;,&quot;\\u624b\\u673a&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;,&quot;\\u4f01\\u4e1a\\u5fae\\u4fe1&quot;:&quot;4&quot;}', '', '', 1, 4, 1, 1, 1, 0),
(217, 7, 'weixinWork', '企业微信ID', 'text', '', '', '', 0, 6, 1, 1, 1, 1),
(218, 2, 'is_null', '是否为空', 'radio', '{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}', '', '', 0, 7, 1, 1, 1, 0),
(219, 17, 'sms', '短信模板内容', 'textarea', '', '在短信模板内容，输入如下变量可以动态输出对应的值：{number}为工单号码，{view}为工单查询的链接地址。另外请到短信平台按照要求添加一致的模板。', '', 1, 4, 0, 1, 1, 0),
(221, 22, 'listsort', '排序', 'text', '', '', '', 0, 98, 1, 1, 1, 0),
(223, 22, 'name', '短语名称', 'text', '', '', '', 0, 1, 1, 1, 1, 0),
(224, 22, 'content', '内容', 'editor', '', '', '', 1, 2, 0, 1, 1, 0),
(225, 22, 'user_id', '所属者', 'text', '', '', '', 0, 90, 0, 0, 1, 0),
(226, 23, 'status', '状态', 'radio', '{"\\u7981\\u7528":"0","\\u542f\\u7528":"1"}', '', '1', 1, 100, 1, 1, 1, 0),
(227, 23, 'listsort', '排序', 'text', '', '', '', 0, 98, 1, 1, 1, 0),
(228, 23, 'createtime', '创建时间', 'date', '', '', '', 0, 99, 1, 1, 1, 0),
(229, 23, 'ticket_model_id', '对应工单', 'ticket', '', '', '', 1, 1, 1, 1, 1, 0),
(230, 23, 'title', '标题', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(231, 23, 'content', '详细内容', 'editor', '', '', '', 1, 3, 0, 1, 1, 0),
(232, 17, 'weixin_template_id', '微信模板ID', 'text', '', '', '', 0, 5, 1, 1, 1, 0),
(233, 17, 'weixin_template', '微信模板内容', 'textarea', '', '微信模板消息，输入如下变量可以动态输出对应的值：{number}为工单号码。请按照微信公众号选择模板的格式填写对应的参数。', '', 0, 6, 0, 1, 1, 0),
(234, 21, 'result', '执行结果', 'text', '', '', '', 1, 2, 1, 1, 1, 0),
(235, 20, 'weixin', '微信OPENID', 'text', '', '', '', 0, 10, 1, 1, 1, 1),
(236, 1, 'page', '分页数', 'text', '', '', '10', 1, 5, 1, 1, 1, 0),
(237, 15, 'time_out', '工单超时时长(分钟)', 'text', '', '有新工单提交后，在指定时间内无人受理工单，系统将发送通知给工单所在的管辖组成员。', '10', 1, 8, 1, 1, 1, 0),
(238, 15, 'time_out_sequence', '超时提醒次数', 'text', '', '工单无人受理超时通知次数，系统将按照工单超时时长的间隔进行重复通知。', '1', 1, 9, 0, 1, 1, 0),
(239, 20, 'account', '登陆账号', 'text', '', '', '', 1, 1, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pes_findpassword`
--

CREATE TABLE IF NOT EXISTS `pes_findpassword` (
  `findpassword_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `findpassword_mark` varchar(255) NOT NULL DEFAULT '' COMMENT '标记',
  `findpassword_createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`findpassword_id`),
  UNIQUE KEY `findpassword_mark` (`findpassword_mark`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='查找密码' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_fqa`
--

CREATE TABLE IF NOT EXISTS `pes_fqa` (
  `fqa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fqa_listsort` int(11) NOT NULL DEFAULT '0',
  `fqa_status` tinyint(4) NOT NULL DEFAULT '0',
  `fqa_url` varchar(255) NOT NULL DEFAULT '',
  `fqa_createtime` int(11) NOT NULL DEFAULT '0',
  `fqa_ticket_model_id` int(11) NOT NULL DEFAULT '0',
  `fqa_title` varchar(255) NOT NULL DEFAULT '',
  `fqa_content` text NOT NULL,
  PRIMARY KEY (`fqa_id`),
  KEY `fqa_ticket_model_id` (`fqa_ticket_model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_mail_template`
--

CREATE TABLE IF NOT EXISTS `pes_mail_template` (
  `mail_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_template_type` int(11) NOT NULL,
  `mail_template_title` varchar(255) NOT NULL,
  `mail_template_content` text NOT NULL,
  `mail_template_sms` varchar(500) NOT NULL DEFAULT '',
  `mail_template_weixin_template_id` varchar(128) NOT NULL DEFAULT '',
  `mail_template_weixin_template` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`mail_template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `pes_mail_template`
--

INSERT INTO `pes_mail_template` (`mail_template_id`, `mail_template_type`, `mail_template_title`, `mail_template_content`, `mail_template_sms`, `mail_template_weixin_template_id`, `mail_template_weixin_template`) VALUES
(1, 1, '工单提交成功！您的工单编号为：{number}', '我们已经收到您提交的工单，单号为：{number} 。我们将会尽快对您的问题进行处理，请耐心等待。此外，您可以通过如下链接对工单的进度查询：{view}', '我们已经收到您提交的工单，我们将尽快安排人员为您解疑释惑。您的工单编号为：{number}。请不要把工单号码泄露给其他人。', '', ''),
(2, 2, '工单:{number}已经受理', '您的工单已经受理，我们将会尽快解决您的问题，请耐心等待。\r\n查看工单进度，可以点击如下链接访问：{view}', '您的工单已经受理，我们将会尽快解决您的问题，请耐心等待。 查看工单进度，可以点击如下链接访问：{view}', '', ''),
(3, 3, '工单:{number}有新的回复', '您好，您的工单:{number} 有新的回复：\n{content}\n点击如下链接可以查看工单的进度:{view}', '您好，您的工单:{number} 有新的回复。点击如下链接可以查看工单的进度:{view}', '', ''),
(4, 4, '工单:{number}需要转交客服处理', '您好，您的工单{number}需要转交客服处理，请耐心等待。\n点击如下链接可以查看工单的进度:{view}', '您好，您的工单{number}需要转交客服处理，请耐心等待。', '', ''),
(5, 5, '工单:{number}已经完成', '您好，您的工单:{number}已经被客服标记为完成状态。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的耐心等待。\n查看工单的详情，请点击如下链接:{view}', '您好，您的工单:{number}已经被客服标记为完成状态。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的耐心等待。', '', ''),
(6, 6, '工单:{number}被关闭', '您好，非常抱歉地告诉您，您的工单:{number}已经被客服标关闭。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的反馈。\r\n查看工单的详情，请点击如下链接:{view}', '您好，非常抱歉地告诉您，您的工单:{number}已经被客服标关闭。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的反馈。', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `pes_member`
--

CREATE TABLE IF NOT EXISTS `pes_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_account` varchar(255) NOT NULL,
  `member_email` varchar(255) NOT NULL DEFAULT '',
  `member_password` varchar(255) NOT NULL DEFAULT '',
  `member_name` varchar(255) NOT NULL DEFAULT '',
  `member_phone` varchar(255) DEFAULT NULL,
  `member_status` tinyint(4) NOT NULL DEFAULT '0',
  `member_createtime` int(11) NOT NULL DEFAULT '0',
  `member_weixin` varchar(255) DEFAULT NULL COMMENT '微信openid',
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_email` (`member_email`),
  UNIQUE KEY `member_account` (`member_account`) USING BTREE,
  UNIQUE KEY `member_phone` (`member_phone`) USING BTREE,
  UNIQUE KEY `member_weixin` (`member_weixin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_menu`
--

CREATE TABLE IF NOT EXISTS `pes_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(128) NOT NULL,
  `menu_pid` int(11) NOT NULL DEFAULT '0',
  `menu_icon` varchar(128) NOT NULL DEFAULT '',
  `menu_link` varchar(255) NOT NULL DEFAULT '',
  `menu_listsort` tinyint(100) NOT NULL DEFAULT '0',
  `menu_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`),
  KEY `menu_pid` (`menu_pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `pes_menu`
--

INSERT INTO `pes_menu` (`menu_id`, `menu_name`, `menu_pid`, `menu_icon`, `menu_link`, `menu_listsort`, `menu_type`) VALUES
(1, '工单设置', 0, 'am-icon-ticket', '', 3, 0),
(2, '工单模型', 1, 'am-icon-modx', 'Ticket-Ticket_model-index', 1, 0),
(3, '帐号管理', 0, 'am-icon-users', '', 5, 0),
(4, '客服帐号', 3, 'am-icon-user', 'Ticket-User-index', 1, 0),
(6, '基础设置', 9, 'am-icon-tv', 'Ticket-Setting-action', 1, 0),
(7, '菜单设置', 9, 'am-icon-map-signs', 'Ticket-Menu-index', 2, 0),
(9, '系统设置', 0, 'am-icon-cog', '', 10, 0),
(10, '帮助文档', 9, 'am-icon-leanpub', 'https://www.pescms.com/d/index/22', 6, 1),
(11, '反馈建议', 9, 'am-icon-twitch', 'https://forum.pescms.com/list/22.html', 7, 1),
(12, '工作台', 0, 'am-icon-tachometer', 'Ticket-Index-index', 1, 0),
(13, '工单列表', 0, 'am-icon-yelp', '', 2, 0),
(14, '用户组', 3, 'am-icon-steam', 'Ticket-User_group-index', 2, 0),
(15, '节点管理', 3, 'am-icon-toggle-off', 'Ticket-Node-index', 3, 0),
(16, '路由规则', 9, 'am-icon-map-o', 'Ticket-Route-index', 4, 0),
(17, '工单列表', 13, 'am-icon-fire', 'Ticket-Ticket-index', 1, 0),
(18, '我的工单', 13, 'am-icon-coffee', 'Ticket-Ticket-myTicket', 2, 0),
(19, '邮件模板', 9, 'am-icon-paint-brush', 'Ticket-Mail_template-index', 5, 0),
(21, '分类管理', 0, 'am-icon-list-alt', 'Ticket-Category-index', 4, 0),
(23, '客户管理', 3, 'am-icon-street-view', 'Ticket-Member-index', 4, 0),
(24, '应用商店', 9, 'am-icon-cogs', 'Ticket-Application-index', 3, 0),
(25, '商业授权', 9, 'am-icon-registered', 'https://www.pescms.com/Page/Authorization.html', 99, 1),
(26, '发送列表', 9, 'am-icon-send', 'Ticket-Send-index', 5, 0),
(27, '全部工单', 13, 'am-icon-list', 'Ticket-Ticket-all', 1, 0),
(32, '常见问题解答', 1, 'am-icon-question-circle', 'Ticket-Fqa-index', 20, 0),
(33, '工单投诉反馈', 0, 'am-icon-cutlery', 'Ticket-Ticket-complain', 6, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pes_model`
--

CREATE TABLE IF NOT EXISTS `pes_model` (
  `model_id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(128) NOT NULL,
  `model_title` varchar(128) NOT NULL DEFAULT '',
  `model_status` tinyint(4) NOT NULL DEFAULT '0',
  `model_search` tinyint(11) NOT NULL DEFAULT '0' COMMENT '允许搜索',
  `model_attr` tinyint(1) NOT NULL DEFAULT '0' COMMENT '模型属性 1:前台(含前台) 2:后台',
  `model_page` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`model_id`),
  UNIQUE KEY `model_name` (`model_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `pes_model`
--

INSERT INTO `pes_model` (`model_id`, `model_name`, `model_title`, `model_status`, `model_search`, `model_attr`, `model_page`) VALUES
(1, 'model', '模型管理', 1, 1, 2, 10),
(2, 'field', '字段管理', 1, 1, 2, 10),
(3, 'menu', '菜单模型', 1, 1, 2, 10),
(4, 'route', '路由规则', 1, 1, 2, 10),
(6, 'User_group', '用户组', 1, 0, 2, 10),
(7, 'User', '客服帐号', 1, 0, 2, 10),
(13, 'Node', '节点列表', 1, 1, 2, 10),
(15, 'ticket_model', '工单模型', 1, 1, 2, 10),
(16, 'ticket_form', '工单表单', 1, 1, 2, 10),
(17, 'mail_template', '邮件模板', 1, 0, 2, 10),
(18, 'Category', '分类', 1, 1, 1, 10),
(20, 'Member', '客户管理', 1, 1, 1, 10),
(21, 'Send', '发送列表', 1, 1, 1, 10),
(22, 'Phrase', '回复短语', 1, 0, 2, 10),
(23, 'Fqa', '常见问题解答', 1, 1, 1, 10);

-- --------------------------------------------------------

--
-- 表的结构 `pes_node`
--

CREATE TABLE IF NOT EXISTS `pes_node` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(255) NOT NULL,
  `node_parent` int(11) NOT NULL DEFAULT '0',
  `node_verify` int(11) NOT NULL DEFAULT '0',
  `node_msg` varchar(255) DEFAULT '',
  `node_method_type` varchar(8) NOT NULL DEFAULT '',
  `node_value` varchar(255) NOT NULL DEFAULT '',
  `node_check_value` varchar(255) NOT NULL DEFAULT '',
  `node_controller` int(11) NOT NULL DEFAULT '0',
  `node_listsort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`node_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=93 ;

--
-- 转存表中的数据 `pes_node`
--

INSERT INTO `pes_node` (`node_id`, `node_name`, `node_parent`, `node_verify`, `node_msg`, `node_method_type`, `node_value`, `node_check_value`, `node_controller`, `node_listsort`) VALUES
(1, '首页', 0, 0, '', 'GET', 'Index', '', -1, 1),
(2, '工单列表', 0, 0, '', 'GET', 'Ticket', '', 0, 2),
(3, '工单列表', 2, 1, '', 'GET', 'index', 'TicketGETTicketindex', 2, 1),
(4, '我的工单', 2, 1, '', 'GET', 'myTicket', 'TicketGETTicketmyTicket', 2, 2),
(5, '回复工单', 2, 1, '', 'POST', 'reply', 'TicketPOSTTicketreply', 2, 3),
(6, '关闭工单', 2, 1, '', 'POST', 'close', 'TicketPOSTTicketclose', 2, 4),
(7, '工单设置', 0, 0, '', 'GET', '', '', -1, 3),
(8, '工单模型', 11, 0, '', 'GET', 'Ticket_model', '', 0, 1),
(9, '工单表单', 11, 0, '', 'GET', 'Ticket_form', '', 0, 2),
(10, '添加/编辑新工单', 7, 1, '', 'GET', 'action', 'TicketGETTicket_modelaction', 8, 20),
(11, '杂项节点', 0, 0, '', 'GET', '', '', -1, 99),
(12, '工单模型列表', 7, 1, '', 'GET', 'index', 'TicketGETTicket_modelindex', 8, 10),
(13, '提交新增工单模型', 7, 1, '', 'POST', 'action', 'TicketPOSTTicket_modelaction', 8, 30),
(14, '提交更新工单模型', 7, 1, '', 'PUT', 'action', 'TicketPUTTicket_modelaction', 8, 40),
(15, '提交删除工单模型', 7, 1, '', 'DELETE', 'action', 'TicketDELETETicket_modelaction', 8, 50),
(16, '工单表单列表', 7, 1, '', 'GET', 'index', 'TicketGETTicket_formindex', 9, 60),
(17, '新增/编辑工单表单', 7, 1, '', 'GET', 'action', 'TicketGETTicket_formaction', 9, 70),
(18, '提交新增工单表单', 7, 1, '', 'POST', 'action', 'TicketPOSTTicket_formaction', 9, 80),
(19, '提交更新工单表单', 7, 1, '', 'PUT', 'action', 'TicketPUTTicket_formaction', 9, 90),
(20, '提交删除工单表单', 7, 1, '', 'DELETE', 'action', 'TicketDELETETicket_formaction', 9, 100),
(21, '用户管理', 0, 0, '', 'GET', 'User', '', 0, 4),
(22, '用户组', 11, 0, '', 'GET', 'User_group', '', 0, 3),
(23, '节点管理', 11, 0, '', 'GET', 'Node', '', 0, 4),
(24, '用户列表', 21, 1, '', 'GET', 'index', 'TicketGETUserindex', 21, 10),
(25, '新增/编辑用户', 21, 1, '', 'GET', 'action', 'TicketGETUseraction', 21, 20),
(26, '提交新增用户', 21, 1, '', 'POST', 'action', 'TicketPOSTUseraction', 21, 30),
(27, '提交更新用户', 21, 1, '', 'PUT', 'action', 'TicketPUTUseraction', 21, 40),
(28, '提交删除用户', 21, 1, '', 'DELETE', 'action', 'TicketDELETEUseraction', 21, 50),
(29, '用户组列表', 21, 1, '', 'GET', 'index', 'TicketGETUser_groupindex', 22, 60),
(30, '新增/编辑用户组', 21, 1, '', 'GET', 'action', 'TicketGETUser_groupaction', 22, 70),
(31, '提交新增用户组', 21, 1, '', 'POST', 'action', 'TicketPOSTUser_groupaction', 22, 80),
(32, '提交编辑用户组', 21, 1, '', 'PUT', 'action', 'TicketPUTUser_groupaction', 22, 90),
(33, '提交删除用户组', 21, 1, '', 'DELETE', 'action', 'TicketDELETEUser_groupaction', 22, 100),
(34, '查看用户组菜单', 21, 1, '', 'GET', 'setMenu', 'TicketGETUser_groupsetMenu', 22, 110),
(35, '更新用户组菜单', 21, 1, '', 'PUT', 'setMenu', 'TicketPUTUser_groupsetMenu', 22, 120),
(36, '查看用户组权限', 21, 1, '', 'GET', 'setAuth', 'TicketGETUser_groupsetAuth', 22, 130),
(37, '更新用户组权限', 21, 1, '', 'PUT', 'setAuth', 'TicketPUTUser_groupsetAuth', 22, 140),
(38, '节点列表', 21, 1, '', 'GET', 'index', 'TicketGETNodeindex', 23, 150),
(39, '新增/编辑节点', 21, 1, '', 'GET', 'action', 'TicketGETNodeaction', 23, 160),
(40, '提交新增节点', 21, 1, '', 'POST', 'action', 'TicketPOSTNodeaction', 23, 170),
(41, '提交更新节点', 21, 1, '', 'PUT', 'action', 'TicketPUTNodeaction', 23, 180),
(42, '提交删除节点', 21, 1, '', 'DELETE', 'action', 'TicketDELETENodeaction', 23, 190),
(43, '系统设置', 0, 0, '', 'GET', 'Setting', '', 0, 6),
(44, '查看基础设置', 43, 1, '', 'GET', 'action', 'TicketGETSettingaction', 43, 10),
(45, '更新基础设置', 43, 1, '', 'PUT', 'action', 'TicketPUTSettingaction', 43, 20),
(46, '菜单设置', 11, 0, '', 'GET', 'Menu', '', 0, 5),
(47, '查看菜单', 43, 1, '', 'GET', 'index', 'TicketGETMenuindex', 46, 30),
(48, '新增菜单', 43, 1, '', 'POST', 'action', 'TicketPOSTMenuaction', 46, 50),
(49, '新增/编辑菜单', 43, 1, '', 'GET', 'action', 'TicketGETMenuaction', 46, 40),
(50, '更新菜单', 43, 1, '', 'PUT', 'action', 'TicketPUTMenuaction', 46, 60),
(51, '删除菜单', 43, 1, '', 'DELETE', 'action', 'TicketDELETEMenuaction', 46, 70),
(52, '路由规则', 11, 0, '', 'GET', 'Route', '', 0, 6),
(53, '路由列表', 43, 1, '', 'GET', 'index', 'TicketGETRouteindex', 52, 80),
(54, '新增/编辑路由规则', 43, 1, '', 'GET', 'action', 'TicketGETRouteaction', 52, 90),
(55, '新增路由规则', 43, 1, '', 'POST', 'action', 'TicketPOSTRouteaction', 52, 100),
(56, '更新路由规则', 43, 1, '', 'PUT', 'action', 'TicketPUTRouteaction', 52, 110),
(57, '删除路由规则', 43, 1, '', 'DELETE', 'action', 'TicketDELETERouteaction', 52, 120),
(58, '模型管理', 0, 0, '', 'GET', 'Model', '', 0, 95),
(59, '字段管理', 11, 0, '', 'GET', 'Field', '', 0, 1),
(60, '模型列表', 58, 1, '', 'GET', 'index', 'TicketGETModelindex', 58, 1),
(61, '新增/编辑模型', 58, 1, '', 'GET', 'action', 'TicketGETModelaction', 58, 1),
(62, '新增模型', 58, 1, '', 'POST', 'action', 'TicketPOSTModelaction', 58, 1),
(63, '更新模型', 58, 1, '', 'PUT', 'action', 'TicketPUTModelaction', 58, 1),
(64, '删除模型', 58, 1, '', 'DELETE', 'action', 'TicketDELETEModelaction', 58, 1),
(65, '字段列表', 58, 1, '', 'GET', 'index', 'TicketGETFieldindex', 59, 0),
(66, '新增/编辑字段', 58, 1, '', 'GET', 'action', 'TicketGETFieldaction', 59, 0),
(67, '新增字段', 58, 1, '', 'POST', 'action', 'TicketPOSTFieldaction', 59, 0),
(68, '更新字段', 58, 1, '', 'PUT', 'action', 'TicketPUTFieldaction', 59, 0),
(69, '删除字段', 58, 1, '', 'DELETE', 'action', 'TicketDELETEFieldaction', 59, 0),
(70, '邮件模板', 11, 0, '', 'GET', 'Mail_template', '', 0, 7),
(71, '邮件模板列表', 43, 1, '', 'GET', 'index', 'TicketGETMail_templateindex', 70, 0),
(72, '新增/编辑邮件模板', 43, 1, '', 'GET', 'action', 'TicketGETMail_templateaction', 70, 0),
(73, '添加邮件模板', 43, 1, '', 'POST', 'action', 'TicketPOSTMail_templateaction', 70, 0),
(74, '更新邮件模板', 43, 1, '', 'PUT', 'action', 'TicketPUTMail_templateaction', 70, 0),
(75, '删除邮件模板', 43, 1, '', 'DELETE', 'action', 'TicketDELETEMail_templateaction', 70, 0),
(76, '分类管理', 0, 0, '', 'GET', 'Category', '', 0, 5),
(77, '新增/编辑分类', 76, 1, '', 'GET', 'action', 'TicketGETCategoryaction', 76, 2),
(78, '提交新增分类', 76, 1, '', 'POST', 'action', 'TicketPOSTCategoryaction', 76, 3),
(79, '提交分类更新', 76, 1, '', 'PUT', 'action', 'TicketPUTCategoryaction', 76, 4),
(80, '提交分类删除', 76, 1, '', 'DELETE', 'action', 'TicketDELETECategoryaction', 76, 5),
(81, '分类列表', 76, 1, '', 'DELETE', 'index', 'TicketGETCategoryindex', 76, 1),
(82, '删除工单', 2, 1, '当前权限不足，无法删除工单。', 'DELETE', 'action', 'TicketDELETETicketaction', 2, 5),
(83, '全部工单', 2, 1, '', 'GET', 'all', 'TicketGETTicketall', 2, 5),
(84, '常见问题', 11, 1, '', 'GET', 'Fqa', '', 0, 8),
(85, 'FQA列表', 7, 1, '', 'GET', 'index', 'TicketGETFqaindex', 84, 110),
(86, 'FQA编辑', 7, 1, '', 'GET', 'action', 'TicketGETFqaaction', 84, 111),
(87, 'FQA添加', 7, 1, '', 'POST', 'action', 'TicketPOSTFqaaction', 84, 112),
(88, 'FQA更新', 7, 1, '', 'PUT', 'action', 'TicketPUTFqaaction', 84, 113),
(89, 'FQA删除', 7, 1, '', 'DELETE', 'action', 'TicketDELETEFqaaction', 84, 114),
(90, '复制用户组', 21, 1, '', 'POST', 'copy', 'TicketPOSTUser_groupcopy', 22, 141),
(91, '工单投诉列表', 2, 1, '', 'GET', 'complain', 'TicketGETTicketcomplain', 2, 130),
(92, '工单投诉详情', 2, 1, '', 'GET', 'complainDetail', 'TicketGETTicketcomplainDetail', 2, 131);

-- --------------------------------------------------------

--
-- 表的结构 `pes_node_group`
--

CREATE TABLE IF NOT EXISTS `pes_node_group` (
  `node_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `node_id` int(11) NOT NULL DEFAULT '0' COMMENT '节点ID',
  PRIMARY KEY (`node_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户组权限节点' AUTO_INCREMENT=73 ;

--
-- 转存表中的数据 `pes_node_group`
--

INSERT INTO `pes_node_group` (`node_group_id`, `user_group_id`, `node_id`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 1, 1),
(8, 1, 2),
(9, 1, 3),
(10, 1, 4),
(11, 1, 5),
(12, 1, 6),
(13, 1, 7),
(14, 1, 12),
(15, 1, 10),
(16, 1, 13),
(17, 1, 14),
(18, 1, 15),
(19, 1, 16),
(20, 1, 17),
(21, 1, 18),
(22, 1, 19),
(23, 1, 20),
(24, 1, 21),
(25, 1, 24),
(26, 1, 25),
(27, 1, 26),
(28, 1, 27),
(29, 1, 28),
(30, 1, 29),
(31, 1, 30),
(32, 1, 31),
(33, 1, 32),
(34, 1, 33),
(35, 1, 34),
(36, 1, 35),
(37, 1, 36),
(38, 1, 37),
(39, 1, 38),
(40, 1, 39),
(41, 1, 40),
(42, 1, 41),
(43, 1, 42),
(44, 1, 43),
(45, 1, 75),
(46, 1, 74),
(47, 1, 73),
(48, 1, 72),
(49, 1, 71),
(50, 1, 44),
(51, 1, 45),
(52, 1, 47),
(53, 1, 49),
(54, 1, 48),
(55, 1, 50),
(56, 1, 51),
(57, 1, 53),
(58, 1, 54),
(59, 1, 55),
(60, 1, 56),
(61, 1, 57),
(62, 1, 11),
(63, 1, 8),
(64, 1, 9),
(65, 1, 22),
(66, 1, 23),
(67, 1, 46),
(68, 1, 52),
(69, 1, 70),
(70, 3, 2),
(71, 3, 91),
(72, 3, 92);

-- --------------------------------------------------------

--
-- 表的结构 `pes_option`
--

CREATE TABLE IF NOT EXISTS `pes_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(128) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `option_range` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `pes_option`
--

INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES
(1, 'domain', '网站URL', '', 'system'),
(2, 'crossdomain', '跨域列表', '', 'system'),
(3, 'version', '系统版本', '', 'system'),
(4, 'openindex', '开启首页', '1', 'system'),
(5, 'customstatus', '工单状态', '[{"color":"#dd514c","name":"\\u5f85\\u89e3\\u51b3"},{"color":"#F37B1D","name":"\\u5df2\\u53d7\\u7406"},{"color":"#3bb4f2","name":"\\u5f85\\u56de\\u590d"},{"color":"#5eb95e","name":"\\u5b8c\\u6210"}]', ''),
(6, 'mail', '邮箱设置', '', ''),
(7, 'notice_way', '通知方式', '2', 'system'),
(8, 'upload_img', '图片格式', '[".jpg",".jpge",".bmp",".gif",".png"]', 'upload'),
(9, 'upload_file', '文件格式', '[".zip",".rar",".7z",".doc",".docx",".pdf",".xls",".xlsx",".ppt",".pptx",".txt"]', 'upload'),
(10, 'interior_ticket', '站内工单', '1', 'system'),
(11, 'open_register', '开启注册', '1', 'system'),
(12, 'weixin_api', '微信接口', '', 'system'),
(13, 'weixinWork_api', '企业微信接口', '', 'system'),
(14, 'login_verify', '登录验证码', '["1"]', 'system'),
(15, 'cs_notice_type', '客服人员接收通知方式', '{"1":"1"}', 'system'),
(16, 'sms', '短信接口', '', 'system'),
(17, 'siteLogo', '网站LOGO', '/Theme/assets/i/logo.png', 'system'),
(18, 'siteTitle', '网站名称', 'PESCMS Ticket', 'system'),
(19, 'pescmsIntroduce', '页脚内容', '<div class="am-u-sm-12 am-u-lg-11 am-u-sm-centered">\n    <div class="am-g">\n        <div class="am-u-sm-12 am-u-lg-3">\n            <h4>关于PESCMS</h4>\n            <p>PESCMS旗下有TEAM团队任务管理系统，Ticket客服工单系统，DOC文档管理系统以及基于浏览器开发的基金定投助手。</p>\n        </div>\n        <div class="am-u-sm-12 am-u-lg-3">\n            <h4>产品列表</h4>\n            <ul>\n                <li><a href="https://www.pescms.com/download/2.html">PESCMS TEAM 团队任务管理系统</a></li>\n                <li><a href="https://www.pescms.com/download/3.html">PESCMS DOC 文档管理系统</a></li>\n                <li><a href="https://www.pescms.com/download/5.html">PESCMS TICKET 客服工单系统</a></li>\n                <li><a href="https://www.pescms.com/download/4.html">PESCMS LOGIN 网站登录管理</a></li>\n                <li><a href="https://www.pescms.com/download/6.html">基金定投助手</a></li>\n            </ul>\n        </div>\n        <div class="am-u-sm-12 am-u-lg-3 am-u-end">\n            <h4>产品服务</h4>\n            <ul>\n                <li><a href="https://www.pescms.com/Page/Authorization.html">商业授权</a></li>\n                <li><a href="https://www.pescms.com/Authorize-Verify">授权查询</a></li>\n                <li><a href="https://www.pescms.com/service.html">有偿服务</a></li>\n                <li><a href="https://www.pescms.com/Page/ad.html">广告投放</a></li>\n                <li><a href="https://www.pescms.com/Page/donate.html">赞助捐赠</a></li>\n            </ul>\n        </div>\n    </div>\n</div>', 'system'),
(20, 'siteContact', '网站联系方式', '<span class="am-margin-right-xs"><i class="am-icon-qq"></i> <a href="https://wpa.qq.com/msgrd?v=3&uin=201418824&menu=yes" target="_blank">201418824</a></span>\n<span class="am-margin-right-xs"><i class="am-icon-weixin"></i> <a href="javascript:;" data-am-popover="{content: ''<img src=\\''https://www.pescms.com/Theme/assets/i/IMG_2866.JPG\\'' width=300>'', trigger: ''hover focus''}" >PESCMS</a></span>\n<span class="am-margin-right-xs"><i class="am-icon-thumbs-o-up"></i> <a href="javascript:;" data-am-popover="{content: ''<img src=\\''https://www.pescms.com/Theme/assets/i/zan.png\\'' width=300>'', trigger: ''hover focus''}" >打赏支持</a></span>', 'system'),
(21, 'authorize', '授权码', '', ''),
(22, 'siteKeywords', '网站Keywords', 'PESCMS Ticket是一款以GPLv2协议发布的开源工单客服系统', 'system'),
(23, 'siteDescription', '网站Description', 'PESCMS,PESCMS Ticket,开源的工单系统,工单系统,工单客服系统,客服工单系统,GPL工单,GPL客服系统,GPL工单客服系统', 'system'),
(24, 'verifyLength', '验证码长度', '4', 'system'),
(25, 'member_review', '审核设置', '1', 'system'),
(26, 'indexStyle', '首页样式', '0', 'system'),
(27, 'member_login', '客户登陆方式', '0', 'system');

-- --------------------------------------------------------

--
-- 表的结构 `pes_phrase`
--

CREATE TABLE IF NOT EXISTS `pes_phrase` (
  `phrase_id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase_listsort` int(11) NOT NULL DEFAULT '0',
  `phrase_name` varchar(255) NOT NULL DEFAULT '',
  `phrase_content` text NOT NULL,
  `phrase_user_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`phrase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_route`
--

CREATE TABLE IF NOT EXISTS `pes_route` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_controller` varchar(255) NOT NULL DEFAULT '',
  `route_param` varchar(255) NOT NULL DEFAULT '',
  `route_rule` varchar(255) NOT NULL DEFAULT '',
  `route_title` varchar(255) NOT NULL DEFAULT '',
  `route_hash` varchar(255) NOT NULL DEFAULT '',
  `route_listsort` int(11) NOT NULL DEFAULT '0',
  `route_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='路由表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_send`
--

CREATE TABLE IF NOT EXISTS `pes_send` (
  `send_id` int(11) NOT NULL AUTO_INCREMENT,
  `send_account` varchar(255) NOT NULL DEFAULT '',
  `send_title` varchar(255) NOT NULL DEFAULT '' COMMENT '待发送标题',
  `send_content` text NOT NULL COMMENT '待发送的内容',
  `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `send_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:邮箱 2:手机 ..',
  `send_result` varchar(255) NOT NULL,
  PRIMARY KEY (`send_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='待发送列表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_ticket`
--

CREATE TABLE IF NOT EXISTS `pes_ticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(128) NOT NULL DEFAULT '' COMMENT '工单序号',
  `ticket_title` varchar(255) NOT NULL DEFAULT '' COMMENT '工单标题',
  `ticket_model_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的工单模型',
  `ticket_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工单状态,详情参考option中customstatus',
  `ticket_submit_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单提交时间',
  `ticket_refer_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单耗时参照时间',
  `ticket_run_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单解决时长',
  `ticket_complete_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单完成时间',
  `ticket_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未读 1:已读',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '工单操作者ID',
  `member_id` int(11) NOT NULL DEFAULT '-1' COMMENT '站内会员ID . -1表示匿名提交',
  `user_name` varchar(128) NOT NULL DEFAULT '' COMMENT '工单操作者名字',
  `ticket_contact` tinyint(4) NOT NULL DEFAULT '0' COMMENT '联系方式 1:邮箱 2:手机号码',
  `ticket_contact_account` varchar(128) NOT NULL DEFAULT '' COMMENT '联系账号',
  `ticket_close` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常 1:关闭',
  `ticket_score` decimal(10,2) NOT NULL COMMENT '本次工单评分',
  `ticket_score_time` int(11) NOT NULL COMMENT '评分时间',
  `ticket_fix` tinyint(1) NOT NULL COMMENT '工单是否解决',
  `ticket_comment` varchar(1000) NOT NULL DEFAULT '' COMMENT '评价留言',
  `ticket_time_out_sequence` int(11) NOT NULL DEFAULT '0' COMMENT '已通知超时次数',
  PRIMARY KEY (`ticket_id`),
  KEY `ticket_number` (`ticket_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_ticket_chat`
--

CREATE TABLE IF NOT EXISTS `pes_ticket_chat` (
  `ticket_chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL DEFAULT '0' COMMENT '工单ID',
  `user_id` int(11) NOT NULL DEFAULT '-1' COMMENT '用户ID,为0则为发起工单者回复',
  `user_name` varchar(128) NOT NULL DEFAULT 'Customer' COMMENT '回复者的名称,为空则为Customer,即用户回复',
  `ticket_chat_content` text NOT NULL COMMENT '回复内容',
  `ticket_chat_time` int(11) NOT NULL DEFAULT '0' COMMENT '沟通时间',
  PRIMARY KEY (`ticket_chat_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工单沟通内容' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_ticket_content`
--

CREATE TABLE IF NOT EXISTS `pes_ticket_content` (
  `ticket_content_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL DEFAULT '0' COMMENT '工单ID',
  `ticket_form_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的工单表单ID',
  `ticket_form_content` text NOT NULL COMMENT '表单内容值',
  PRIMARY KEY (`ticket_content_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工单动态表单内容表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_ticket_form`
--

CREATE TABLE IF NOT EXISTS `pes_ticket_form` (
  `ticket_form_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_form_model_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的工单模型ID',
  `ticket_form_name` varchar(128) NOT NULL DEFAULT '' COMMENT '工单表单名词',
  `ticket_form_description` varchar(128) NOT NULL DEFAULT '' COMMENT '工单表单显示名称',
  `ticket_form_explain` varchar(128) NOT NULL DEFAULT '' COMMENT '工单表单说明',
  `ticket_form_msg` varchar(128) NOT NULL DEFAULT '' COMMENT '提示信息',
  `ticket_form_type` varchar(16) NOT NULL DEFAULT '' COMMENT '工单表单类型',
  `ticket_form_option` text NOT NULL COMMENT '工单表单的选项值',
  `ticket_form_verify` varchar(32) NOT NULL DEFAULT '' COMMENT '工单表单的验证类型',
  `ticket_form_required` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否必填 0: 否 1:必填',
  `ticket_form_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用 0:否 1:启用',
  `ticket_form_listsort` int(11) NOT NULL DEFAULT '0' COMMENT '动态表单的排序值（升值））',
  `ticket_form_bind` int(11) NOT NULL DEFAULT '0' COMMENT '绑定的联动表单',
  `ticket_form_bind_value` varchar(255) NOT NULL DEFAULT '' COMMENT '联动触发值',
  PRIMARY KEY (`ticket_form_id`),
  KEY `ticket_form_model_id` (`ticket_form_model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工单动态表单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_ticket_model`
--

CREATE TABLE IF NOT EXISTS `pes_ticket_model` (
  `ticket_model_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_model_number` varchar(32) DEFAULT '' COMMENT '每个用户看到的唯一工单模型ID',
  `ticket_model_name` varchar(128) NOT NULL DEFAULT '' COMMENT '工单模型名称',
  `ticket_model_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工单模型是否启用',
  `ticket_model_login` int(11) NOT NULL DEFAULT '0',
  `ticket_model_verify` int(11) NOT NULL DEFAULT '0',
  `ticket_model_cid` int(11) NOT NULL DEFAULT '0',
  `ticket_model_listsort` int(11) NOT NULL DEFAULT '0',
  `ticket_model_explain` text NOT NULL,
  `ticket_model_group_id` varchar(255) NOT NULL DEFAULT '',
  `ticket_model_time_out` int(11) NOT NULL DEFAULT '10' COMMENT '工单超时提醒设置',
  `ticket_model_time_out_sequence` int(11) NOT NULL DEFAULT '1' COMMENT '超时提醒次数',
  PRIMARY KEY (`ticket_model_id`),
  UNIQUE KEY `ticket_model_number` (`ticket_model_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工单模型' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_ticket_notice_action`
--

CREATE TABLE IF NOT EXISTS `pes_ticket_notice_action` (
  `action_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(128) NOT NULL COMMENT '工单单号',
  `send_account` varchar(255) NOT NULL DEFAULT '' COMMENT '接收帐号',
  `send_type` int(11) NOT NULL DEFAULT '0' COMMENT '发送方式',
  `template_type` int(11) NOT NULL DEFAULT '0' COMMENT '发送模板类型',
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工作消息通知发送动作' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_user`
--

CREATE TABLE IF NOT EXISTS `pes_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_account` varchar(255) NOT NULL DEFAULT '',
  `user_password` varchar(255) NOT NULL DEFAULT '',
  `user_mail` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `user_group_id` int(11) NOT NULL DEFAULT '0',
  `user_status` tinyint(4) NOT NULL DEFAULT '0',
  `user_createtime` int(11) NOT NULL DEFAULT '0',
  `user_last_login` int(11) NOT NULL DEFAULT '0',
  `user_weixinWork` varchar(255) DEFAULT NULL,
  `user_score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总体评分',
  `user_score_frequency` int(11) NOT NULL DEFAULT '0' COMMENT '评分次数',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_weixinWork` (`user_weixinWork`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pes_user_group`
--

CREATE TABLE IF NOT EXISTS `pes_user_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_status` tinyint(4) NOT NULL DEFAULT '0',
  `user_group_createtime` int(11) NOT NULL DEFAULT '0',
  `user_group_name` varchar(255) NOT NULL DEFAULT '',
  `user_group_menu` text NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `pes_user_group`
--

INSERT INTO `pes_user_group` (`user_group_id`, `user_group_status`, `user_group_createtime`, `user_group_name`, `user_group_menu`) VALUES
(1, 1, 0, '管理员', '12,13,17,18,1,2,21,3,4,14,15,23,9,6,7,16,19,10,11'),
(2, 1, 0, '客服人员', '12,13,17,18'),
(3, 1, 0, '投诉反馈', '33');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
