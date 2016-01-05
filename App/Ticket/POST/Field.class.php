<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
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
