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
        $sql = "SELECT %s FROM {$this->prefix}ticket AS t
                LEFT JOIN {$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id
                WHERE t.member_id = :member_id
                ORDER BY t.ticket_submit_time DESC
                ";
        $result = \Model\Content::quickListContent([
            'count' => sprintf($sql, 'count(*)'),
            'normal' => sprintf($sql, 't.*, tm.ticket_model_name'),
            'param' => [
                'member_id' => $this->session()->get('member')['member_id']
            ],
            'page' => 15
        ]);

        $this->assign('page', $result['page']);
        $this->assign('list', $result['list']);
        $this->layout();
    }

    /**
     * 查看和更新个人信息
     */
    public function update(){

    }

}