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
 * 插件接口
 * Interface PluginImplements
 * @package Core\Plugin
 */
interface PluginImplements{


    /**
     * 插件配置选项
     * @return mixed
     */
    public function option();

    /**
     * 启用插件
     * @return mixed
     */
    public function enabled();

    /**
     * 关闭插件
     * @return mixed
     */
    public function disabled();

    /**
     * 删除插件
     * @return mixed
     */
    public function remove();

    /**
     * 安装插件执行的事件
     * @return mixed
     */
    public function install();

    /**
     * 升级插件执行的事件
     * @return mixed
     */
    public function upgrade();

}