<?php

/**
 * PSE核心引入文件
 * @author LuoBoss
 * @copyright ©2013-2015 PESCMS
 * @license http://www.pescms.com/license
 * @version 2.5
 */
define('PES_RUN_TIME', microtime(true));
//PES已经自定义错误功能，因此禁用系统的错误信息
error_reporting(0);
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
//调试模式
defined('DEBUG') or define('DEBUG', FALSE);
//核心文件当前的路径
defined('PES_CORE') or define('PES_CORE', dirname(dirname(__FILE__)) . '/');
//项目默认控制器所在目录
defined('APP_PATH') or define('APP_PATH', dirname(dirname(__FILE__)). '/');
//项目默认的配置文件所在目录
defined('CONFIG_PATH') or define('CONFIG_PATH', PES_CORE . 'Config/');
//vendor目录
defined('VENDOR_PATH') or define('VENDOR_PATH', PES_CORE . 'vendor');

//解决二级目录的问题
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

require PES_CORE . '/Core/App.php';
require PES_CORE . '/vendor/autoload.php';

use Core\App as App;

$autoloader = new App();
