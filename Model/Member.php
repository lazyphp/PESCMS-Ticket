<?php

/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
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