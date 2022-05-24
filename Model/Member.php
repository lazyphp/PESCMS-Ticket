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
 * 客户模型
 */
class Member extends \Core\Model\Model {

    private static $memberWithID = [];

    /**
     * 通过ID来查询客户信息
     * @param $id 为空则返回全部
     */
    public static function getMemberWithID($id = NULL){
        if(empty(self::$memberWithID)){
            $list = \Model\Content::listContent(['table' => 'member']);
            foreach ($list as $item){
                self::$memberWithID[$item['member_id']] = $item;
            }
        }

        if(empty($id)){
            return self::$memberWithID;
        }else{
            return self::$memberWithID[$id];
        }


    }

}