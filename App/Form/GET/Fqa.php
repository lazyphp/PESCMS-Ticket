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

    public function __call($name, $arguments) {
        if($name == 'list'){
            $this->_list();
        }else{
            $this->_404();
        }

    }

    /**
     * FQA列表输出
     */
    public function index(){
        $number = $this->isG('number', '请提交工单number');
        $ticket = \Model\TicketModel::numberFind($number);
        $list = \Model\Content::listContent([
            'table' => 'fqa',
            'field' => 'fqa_id, fqa_url, fqa_title',
            'condition' => 'fqa_ticket_model_id = :model_id AND fqa_status = 1',
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

    public function _list(){
        $condtion = 'f.fqa_status = 1';
        $param = [];

        if(!empty($_GET['keyword'])){
            $condtion .= ' AND (f.fqa_title LIKE :fqa_title OR f.fqa_content LIKE :fqa_content)';
            $param['fqa_title'] = $param['fqa_content'] = '%'.$this->g('keyword').'%';
        }

        //登录可看所有FQA
        if(empty($this->session()->get('member')['member_id'])){
            $condtion .= ' AND tm.ticket_model_login = 0 ';
        }


        $result = \Model\Content::listContent([
            'table' => 'fqa AS f',
            'field' => 'fqa_id, fqa_url, fqa_title, fqa_ticket_model_id, tm.ticket_model_name, tm.ticket_model_cid',
            'join' => "{$this->prefix}ticket_model AS tm ON tm.ticket_model_id = f.fqa_ticket_model_id",
            'condition' => $condtion,
            'order' => 'fqa_listsort ASC, fqa_id DESC',
            'param' => $param
        ]);
        if(!empty($result)){
            foreach ($result as $value){
                $list[$value['ticket_model_cid']][$value['fqa_ticket_model_id']]['ticket_model_name'] = $value['ticket_model_name'];
                $list[$value['ticket_model_cid']][$value['fqa_ticket_model_id']]['list'][] = $value;
            }
        }

        $this->assign('title', '常见问题');
        $this->assign('list', $list);
        $this->assign('category', \Model\Category::getAllCategoryCidPrimaryKey());
        $this->layout('Fqa_list');
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