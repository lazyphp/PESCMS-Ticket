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

class Index extends \App\Ticket\Common {

    /**
     * 系统首页
     */
    public function index() {

        //显示简单得统计信息
        $countCondition = [
            'new' => 'ticket_submit_time BETWEEN :begin AND :end',
            'accept' => 'ticket_refer_time BETWEEN :begin AND :end',
            'complete' => 'ticket_complete_time BETWEEN :begin AND :end',
        ];
        $count = [];

        $today = strtotime(date('Y-m-d').' 00:00:00');
        $param = ['今天' => ['begin' => $today, 'end' => $today + 86399], '昨天' => ['begin' => $today - 86400, 'end' => $today - 1]];

        foreach($countCondition as $key => $value){
            foreach($param as $date => $day){
                $count[$date][$key] = $this->db('ticket')->field('count(*) AS count')->where($value)->find($day)['count'];
            }
        }
        $this->assign('count', $count);

        //列出3种10条不同意类型的工单
        $type = [
            'am-panel-primary' => ['title' => '新/未读工单', 'condition' => '(ticket_status = 0 OR ticket_read = 0) AND ticket_close = 0 '],
            'am-panel-warning' =>  ['title' => '新受理/待回复工单', 'condition' => 'ticket_status in (1,2) AND ticket_close = 0'],
            'am-panel-success' => ['title' => '已完成/关闭工单', 'condition' => 'ticket_status = 3 OR ticket_close = 1']
        ];
        $list = [];
        foreach ($type as $key => $value) {

            $list[$key]['title'] = $value['title'];
            $list[$key]['list'] = \Model\Content::listContent([
                'table' => 'ticket',
                'condition' => $value['condition'],
                'order' => 'ticket_refer_time DESC, ticket_submit_time DESC, ticket_id DESC',
                'limit' => '10'
            ]);
        }

        $this->assign('list', $list);

        $this->layout();
    }

}