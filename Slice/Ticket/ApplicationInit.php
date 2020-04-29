<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


namespace Slice\Ticket;

/**
 * 插件控制器切片
 * Class ApplicationPlugin
 * @package Slice\Ticket
 */
class ApplicationInit extends \Core\Slice\Slice{

    public function before() {
        $pluginName = $this->isG('n', '请提交插件名称');
        $pluginFunc = $this->isG('f', '请提交插件名称');

        $splitPluginName = explode('-', $pluginName);

        $pluginNameSpace = "\Plugin\\{$splitPluginName[0]}\\{$splitPluginName[1]}";

        $plugin = new $pluginNameSpace;

        //运行插件
        $plugin->{$pluginFunc}();
        exit;
    }

    public function after() {

    }

}