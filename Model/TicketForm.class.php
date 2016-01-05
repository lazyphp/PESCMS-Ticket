<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */

namespace Model;

class TicketForm extends \Core\Model\Model{

    public static function getFormWithNumber($number){
        $ticket = self::db('ticket_model AS tm')->field('tm.*, tf.*')->join(self::$modelPrefix."ticket_form AS tf ON tf.ticket_form_model_id = ticket_model_id")->where('tm.ticket_model_status = 1 AND tf.ticket_form_status = 1  AND tm.ticket_model_number = :number')->order('tf.ticket_form_listsort ASC, tf.ticket_form_id DESC')->select(['number' => $number]);
        if(empty($ticket)){
            self::error('当前工单没有可用的表单或者工单没有启用');
        }
        return $ticket;
    }

}