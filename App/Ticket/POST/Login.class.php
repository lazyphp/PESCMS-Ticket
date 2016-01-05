<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version
 */

namespace App\Ticket\POST;

class Login extends \App\Ticket\Common{

    public function index(){
        $data['user_account'] = $data['user_mail'] = $this->isP('account', '请提交账号信息');
        $data['user_password'] = \Core\Func\CoreFunc::generatePwd($this->isP('passwd', '请提交密码'));
        $login = $this->db('user')->where('(user_account = :user_account OR user_mail = :user_mail ) AND user_password = :user_password AND user_status = 1  ')->find($data);

        if(empty($login)){
            $this->error('帐号或者密码错误，也可能您的账号被禁止登录鸟!');
        }

        $_SESSION['ticket'] = $login;

        $this->success('登录成功!', $this->url('Ticket-Index-index'));
    }

}