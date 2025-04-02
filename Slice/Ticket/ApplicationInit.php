<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace Slice\Ticket;

/**
 * 插件控制器切片
 * Class ApplicationPlugin
 * @package Slice\Ticket
 */
class ApplicationInit extends \Core\Slice\Slice{

    public function before() {

        if(isset(self::session()->get('ticket')['user_id']) && self::session()->get('ticket')['user_id'] != '1'){
            $this->error('请使用超级管理员账号进行操作');
        }

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