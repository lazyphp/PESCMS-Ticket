<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

class TicketForm extends \Core\Model\Model{

    public static function getFormWithNumber($number){
        $ticket = self::db('ticket_model AS tm')->field('tm.*, tf.*')->join(self::$modelPrefix."ticket_form AS tf ON tf.ticket_form_model_id = ticket_model_id")->where('tm.ticket_model_status = 1 AND tf.ticket_form_status = 1  AND tm.ticket_model_number = :number')->order('tf.ticket_form_listsort ASC, tf.ticket_form_id DESC')->select(['number' => $number]);
        return $ticket;
    }

}