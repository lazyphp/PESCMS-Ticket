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
        if(empty($_SESSION['ticket']['user_id'])){
            $this->jump($this->url('Ticket-Login-index'));
        }
    }

    public function after() {
    }


}