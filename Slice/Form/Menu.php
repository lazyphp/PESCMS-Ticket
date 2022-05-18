<?php
/**
 * Copyright (c) 2022 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Slice\Form;

/**
 * 前端菜单输出
 */
class Menu extends \Core\Slice\Slice{

    public function before() {
        $list = $this->db('form_menu')->where('form_menu_status = 1')->order('form_menu_listsort ASC, form_menu_id DESC ')->select();
        $this->assign('menu', $list);

    }

    public function after() {
    }


}