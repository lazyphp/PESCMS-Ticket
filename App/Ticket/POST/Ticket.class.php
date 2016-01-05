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

namespace App\Ticket\POST;

/**
 * 工单
 * Class Ticket
 * @package App\Ticket\GET
 */
class Ticket extends \App\Ticket\Common {

    /**
     * 回复工单
     */
    public function reply() {
        $number = $this->isP('number', '请选择您要查看的工单');
        $ticket = \Model\Content::findContent('ticket', $number, 'ticket_number');
        if (empty($ticket)) {
            $this->error('该工单不存在');
        }

        $viewTicketLinke = \Model\MailTemplate::getViewLink($ticket['ticket_number']);

        switch ($ticket['ticket_status']) {
            case '0':
                $status = '1';
                $content = '已收到您的工单，我们将会尽快安排人手进行处理';
                \Model\Ticket::setUser($ticket['ticket_id'], $_SESSION['ticket']['user_id'], $_SESSION['ticket']['user_name']);

                $sendTitle = \Model\MailTemplate::matchTitle($ticket['ticket_number'], '2');
                $sendContent = \Model\MailTemplate::matchContent([
                    'view' => $viewTicketLinke,
                ], '2');

                $referTime = $ticket['ticket_submit_time'];
                break;
            case '1':
            case '2':
                $status = '2';
                $referTime = $ticket['ticket_refer_time'];

                if ($_POST['assign'] == '2') {
                    $content = $this->isP('content', '请提交回复内容');
                    $sendTitle = \Model\MailTemplate::matchTitle($ticket['ticket_number'], '3');
                    $sendContent = \Model\MailTemplate::matchContent([
                        'number' => $ticket['ticket_number'],
                        'content' => $content,
                        'view' => $viewTicketLinke,
                    ], '3');

                } elseif ($_POST['assign'] == '3') {
                    $userID = $this->isP('uid', '请选择您要指派的用户');
                    $checkUser = \Model\Content::findContent('user', $userID, 'user_id');
                    if (empty($checkUser)) {
                        $this->error('转派的用户不存在');
                    }
                    \Model\Ticket::setUser($ticket['ticket_id'], $checkUser['user_id'], $checkUser['user_name']);


                    $sendTitle = \Model\MailTemplate::matchTitle($ticket['ticket_number'], '4');
                    $sendContent = \Model\MailTemplate::matchContent([
                        'number' => $ticket['ticket_number'],
                        'view' => $viewTicketLinke,
                    ], '4');
                    $content = '当前问题需要移交给其他客服人员，请耐心等待';

                } elseif ($_POST['assign'] == '4') {
                    $status = '3';
                    $content = "客服已经将本工单结束，如有疑问请重新发起工单咨询，谢谢!";

                    $sendTitle = \Model\MailTemplate::matchTitle($ticket['ticket_number'], '5');
                    $sendContent = \Model\MailTemplate::matchContent([
                        'number' => $ticket['ticket_number'],
                        'view' => $viewTicketLinke,
                    ], '5');

                    \Model\Ticket::inTicketIdWithUpdate([
                        'ticket_complete_time' => time(),
                        'noset' => ['ticket_id' => $ticket['ticket_id']]
                    ]);

                } else {
                    $this->error('未知的工单选择状态，请重新选择');
                }

                break;
            case '4':
                $this->error('本工单已处理结束！');
            default:
                $this->error('获取工单状态失败');
        }
        \Model\Ticket::updateReferTime($ticket['ticket_id']);
        \Model\Ticket::runTime($ticket['ticket_id'], $referTime, $ticket['ticket_run_time']);
        \Model\Ticket::changeStatus($ticket['ticket_id'], $status);
        \Model\Ticket::addReply($ticket['ticket_id'], $content);

        \Model\Extra::insertSend(
            $ticket['ticket_contact_account'],
            $sendTitle,
            $sendContent,
            $ticket['ticket_contact']
        );

        if (empty($_POST['back_url'])) {
            $back_url = base64_encode($this->url('Ticket-Ticket-index'));
        } else {
            $back_url = $_POST['back_url'];
        }

        $this->success('工单处理成功!', $this->url('Ticket-Ticket-handle', ['number' => $ticket['ticket_number'], 'back_url' => $back_url]));

    }

    /**
     * 关闭工单
     */
    public function close() {
        $number = $this->isG('number', '请选择您要查看的工单');
        $ticket = \Model\Content::findContent('ticket', $number, 'ticket_number');
        if (empty($ticket)) {
            $this->error('该工单不存在');
        }

        \Model\Ticket::addReply($ticket['ticket_id'], '工单已关闭，若还有疑问，请重新发表工单咨询!');
        \Model\Ticket::inTicketIdWithUpdate(['ticket_close' => '1', 'noset' => ['ticket_id' => $ticket['ticket_id']]]);

        \Model\Extra::insertSend(
            $ticket['ticket_contact_account'],
            \Model\MailTemplate::matchTitle($number, '6'),
            \Model\MailTemplate::matchContent([
                'number' => $number,
                'view' => \Model\MailTemplate::getViewLink($number)
            ], '6'),
            $ticket['ticket_contact']
        );

        if (empty($_POST['back_url'])) {
            $url = $this->url('Ticket-Ticket-index');
        } else {
            $url = $_POST['back_url'];
        }

        $this->success('工单已被关闭!', $url);
    }


}