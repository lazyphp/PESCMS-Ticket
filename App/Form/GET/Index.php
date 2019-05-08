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

class Index extends \Core\Controller\Controller {

    public function index() {
        $openindex = \Model\Content::findContent('option', 'openindex', 'option_name');
        if ($openindex['value'] == '0') {
            $this->_404(true);
        }
        $this->layout();
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
        $list = \Model\Content::listContent(['table' => 'ticket_notice_action']);
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

        $system = \Core\Func\CoreFunc::$param['system'];
        if (in_array($system['notice_way'], ['1', '3'])) {
            \Model\Extra::actionNoticeSend();
        }

        $this->ticketTimeOut();

    }

    private function ticketTimeOut(){
        $list = \Model\Content::listContent([
            'table' => 'ticket AS t',
            'field' => 't.ticket_id, t.ticket_number, t.ticket_status, t.ticket_submit_time, t.user_id, t.ticket_time_out_sequence, tm.ticket_model_group_id, tm.ticket_model_time_out, tm.ticket_model_time_out_sequence',
            'join' => "{$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id",
            'condition' => 't.ticket_status = 0'
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

            //移除手尾,
            $item['ticket_model_group_id'] = trim($item['ticket_model_group_id'], ',');

            $userList = self::db('user')->where("user_group_id IN ({$item['ticket_model_group_id']})")->select();
            if(!empty($userList)){
                foreach ($userList as $user){
                    \Model\Notice::addCSNotice($item['ticket_number'], $user, -504);
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
     * 获取session id
     */
    public function getSession() {
        echo json_encode($this->session()->getId());
        exit;
    }

}