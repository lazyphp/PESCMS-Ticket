<?php

abstract class Core {
    /* 是否调试 */

    const DEBUG = TRUE;

    public function __construct() {

        if (self::DEBUG == FALSE) {
            error_reporting(0);
        }
        if (substr(php_sapi_name(), 0, 3) != 'cli' && !self::DEBUG) {
            exit("Only run in cmd!");
        }
        header("Content-type: text/html; charset=utf-8");

        $basePath = dirname(dirname(dirname(__FILE__)));

        defined('DOCUMENT_ROOT') or define('DOCUMENT_ROOT', $basePath . '/');

        //核心文件当前的路径
        defined('PES_CORE') or define('PES_CORE', $basePath . '/');

        defined('PES_PATH') or define('PES_PATH', $basePath . '/');
        //项目默认控制器所在目录
        defined('APP_PATH') or define('APP_PATH', $basePath . '/');
        //项目默认的配置文件所在目录
        defined('CONFIG_PATH') or define('CONFIG_PATH', PES_CORE . 'Config/');
        //vendor目录
        defined('VENDOR_PATH') or define('VENDOR_PATH', PES_CORE . 'vendor');


        define('THEME', __DIR__);

        /**
         * 配置原因，
         */
        define('GROUP', 'Ticket');
        define('DEBUG', TRUE);

        spl_autoload_register([$this, 'loader']);
        $this->system();

        new \Core\Controller\Controller();

    }

    /**
     * 声明DB类
     * @param type $name 表名
     * @return type
     */
    public function db($name = '', $database = '', $dbPrefix = '') {
        return \Core\Func\CoreFunc::db($name, $database, $dbPrefix);
    }

    /**
     * 自动加载
     */
    private function loader($className) {
        $unixPath = str_replace("\\", "/", $className);
        if (file_exists(PES_PATH . $unixPath . '.php')) {
            require PES_PATH . $unixPath . '.php';
        }
    }

    /**
     * 配置全局系统变量
     */
    private function system() {
        $list = \Model\Content::listContent([
            'table'     => 'option',
            'condition' => "option_range = 'system'",
        ]);
        $system = [];
        foreach ($list as $value) {
            $system[$value['option_name']] = $value['value'];
        }
        \Core\Func\CoreFunc::$param['system'] = $system;
    }
}
