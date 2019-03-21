<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2016 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


namespace App\Ticket\GET;

class User extends Content {

    /**
     * 个人设置
     */
    public function setting(){
        $info = \Model\Content::findContent('user', $this->session()->get('ticket')['user_id'], 'user_id');
        $this->assign($info);
        $this->assign('title', '个人信息');
        $this->layout();
    }
}