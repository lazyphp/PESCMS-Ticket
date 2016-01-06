<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @version 2.5
 */

namespace Core\Func;

/**
 * PES系统函数
 * @author LuoBoss
 * @license http://www.pescms.com/license
 * @version 1.0
 */
class CoreFunc {

    /**
     * 引用第三方库是否使用默认路径
     * @var type true开启 | false 关闭
     */
    public static $defaultPath = true;

    /**
     * 快速获取程序当前的主题名称
     * @var string
     */
    private static $ThemeName;

    /**
     * 用于存储赋值变量
     * @var array
     */
    public static $param = array();

    /**
     * 暴露当前URL是否使用了自定义路由规则。
     * PS:其实就是一个裸露癖患者。
     * @var bool
     */
    public static $useRoute = false;

    /**
     * 获取系统配置信息
     * @param type $name
     * @return type
     */
    final public static function loadConfig($name = NULL) {
        static $config;
        if (empty($config)) {
            $config = require CONFIG_PATH . 'Config/config.php';
        }
        if (empty($config[$name])) {
            return $config;
        } else {
            return $config[$name];
        }
    }

    /**
     * 生成URL链接
     * @param type $controller 链接的控制器
     * @param array $param 参数 | 当本参数为true时，那么将会直接返回$controller当作URL。适用于输出自定义路由
     * @param bool $close 强制关闭后缀
     * @return type 返回URL
     */
    final public static function url($controller, $param = array(), $close = false) {

        $urlModel = self::loadConfig('URLMODEL');
        /**
         * 是否显示HTML后缀
         */
        if ($urlModel['SUFFIX'] == '1' && $close === false) {
            $suffix = ".html";
        }

        if ($param === true) {
            self::$useRoute = true;
            return $controller;
        }

        $routeUrlPath = PES_PATH . '/Config/RouteUrl/' . md5(self::loadConfig('PRIVATE_KEY')) . '_route.php';

        $routeUrl = [];
        if (is_file($routeUrlPath)) {
            $routeUrl = require $routeUrlPath;

            $hash = md5($controller . implode(',', array_keys($param)));
            //匹配路由
            if (!empty($routeUrl[$hash])) {
                //是否显示index.php
                $url = $urlModel['INDEX'] == '0' ? '/index.php/' : '/';
                //替换参数占位符
                $replaceurl = str_replace(['{', '}'], '', $routeUrl[$hash]);

                //代入参数值
                if (!empty($param)) {
                    foreach ($param as $key => $value) {
                        $replaceurl = str_replace($key, $value, $replaceurl);
                    }
                }
                $url .= $replaceurl . $suffix;
                self::$useRoute = true;
                return DOCUMENT_ROOT . $url;

            }
        }

        //拆分参数控制器
        $dismantling = explode('-', $controller);
        $totalDismantling = count($dismantling);

        if ($totalDismantling == 2) {
            $url = "/?m={$dismantling[0]}&a={$dismantling[1]}";
            $url .= self::urlLinkStr($param);
        } else {
            $url = "/?g={$dismantling[0]}&m={$dismantling[1]}&a={$dismantling[2]}";
            $url .= self::urlLinkStr($param);
        }

        return DOCUMENT_ROOT . $url;
    }

    /**
     * URL的链接字符串格式
     * @param type $param 参数内容
     */
    private static function urlLinkStr($param) {
        $url = "";
        foreach ($param as $key => $value) {
            $url .= "&{$key}={$value}";
        }
        return $url;
    }

    /**
     * 连接数据库
     * @param string $name 要连接数据库表名称
     * @param string $database 要连接数据库名称
     * @param string $dbPrefix 要连接数据库表的前缀
     * @return \Core\Db\Mysql
     */
    public static function db($name = '', $database = '', $dbPrefix = '') {
        static $db;

        if (empty($db)) {
            $db = new \Core\Db\Mysql();
        }

        $db->tableName($name, $database, $dbPrefix);
        return $db;
    }

    /**
     * 生成密码
     * @param type $pwd 密码
     * @param type $key 混淆配置
     * @todo 需要升级加密方法, 2016年PESCMS系列软件将淘汰MD5加密用户的密码的方式
     */
    public static function generatePwd($pwd, $key = 'PRIVATE_KEY') {
        $config = self::loadConfig();
        $salt = $config[GROUP][$key] ? $config[GROUP][$key] : $config[$key];
        $salt = '$6$' . $salt;
        return crypt($pwd, $salt);
    }

    /**
     * 获取主题目录的名称
     */
    public static function getThemeName($group) {
        if (empty(self::$ThemeName)) {
            $privateKey = md5($group . self::loadConfig('PRIVATE_KEY'));
            $checkTheme = THEME . "/" . $group . "/{$privateKey}";
            if (is_file($checkTheme)) {
                self::$ThemeName = trim(file($checkTheme)['0']);
            } else {
                self::$ThemeName = 'Default';
                $f = fopen($checkTheme, 'w');
                fwrite($f, self::$ThemeName);
                fclose($f);
            }
            //设置一个主题目录常量
            defined('THEME_PATH') or define('THEME_PATH', THEME . '/' . $group . '/' . self::$ThemeName);
        }
        return self::$ThemeName;
    }

}
