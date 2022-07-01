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

}