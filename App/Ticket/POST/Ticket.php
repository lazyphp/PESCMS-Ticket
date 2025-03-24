<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
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
        $this->checkToken();
        $number = $this->isP('number', '请选择您要查看的工单');
        $ticket = \Model\Content::findContent('ticket', $number, 'ticket_number');
        if (empty($ticket)) {
            $this->error('该工单不存在');
        }

        $csText = \Model\Option::csText();
        
        list($status, $templateType, $content, $referTime) = $this->handleTicketStatusChange($ticket, $csText);
        
        \Model\Ticket::updateReferTime($ticket['ticket_id']);
        \Model\Ticket::runTime($ticket['ticket_id'], $referTime, $ticket['ticket_run_time']);
        \Model\Ticket::changeStatus($ticket, $status);
        if(!empty($content)){
            \Model\Ticket::addReply($ticket['ticket_id'], $content);
        }

        $this->handleTicketNotifications($ticket, $templateType);

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
     * 处理工单状态变更
     * @param array $ticket 工单信息
     * @param array $csText 客服文本
     * @return array [状态码, 通知模板类型, 回复内容, 参考时间]
     */
    private function handleTicketStatusChange($ticket, $csText) {
        $status = '';
        $templateType = 0;
        $content = '';
        $referTime = 0;
        
        if ($_POST['assign'] == 5 && $ticket['ticket_status'] == 3) {
            $this->validateAuth('TicketPUTTicketcomplete');
            $status = '1';
            $templateType = 2;
            $content = $csText['recovery']['content'] ?? '因业务需要，客服已将本工单状态重置。';

            \Model\Ticket::inTicketIdWithUpdate([
                'ticket_complete_time' => 0,
                'noset'                => ['ticket_id' => $ticket['ticket_id']],
            ]);
            return [$status, $templateType, $content, $referTime];
        }
        
        switch ($ticket['ticket_status']) {
            case '0':
                $status = '1';
                $templateType = 2;
                if(!empty($_POST['exchange'])){
                    $content = $csText['accept']['content'];
                }
                \Model\Ticket::setUser($ticket['ticket_id'], $this->session()->get('ticket')['user_id'], $this->session()->get('ticket')['user_name']);
                $referTime = $ticket['ticket_submit_time'];
                break;
            case '1':
            case '2':
                return $this->handleActiveTicket($ticket, $csText);
            case '4':
                $this->error('本工单已处理结束！');
            default:
                $this->error('获取工单状态失败');
        }
        
        return [$status, $templateType, $content, $referTime];
    }

    /**
     * 处理活动状态的工单
     * @param array $ticket 工单信息
     * @param array $csText 客服文本
     * @return array [状态码, 通知模板类型, 回复内容, 参考时间]
     */
    private function handleActiveTicket($ticket, $csText) {
        $status = '2';
        $templateType = 0;
        $content = '';
        $referTime = $ticket['ticket_refer_time'];
        
        if ($_POST['assign'] == '2') {
            $content = $this->isP('content', '请提交回复内容');
            $templateType = 3;
        } elseif ($_POST['assign'] == '3') {
            $status = '0';
            $userID = $this->isP('uid', '请选择您要指派的用户');
            $this->assignToUser($ticket, $userID, $csText);
            $templateType = 4;
            if(!empty($_POST['exchange'])){
                $content = $csText['assign']['content'];
            }
        } elseif ($_POST['assign'] == '4') {
            $this->validateAuth('TicketPUTTicketcomplete');
            $status = '3';
            $templateType = 5;
            $content = $csText['complete']['content'];

            \Model\Ticket::inTicketIdWithUpdate([
                'ticket_complete_time' => time(),
                'noset'                => ['ticket_id' => $ticket['ticket_id']],
            ]);
        } else {
            $this->error('未知的工单选择状态，请重新选择');
        }
        
        return [$status, $templateType, $content, $referTime];
    }

    /**
     * 验证权限
     * @param string $permission 权限标识
     */
    private function validateAuth($permission) {
        $auth = \Model\Auth::check($permission);
        if ($auth !== true) {
            $this->error($auth);
        }
    }

    /**
     * 分配工单给用户
     * @param array $ticket 工单信息
     * @param int $userID 用户ID
     * @param array $csText 客服文本
     */
    private function assignToUser($ticket, $userID, $csText) {
        $checkUser = \Model\Content::findContent('user', $userID, 'user_id');
        if (empty($checkUser) || $checkUser['user_status'] == 0) {
            $this->error('转派的用户不存在');
        }
        if ($checkUser['user_vacation'] == 1) {
            $this->error('转派的用户正在休假');
        }
        \Model\Ticket::setUser($ticket['ticket_id'], $checkUser['user_id'], $checkUser['user_name'], $this->session()->get('ticket')['user_id']);
        \Model\Notice::addCSNotice($ticket['ticket_number'], $checkUser, -4);
    }

    /**
     * 处理工单通知
     * @param array $ticket 工单信息
     * @param int $templateType 通知模板类型
     */
    private function handleTicketNotifications($ticket, $templateType) {
        if ($_POST['notice'] != 1 && !in_array($_POST['assign'], ['4', '5'])) {
            return;
        }

        if (empty($_POST['contact_type']) || $ticket['member_id'] == '-1') {
            \Model\Notice::addTicketNoticeAction($ticket['ticket_number'], $ticket['ticket_contact_account'], $ticket['ticket_contact'], $templateType);
        } else {
            $this->manyTicketNotice($ticket, $templateType);
        }
    }

    /**
     * 多个留言方式触发
     * @param $ticket
     * @param $templateType
     */
    private function manyTicketNotice($ticket, $templateType) {
        $member = \Model\Member::getMemberWithID($ticket['member_id']);
        foreach ($_POST['contact_type'] as $contact) {
            switch ($contact) {
                case '1':
                    $account = $member['member_email'];
                    break;
                case '2':
                    $account = $member['member_phone'];
                    break;
                case '3':
                    $account = $member['member_weixin'];
                    break;
                case '6':
                    $account = $member['member_wxapp'];
                    break;
            }
            if (empty($account)) {
                continue;
            }
            \Model\Notice::addTicketNoticeAction($ticket['ticket_number'], $account, (int)$contact, $templateType);
        }
    }

    /**
     * 关闭工单
     */
    public function close() {
        $this->checkToken();
        $number = $this->isG('number', '请选择您要查看的工单');
        $reason = $this->isP('reason', '请填写关闭工单的理由');

        $ticket = \Model\Content::findContent('ticket', $number, 'ticket_number');

        if (empty($ticket)) {
            $this->error('该工单不存在');
        }

        \Model\Ticket::addReply($ticket['ticket_id'], \Model\Option::csText()['close']['content']);

        \Model\Ticket::inTicketIdWithUpdate([
            'noset'               => [
                'ticket_id' => $ticket['ticket_id'],
            ],
            'ticket_read'         => '1',
            'ticket_close'        => '1',
            'ticket_close_time'   => time(),
            'ticket_close_reason' => $reason,
        ]);

        \Model\Ticket::recordStatusLine($ticket, '-1');

        \Model\Notice::addTicketNoticeAction($number, $ticket['ticket_contact_account'], $ticket['ticket_contact'], 6);


        if (empty($_GET['back_url'])) {
            $url = $this->url('Ticket-Ticket-index');
        } else {
            $url = base64_decode($_GET['back_url']);
        }

        $this->success('工单已被关闭!', $url);
    }

    /**
     * 登记工单备注
     */
    public function remark() {
        $number = $this->isP('number', '请提交要记录备注的工单号码');
        $remark = $this->isP('remark', '请提交您要记录的备注信息');
        $this->db('ticket')->where('ticket_number = :ticket_number')->update([
            'noset'         => [
                'ticket_number' => $number,
            ],
            'ticket_remark' => $remark,
        ]);

        $this->success('备注已更新');
    }

    /**
     * 添加留言提醒内容
     * @return void
     */
    public function tips(){
        $id = $this->isP('id', '请提交工单ID');
        $cid = $this->isP('cid', '请提交要添加提醒的留言ID');
        $type = $this->isP('type', '请提交您要添加提醒的类型');
        $content = $this->isP('content', '请提交您要添加的提醒内容');

        $param = [
            'ticket_id' => $id,
            'ticket_chat_id' => $cid,
            'tips_type' => $type,
            'tips_user_id' => $this->session()->get('ticket')['user_id']
        ];

        $check = \Model\Content::getContentWithConditions('ticket_chat_tips', $param);

        if(!empty($check)){
            $this->error('您已经添加了提醒，请先删除再重新添加。');
        }

        $param['tips_content'] = $content;
        $param['tips_time'] = time();

        $this->db('ticket_chat_tips')->insert($param);

        $this->success('提醒添加成功！');
    }


}