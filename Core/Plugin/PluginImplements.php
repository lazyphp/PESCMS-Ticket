<?php

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
     * 升级插件
     * @return mixed
     */
    public function upgrade();

}