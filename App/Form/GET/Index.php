<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Form\GET;

use Model\Content;

class Index extends \Core\Controller\Controller {

    private $rowlock = '';

    public function index() {
        if(!empty($_GET)){
            $this->jump('/');
        }
        $system = \Core\Func\CoreFunc::$param['system'];
        if ($system['openindex'] == '0') {
            $this->_404();
        }
        $template = $system['indexStyle'] == 0 ? '' : 'Index_ticket';

        $this->assign('indexSetting', \Model\Theme::getThemeIndexSetting());

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
        $system = \Core\Func\CoreFunc::$param['system'];
        $this->db()->transaction();
        if (in_array($system['notice_way'], ['1', '3'])) {
            \Model\Extra::actionNoticeSend();
        }

        $this->db()->commit();
    }

    /**
     * 工单系统行为事件
     */
    public function behavior(){
        $system = \Core\Func\CoreFunc::$param['system'];
        $this->rowlock = $system['rowlock'] == 1 ? 'FOR UPDATE' : '';
        $openDisturb = false;
        $disturb = json_decode($system['disturb'], true);
        if(is_numeric($disturb['begin']) && is_numeric($disturb['end'])){
            $openDisturb = \Model\Extra::notDisturb($disturb['begin'], $disturb['end']);
        }

        $this->db()->transaction();

        try {

            $list = \Model\Content::listContent(['table' => 'ticket_notice_action', 'lock' => $this->rowlock,]);
            if (!empty($list)) {
                foreach ($list as $item) {
                    //大于0的，则为发送给客户的，反之是给客服
                    if ($item['template_type'] > 0) {
                        \Model\Notice::insertMemberNoticeSendTemplate($item);
                    } else {
                        if($openDisturb == true){
                            continue;
                        }
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
            'condition' => 't.ticket_status = 0 AND t.ticket_close = 0 AND ticket_time_out_sequence < ticket_model_time_out_sequence  ',
            'lock' => $this->rowlock
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
            'field' => 't.ticket_id, t.ticket_status, t.ticket_number, t.member_id, t.ticket_submit_time, t.ticket_refer_time, t.ticket_contact_account, t.ticket_contact, tm.ticket_model_close_time, tm.ticket_model_close_type',
            'join' => "{$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id",
            'condition' => 't.ticket_status IN (0, 1, 2) AND t.ticket_close = 0 AND tm.ticket_model_open_close = 1',
            'lock' => $this->rowlock,
        ]);

        foreach ($list as $item){
            $closeType = explode(',', $item['ticket_model_close_type']);
            if(!in_array($item['ticket_status'], $closeType)){
                continue;
            }

            switch ($item['ticket_status']){
                case '0':
                    if($item['ticket_submit_time'] < time() - $item['ticket_model_close_time'] * 60 ){
                        $close = true;
                    }
                    break;
                case '1':
                case '2':
                    if($item['ticket_refer_time'] < time() - $item['ticket_model_close_time'] * 60 ){
                        $close = true;
                    }
                    break;
                default:
                    $close = false;
                    break;
            }

            if($close === true){
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