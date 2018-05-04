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
 * 处理节点管理 添加/编辑 提交的表单内容
 * @package Slice\Ticket
 */
class HandleNode extends \Core\Slice\Slice {

    public function before() {
        if (in_array(METHOD, ['POST', 'PUT'])) {
            if ($_POST['controller'] == '0' || $_POST['controller'] == '-1' ) {
                $_POST['value'] = (string)ucfirst(strtolower($_POST['value']));
            } else {
                $controller = \Model\Content::findContent('node', $_POST['controller'], 'node_id');
                $_POST['check_value'] = GROUP . $_POST['method_type'] . $controller['node_value'] . $_POST['value'];
            }
        }
    }

    public function after() {
    }


}