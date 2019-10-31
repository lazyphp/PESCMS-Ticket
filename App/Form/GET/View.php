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

class View extends \Core\Controller\Controller{


    /**
     * 查看工单的进度
     */
    public function ticket(){
        $content = $this->getTicketInfo();

        \Model\Ticket::loginCheck($content['ticket']);

        //查询工单是否有新回复。
        if(!empty($_GET['replyRefresh'])){
            echo $content['chat']['pageObj']->totalRow;
            exit;
        }else{
            $this->assign($content['ticket']);
            $this->assign('form', $content['form']);
            $this->assign('member', $content['member']);
            $this->assign('chat', $content['chat']['list']);
            $this->assign('page', $content['chat']['page']);
            $this->assign('pageObj', $content['chat']['pageObj']);
            $this->layout();
        }
    }

    /**
     * 打印发票
     */
    public function printer(){
        $content = $this->getTicketInfo(9999);

        if(empty($this->session()->get('ticket'))){
            \Model\Ticket::loginCheck($content['ticket']);
        }

        $this->assign($content);

        $this->display();

    }

    /**
     * 获取工单的信息
     * @param $page 聊天内容分页输
     * @return array 返回详细信息
     */
    private function getTicketInfo($chatPage = 30){
        $content = \Model\Ticket::view($chatPage);
        if($content == false){
            $this->_404();
        }else{
            return $content;
        }
    }

}