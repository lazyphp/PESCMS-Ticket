<?php

namespace Slice\Ticket\UpdateField;

/**
 * 执行更新客户分组字段的动作
 * Class Login
 * @package Slice\Ticket
 */
class UpdateMemberOrganizeField extends \Core\Slice\Slice{

    public function before() {
    }

    /**
     * 更新模型字段中，绑定了用户组ID的字段选项
     */
    public function after() {
        $memberOrganizeList = \Model\Content::listContent(['table' => 'member_organize']);

        $memberOrganize = [];
        foreach($memberOrganizeList as $value){
            $memberOrganize[$value['member_organize_name']] = $value['member_organize_id'];
        }
        $this->db('field')->where('field_name = :field_name')->update([
            'noset' => [
                'field_name' => 'organize_id'
            ],
            'field_option' => json_encode($memberOrganize),
        ]);
    }


}