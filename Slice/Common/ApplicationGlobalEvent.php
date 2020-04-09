<?php

namespace Slice\Common;

/**
 * 应用插件全局事件
 * Class ApplicationPlugin
 * @package Slice\Common
 */
class ApplicationGlobalEvent extends \Core\Slice\Slice{

    public function before() {
        (new \Core\Plugin\Plugin())->event('before', NULL);
    }

    public function after() {
        (new \Core\Plugin\Plugin())->event('after', NULL);
    }

}