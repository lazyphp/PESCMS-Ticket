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

    /**
     * 快速获取用户字段
     * @return array
     */
    public static function getModelField(){

        $result = \Model\Field::fieldList('20', 'AND field_status = 1 AND field_form = 1');
        $field = [];
        foreach ($result as $item){
            switch ($item['field_name']){
                case 'organize_id':
                case 'createtime':
                case 'status':
                    break;
                case 'password':
                    $password = $item;
                    break;
                default:
                    $field[$item['field_name']] = $item;
            }

        }
        return [
            'field' => $field,
            'password' => $password
        ];
    }

    /**
     * 验证用户唯一字段
     * @param $field
     * @param $value
     * @return bool
     */
    public static function checkOnly($field, $value){
        $result = self::db('member')->where("member_{$field} = :{$field} AND member_id != :member_id ")->find([
            $field => $value,
            'member_id' => self::session()->get('doc')['member_id']
        ]);
        if(empty($result)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取客服允许登录字段当前默认值
     * @return mixed
     */
    public static function getRequisitionStatus(){
        return self::db()->fetch("SHOW COLUMNS FROM ".self::$modelPrefix."member WHERE FIELD = 'member_requisition'")['Default'] ?? 0;
    }

}