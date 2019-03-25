<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */

namespace App\Form\GET;

class Fqa extends \Core\Controller\Controller{

    /**
     * FQA列表输出
     */
    public function index(){
        $number = $this->isG('number', '请提交工单number');
        $ticket = \Model\TicketModel::numberFind($number);
        $list = \Model\Content::listContent([
            'table' => 'fqa',
            'field' => 'fqa_id, fqa_url, fqa_title',
            'condition' => 'fqa_ticket_model_id = :model_id',
            'order' => 'fqa_listsort ASC, fqa_id DESC',
            'param' => [
                'model_id' => $ticket['ticket_model_id']
            ]
        ]);
        if(empty($list) || ($ticket['ticket_model_login'] == 1 && empty($this->session()->getId('member')) ) ){
            $this->error('没有FQA');
        }else{
            $this->success(['msg' => '获取FQA成功', 'data' => $list]);
        }


    }

    /**
     * 查看工单详情
     */
    public function view(){
        $id = $this->isG('id', '请提交您要查看的问题');
        $content = \Model\Content::findContent('fqa', $id, 'fqa_id');
        if(empty($content)){
            $this->_404();
        }
        $this->assign($content);

        $ticket = \Model\TicketModel::getTicketModelList($content['fqa_ticket_model_id']);
        $this->assign('ticketModel', $ticket);

        $this->assign('title', $content['fqa_title']);

        $this->layout();
    }

}