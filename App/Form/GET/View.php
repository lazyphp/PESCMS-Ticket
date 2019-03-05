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
        $content = \Model\Ticket::view();
        if($content == false){
            $this->_404();
        }

        //判断工单模型是否设置登录验证.
        if($content['ticket']['ticket_model_login'] == 1 && empty(self::session()->get('member'))){
            self::jump(self::url('Login-index', ['back_url' => base64_encode($_SERVER['REQUEST_URI'])]));
        }

        //非匿名工单判断用户所属，非此用户所属则返回false
        if($content['ticket']['member_id'] != '-1' && $content['ticket']['member_id'] != self::session()->get('member')['member_id'] ){
            $this->_404();
        }

        //查询工单是否有新回复。
        if(!empty($_GET['replyRefresh'])){
            echo $content['chat']['pageObj']->totalRow;
            exit;
        }else{
            $this->assign($content['ticket']);
            $this->assign('form', $content['form']);
            $this->assign('chat', $content['chat']['list']);
            $this->assign('page', $content['chat']['page']);
            $this->assign('pageObj', $content['chat']['pageObj']);
            $this->layout();
        }
    }

}