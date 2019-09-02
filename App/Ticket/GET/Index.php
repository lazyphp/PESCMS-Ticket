<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */

namespace App\Ticket\GET;

class Index extends \Core\Controller\Controller {

    private $category = [];

    /**
     * 系统首页
     */
    public function index() {

        $this->category = \Model\Category::getAllCategoryCidPrimaryKey();
        $this->assign('category', $this->category);

        $this->statistics();

        $this->memberInfo();

        $this->threeTypeTicket();

        $this->layout();
    }

    /**
     * 简单的统计
     */
    private function statistics(){
        $countCondition = [
            'new' => 'ticket_submit_time BETWEEN :begin AND :end',
            'accept' => 'user_id =:user_id AND ticket_status IN (1,2) AND ticket_close = 0 AND ticket_refer_time BETWEEN :begin AND :end',
            'complete' => 'user_id =:user_id AND ticket_status = 3 AND ticket_close = 0 AND ticket_complete_time BETWEEN :begin AND :end',
        ];
        $count = [];

        $today = strtotime(date('Y-m-d') . ' 00:00:00');
        $param = [
            '今天' => ['begin' => $today, 'end' => $today + 86399, 'user_id' => $this->session()->get('ticket')['user_id'],],
            '昨天' => ['begin' => $today - 86400, 'end' => $today - 1, 'user_id' => $this->session()->get('ticket')['user_id'],]
        ];

        foreach ($countCondition as $key => $value) {
            foreach ($param as $date => $day) {
                if($key == 'new'){
                    unset($day['user_id']);
                }
                $count[$date][$key] = $this->db('ticket')->field('count(*) AS count')->where($value)->find($day)['count'];
            }
        }
        $this->assign('count', $count);
    }

    /**
     * 获取用户信息
     * --管辖工单的处理数
     * --上周和本周的工单耗时对比
     */
    private function memberInfo() {
        //计算当前用户所在组的工单数量(关闭不计算)
        $obligationsList = $this->db('ticket_model AS tm')
            ->field('t.ticket_id, t.user_id, tm.ticket_model_name, tm.ticket_model_id, tm.ticket_model_cid')
            ->join("{$this->prefix}ticket AS t ON t.ticket_model_id = tm.ticket_model_id")
            ->where('t.ticket_close = 0  AND tm.ticket_model_group_id LIKE :group_id')
            ->select([
            'group_id' => "%,{$this->session()->get('ticket')['user_group_id']},%"
        ]);

        $obligations = [];
        foreach ($obligationsList as $item){
            if(empty($obligations[$item['ticket_model_id']]['total'])){
                $obligations[$item['ticket_model_id']]['total'] = 0;
            }
            if(empty($obligations[$item['ticket_model_id']]['userTotal'])){
                $obligations[$item['ticket_model_id']]['userTotal'] = 0;
            }
            $obligations[$item['ticket_model_id']]['name'] = "{$this->category[$item['ticket_model_cid']]['category_name']} - {$item['ticket_model_name']}";
            $obligations[$item['ticket_model_id']]['total'] += 1;

            if($item['user_id'] == $this->session()->get('ticket')['user_id']){
                $obligations[$item['ticket_model_id']]['userTotal'] += 1;
            }
        }
        $this->assign('obligations', $obligations);

        //14天前和过去7天的工单耗时对比(关闭不计算)
        $time = [
            '过去14天' => [
                'begin' => time() - 14 * 86400,
                'end' => time() - 7 * 86400,
                'user_id' => $this->session()->get('ticket')['user_id']
            ],
            '过去7天' => [
                'begin' => time() - 7 * 86400,
                'end' => time(),
                'user_id' => $this->session()->get('ticket')['user_id']
            ]
        ];
        foreach ($time as $key => $param){
            //ticket_run_time 在工单没有结束前，时间是会时刻变化
            $runTime[$key] = $this->db('ticket')->field('AVG(ticket_run_time) AS run_time')->where('user_id = :user_id AND ticket_close = 0 AND ticket_submit_time BETWEEN :begin AND :end ')->find($param);
        }

        $this->assign('runTime', $runTime);

    }

    /**
     * 列出3种10条不同意类型的工单
     */
    private function threeTypeTicket() {
        $type = [
            'am-panel-primary' => [
                'title' => '新提交工单',
                'condition' => 't.ticket_status = 0 AND t.user_id = 0 AND t.ticket_close = 0 AND tm.ticket_model_group_id LIKE :group_id ',
                'param' => [
                    'group_id' => "%,{$this->session()->get('ticket')['user_group_id']},%"
                ],
                'url' => $this->url('Ticket-Ticket-index', ['status' => 0, 'close' => '0']),
            ],
            'am-panel-default' => [
                'title' => '待处理',
                'condition' => 't.user_id = :user_id AND  t.ticket_status = 1 AND t.ticket_close = 0',
                'param' => ['user_id' => $this->session()->get('ticket')['user_id']],
                'url' => $this->url('Ticket-Ticket-myTicket', ['status' => 1, 'close' => '0']),
            ],
            'am-panel-warning' => [
                'title' => '待回复工单',
                'condition' => 't.user_id = :user_id AND  t.ticket_status = 2 AND t.ticket_close = 0',
                'param' => ['user_id' => $this->session()->get('ticket')['user_id']],
                'url' => $this->url('Ticket-Ticket-myTicket', ['status' => 2, 'close' => '0']),
            ],
            'am-panel-success' => [
                'title' => '已完成/关闭工单',
                'condition' => 't.user_id = :user_id AND (t.ticket_status = 3 OR t.ticket_close = 1)',
                'param' => ['user_id' => $this->session()->get('ticket')['user_id']],
                'url' => $this->url('Ticket-Ticket-myTicket', ['status' => 3]),
            ]
        ];
        $list = [];
        foreach ($type as $key => $value) {

            $list[$key]['title'] = $value['title'];
            $list[$key]['url'] = $value['url'];
            $list[$key]['list'] = \Model\Content::listContent([
                'table' => 'ticket AS t',
                'field' => 't.*, tm.ticket_model_name, tm.ticket_model_cid, tm.ticket_model_time_out',
                'join' => "{$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id",
                'condition' => $value['condition'],
                'param' => $value['param'],
                'order' => 'ticket_refer_time DESC, ticket_submit_time DESC, ticket_id DESC',
                'limit' => '10'
            ]);
        }


        $this->assign('list', $list);
    }

    /**
     * 清空临时目录文件缓存
     */
    public function clean(){
        $result = \Model\Extra::clearDirAllFile();
        if($result['status'] == 200){
            $this->success('缓存已清空完毕');
        }else{
            $this->error($result['msg']);
        }
    }

}