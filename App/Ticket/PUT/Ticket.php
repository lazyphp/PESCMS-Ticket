<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Ticket\PUT;

/**
 * 工单控制器
 */
class Ticket extends \Core\Controller\Controller {

    /**
     * 变更工单模型
     */
    public function changeTicketModel() {
        $id = $this->isP('id', '请提交要变更的工单模型ID');
        $number = $this->isP('number', '请提交要变更的工单ID');

        $result = \Model\Content::findContent(['ticket_model', true], $id, 'ticket_model_id', 'ticket_model_id')->emptyTips('变更的工单模型不存在，请重新提交');

        $this->db('ticket')->where('ticket_number = :ticket_number')->update([
            'noset' => [
                'ticket_number' => $number
            ],
            'ticket_model_id' => $id
        ]);

        $this->success('工单类型变更完成');
    }

    /**
     * 置顶个人工单
     */
    public function setTop() {
        $ticket = $this->checkTicket();
        if($ticket['user_id'] != $this->session()->get('ticket')['user_id']){
            $this->error('您不能置顶别人的工单');
        }
        $this->db('ticket')->where('ticket_id = :ticket_id')->update([
            'noset' => [
                'ticket_id' => $ticket['ticket_id'],
            ],
            'ticket_top' => $ticket['ticket_top'] == 1 ? 0 : 1
        ]);

        $this->success('个人工单置顶设置完成', '', -1);

    }

    /**
     * 置顶列表工单
     */
    public function setListTop(){
        $ticket = $this->checkTicket();
        $this->db('ticket')->where('ticket_id = :ticket_id')->update([
            'noset' => [
                'ticket_id' => $ticket['ticket_id'],
            ],
            'ticket_top_list' => $ticket['ticket_top_list'] == 1 ? 0 : 1
        ]);
        $this->success('置顶工单完成', '', -1);
    }

    /**
     * 检查工单是否存在
     * @return mixed
     */
    private function checkTicket(){
        $number = $this->isG('number', '请提交变更置顶的工单');
        return  \Model\Content::findContent(['ticket', true], $number, 'ticket_number')->emptyTips('工单不存在，请检查提交的工单是否正确.');
    }

}