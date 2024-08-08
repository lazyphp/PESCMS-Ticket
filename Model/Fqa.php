<?php

/**
 * 版权所有 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

/**
 * FQA模型
 */
class Fqa extends \Core\Model\Model {

    public static
        $field = "f.*, tm.ticket_model_login, tm.ticket_model_cid, tm.ticket_model_name, tm.ticket_model_img",
        $condition = " f.fqa_status = 1 ",
        $param = [];

    public static function getList() {
        
        $result = \Model\Content::listContent([
            'table'     => 'fqa AS f',
            'field'     => self::$field,
            'join'      => self::$modelPrefix . "ticket_model AS tm ON tm.ticket_model_id = f.fqa_ticket_model_id",
            'condition' => self::$condition,
            'order'     => 'fqa_listsort ASC, fqa_id DESC',
            'param'     => self::$param,
        ]);

        return $result;

    }

}