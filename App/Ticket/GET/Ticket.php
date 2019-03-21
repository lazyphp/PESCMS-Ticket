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

namespace App\Ticket\GET;

/**
 * 工单
 * Class Ticket
 * @package App\Ticket\GET
 */
class Ticket extends \Core\Controller\Controller {

    public $condition = 'WHERE 1 = 1', $param = [], $category = [];

    /**
     * 工单列表(默认按管辖组)
     */
    public function index() {

        //搜索
        if (!empty($_GET['keyword'])) {
            $this->param['ticket_number'] = $this->param['ticket_title'] = '%' . urldecode($this->g('keyword')) . '%';
            $this->condition .= ' AND (t.ticket_title LIKE :ticket_title OR t.ticket_number LIKE :ticket_number )';
        }

        //状态筛选
        foreach (['model_id', 'status', 'close', 'read'] as $key => $value) {
            if ((!empty($_GET[$value]) || is_numeric($_GET[$value])) && $_GET[$value] != '-1') {
                $this->param["ticket_{$value}"] = (int)$_GET[$value];
                $this->condition .= " AND t.ticket_{$value} = :ticket_{$value}";
            }
        }

        if(!empty($_GET['member']) && $_GET['member'] != '-1' ){
            $this->condition .= ' AND member_id = :member_id ';
            $this->param['member_id'] = $this->g('member');
        }

        //方法index的工单列表，默认是筛选管辖组的
        if(ACTION == 'index'){
            $this->condition .= ' AND tm.ticket_model_group_id LIKE :group_id';
            $this->param['group_id'] = "%,{$this->session()->get('ticket')['user_group_id']},%";
        }

        $sql = "SELECT %s
                FROM {$this->prefix}ticket AS t
                LEFT JOIN {$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id
                {$this->condition}
                ORDER BY t.ticket_close ASC, t.ticket_status ASC, t.ticket_id DESC ";

        $result = \Model\Content::quickListContent([
            'count' => sprintf($sql, 'count(*)'),
            'normal' => sprintf($sql, 't.*, tm.ticket_model_name, tm.ticket_model_cid'),
            'param' => $this->param
        ]);

        $this->assign('ticketModel', \Model\Content::listContent(['table' => 'ticket_model']));
        $this->assign('list', $result['list']);
        $this->assign('page', $result['page']);

        $this->category = \Model\Category::getAllCategoryCidPrimaryKey();
        $this->assign('category', $this->category);

        $this->assign('member', \Model\Member::getMemberWithID());

        $this->layout('Ticket_index');
    }

    /**
     * 所有工单
     */
    public function all(){
        $this->index();
    }

    /**
     * 我的工单
     */
    public function myTicket(){
        $this->param['user_id'] = $this->session()->get('ticket')['user_id'];
        $this->condition .= ' AND t.user_id = :user_id';
        $this->index();
    }

    /**
     * 依据用户组ID查询最新工单
     */
    public function getNewTicketWithGroupID(){
        $groupID = '%,'.$this->session()->get('ticket')['user_group_id'].',%';

        $time = time() - 3600;
        $list = $this->db('ticket AS t')
                ->field('ticket_id')
                ->join("{$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id")
                ->where('t.ticket_status = 0 AND t.user_id = 0 AND t.ticket_close = 0 AND t.ticket_submit_time > :time AND tm.ticket_model_group_id LIKE :groupID  ')
                ->select([
                    'time' => $time,
                    'groupID' => $groupID
                ]);
        $this->success(['msg' => '获取成功', data=> $list]);
    }

    /**
     * 处理工单
     */
    public function handle() {
        $content = \Model\Ticket::view();

        $userID = $this->session()->get('ticket')['user_id'];

        /**
         * ticket_read为0则标记为已读
         */
        if ($content['ticket']['ticket_read'] == '0') {
            \Model\Ticket::inTicketIdWithUpdate(['ticket_read' => '1', 'noset' => ['ticket_id' => $content['ticket']['ticket_id']]]);
        }
        $this->assign($content['ticket']);
        $this->assign('user', \Model\Content::listContent([
            'table' => 'user',
            'condition' => 'user_id != :user_id AND user_status = 1',
            'order' => 'user_group_id ASC',
            'param' => [
                'user_id' => $userID
            ]
        ]));

        //查询工单是否有新回复。
        if(!empty($_GET['replyRefresh'])){
            echo $content['chat']['pageObj']->totalRow;
            exit;
        }else {

            $this->assign('phrase', \Model\Content::listContent([
                'table' => 'phrase',
                'condition' => 'phrase_user_id = :user_id',
                'order' => 'phrase_listsort ASC, phrase_id DESC',
                'param' => [
                    'user_id' => $userID
                ]
            ]));

            $this->assign('form', $content['form']);
            $this->assign('chat', $content['chat']['list']);
            $this->assign('page', $content['chat']['page']);
            $this->assign('pageObj', $content['chat']['pageObj']);
            $this->layout();
        }

    }


}