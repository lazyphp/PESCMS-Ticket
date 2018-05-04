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

namespace Model;

class TicketModel extends \Core\Model\Model {

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

}