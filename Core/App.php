<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Core;
use Core\Abnormal\Abnormal as Abnormal,
    Core\Route\Route as Route;
/**
 * 初始化系统控制层
 * @author LuoBoss
 * @version 1.0
 */
class App {

    private $unixPath;

    public function __construct() {

        //自动注册类
        spl_autoload_register(array($this, 'loader'));
        //自定义报错机制
        set_error_handler("Core\Abnormal\Error::getError");
        register_shutdown_function('Core\Abnormal\Error::getShutdown');
        //实体化控制层
        $this->start();
    }

    /**
     * 执行指定模块
     */
    public function start() {
        $route = new Route();
        $route->index();
        unset($route);

        include PES_CORE . 'Slice/registerSlice.php';

        array_walk(\Core\Slice\InitSlice::$slice, function($obj){
            $obj->before();
        });


        /**
         * runningNormally用于判断控制器是否存在、是否拥有魔术方法。
         * 反之返回404状态和错误页
         */
        $runningNormally = false;
        foreach (['getContorller', 'getContent'] as $value) {
            if ($this->$value() !== false) {
                $runningNormally = true;
                break;
            }
        }

        if(\Core\Slice\InitSlice::$beforeViewToExecAfter === false){
            array_walk(\Core\Slice\InitSlice::$slice, function($obj){
                $obj->after();
            });
        }


        if ($runningNormally === false) {
            $title = "404 页面不存在";
            $errorMes = "<b>Debug route info:</b><br />Group:" . GROUP . ", Model:" . MODULE . ", Method:" . METHOD . ", Action:" . ACTION;
            $errorFile = "<b>File loaded:</b><br />" . APP_PATH . substr($this->unixPath, 1).".php";

            $this->promptPage($title, $errorMes, $errorFile);
        }

    }

    /**
     * 初始化控制器
     */
    private function getContorller() {
        return $this->initObj("\\" . ITEM . "\\" . GROUP . "\\" . METHOD . "\\" . MODULE);
    }

    /**
     * 获取智能表单
     */
    private function getContent() {
        return $this->initObj("\\" . ITEM . "\\" . GROUP . "\\" . METHOD . "\\Content");
    }

    /**
     * 初始化控制器的对象
     * @param $class 对象的命名空间
     */
    private function initObj($class) {
        $this->unixPath = str_replace("\\", "/", $class);

        if (!file_exists(APP_PATH . $this->unixPath . '.php')) {
            return false;
        }
        //使用反射机制，验证控制器方法和是否支持魔术方法是否存在
        $reflectionClass = new \ReflectionClass($class);
        if ($reflectionClass->hasMethod(ACTION) === false && $reflectionClass->hasMethod('__call') === false) {
            return false;
        }

        $obj = new $class();
        $a = ACTION;
        $obj->$a();

    }

    /**
     * 获取模板
     * @todo 本方法暂时被废弃。因为和智能表单功能产生了一些冲突。
     */
    private function getTemplate() {
        $theme = \Core\Func\CoreFunc::getThemeName();
        $path = THEME . '/' . GROUP . "/{$theme}/";
        if (file_exists($path . MODULE . '/' . MODULE . '_' . ACTION . '.php')) {
            require $path . MODULE . '/' . MODULE . '_' . ACTION . '.php';
        } elseif (file_exists($path . MODULE . '_' . ACTION . '.php')) {
            require $path . MODULE . '_' . ACTION . '.php';
        } else {
            return false;
        }
    }

    /**
     * 加载必须的类名
     * @param type $className 加载类名
     */
    private function loader($className) {
        $unixPath = str_replace("\\", "/", $className);

        if (file_exists(APP_PATH . $unixPath . '.php')) {
            require APP_PATH . $unixPath . '.php';
        }elseif(file_exists(PES_CORE . $unixPath . '.php')){
            require PES_CORE . $unixPath . '.php';
        }elseif(file_exists(VENDOR_PATH . $unixPath . '.php')){
            require VENDOR_PATH . $unixPath . '.php';
        } else {
            if (\Core\Func\CoreFunc::$defaultPath == false) {
                return true;
            } else {
                $title = 'Class File Lose';
                $errorMsg = "<b>Debug info:</b><br /> Class undefined.";
                $errorFile = "<b>File :</b> <br />" . APP_PATH . "{$unixPath}.php";
                $this->promptPage($title, $errorMsg, $errorFile);
            }
        }
    }

    /**
     * 加载失败 获取提示页
     * @return type 返回模板
     */
    private function promptPage($title, $errorMsg, $errorFile) {
        header('HTTP/1.1 404');
        if (DEBUG === false) {
            $title = '404 页面不存在';
            $errorMsg = '当前请求服务器无法匹配，请检查请求的地址是否正确。';
            $errorFile = '我们已经记录此错误信息';
        }

        $label = new \Expand\Label();
        if (!empty(\Core\Func\CoreFunc::$param)) {
            extract(\Core\Func\CoreFunc::$param, EXTR_OVERWRITE);
        }
	    //加载文件丢失，加载全局404页面。
        require PES_CORE . 'Core/Theme/404.php';
        exit;
    }

}
