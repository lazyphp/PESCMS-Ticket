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
 * 后台全局菜单输出
 * Class Login
 * @package Slice\Ticket
 */
class Menu extends \Core\Slice\Slice{

    public function before() {
        $this->assign('menu', \Model\Menu::menu($_SESSION['ticket']['user_group_id']));
    }

    public function after() {
    }


}