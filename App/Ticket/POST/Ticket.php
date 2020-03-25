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
class Ticket extends \Core\Controller\Controller {

    /**
     * 回复工单
     */
    public function reply() {
        $number = $this->isP('number', '请选择您要查看的工单');
        $ticket = \Model\Content::findContent('ticket', $number, 'ticket_number');
        if (empty($ticket)) {
            $this->error('该工单不存在');
        }
        
        $csText = \Model\Option::csText();

        switch ($ticket['ticket_status']) {
            case '0':
                $status = '1';
                $templateType = 2;
                $content = $csText['accept']['content'];
                \Model\Ticket::setUser($ticket['ticket_id'], $this->session()->get('ticket')['user_id'], $this->session()->get('ticket')['user_name']);
                $referTime = $ticket['ticket_submit_time'];
                break;
            case '1':
            case '2':
                $status = '2';
                $referTime = $ticket['ticket_refer_time'];

                if ($_POST['assign'] == '2') {
                    $content = $this->isP('content', '请提交回复内容');
                    $templateType = 3;

                } elseif ($_POST['assign'] == '3') {
                    $userID = $this->isP('uid', '请选择您要指派的用户');
                    $checkUser = \Model\Content::findContent('user', $userID, 'user_id');
                    if (empty($checkUser)) {
                        $this->error('转派的用户不存在');
                    }
                    \Model\Ticket::setUser($ticket['ticket_id'], $checkUser['user_id'], $checkUser['user_name']);
                    $templateType = 4;
                    $content = $csText['assign']['content'];
                    \Model\Notice::addCSNotice($ticket['ticket_number'], $checkUser, -$templateType);

                } elseif ($_POST['assign'] == '4') {
                    $status = '3';
                    $templateType = 5;
                    $content = $csText['complete']['content'];

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

        //只有勾选告知客户才生成通知(完成工单不受影响)，尽量减少对客户的滋扰。
        if($_POST['notice'] == 1 || $_POST['assign'] == '4' ){
            \Model\Notice::addTicketNoticeAction($ticket['ticket_number'], $ticket['ticket_contact_account'], $ticket['ticket_contact'], $templateType);
        }


        if (empty($_POST['back_url'])) {
            $back_url = base64_encode($this->url('Ticket-Ticket-index'));
        } else {
            $back_url = $_POST['back_url'];
        }

        $this->success(
            '工单处理成功!',
            $this->url('Ticket-Ticket-handle', ['number' => $ticket['ticket_number'], 'back_url' => $back_url]),
            -1
        );

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

        \Model\Ticket::addReply($ticket['ticket_id'], \Model\Option::csText()['close']['content']);
        \Model\Ticket::inTicketIdWithUpdate(['ticket_close' => '1', 'noset' => ['ticket_id' => $ticket['ticket_id']]]);

        \Model\Notice::addTicketNoticeAction($number, $ticket['ticket_contact_account'], $ticket['ticket_contact'], 6);


        if (empty($_POST['back_url'])) {
            $url = $this->url('Ticket-Ticket-index');
        } else {
            $url = $_POST['back_url'];
        }

        $this->success('工单已被关闭!', $url);
    }

    /**
     * 登记工单备注
     */
    public function remark(){
        $number = $this->isP('number', '请提交要记录备注的工单号码');
        $remark = $this->isP('remark', '请提交您要记录的备注信息');
        $this->db('ticket')->where('ticket_number = :ticket_number')->update([
            'noset' => [
                'ticket_number' => $number
            ],
            'ticket_remark' => $remark
        ]);

        $this->success('备注已更新');
    }


}