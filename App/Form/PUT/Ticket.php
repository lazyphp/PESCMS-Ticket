<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */
namespace App\Form\PUT;

class Ticket extends \Core\Controller\Controller{

    /**
     * 更改工单状态 | 当前仅限完成
     */
    public function status(){
        $number = $this->isG('number', '请提交您要修改的工单');

        $ticket = \Model\Ticket::getTicketBaseInfo($number);


        if(empty($ticket) ||  $ticket['ticket_close'] == 1 ){
            $this->error('当前工单不存在或已完成.');
        }

        if(!empty($_GET['back_url'])){
            $back_url = base64_decode($this->g('back_url'));
        }else{
            $back_url = $this->url('View-ticket', ['number' => $ticket['ticket_number']]);
        }
        \Model\Ticket::loginCheck($ticket, base64_encode($back_url));


        if($ticket['ticket_status']  == 3 ){

            if(time() - 86400 * $ticket['ticket_model_recovery_day'] > $ticket['ticket_complete_time']){
                $this->error("无法恢复工单：要恢复工单的完成时间已超过{$ticket['ticket_model_recovery_day']}天有效期，请重新提交工单。");
            }

            $status = 1;
            $msg = '由于工单反馈问题还需要继续完善，我申请了恢复本工单。';
            $ticket_complete_time = 0;
        }else{
            $status = 3;
            $msg = '本工单我已点击标记完成，且认可问题解决方案。';
            $ticket_complete_time = time();
            //记录执行时间
            \Model\Ticket::runTime($ticket['ticket_id'], $ticket['ticket_refer_time'], $ticket['ticket_run_time']);
        }

        //标记完成时间
        \Model\Ticket::inTicketIdWithUpdate([
            'ticket_complete_time' => $ticket_complete_time,
            'noset' => ['ticket_id' => $ticket['ticket_id']]
        ]);

        //更改工单状态
        \Model\Ticket::changeStatus($ticket, $status);

        //添加由用户主动操作更改工单状态的内容
        \Model\Ticket::addReply($ticket['ticket_id'], $msg, 'custom');


        $this->success($status == 3 ? '工单已结束,请对本次工单评价.' : '工单已恢复,可继续后续事项操作。', $back_url);

    }

}