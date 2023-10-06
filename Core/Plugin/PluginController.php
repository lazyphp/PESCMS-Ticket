<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */
namespace Core\Plugin;

/**
 * 插件控制器
 */
class PluginController extends \Core\Controller\Controller {

    public $pluginPath = [];
    
    public function __init() {
        $this->getPluginPath();
    }


    protected function display($themeFile='') {
        echo '<b>Parse error:</b>禁止调用Plugin\Plugin::display()';
        exit;
    }

    protected function layout($themeFile = '', $layout = "layout") {
        echo '<b>Parse error:</b>禁止调用Plugin\Plugin::layout()';
        exit;
    }

    protected function view($file){
        /* 加载标签库 */
        $label = new \Expand\Label();

        if (!empty(\Core\Func\CoreFunc::$param)) {
            extract(\Core\Func\CoreFunc::$param, EXTR_OVERWRITE);
        }

        require "{$this->pluginPath['view']}/view/{$file}.php";
    }

    protected function viewLayout($file, $layout = 'layout'){
        /* 加载标签库 */
        $label = new \Expand\Label();

        if (!empty(\Core\Func\CoreFunc::$param)) {
            extract(\Core\Func\CoreFunc::$param, EXTR_OVERWRITE);
        }
        $file = "{$this->pluginPath['view']}/view/{$file}.php";
        require THEME_PATH."/{$layout}.php";
    }

    /**
     * 获取当前运行插件的地址
     * @throws \Exception
     */
    private function getPluginPath(){
        $pluginClass = get_called_class();
        if(empty($pluginClass)){
            throw new \Exception("获取插件地址失败");
        }
        $split = explode('\\', $pluginClass);

        $this->pluginPath['plugin'] = PES_CORE."{$split[0]}/{$split[1]}";
        $this->pluginPath['view'] = PES_CORE."Public/{$split[0]}/{$split[1]}";
    }

    /**
     * 注册Form组件
     * @param array $name
     * @return void
     */
    public function regForm(array $name){

        $res = \Model\Extra::getFormContent();
        $json = array_merge($res['json'], $name);

        $f = fopen($res['path'], 'w+');
        fwrite($f, json_encode($json ?? [], JSON_UNESCAPED_UNICODE));
        fclose($f);
    }

    /**
     * 删除Form组件
     * @param $key
     * @return void
     */
    public function removeForm($key){
        $res = \Model\Extra::getFormContent();
        unset($res['json'][$key]);
        $f = fopen($res['path'], 'w+');
        fwrite($f, json_encode($res['json'] ?? [], JSON_UNESCAPED_UNICODE));
        fclose($f);

    }

    /**
     * 读取配置信息
     * @param $obj
     * @return array|bool
     */
    public function loadConfig($obj){
        return (new \Core\Plugin\Plugin())->loadConfig($obj);
    }

    public function updateConfig($obj, $config){
        return (new \Core\Plugin\Plugin())->updateConfig($obj, $config);
    }

}