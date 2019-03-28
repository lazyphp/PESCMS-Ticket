<?php
namespace App\Form\GET;

class Member extends \Core\Controller\Controller {

    /**
     * 我的工单
     * @todo 本来打算将个人的工单编写在Ticket控制器
     * 但考虑到我的工单应该是登录后可以直接查看的
     * 因此我将此方法放置于Member控制器
     * 若以后有调整，在将此方法进行细分.
     */
    public function index(){

        foreach (range(0,3) as $item){
            $statistics[$item] = [
                'total' => 0,
                'ticket_status' => $item
            ];
        }

        $statisticsResult = $this->db('ticket')->field('count(ticket_id) AS total, ticket_status')->where('member_id = :member_id')->group('ticket_status')->select([
            'member_id' => $this->session()->get('member')['member_id']
        ]);

        foreach ($statisticsResult as $item){
            $statistics[$item['ticket_status']]['total'] = $item['total'];
        }

        $this->ticketList();
        $this->assign('statistics', $statistics);

        $this->assign('category', \Model\Category::getAllCategoryCidPrimaryKey());

        $this->layout();
    }

    /**
     * 工单列表
     */
    private function ticketList(){
        $condition = '';
        $param = ['member_id' => $this->session()->get('member')['member_id']];
        //关键词搜索
        if(!empty($_GET['keyword'])){
            $keyword = $this->g('keyword');
            $condition .= ' AND (ticket_number LIKE :ticket_number OR ticket_title LIKE :ticket_title)  ';
            $param['ticket_number'] = $param['ticket_title'] = "%{$keyword}%";
        }
        //快速日期搜索
        if(!empty($_GET['dataType'])){
            $param['begin'] = strtotime(date('Y-m-d').' 00:00:00');
            $param['end'] = strtotime(date('Y-m-d').' 23:59:59');
            switch ($_GET['dataType']){
                case '1':
                    $param['begin'] = strtotime(date('Y-m-d').' 00:00:00');
                    $param['end'] = strtotime(date('Y-m-d').' 23:59:59');
                    break;
                case '-1':
                    $param['begin'] = $param['begin'] - 86400;
                    $param['end'] = $param['end'] - 86400;
                    break;
                case '-7':
                    $param['begin'] = $param['begin'] - 86400 * 7;
                    break;
            }
            $condition .= ' AND ticket_submit_time BETWEEN :begin AND :end';
        }

        //状态
        if(!empty($_GET['status']) || is_numeric($_GET['status'])){
            $condition .= ' AND ticket_status = :ticket_status  ';
            $param['ticket_status'] = $this->g('status');
        }

        $sql = "SELECT %s FROM {$this->prefix}ticket AS t
                LEFT JOIN {$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id
                WHERE t.member_id = :member_id {$condition}
                ORDER BY t.ticket_submit_time DESC
                ";
        $result = \Model\Content::quickListContent([
            'count' => sprintf($sql, 'count(*)'),
            'normal' => sprintf($sql, 't.*, tm.ticket_model_name, tm.ticket_model_cid'),
            'param' => $param,
            'page' => 15
        ]);

        $this->assign('page', $result['page']);
        $this->assign('list', $result['list']);

        $this->assign('keyword', empty($keyword) ? '' : $keyword);
    }

    /**
     * 查看和更新个人信息
     */
    public function update(){
        $this->assign('member', \Model\Content::findContent('member', $this->session()->get('member')['member_id'], 'member_id'));
        $this->layout();
    }

}