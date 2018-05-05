<?php
/**
 * 项目入口
 * @author LuoBoss
 * @copyright ©2013-2014 PESCMS
 * @license http://www.pescms.com/license
 * @version 1.0
 */
//控制器名称
define('ITEM', 'App');
//调试模式
define('DEBUG', true);
//定位入口文件到PES CORE的目录路径
$parentPath = dirname(dirname(__FILE__));
//模板存放目录
defined('THEME') or define('THEME', dirname(__FILE__). '/Theme');

require $parentPath.'/Core/index.php';