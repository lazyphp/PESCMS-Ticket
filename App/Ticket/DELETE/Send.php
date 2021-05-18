<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */
namespace App\Ticket\DELETE;

class Send extends Content {

    /**
     * 清空发送列表
     */
    public function truncate(){
        $this->checkToken();
        $this->db()->query("TRUNCATE {$this->prefix}send");
        $this->success('发送列表已清空');
    }

}