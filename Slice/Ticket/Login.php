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


namespace Slice\Ticket;

/**
 * 登录验证切片
 * Class Login
 * @package Slice\Ticket
 */
class Login extends \Core\Slice\Slice{

    public function before() {
        if(empty($this->session()->get('backstage'))){
            $this->jump('/');
        }

        //已登录引导回首页
        if(MODULE == 'Login' && ACTION == 'index' && !empty($this->session()->get('ticket')['user_id']) ){
            $this->jump($this->url('Ticket-Ticket-index'));
        }

        if(MODULE != 'Login' && empty($this->session()->get('ticket')['user_id'])){
            $this->jump($this->url('Ticket-Login-index', ['back_url' => base64_encode($_SERVER['REQUEST_URI'])]));
        }
    }

    public function after() {
    }


}