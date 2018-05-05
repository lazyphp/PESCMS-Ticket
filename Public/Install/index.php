<?php

/**
 * 项目入口
 * @author LuoBoss
 * @copyright ©2013-2014 PESCMS
 * @license http://www.pescms.com/license
 * @version 1.0
 */
define('ITEM', 'App');
//当前项目控制器所在目录
defined('APP_PATH') or define('APP_PATH', dirname(__FILE__). '/');

//调试模式
define('DEBUG', true);
//定位入口文件到PES CORE的目录路径
$parentPath = dirname(dirname(APP_PATH));
//当前项目配置文件
defined('CONFIG_PATH') or define('CONFIG_PATH', APP_PATH . 'Config/');
//模板存放目录
define('THEME', APP_PATH.'/Theme');

require $parentPath.'/Core/index.php';