<?php

/**
 * PSE核心引入文件
 * @author LuoBoss
 * @copyright ©2013-2015 PESCMS
 * @license http://www.pescms.com/license
 * @version 2.5
 */
//PES已经自定义错误功能，因此禁用系统的错误信息
error_reporting(0);
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
session_start();
//调试模式
defined('DEBUG') or define('DEBUG', FALSE);
//项目目录
defined('ITEM') or define('ITEM', dirname(__FILE__) . '/');
//项目模板
defined('THEME') or define('THEME', dirname(__FILE__) . '/');
//项目配置文件
defined('CONFIG_PATH') or define('CONFIG_PATH', dirname(dirname(__FILE__)) . '/');

defined('PES_PATH') or define('PES_PATH', dirname(dirname(__FILE__)) . '/');

defined('PES_CORE') or define('PES_CORE', dirname(__FILE__) . '/');

/**
 * 由于没有找到解决方法
 * 此处直接使用thinkphp的源码，感谢！
 */
define('IS_CGI', (0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')) ? 1 : 0 );
if (!defined('_PHP_FILE_')) {
    if (IS_CGI) {
        //CGI/FASTCGI模式下
        $_temp = explode('.php', $_SERVER['PHP_SELF']);
        define('PHP_FILE', rtrim(str_replace($_SERVER['HTTP_HOST'], '', $_temp[0] . '.php'), '/'));
    } else {
        define('PHP_FILE', rtrim($_SERVER['SCRIPT_NAME'], '/'));
    }
}
if (!defined('DOCUMENT_ROOT')) {
    $_root = rtrim(dirname(PHP_FILE), '/');
    define('DOCUMENT_ROOT', (($_root == '/' || $_root == '\\') ? '' : $_root));
}

require PES_CORE . 'App.class.php';

use Core\App as App;

$autoloader = new App();
