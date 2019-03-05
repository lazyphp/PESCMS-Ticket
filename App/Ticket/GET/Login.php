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

namespace App\Ticket\GET;

class Login extends \Core\Controller\Controller{

    public function index(){
        $this->display();
    }

    /**
     * 企业微信登录入口
     */
    public function agree(){
        $weixinWork = new \Expand\weixinWork();
        $this->assign('login', $weixinWork->agree(\Core\Func\CoreFunc::$param['system']['domain'].$this->url('Ticket-Login-weixinWork')));
        $this->display();
    }

    /**
     * 企业微信执行登录
     * @todo 废弃
     */
    public function weixinWork() {
        if (empty($_GET['code'])) {
            $this->error('获取参数失败');
        }
        $weixinWork = new \Expand\weixinWork();
        $weixinWork->user($_GET['code']);
    }

    public function logout(){
        $this->session()->destroy();
        $this->jump($this->url('Ticket-Login-index'));
    }

}