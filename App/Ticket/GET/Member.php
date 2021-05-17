<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


namespace App\Ticket\GET;

class Member extends Content {

    public function index($display = true) {
        switch ($_GET['sortby']){
            case '1':
                $this->sortBy = 'CONVERT( member_name USING gbk ) ASC';
                break;
            case '2':
                $this->sortBy = 'CONVERT( member_name USING gbk ) DESC';
                break;
        }

        parent::index($display);
    }

    /**
     * 登录客户的账号，发起工单
     */
    public function issue(){
        if(!empty($_GET['id'])){
            $member = $this->db('member')->field('member_id, member_name')->where('member_organize_id = :member_organize_id')->select([
                'member_organize_id' => $this->g('id')
            ]);
            $option = '<option value="">请选择客户</option>';
            if (!empty($member)){
                foreach ($member as $item){
                    $option .= '<option value="'.$item['member_id'].'">'.$item['member_name'].'</option>';
                }
            }

            $this->success(['msg' => '获取客户信息完成', 'data' => $option]);

        }else{
            $this->assign('member_organize', $this->db('member_organize')->select());
            $this->assign('title', '发起工单');
            $this->layout();
        }
    }

    /**
     * 执行登录客户账号
     */
    public function issueLogin(){
        $this->checkToken();
        $id = $this->isG('id', '请选择您要登录的客户账号');
        $member = \Model\Content::findContent('member', $id, 'member_id');
        $this->session()->set('member', $member);
        $this->jump($this->url('Category-index'));
    }

}