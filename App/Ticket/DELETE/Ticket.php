<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

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
    public function action() {
        $this->checkToken();
        $id = $this->isG('id', '请提交您要删除的工单ID');

        $ticket = \Model\Content::findContent('ticket', $id, 'ticket_id');
        if (empty($ticket)) {
            $this->error('删除的工单不存在');
        }

        $this->db()->transaction();

        $this->db('ticket')->where('ticket_id = :ticket_id')->delete([
            'ticket_id' => $id,
        ]);

        $this->db('ticket_content')->where('ticket_id = :ticket_id')->delete([
            'ticket_id' => $id,
        ]);

        $this->db('ticket_chat')->where('ticket_id = :ticket_id')->delete([
            'ticket_id' => $id,
        ]);

        $this->db('csnotice')->where('ticket_number = :ticket_number')->delete([
            'ticket_number' => $ticket['ticket_number'],
        ]);

        $this->db()->commit();

        $this->success('该工单已删除');

    }

    /**
     * 删除工单回复的内容
     * @return void
     */
    public function chat() {
        $id = $this->isG('id', '请提交您要删除的回复内容');

        $param = [
            'ticket_chat_id' => $id,
            'user_id'        => $this->session()->get('ticket')['user_id'],
        ];

        $check = $this->db('ticket_chat')->where('ticket_chat_id = :ticket_chat_id AND user_id = :user_id')->find($param);

        if (empty($check)) {
            $this->error('您要删除的回复内容不存在.');
        } else {
            $this->db('ticket_chat')->where('ticket_chat_id = :ticket_chat_id AND user_id = :user_id')->update([
                'noset'              => $param,
                'ticket_chat_delete' => 1,
            ]);
            $this->success('删除指定回复内容成功!');
        }
    }

    public function tips() {
        $id = $this->isG('id', '请提交工单ID');
        $tid = $this->isG('tid', '请提交要添加提醒的留言ID');

        $param = [
            'tips_id'      => $tid,
            'ticket_id'    => $id,
            'tips_user_id' => $this->session()->get('ticket')['user_id'],
        ];


        $check = \Model\Content::getContentWithConditions('ticket_chat_tips', $param);

        if (empty($check)) {
            $this->error('提醒内容不存在，请检查后再试');
        }

        $this->db('ticket_chat_tips')->where('tips_id = :tips_id')->delete([
            'tips_id' => $tid,
        ]);

        $this->success('提醒内容已删除。');


    }

}