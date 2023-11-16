<?php
/**
 * 版权所有 2023 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

class TicketChat extends \Core\Model\Model {

    /**
     * 工单对话提醒内容
     * @param $array
     * @return array
     */
    public static function chatTips($array) {

        if (empty($array)) {
            return [];
        }

        $id = array_column($array, 'ticket_chat_id');

        $res = self::db('ticket_chat_tips')->where('ticket_chat_id IN (:' . implode(array_keys($array), ', :') . ')')->select($id);

        $list = [];
        if (!empty($res)) {
            foreach ($res as $item) {
                $list[$item['ticket_chat_id']][] = $item;
            }
        }

        return $list;
    }

}