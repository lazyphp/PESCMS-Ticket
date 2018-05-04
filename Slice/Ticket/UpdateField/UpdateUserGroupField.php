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


namespace Slice\Ticket\UpdateField;

/**
 * 执行更新用户组字段的动作
 * Class Login
 * @package Slice\Ticket
 */
class UpdateUserGroupField extends \Core\Slice\Slice{

    public function before() {
    }

    /**
     * 更新模型字段中，绑定了用户组ID的字段选项
     */
    public function after() {
        $userGroupList = \Model\Content::listContent(['table' => 'user_group']);
        $userGroup = [];
        foreach($userGroupList as $value){
            $userGroup[$value['user_group_name']] = $value['user_group_id'];
        }
        $this->db('field')->where('field_name = :field_name')->update(['field_option' => json_encode($userGroup), 'noset' => ['field_name' => 'group_id'] ]);
    }


}