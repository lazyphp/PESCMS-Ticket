<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

class TicketModel extends \Core\Model\Model {

    private static $ticketModelList = [];

    /**
     * 依据工单模型的number查找信息
     */
    public static function numberFind($number){
        $result = self::db('ticket_model')->where('ticket_model_number = :number')->find(array('number' => $number));
        if(empty($result)){
            self::error('该工单模型不存在');
        }
        return $result;
    }

    /**
     * 获取工单模型
     * @param null $id 提交ID则获取指定的模型
     * @param string $condition 筛选条件
     * @return array|mixed
     */
    public static function getTicketModelList($id = NULL, $condition = ''){
        if(empty(self::$ticketModelList)){
            $result = \Model\Content::listContent([
                'table' => 'ticket_model AS tm',
                'field' => 'tm.*, c.category_name',
                'join' => self::$modelPrefix.'category AS c ON c.category_id = tm.ticket_model_cid',
                'condition' => $condition,
                'order' => 'tm.ticket_model_listsort ASC, tm.ticket_model_id DESC'
            ]);
            foreach ($result as $item){
                self::$ticketModelList[$item['ticket_model_id']] = $item;
            }
        }

        if(empty($id)){
            return self::$ticketModelList;
        }else{
            return self::$ticketModelList[$id];
        }

    }

}