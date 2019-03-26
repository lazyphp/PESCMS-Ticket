<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */
namespace App\Form\PUT;

class Ticket extends \Core\Controller\Controller{

    /**
     * 更改工单状态 | 当前仅限完成
     */
    public function status(){
        $number = $this->isG('number', '请提交您要修改的工单');

        $ticket = \Model\Ticket::getTicketBaseInfo($number);

        if(empty($ticket) || $ticket['ticket_status']  == 3 || $ticket['ticket_close'] == 1 ){
            $this->error('当前工单不存在或已完成.');
        }

        if(!empty($_GET['back_url'])){
            $back_url = base64_decode($this->g('back_url'));
        }else{
            $back_url = $this->url('View-ticket', ['number' => $ticket['ticket_number']]);
        }
        \Model\Ticket::loginCheck($ticket, base64_encode($back_url));

        //标记完成
        \Model\Ticket::inTicketIdWithUpdate([
            'ticket_status' => 3,
            'ticket_complete_time' => time(),
            'noset' => ['ticket_id' => $ticket['ticket_id']]
        ]);
        //记录执行时间
        \Model\Ticket::runTime($ticket['ticket_id'], $ticket['ticket_refer_time'], $ticket['ticket_run_time']);

        $this->success('工单已结束,请对本次工单评价.', $back_url);

    }

}