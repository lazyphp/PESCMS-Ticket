<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Ticket\POST;

/**
 * 字段管理
 */
class Field extends Content {


    public function action($jump = FALSE, $commit = FALSE) {
        \Model\Field::baseForm();
        parent::action($jump, $commit);
        $filedID = $this->db()->getLastInsert;
        \Model\Field::addField($filedID);

        if(empty($_GET['back_url'])){
            $url = $this->url(GROUP . '-Model-fieldList', array('id' => $filedID, 'model_id' => \Model\Field::$model['model_id']));
        }else{
            $url = base64_decode($_GET['back_url']);
        }

        $this->success('添加字段成功', $url);


    }

}
