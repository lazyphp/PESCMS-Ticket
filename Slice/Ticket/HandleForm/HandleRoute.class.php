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


namespace Slice\Ticket\HandleForm;

/**
 * 处理路由规则 添加/编辑 提交的表单内容
 * @package Slice\Ticket
 */
class HandleRoute extends \Core\Slice\Slice {

    /**
     * 更新哈希值
     */
    public function before() {
        $_POST['hash'] = (string)md5($_POST['controller'] . $_POST['param']);
    }

    /**
     * 更新路由规则
     */
    public function after() {
    }


}