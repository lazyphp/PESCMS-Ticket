<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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