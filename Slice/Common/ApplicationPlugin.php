<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */


namespace Slice\Common;

/**
 * 插件切片
 * Class ApplicationPlugin
 * @package Slice\Ticket
 */
class ApplicationPlugin extends \Core\Slice\Slice{

    public function before() {
        $pluginName = $this->isG('n', '请提交插件名称');
        $pluginFunc = $this->isG('f', '请提交插件名称');

        $splitPluginName = explode('-', $pluginName);

        /**
         * 插件初始化入口是禁止访问
         */
        if(strcasecmp(trim($splitPluginName[1]), 'Init') == 0
            && ACTION != 'Init'
        ){
            $this->_404();
        }

        $pluginNameSpace = "\Plugin\\{$splitPluginName[0]}\\{$splitPluginName[1]}";

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