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


namespace Slice\Ticket\UpdateField;

/**
 * 执行更新节点父类字段的动作
 * Class Login
 * @package Slice\Ticket
 */
class UpdateNodeParentField extends \Core\Slice\Slice {

    public function before() {
    }

    /**
     * 更新节点模型字段中，父类的字段选项值
     */
    public function after() {
        $nodeList = \Model\Content::listContent(['table' => 'node', 'order' => 'node_listsort ASC, node_id DESC']);
        $parent = ['请选择' => '', '顶层菜单' => '0'];
        $controller = ['请选择' => '', '顶层节点' => '0', '非权限节点' => '-1'];
        foreach ($nodeList as $value) {
            if ($value['node_parent'] == '0') {
                $parent[$value['node_name']] = $value['node_id'];
            }
            if ($value['node_controller'] == '0') {
                $controller[$value['node_name']] = $value['node_id'];
            }

        }

        $this->db('field')->where(' field_model_id = 13 AND field_name = :parent')->update(['field_option' => json_encode($parent), 'noset' => ['parent' => 'parent']]);
        $this->db('field')->where(' field_model_id = 13 AND field_name = :controller')->update(['field_option' => json_encode($controller), 'noset' => ['controller' => 'controller']]);
    }


}