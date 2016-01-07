<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */

namespace App\Ticket\GET;

/**
 * 工单
 * Class Ticket
 * @package App\Ticket\GET
 */
class Ticket extends \App\Ticket\Common {

    public $condition = 'WHERE 1 = 1', $param = [];

    /**
     * 工单列表
     */
    public function index() {
        if (!empty($_GET['keyword'])) {
            $this->param['ticket_number'] = $this->param['ticket_title'] = '%' . urldecode($this->g('keyword')) . '%';
            $this->condition .= ' AND (t.ticket_title LIKE :ticket_title OR t.ticket_number LIKE :ticket_number )';
        }

        foreach (['model_id', 'status', 'close', 'read'] as $key => $value) {
            if ((!empty($_GET[$value]) || is_numeric($_GET[$value])) && $_GET[$value] != '-1') {
                $this->param["ticket_{$value}"] = (int)$_GET[$value];
                $this->condition .= " AND t.ticket_{$value} = :ticket_{$value}";
            }
        }

        $sql = "SELECT %s
                FROM {$this->prefix}ticket AS t
                LEFT JOIN {$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id
                {$this->condition}
                ORDER BY t.ticket_close ASC, t.ticket_status ASC, t.ticket_id DESC ";
        $result = \Model\Content::quickListContent(['count' => sprintf($sql, 'count(*)'), 'normal' => sprintf($sql, 't.*, tm.ticket_model_name'), 'param' => $this->param]);

        $this->assign('ticketModel', \Model\Content::listContent(['table' => 'ticket_model']));
        $this->assign('list', $result['list']);
        $this->assign('page', $result['page']);

        $this->layout('Ticket_index');
    }

    public function myTicket(){
        $this->param['user_id'] = $_SESSION['ticket']['user_id'];
        $this->condition .= ' AND t.user_id = :user_id';
        $this->index();
    }

    /**
     * 处理工单
     */
    public function handle() {
        $content = \Model\Ticket::view();

        /**
         * ticket_read为0则标记为已读
         */
        if ($content['ticket']['ticket_read'] == '0') {
            \Model\Ticket::inTicketIdWithUpdate(['ticket_read' => '1', 'noset' => ['ticket_id' => $content['ticket']['ticket_id']]]);
        }
        $this->assign($content['ticket']);
        $this->assign('user', \Model\Content::listContent([
            'table' => 'user',
            'condition' => 'user_id != :user_id AND user_status = 1',
            'order' => 'user_group_id ASC',
            'param' => ['user_id' => $_SESSION['ticket']['user_id']]
        ]));
        $this->assign('form', $content['form']);
        $this->assign('chat', $content['chat']['list']);
        $this->assign('page', $content['chat']['page']);

        $this->layout();

    }


}