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
            $this->_404(true);
        }

        \Model\Ticket::loginCheck($content['ticket']);

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