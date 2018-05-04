<?php
/**
 * 项目入口
 * @author LuoBoss
 * @copyright ©2013-2014 PESCMS
 * @license http://www.pescms.com/license
 * @version 1.0
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
header('Location:'.DOCUMENT_ROOT.'/Install/index.php?g=Install&m=Index&a=index');