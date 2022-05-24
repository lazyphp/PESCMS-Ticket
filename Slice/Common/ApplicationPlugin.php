<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace Slice\Common;

/**
 * 插件控制器切片
 * Class ApplicationPlugin
 * @package Slice\Ticket
 */
class ApplicationPlugin extends \Core\Slice\Slice{

    public function before() {
        $pluginName = $this->isG('n', '请提交插件名称');
        $pluginFunc = $this->isG('f', '请提交插件名称');

        $splitPluginName = explode('-', $pluginName);

        $pluginNameSpace = "\Plugin\\{$splitPluginName[0]}\\".GROUP."\\{$splitPluginName[1]}";

        $plugin = new $pluginNameSpace;

        $config = (new \Core\Plugin\Plugin())->loadConfig($plugin);

        //不在运行组则404
        if(!in_array(GROUP, explode(',', $config['plugin']['GROUP']))){
            $this->_404();
        }

        //运行插件
        $plugin->{$pluginFunc}();
        exit;
    }

    public function after() {

    }

}