<?php
/**
 * Copyright (c) 2023 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Slice\Ticket\HandleForm;

/**
 * 工单留言提示
 * @package Slice\Ticket
 */
class HandleTicketChatTips extends \Core\Slice\Slice {

    public function before() {
        $id = $this->isR('id', '请提交工单ID');
        $checkUser = \Model\Content::getContentWithConditions('ticket', [
            'ticket_id' => $id,
            'user_id' => $this->session()->get('ticket')['user_id']
        ]);
        if(empty($checkUser)){
            $this->error('工单不存在或者该工单不是您所处理的，请检查后再试。');
        }
    }

    public function after() {

    }

}