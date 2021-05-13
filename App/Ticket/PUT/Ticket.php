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
    public function changeTicketModel(){
        $id = $this->isP('id', '请提交要变更的工单模型ID');
        $number = $this->isP('number', '请提交要变更的工单ID');

        if(empty(\Model\Content::findContent('ticket_model', $id, 'ticket_model_id', 'ticket_model_id'))){
            $this->error('变更的工单模型不存在，请重新提交');
        }

        $this->db('ticket')->where('ticket_number = :ticket_number')->update([
            'noset' => [
                'ticket_number' => $number
            ],
            'ticket_model_id' => $id
        ]);

        $this->success('工单类型变更完成');
    }

}