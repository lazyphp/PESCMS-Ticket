<?php
/**
 *
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\API\POST;


class Ticket extends \Core\Controller\Controller {

    /**
     * 提交工单
     */
    public function submit() {
        $result = \Model\API\Ticket::insert();

        if (!empty($result) && is_array($result)) {
            $this->success([
                'msg' => '工单提交成功',
                'data' => $result['ticket_number']
            ]);
        } else {
            $this->error('提交工单出错，请尝试再次提交或者联系客服。');
        }

    }

    /**
     * 回复工单
     */
    public function reply(){
        $check = \Model\API\Member::auth();

        $number = $this->isP('number', '请提交工单单号');
        $content = $this->isP('content', '请提交您要回复的内容');

        $ticket = \Model\Content::findContent('ticket', $number, 'ticket_number');
        if(empty($ticket) || $ticket['member_id'] != $check['member_id'] ){
            $this->error('工单不存在。');
        }

        $this->db('ticket_chat')->insert([
            'ticket_id' => $ticket['ticket_id'],
            'user_id' => '-1',
            'user_name' => 'Customer',
            'ticket_chat_content' => $content,
            'ticket_chat_time' => time()
        ]);

        $this->success('回复工单成功');
    }

}