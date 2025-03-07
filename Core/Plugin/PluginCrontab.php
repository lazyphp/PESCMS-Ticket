<?php

/**
 * 版权所有 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Core\Plugin;

/**
 * 插件定时任务抽象类
 */
abstract class PluginCrontab extends \Core\Controller\Controller {

    abstract public function run();

}