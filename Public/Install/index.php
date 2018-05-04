<?php

/**
 * 项目入口
 * @author LuoBoss
 * @copyright ©2013-2014 PESCMS
 * @license http://www.pescms.com/license
 * @version 1.0
 */
define('ITEM', 'Install\App');
//调试模式
define('DEBUG', true);
$parentPath = dirname(dirname(dirname(__FILE__)));
//项目配置文件
defined('CONFIG_PATH') or define('CONFIG_PATH', $parentPath . '/Install/');
//项目目录
defined('PES_PATH') or define('PES_PATH', $parentPath. '/');
//模板存放目录
define('THEME', dirname(__FILE__).'/Theme');

require $parentPath.'/Core/index.php';