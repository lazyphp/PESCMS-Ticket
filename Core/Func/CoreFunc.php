<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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
    private static $ThemeName = [];

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
     * 存储SESSION对象
     * @var
     */
    public static $session;

    /**
     * 存放token值
     * @var
     */
    public static $token;

    /**
     * 获取系统配置信息
     * @param type $name 要读取的配置名称
     * @param bool $overload 是否要重载
     * @return mixed 存在则返回对应的配置，反之返回所有配置信息
     */
    final public static function loadConfig($name = '', $overload = false) {
        static $config;
        if (empty($config) || $overload === true ) {
            $config = require CONFIG_PATH . 'config.php';
        }

        if(empty($name)){
            return $config;
        }elseif(!empty($config[$name])){
            return $config[$name];
        }else{
            return NULL;
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
            return $controller.$suffix;
        }

        $routeUrlPath = CONFIG_PATH . 'RouteUrl/' . md5(self::loadConfig('PRIVATE_KEY')) . '_route.php';

        $routeUrl = [];
        if (is_file($routeUrlPath)) {
            $routeUrl = require $routeUrlPath;

            $hash = md5($controller . implode(',', array_keys($param)));
            //匹配路由
            if (!empty($routeUrl[$hash])) {
                //是否显示index.php
                $url = $urlModel['INDEX'] == '0' ? '/index.php/' : '/';
                $replaceUrl = $routeUrl[$hash];
                //代入参数值
                if (!empty($param)) {

                    foreach ($param as $key => $value) {
                        $replaceUrl = str_replace('{'.$key.'}', $value, $replaceUrl);
                    }
                }
                $url .= $replaceUrl . $suffix;
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
            $url .= "&".htmlspecialchars($key)."=".htmlspecialchars($value);
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
     */
    public static function generatePwd($pwd, $key = 'PRIVATE_KEY') {
        $config = self::loadConfig('', true);
        $salt = $config[GROUP][$key] ? $config[GROUP][$key] : $config[$key];
        $salt = '$6$' . $salt;
        return crypt($pwd, $salt);
    }

    /**
     * 获取主题目录的名称
     */
    public static function getThemeName($group) {
        if (empty(self::$ThemeName[$group])) {
            $privateKey = md5($group . self::loadConfig('PRIVATE_KEY'));
            $checkTheme = THEME . "/" . $group . "/{$privateKey}";
            if (is_file($checkTheme)) {
                self::$ThemeName[$group] = trim(file($checkTheme)['0']);
            } else {
                self::$ThemeName[$group] = 'Default';
                $f = fopen($checkTheme, 'w');
                fwrite($f, self::$ThemeName[$group]);
                fclose($f);
            }
            //设置一个主题目录常量
            defined('THEME_PATH') or define('THEME_PATH', THEME . '/' . $group . '/' . self::$ThemeName[$group]);
        }
        return self::$ThemeName[$group];
    }

    /**
     * 判断是否ajax提交
     * @param str $data 信息
     * @param str $code 状态码
     * @param str $jumpUrl 跳转的URL
     * @param str $waitSecond 响应时间
     * @return boolean|json|xml|str 返回对应的数据类型
     */
    public static function isAjax($data, $code, $jumpUrl = '', $waitSecond = 3){
        if(self::X_REQUESTED_WITH() === false){
            return FALSE;
        }

        //@todo 我觉得ajax请求不论失败还是什么，不应该存在返回上一页的。现在直接设置为空置，让本身的函数执行刷新功能。
        if($jumpUrl == 'javascript:history.go(-1)'){
            $jumpUrl = '';
        }

        $data = array_merge([
            'msg' => '',
            'data' => ''
        ], $data);

        $type = explode(',', $_SERVER['HTTP_ACCEPT']);
        $status['status'] = $code;
        $status['msg'] = $data['msg'];
        $status['data'] = $data['data'];
        $status['url'] = $jumpUrl;
        $status['waitSecond'] = $waitSecond;

        if(empty($_REQUEST['keepToken'])){
            $token = self::token();
            $status['token'] = $token;
        }

        switch ($type[0]) {
            case 'application/json':
                exit(json_encode($status));
                break;
            case 'text/javascript':
                // javascript 或 JSONP 格式  需要扩展
                exit();
                break;
            case 'text/html':
                exit($status);
                break;
            case 'application/xml':
                //  XML 格式  需要扩展
                exit();
                break;
        }
    }

    public static function X_REQUESTED_WITH(){
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'XMLHttpRequest') != 0 ) {
            return false;
        }else{
            return true;
        }
    }

    /**
     * 调用session类库
     * @return \duncan3dc\Sessions\SessionInstance
     */
    public final static function session($id = ''){
        if(empty(self::$session)){
            $sessionid = self::loadConfig('SESSION_ID');
            self::$session = new \duncan3dc\Sessions\SessionInstance($sessionid, null, $id);
        }
        return self::$session;
    }

    /**
     * 生成token
     * @return string
     */
    public static function token(){
        $tokenArray = \Core\Func\CoreFunc::session()->get('token');
        if(empty($tokenArray)){
            $tokenArray = [];
        }

        //系统默认只保存30个token
        if(count($tokenArray) > 30){
            array_shift($tokenArray);
            //当最后一个token都已过时，则全部清空。
            if(self::checkTokenExpired(end($tokenArray)) == true){
                \Core\Func\CoreFunc::session()->delete('token');
                self::$token = NULL;
                $tokenArray = [];
            }
        }

        if(empty(self::$token)){
            list($usec, $sec) = explode(" ", microtime());
            $shelfLife = time() * self::tokenTimeSalt();
            self::$token = md5(substr($usec, 2) * rand(1, 100))."_{$shelfLife}";
            \Core\Func\CoreFunc::session()->set('token', array_merge($tokenArray, [self::$token => self::$token]));
        }elseif(in_array(self::$token, $tokenArray)){
            \Core\Func\CoreFunc::session()->set('token', array_merge($tokenArray, [self::$token => self::$token]));
        }



        return self::$token;
    }

    /**
     * 令牌的时效加盐值
     * @return float|int
     */
    public static function tokenTimeSalt(){
        $publicKey = self::loadConfig('USER_KEY');
        $salt = ord($publicKey[0]) + ord($publicKey[1]) * ord($publicKey[2]);
        return $salt;
    }

    /**
     * 验证令牌是否过期
     * @param $token
     * @return bool
     */
    public static function checkTokenExpired($token){
        $checkExpired = explode('_', $token)[1] / self::tokenTimeSalt();
        if($checkExpired + 600 < time()){
            return true;
        }else{
            return false;
        }
    }

}
