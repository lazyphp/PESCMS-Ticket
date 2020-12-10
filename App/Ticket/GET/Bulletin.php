<?php

namespace App\Ticket\GET;

class Bulletin extends Content {

    /**
     * 列表页
     */
    public function listing(){
        $sql = "SELECT %s FROM {$this->prefix}bulletin WHERE bulletin_status = 1 AND bulletin_group_id LIKE :bulletin_group_id ORDER BY bulletin_listsort ASC, bulletin_id DESC  ";
        $result = \Model\Content::quickListContent([
            'count' => sprintf($sql, 'count(*)'),
            'normal' => sprintf($sql, '*'),
            'param' => [
                'bulletin_group_id' => '%,'.$this->session()->get('ticket')['user_group_id'].',%'
            ]
        ]);
        $this->assign('list', $result['list']);
        $this->assign('page', $result['page']);
        $this->assign('title', '公告栏列表');
        $this->layout();
    }

    /**
     * 详细页
     */
    public function view(){
        $id = $this->isG('id', '请提交您要查看的公告ID');
        $result = $this->db('bulletin')->where('bulletin_id = :bulletin_id AND bulletin_status = 1 AND bulletin_group_id LIKE :bulletin_group_id ')->find([
            'bulletin_id' => $id,
            'bulletin_group_id' => '%,'.$this->session()->get('ticket')['user_group_id'].',%'
        ]);
        $this->assign($result);
        $this->assign('title', $result['bulletin_title']);
        $this->layout();
    }

}