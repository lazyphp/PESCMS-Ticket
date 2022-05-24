<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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
        $userGroupList = \Model\Content::listContent([
            'table' => 'user_group',
            'condition' => 'user_group_status = 1'
        ]);
        $userGroup = [];
        foreach($userGroupList as $value){
            $userGroup[$value['user_group_name']] = $value['user_group_id'];
        }
        $this->db('field')->where('field_name = :field_name')->update([
            'noset' => [
                'field_name' => 'group_id'
            ],
            'field_option' => json_encode($userGroup),
        ]);
    }


}