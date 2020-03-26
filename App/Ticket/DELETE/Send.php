<?php
namespace App\Ticket\DELETE;

class Send extends Content {

    /**
     * 清空发送列表
     */
    public function truncate(){
        $this->db()->query("TRUNCATE {$this->prefix}send");
        $this->success('发送列表已清空');
    }

}