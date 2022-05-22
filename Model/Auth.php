<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

/**
 * 权限认证模型
 */
class Auth extends \Core\Model\Model {

    /**
     * 权限认证
     * @param string $auth 认证的权限名称:组控制器方法
     * @return bool|type 存在则返回权限
     */
    public static function check($auth = GROUP . METHOD . MODULE . ACTION){

        if(isset(self::session()->get('ticket')['user_id']) && self::session()->get('ticket')['user_id'] == '1'){
            return true;
        }
        $findNode = \Model\Content::findContent('node', $auth, 'node_check_value');
        if(empty($findNode)){
            return true;
        }

        $list = \Model\Content::listContent([
            'table' => 'node_group',
            'condition' => 'user_group_id = :user_group_id AND node_id = :node_id',
            'param' => [
                'user_group_id' => self::session()->get('ticket')['user_group_id'],
                'node_id' => $findNode['node_id']
            ]
        ]);

        if(!empty($list)){
            return true;
        }else{
            return !empty($findNode['node_msg']) ? $findNode['node_msg'] : '您的权限不足';
        }


    }

}