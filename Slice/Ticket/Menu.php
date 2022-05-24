<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace Slice\Ticket;

/**
 * 后台全局菜单输出
 * Class Login
 * @package Slice\Ticket
 */
class Menu extends \Core\Slice\Slice{

    public function before() {
        $this->assign('menu', \Model\Menu::menu($this->session()->get('ticket')['user_group_id']));
    }

    public function after() {
    }


}