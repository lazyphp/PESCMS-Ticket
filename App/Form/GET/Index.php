<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */

namespace App\Form\GET;

use Model\Content;

class Index extends \Core\Controller\Controller {

    public function index() {
        $system = \Core\Func\CoreFunc::$param['system'];
        if ($system['openindex'] == '0') {
            $this->_404();
        }
        $template = $system['indexStyle'] == 0 ? '' : 'Index_ticket';

        $this->layout($template);
    }

    /**
     * 验证码
     */
    public function verify() {
        $verify = new \Expand\Verify();
        if(!empty($_GET['height'])){
            $verify->height = intval($this->g('height'));
        }
        $verifyLength = \Core\Func\CoreFunc::$param['system']['verifyLength'];
        $verify->createVerify(empty($verifyLength) ? '4' : $verifyLength);
    }

    /**
     * 发送通知
     */
    public function notice() {
        $this->db()->transaction();

        $system = \Core\Func\CoreFunc::$param['system'];
        if (in_array($system['notice_way'], ['1', '3'])) {
            \Model\Extra::actionNoticeSend();
        }

        $this->db()->commit();
    }

    /**
     * 工单系统行为事件
     */
    public function behavior(){
        $this->db()->transaction();

        try {

            $list = \Model\Content::listContent(['table' => 'ticket_notice_action', 'lock' => 'FOR UPDATE',]);
            if (!empty($list)) {
                foreach ($list as $item) {
                    //大于0的，则为发送给客户的，反之是给客服
                    if ($item['template_type'] > 0) {
                        \Model\Notice::insertMemberNoticeSendTemplate($item);
                    } else {
                        \Model\Notice::insertCSNoticeSendTemplate($item);
                    }
                }
            }

            $this->ticketTimeOut();

            $this->autoClose();

        } catch (Exception $e) {
            echo "当前程序执行出错\n";
            $this->db()->rollback();
        }

        $this->db()->commit();
    }

    /**
     * 工单超时提醒
     * @return bool
     */
    private function ticketTimeOut(){
        $list = \Model\Content::listContent([
            'table' => 'ticket AS t',
            'field' => 't.ticket_id, t.ticket_number, t.ticket_status, t.ticket_submit_time, t.user_id, t.ticket_time_out_sequence, t.ticket_exclusive, tm.ticket_model_group_id, tm.ticket_model_time_out, tm.ticket_model_time_out_sequence',
            'join' => "{$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id",
            'condition' => 't.ticket_status = 0 AND ticket_time_out_sequence < ticket_model_time_out_sequence  ',
            'lock' => 'FOR UPDATE'
        ]);

        if(empty($list)){
            return true;
        }
        foreach ($list as $item){
            //已通知的次数大于设定的次数则不再通知
            if($item['ticket_time_out_sequence'] >= $item['ticket_model_time_out_sequence'] || empty($item['ticket_model_group_id']) ){
                continue;
            }

            $timeOutTime = $item['ticket_submit_time'] + (1 + $item['ticket_time_out_sequence']) * $item['ticket_model_time_out'] * 60 ;
            if($timeOutTime > time()){
                continue;
            }


            if($item['ticket_exclusive'] == 1 && !empty($item['user_id'])){

                $user = \Model\Content::findContent('user', $item['user_id'], 'user_id');
                \Model\Notice::addCSNotice($item['ticket_number'], $user, -504);
            }else{
                //移除手尾,
                $item['ticket_model_group_id'] = trim($item['ticket_model_group_id'], ',');

                $userList = self::db('user')->where("user_group_id IN ({$item['ticket_model_group_id']})")->select();
                if(!empty($userList)){
                    foreach ($userList as $user){
                        \Model\Notice::addCSNotice($item['ticket_number'], $user, -504);
                    }
                }
            }

            $this->db('ticket')->where('ticket_id = :ticket_id')->update([
                'noset' => [
                    'ticket_id' => $item['ticket_id']
                ],
                'ticket_time_out_sequence' => $item['ticket_time_out_sequence'] + 1
            ]);

        }

    }

    /**
     * 自动关闭工单
     */
    private function autoClose(){
        $list = \Model\Content::listContent([
            'table' => 'ticket AS t',
            'field' => 't.ticket_id, t.ticket_number, t.member_id, t.ticket_submit_time, t.ticket_contact_account, t.ticket_contact, tm.ticket_model_close_time',
            'join' => "{$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id",
            'condition' => 't.ticket_status = 0 AND t.ticket_close = 0 AND tm.ticket_model_open_close = 1',
            'lock' => 'FOR UPDATE',
        ]);

        foreach ($list as $item){
            if($item['ticket_submit_time'] < time() - $item['ticket_model_close_time'] * 60 ){
                \Model\Ticket::addReply($item['ticket_id'], '工单已关闭，若还有疑问，请重新发表工单咨询!');
                \Model\Ticket::inTicketIdWithUpdate(['ticket_close' => '1', 'noset' => ['ticket_id' => $item['ticket_id']]]);
                \Model\Notice::addTicketNoticeAction($item['ticket_number'], $item['ticket_contact_account'], $item['ticket_contact'], 6);

            }
        }
    }

    /**
     * 获取session id
     */
    public function getSession() {
        echo json_encode($this->session()->getId());
        exit;
    }

}