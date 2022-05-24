<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

class CSnotice extends \Core\Model\Model {

    /**
     * 快速添加客服通知
     * @param $ticket_id
     * @param $user_id
     * @param $csnotice_type
     * @return mixed
     */
    public static function addCSNotice($ticket_id, $user_id, $csnotice_type){
        return self::db('csnotice')->insert([
            'ticket_number' => $ticket_id,
            'user_id' => $user_id,
            'csnotice_type' => $csnotice_type,
            'csnotice_time' => time(),
        ]);
    }

}