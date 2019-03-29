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
namespace App\Form\POST;

/**
 * @todo 这个方法命名得不好，实际应该是Ticket。当时考虑到跨域工单，所以用此命名，未来再结合实际情况进行更改吧。
 * Class Submit
 * @package App\Form\POST
 */
class Submit extends \Core\Controller\Controller{

    /**
     * 提交工单
     */
    public function ticket(){
        $result = \Model\Ticket::insert();
        if(!empty($result) && is_array($result)){
            $this->success(
                "工单提交成功,您的受理编号为:{$result['ticket_number']}",
                $this->url('Form-View-ticket', ['number' => $result['ticket_number']]),
                -1);
        }else{
            $this->error('提交工单出错，请尝试再次提交或者联系客服。');
        }
    }

    /**
     * 回复工单
     */
    public function reply(){
        $this->checkToken();

        $number = $this->isP('number', '请选择您要查看的工单');
        $content = $this->isP('content', '请提交回复内容');
        $ticket = \Model\Ticket::getTicketBaseInfo($number);

        if(!empty($_POST['back_url'])){
            $back_url = base64_decode($this->p('back_url'));
        }else{
            $back_url = $this->url('View-ticket', ['number' => $ticket['ticket_number']]);
        }

        \Model\Ticket::loginCheck($ticket, base64_encode($back_url));

        if (empty($ticket) || in_array($ticket['ticket_status'], [3, 4])) {
            $this->error('该工单不存在或者已经关闭');
        }

        if($ticket['ticket_model_verify'] == 1){
            $verify = $this->isP('verify', '请填写验证码');
            if (md5($verify) != $this->session()->get('verify')) {
                $this->error('验证码错误');
            }
        }

        $status = $ticket['ticket_status'] == 0 ? 0 : 1;

        \Model\Ticket::updateReferTime($ticket['ticket_id']);
        \Model\Ticket::inTicketIdWithUpdate([
            'ticket_status' => $status,
            'ticket_read' => '0',
            'noset' => ['ticket_id' => $ticket['ticket_id']]
        ]);
        \Model\Ticket::addReply($ticket['ticket_id'], $content, 'custom');

        if($ticket['user_id'] > 0){
            $user = \Model\Content::findContent('user', $ticket['user_id'], 'user_id');

            $content = "工单《{$ticket['ticket_title']}》有新回复! 单号:{$ticket['ticket_number']},请跟进!";
            \Model\Notice::addCSNotice($number, $user, -3);
        }

        $this->success('回复工单成功!', $back_url);

    }

    /**
     * 工单评价
     */
    public function score(){

        $score = $this->isP('score', '请为本次评价打分');
        $number = $this->isP('number', '请选择您要查看的工单');
        $fix = $this->isP('fix', '请选择问题是否解决');
        $comment = $this->p('comment');
        $ticket = \Model\Ticket::getTicketBaseInfo($number);

        if(empty($ticket) || $ticket['ticket_score_time'] >0 ){
            $this->error('当前工单不存在或已评价.');
        }

        if(!empty($_POST['back_url'])){
            $back_url = base64_decode($this->p('back_url'));
        }else{
            $back_url = $this->url('View-ticket', ['number' => $ticket['ticket_number']]);
        }
        \Model\Ticket::loginCheck($ticket, base64_encode($back_url));

        $this->db()->transaction();

        $this->db('ticket')->where('ticket_id = :ticket_id')->update([
            'noset' => [
                'ticket_id' => $ticket['ticket_id']
            ],
            'ticket_score' => $score,
            'ticket_score_time' => time(),
            'ticket_fix' => $fix,
            'ticket_comment' => $comment
        ]);

        $this->db()->query("UPDATE {$this->prefix}user SET user_score = user_score + :user_score, user_score_frequency = user_score_frequency + 1 WHERE user_id = :user_id", [
            'user_score' => $score,
            'user_id' => $ticket['user_id']
        ]);

        $this->db()->commit();

        $this->success('感谢您的评价!我们将继续为您提供更加优质的服务!', $back_url);

    }

}