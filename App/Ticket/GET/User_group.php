<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */
namespace App\Ticket\GET;

class User_group extends Content {

    /**
     * 设置菜单
     */
    public function setMenu() {
        $id = $this->isG('id', '请提交用户组');
        $record = [];
        $recordList = \Model\Content::findContent('user_group', $id, 'user_group_id')['user_group_menu'];
        if(!empty($recordList)){
            $record = explode(',', $recordList);
        }
        $this->assign('record', json_encode($record));
        $this->assign('list', \Core\Func\CoreFunc::$param['menu']);
        $this->assign('prefix', 'menu_');
        $this->display('User_group_setting');
    }

    /**
     * 设置权限
     */
    public function setAuth() {
        $id = $this->isG('id', '请提交用户组');
        $record = [];
        $recordList = \Model\Content::listContent(['table' => 'node_group', 'condition' => 'user_group_id = :user_group_id', 'param' => ['user_group_id' => $id]]);
        if(!empty($recordList)){
            foreach($recordList as $value){
                $record[] = $value['node_id'];
            }
        }

        $this->assign('record', json_encode($record));
        $this->assign('list', \Model\Node::nodeList());
        $this->assign('prefix', 'node_');
        $this->display('User_group_setting');
    }
}