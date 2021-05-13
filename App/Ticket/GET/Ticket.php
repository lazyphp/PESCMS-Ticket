<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Ticket\GET;

/**
 * 工单
 * Class Ticket
 * @package App\Ticket\GET
 */
class Ticket extends \Core\Controller\Controller {

    public $join = [],  $condition = 'WHERE 1 = 1', $group = '', $param = [], $category = [];

    public function __init() {
        parent::__init();
        $this->category = \Model\Category::getAllCategoryCidPrimaryKey();
        $this->assign('category', $this->category);
    }

    /**
     * 工单列表(默认按管辖组)
     */
    public function index($template = 'Ticket_index') {

        //搜索
        if (!empty($_GET['keyword'])) {
            $this->param['ticket_number'] = $this->param['ticket_title'] = '%' . urldecode($this->g('keyword')) . '%';
            $this->condition .= ' AND (t.ticket_title LIKE :ticket_title OR t.ticket_number LIKE :ticket_number )';
        }

        //状态筛选
        foreach (['model_id', 'status', 'close', 'read', 'fix'] as $key => $value) {
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

        if(!empty($_GET['begin']) && !empty($_GET['end']) ){
            $timeField = $_GET['time_type'] == 1 ? 't.ticket_submit_time' : 't.ticket_complete_time';
            $this->condition .= " AND {$timeField} BETWEEN :begin AND :end  ";
            $this->param['begin'] = strtotime($this->g('begin'). ' 00:00:00');
            $this->param['end'] = strtotime($this->g('end'). ' 23:59:59');
        }

        if(!empty($_GET['form_content']) ){
            $this->join[] = " LEFT JOIN {$this->prefix}ticket_content AS tc ON tc.ticket_id = t.ticket_id ";
            $this->condition .= " AND (tc.ticket_form_content LIKE :ticket_form_content OR tc.ticket_form_option_name LIKE :ticket_form_option_name ) ";
            $this->param['ticket_form_option_name'] = $this->param['ticket_form_content'] = '%' . urldecode($this->g('form_content')) . '%';
            $this->group = ' GROUP BY t.ticket_id';

        }

        if(!empty($_GET['member_name']) ){
            $this->join[] = " LEFT JOIN {$this->prefix}member AS m ON m.member_id = t.member_id ";
            $this->condition .= " AND m.member_name LIKE :member_name ";
            $this->param['member_name'] = '%' . urldecode($this->g('member_name')) . '%';
        }

        $sql = "SELECT %s
                FROM {$this->prefix}ticket AS t
                LEFT JOIN {$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id
                ".implode(' ', $this->join)."
                {$this->condition} 
                {$this->group}
                ORDER BY t.ticket_close ASC, t.ticket_status ASC, t.ticket_id DESC ";


        $result = \Model\Content::quickListContent([
            'count' => empty($this->group) ? sprintf($sql, 'count(*)') : 'SELECT COUNT(*) FROM ('.sprintf($sql, 't.ticket_id').') AS t ',
            'normal' => sprintf($sql, 't.*, tm.ticket_model_name, tm.ticket_model_cid, tm.ticket_model_time_out'),
            'param' => $this->param,
            'page' => !empty($_GET['csv']) ? '9919999' : '20'
        ]);

        $this->assign('ticketModel', \Model\Content::listContent(['table' => 'ticket_model']));
        $this->assign('list', $result['list']);
        $this->assign('page', $result['page']);

        $this->assign('member', \Model\Member::getMemberWithID());
        $this->assign('title', \Model\Menu::getTitleWithMenu()['menu_name']);
        
        $this->csv();

        $this->layout($template);
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

    public function csv(){
        if(empty($_GET['csv'])){
            return false;
        }

        if(empty($_GET['debug_dev'])){
            header('Content-type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment;filename=工单列表导出CSV-'.date('YmdHis').'.csv');
            header('Cache-Control: max-age=0');

            echo "\xEF\xBB\xBF"; //输出BOM头，解决中文问题
        }

        $fp = fopen('php://output', 'a');
        $title = [
            '工单单号',
            '工单类型',
            '工单标题',
            '工单状态',
            '提交者',
            '责任人',
            '工单提交时间',
        ];
        fputcsv($fp, $title);

        $content = [];

        $statsu = \Core\Func\CoreFunc::$param['ticketStatus'];
        $category = \Core\Func\CoreFunc::$param['category'];
        $member = \Core\Func\CoreFunc::$param['member'];

        $num = 0;

        foreach (\Core\Func\CoreFunc::$param['list'] as $key => $item){

            if ($num == 1) {
                ob_flush();
                flush();
                $num = 0;
            }
            $num++;

            $content = [
                $item['ticket_number'],
                "{$category[$item['ticket_model_cid']]['category_name']} - {$item['ticket_model_name']}",
                $item['ticket_title'],
                $statsu[$item['ticket_status']]['name'],
                $item['member_id'] == '-1' ? '匿名用户' :$member[$item['member_id']]['member_name'],
                $item['user_name'],
                date('Y-m-d H:i', $item['ticket_submit_time']),
            ];
            fputcsv($fp, $content);
        }

        fclose($fp);
        
        exit;
    }

    /**
     * 依据用户组ID查询最新工单
     */
    public function getMyTicketNotice(){
        $list = $this->db('csnotice')->field('COUNT(csnotice_type) AS num, ABS(csnotice_type) AS csnotice_type')->where('user_id = :user_id AND csnotice_read = 0 ')->group('csnotice_type')->select([
            'user_id' => $this->session()->get('ticket')['user_id']
        ]);

        //排序
        uasort($list, function ($a, $b){
            if ($a['csnotice_type'] == $b['csnotice_type']) {
                return 0;
            }
            return ($a['csnotice_type'] < $b['csnotice_type']) ? -1 : 1;
        });

        $this->assign('list', $list);

        ob_start();
        $this->display();
        $content = ob_get_contents();
        ob_clean();

        $this->ajaxReturn([
            'msg' => '获取完成',
            'data' => $content
        ], empty($list) ? 0 : 200);

    }

    /**
     * 处理工单
     */
    public function handle() {
        $content = \Model\Ticket::view();
        if($content === false){
            $this->error('工单不存在');
        }

        $userID = $this->session()->get('ticket')['user_id'];

        /**
         * ticket_read为0则标记为已读
         */
        if ($content['ticket']['ticket_read'] == '0') {
            \Model\Ticket::inTicketIdWithUpdate(['ticket_read' => '1', 'noset' => ['ticket_id' => $content['ticket']['ticket_id']]]);
        }
        $this->assign($content['ticket']);

        //查询工单是否有新回复。
        if(!empty($_GET['replyRefresh'])){
            echo $content['chat']['pageObj']->totalRow;
            exit;
        }else {

            $this->getTicketUserGroup($content['ticket']['ticket_model_group_id']);
            //当前客服的回复短语
            $this->assign('phrase', \Model\Content::listContent([
                'table' => 'phrase',
                'condition' => 'phrase_user_id = :user_id',
                'order' => 'phrase_listsort ASC, phrase_id DESC',
                'param' => [
                    'user_id' => $userID
                ]
            ]));


            $this->assign('ticketModel', \Model\Content::listContent(['table' => 'ticket_model', 'field' => 'ticket_model_id, ticket_model_number, ticket_model_cid, ticket_model_name']));
            $this->assign('form', $content['form']);
            $this->assign('member', $content['member']);
            $this->assign('prefix', 'member_');
            $this->assign('memberField', \Model\Field::fieldList('20', ['field_status' => 1, 'field_list' => '1']));
            $this->assign('global_contact', $content['global_contact']);
            $this->assign('chat', $content['chat']['list']);
            $this->assign('page', $content['chat']['page']);
            $this->assign('pageObj', $content['chat']['pageObj']);
            $this->assign('title', '工单详情');
            $this->layout('Ticket_handle');
        }

    }

    /**
     * 获取当前工单所允许的用户组信息。
     * @param $ticketGroupID
     */
    private function getTicketUserGroup($ticketGroupID){
        $myGroup = \Model\Content::findContent('user_group', $this->session()->get('ticket')['user_group_id'], 'user_group_id');

        $condition = '';
        if($myGroup['user_group_view_type'] == 0){
            $groupID = trim($ticketGroupID, ',');//管辖组首尾是逗号需要移除
            $condition = "user_group_id IN ({$groupID})";
        }

        $groupList = $this->db('user_group')->where($condition)->select();
        $this->assign('groupList', $groupList);

    }

    /**
     * 工单投诉列表
     */
    public function complain(){
        $this->condition .= ' AND t.ticket_status = 3 AND t.ticket_score_time > 0';
        $this->index('Ticket_complain');
    }

    /**
     * 工单投诉详情
     */
    public function complainDetail(){
        $this->handle();
    }

    /**
     * 获取可以指派的用户名单
     */
    public function getAssignUser(){

        $groupID = $this->isP('group', '请提交用户组ID');

        $field = 'IF(user_id = '.$this->session()->get('ticket')['user_id'].', "disabled", "") AS disabled';

        $user = $this->db('user')->field("user_id, user_name, {$field}")->where('user_group_id = :groupID')->select([
            'groupID' => $groupID
        ]);
        if(empty($user)){
            $this->error('获取客服信息失败');
        }else{
            $this->success(['msg' => '获取客服信息完成', 'data' => $user]);
        }
    }




}