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

        include PES_PATH . '/Slice/registerSlice.php';

        array_walk(\Core\Slice\InitSlice::$slice, function($obj){
            $obj->before();
        });

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
            $title = "404 Page Not Found";
            $errorMes = "<b>Debug route info:</b><br />Group:" . GROUP . ", Model:" . MODULE . ", Method:" . METHOD . ", Action:" . ACTION;
            $errorFile = "<b>File loaded:</b><br />" . PES_PATH . "{$this->unixPath}.class.php";

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

        if (!file_exists(PES_PATH . $this->unixPath . '.class.php')) {
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

        if (file_exists(PES_PATH . $unixPath . '.class.php')) {
            require PES_PATH . $unixPath . '.class.php';
        } else {
            if (\Core\Func\CoreFunc::$defaultPath == false) {
                return true;
            } else {
                $title = 'Class File Lose';
                $errorMes = "<b>Debug info:</b><br /> Class undefined.";
                $errorFile = "<b>File :</b> <br />" . PES_PATH . "{$unixPath}.class.php";
                $this->promptPage($title, $errorMes, $errorFile);
            }
        }
    }

    /**
     * 获取提示页
     * @return type 返回模板
     */
    private function promptPage($title, $errorMes, $errorFile) {
        header('HTTP/1.1 404');
        if (DEBUG === false) {
            $title = '404';
            $errorMes = 'The requested URL was not found on this server.';
            $errorFile = 'That’s all we know.';
        }

        if (file_exists(THEME . '/' . GROUP . '/404.php')) {
            require THEME . '/' . GROUP . '/404.php';
        } else {
            require PES_CORE . 'Theme/error.php';
        }
        exit;
    }

}
