<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Core\Plugin;

class Plugin{

    /**
     * 应用插件的注册方法
     * @var array
     */
    private static $pluginJson = [];

    /**
     * 记录初始化过的应用插件的对象
     * @var array
     */
    private static $pluginObj =  [];

    /**
     * 插件按钮事件
     * @param $type 事件类型
     * @param $arguments 传递参数
     * @return bool
     */
    public function event($type, $arguments){

        if(empty(self::$pluginJson)){
            self::$pluginJson = json_decode(file_get_contents(PES_CORE.'plugin.json'), true);
            if(empty(self::$pluginJson) && !is_array(self::$pluginJson)){
                return false;
            }
        }

        /**
         * @todo 随着应用增多，应该先依据GMA判断存在符合的事件。因此应该将self::$pluginObj调整一个可判断的应用对象变量。
         */
        foreach(self::$pluginJson as $key => $item){
            if(!$this->checkPluginFile(explode("\\", $key)) || empty($item[$type]) ){
                continue;
            }

            foreach ($item[$type] as $action => $auth){
                if(strcmp($this->placeholder($auth), GROUP.'-'.MODULE.'-'.ACTION) !== 0){
                    continue;
                }

                if(empty(self::$pluginObj[$key])){
                    self::$pluginObj[$key] = new $key();
                }
                self::$pluginObj[$key]->$action($arguments);
            }
        }

    }

    /**
     * 快速处理路由的占位符
     * @param $str 需要处理的路由规则
     * @return mixed
     */
    private static function placeholder($str){
        return str_replace([':g', ':m', ':a'], [GROUP, MODULE, ACTION], $str);
    }

    /**
     * 注册插件
     */
    public function register($class, $action){
        $this->writePluginJson($class, $action);
        return $this;
    }

    /**
     * 注销插件
     */
    public function unRegister($class){
        $this->writePluginJson($class);
        return $this;
    }

    /**
     * 写入插件json
     * @param $class 插件命名空间
     * @param array $action 注册插件事件 | 空则表示删除
     */
    private function writePluginJson($class, $action = array()){

        $className = is_object($class) ? "\\".get_class($class) : $class;

        $pluginJsonFile = PES_CORE.'plugin.json';
        $pluginJson = json_decode(file_get_contents($pluginJsonFile), true);

        if(empty($action)){
            unset($pluginJson[$className]);
        }else{
            $pluginJson[$className] = $action;
        }

        $fopen = fopen($pluginJsonFile, 'w+');
        fwrite($fopen, json_encode($pluginJson, JSON_PRETTY_PRINT));
        fclose($fopen);
    }

    /**
     * 更新配置文件
     * @param $obj
     * @param $status
     * @return $this 连贯操作进行插件事件注册和注销
     */
    public function updateConfig($obj, $config){
        $pluginConfigFile = $obj->pluginPath['plugin'].'/plugin.ini';

        $fopen = fopen($pluginConfigFile, 'w+');

        foreach ($config as $name => $item){
            fwrite($fopen, "[{$name}]\n");
            foreach ($item as $key => $value){
                fwrite($fopen, "{$key} = {$value}\n");
            }
        }
        fclose($fopen);

        return $this;
    }

    /**
     * 删除插件
     * @param $obj
     * @return array|bool
     */
    public function remove($obj){
        $config = $this->loadConfig($obj);

        $removePluginController = \Model\Extra::clearDirAllFile($obj->pluginPath['plugin'], $obj->pluginPath['plugin']);

        if($removePluginController['status'] == 0){
            return $removePluginController;
        }

        $removePluginView = \Model\Extra::clearDirAllFile($obj->pluginPath['view'], $obj->pluginPath['view']);
        if($removePluginView['status'] == 0){
            return $removePluginView;
        }
        return true;
    }

    /**
     * 读取插件配置信息
     * @param $obj 插件对象
     * @return array|bool
     */
    public function loadConfig($obj){
        $pluginConfigFile = $obj->pluginPath['plugin'].'/plugin.ini';
        return parse_ini_file($pluginConfigFile, true);
    }

    /**
     * 验证插件是否存在
     * @param $file
     * @return bool
     */
    private function checkPluginFile($file){
        return is_file(PES_CORE.implode('/', $file).'.php');
    }
}