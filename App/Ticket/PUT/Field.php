<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Ticket\PUT;

/**
 * 字段管理
 */
class Field extends Content {

    public function action($jump = FALSE, $commit = true) {
        \Model\Field::baseForm();
        parent::action($jump, $commit);

        if (empty($_GET['back_url'])) {
            $url = $this->url(GROUP . '-Model-fieldList', array('id' => $this->p('id'), 'model_id' => \Model\Field::$model['model_id']));
        } else {
            $url = base64_decode($_GET['back_url']);
        }

        $this->success('更新字段成功', $url);
    }
}
