<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */
namespace App\Ticket\POST;

class User_group extends Content {

    /**
     * 复制用户组
     */
    public function copy(){
        $id = $this->isP('id', '请提交您要复制的用户组');
        $name = $this->isP('name', '请输入用户组名称');
        $status = $this->isP('status', '请选择用户组的状态');
        $group = \Model\Content::findContent('user_group', $id, 'user_group_id');
        if(empty($group)){
            $this->error('您要复制的用户组不存在');
        }

        $this->db()->transaction();

        $newGroupID = $this->db('user_group')->insert([
            'user_group_status' => $status,
            'user_group_name' => $name,
            'user_group_menu' => $group['user_group_menu']
        ]);

        //复制权限节点
        $this->db()->query("
            INSERT INTO {$this->prefix}node_group (user_group_id, node_id)
            SELECT :newGroupID, node_id FROM {$this->prefix}node_group
            WHERE user_group_id = :user_group_id;
        ", [
            'newGroupID' => $newGroupID,
            'user_group_id' => $group['user_group_id'],
        ]);

        $this->db()->commit();

        if (!empty($_POST['back_url'])) {
            $url = base64_decode($_POST['back_url']);
        } else {
            $url = $this->url(GROUP . '-' . MODULE . '-index');
        }

        $this->success('复制用户组成功', $url);


    }


}