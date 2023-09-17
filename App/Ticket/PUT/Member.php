<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace App\Ticket\PUT;

class Member extends Content {

    /**
     * 一键转换所有客户的允许登录状态
     * @return void
     */
    public function requisitionStatus(){
        if($this->session()->get('ticket')['user_id'] != 1){
            $this->error('您不能进行此操作');
        }

        $status = \Model\Member::getRequisitionStatus() == 1 ? 0 : 1;

        $this->db()->query("ALTER TABLE `{$this->prefix}member` CHANGE `member_requisition` `member_requisition` INT(11) NOT NULL DEFAULT '{$status}';");

        $this->db()->query("UPDATE {$this->prefix}member SET member_requisition = :member_requisition ", [
            'member_requisition' => $status
        ]);

        $this->success('所有客户的登录状态已变更.');

    }

    /**
     * 对指定客服账号绑定新工单的账号
     * @return void
     */
    public function bind(){
        $uid = $this->isG('uid', '请提交要绑定的客服账号');
        $id = $this->isP('id', '请提交您要绑定的客户账号');

        $this->db('user')->where('user_id = :user_id')->update([
            'noset' => [
                'user_id' => $uid
            ],
            'user_bind_mid' => $id
        ]);

        if(empty($_POST['back_url'])){
            $url = $this->url('Ticket-User-index');
        }else{
            $url = base64_decode($this->p('back_url'));
        }


        $this->success('客服绑定客户账号完成', $url);

    }

    /**
     * 解除绑定
     * @return void
     */
    public function unbind(){
        $_POST['id'] = (string) '0';
        $this->bind();
    }

}