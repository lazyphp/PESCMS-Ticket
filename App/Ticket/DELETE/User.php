<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */
namespace App\Ticket\DELETE;

class User extends Content {

    public function delete() {
        if($_GET['id'] == 1){
            $this->error('天呐，您竟然想删除超级管理员账户！');
        }
        parent::delete();
    }

}