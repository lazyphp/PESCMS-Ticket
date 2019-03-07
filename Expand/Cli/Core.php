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
        defined('CONFIG_PATH') or define('CONFIG_PATH', dirname(dirname(dirname(__FILE__))) . '/Config/');
        defined('PES_PATH') or define('PES_PATH', dirname(dirname(dirname(__FILE__))) . '/');
        /**
         * 配置原因，
         */
        define('GROUP', 'Ticket');
        define('DEBUG', TRUE);

        spl_autoload_register(array($this, 'loader'));
        $this->system();
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
     * @param type $className
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
    private function system(){
        $list = \Model\Content::listContent([
            'table' => 'option',
            'condition' => "option_range = 'system'"
        ]);
        $system = [];
        foreach($list as $value){
            $system[$value['option_name']] = $value['value'];
        }
        \Core\Func\CoreFunc::$param['system'] = $system;
    }

    abstract public function index();
}
