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
namespace App\Ticket\PUT;

class User_group extends Content {

    /**
     * 设置菜单
     */
    public function setMenu() {
        $id = $this->isP('id', '请提交用户组');
        $node = implode(',', $this->p('node'));
        $update = $this->db('user_group')->where('user_group_id = :id')->update([
            'user_group_menu' => $node,
            'noset' => ['id' => $id]
        ]);
        if($update == '0'){
            $this->error('更新失败，可能没有更新数据或者程序更新失败');
        }
        $this->success('更新成功!', $this->url(GROUP.'-'.MODULE.'-index'));
    }

    /**
     * 设置权限
     */
    public function setAuth() {
        $id = $this->isP('id', '请提交用户组');
        $node = $this->p('node');
        $this->db('node_group')->where('user_group_id = :id')->delete(['id' => $id]);
        foreach($node as $value){
            $this->db('node_group')->insert([
                'user_group_id' => $id,
                'node_id' => $value
            ]);
        }
        $this->success('更新成功!', $this->url(GROUP.'-'.MODULE.'-index'));
    }
}