<?php

namespace App\Ticket\DELETE;

/**
 * 工单
 * Class Ticket
 * @package App\Ticket\GET
 */
class Ticket extends \Core\Controller\Controller {

    /**
     * 删除工单
     * 由于Mysql的版本特性，单纯删除ticket表，当Mysql重启后，ticket表(Innodb引擎)的自增ID可能会被重置为(MAX ID)+1。这时候冗余的关联表，会因为此现象，加载了重复的信息。所以在这里，我们需要连同冗余表一起删除。
     * 当然了，Mysql8 已经可以解决此问题。但用户普遍使用5.X版本。
     */
    public function action(){
        $id = $this->isG('id', '请提交您要删除的工单ID');

        $this->db()->transaction();

        $this->db('ticket')->where('ticket_id = :ticket_id')->delete([
            'ticket_id' => $id
        ]);

        $this->db('ticket_content')->where('ticket_id = :ticket_id')->delete([
            'ticket_id' => $id
        ]);

        $this->db('ticket_chat')->where('ticket_id = :ticket_id')->delete([
            'ticket_id' => $id
        ]);

        $this->db()->commit();

        $this->success('该工单已删除');

    }

}