<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Core\Route;

use Core\Abnormal\Abnormal as Abnormal,
    Core\Func\CoreFunc as CoreFunc;

/**
 * PES路由器
 * @author LuoBoss
 * @version 1.0
 */
class Route {

    /**
     * 析构函数设置restfull规则
     */
    public function __destruct() {
        /**
         * 没有找到方法时，则通过$_SERVER变量查找
         * 确认最终的restfull指向。
         */
        if (empty($_REQUEST['method'])) {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    defined('METHOD') or define('METHOD', 'POST');
                    break;
                case 'PUT':
                    defined('METHOD') or define('METHOD', 'PUT');
                    break;
                case 'DELETE':
                    defined('METHOD') or define('METHOD', 'DELETE');
                    break;
                case 'GET':
                default :
                    defined('METHOD') or define('METHOD', 'GET');
            }
            return true;
        }

        switch (strtoupper($_REQUEST['method'])) {
            case 'POST':
                defined('METHOD') or define('METHOD', 'POST');
                break;
            case 'PUT':
                defined('METHOD') or define('METHOD', 'PUT');
                break;
            case 'DELETE':
                defined('METHOD') or define('METHOD', 'DELETE');
                break;
            case 'GET':
            default :
                defined('METHOD') or define('METHOD', 'GET');
        }
    }

    /**
     * 初始化路由器规则
     */
    public function index() {
        $requestUri = $this->filterSuffix($this->splitIndex());
        /**
         * 防止浏览器因为寻找ico图标
         * 造成二次访问，产生多次访问。
         */
        if ($requestUri == 'favicon.ico') {
            header('HTTP/1.1 404');
            exit;
        }

        $this->custom($requestUri);

        if (empty($_GET['m']) || empty($_GET['a'])) {
            defined('GROUP') or define('GROUP', CoreFunc::loadConfig('DEFAULT_GROUP'));
            defined('MODULE') or define('MODULE', 'Index');
            defined('ACTION') or define('ACTION', 'index');
        } else {
            /**
             * 暂时不清楚在nginx下，会多一个S的get参数。
             * 为了让程序的正常运行，所以将该参数清空。
             */
            unset($_GET['s']);
            $this->normal();
        }
    }

    /**
     * 加载用户自定义路由
     * @param type $request 请求
     * @return type 成功则返回true
     */
    public function custom($request) {
        if (!is_file(CONFIG_PATH . 'Route.php')) {
            return false;
        }

        $routeArray = require CONFIG_PATH . 'Route.php';
        if(empty($routeArray)){
            return false;
        }


        $splitRequest = explode('/', $request);
        $splitRequesCount = count($splitRequest);

        $urlParam = false;
        foreach ($routeArray as $route => $controller) {
            $splitRoute = explode('/', $route);

            if (count($splitRoute) === $splitRequesCount) {
                $urlParam = array();
                array_walk($splitRequest, function($param, $key) use ($splitRequest, $splitRoute, &$urlParam) {
                    if ($splitRoute[$key] == $param && $urlParam !== false) {
                        
                    } elseif (preg_match('/\{\w+\}/i', $splitRoute[$key]) && $urlParam !== false) {
                        $urlParam[] = str_replace(array('{', '}'), '', $splitRoute[$key]);
                        $urlParam[] = $param;
                    } else {
                        $urlParam = false;
                    }
                });


                if ($urlParam !== false) {
                    $controller = explode('-', $controller);
                    if(count($controller) == 2){
                        $_GET['m'] = $controller['0'];
                        $_GET['a'] = $controller['1'];
                    }else{
                        $_GET['g'] = $controller['0'];
                        $_GET['m'] = $controller['1'];
                        $_GET['a'] = $controller['2'];
                    }

                    foreach($urlParam as $key => $value){
                        if($key % 2 != 0){
                            $_GET[$urlParam[$key - 1]] = $value;
                        }
                    }
                }
            }
        }
    }

    /**
     * 正常的路由加载模式
     * @throws Abnormal
     */
    private function normal() {
        //获取所有组
        $group = explode(',', CoreFunc::loadConfig('APP_GROUP_LIST'));

        if (!empty($_GET['m']) && !empty($_GET['a'])) {
            //获取组
            if (empty($_GET['g'])) {
                define('GROUP', CoreFunc::loadConfig('DEFAULT_GROUP'));
            } elseif (in_array($_GET['g'], $group)) {
                $key = array_search($_GET['g'], $group);
                define('GROUP', $group[$key]);
            }
            define('MODULE', $_GET['m']);
            define('ACTION', $_GET['a']);
            //清空GET
            unset($_GET['g'], $_GET['m'], $_GET['a']);
        }
    }



    /**
     * 当URL存在下级目录时，执行一个替换操作
     * @param type $splitParam 替换的参数
     * @return type 返回替换好的参数
     */
    private function splitIndex() {
        $REQUEST_URI = substr($_SERVER['REQUEST_URI'], 1);
        $existIndex = strpos($REQUEST_URI, 'index.php');
        if($existIndex !== false){
            return str_replace('index.php/', '', substr($REQUEST_URI, $existIndex));
        }
        return $REQUEST_URI;

    }

    /**
     * 拆分URL中ACTION后面附带的各种参数
     */
    private function splitAction($param) {
        /**
         * 拆分问号
         */
        $mark = explode('?', $param);
        return $mark[0];
    }

    /**
     * 过滤常规的后缀
     * @param type $url 待过滤的URL
     */
    private function filterSuffix($url) {
        if (substr($url, '-5') == '.html') {
            $url = substr($url, '0', '-5');
        }

        $findPage = strpos($url, '/page');
        if ($findPage !== false) {
            $pageParam = (int)str_replace('/page/', '', substr($url, $findPage));
            if (!is_numeric($pageParam) || $pageParam <= 0 ) {
                $_GET['page'] = 1;
            } else {
                $_GET['page'] = $pageParam;
            }

            $url = substr($url, 0, $findPage);
        }

        return $url;
    }

}
