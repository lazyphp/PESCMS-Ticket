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
 * 模型管理
 */
class Model extends Content {

    /**
     * 更新模型
     */
    public function action($jump=FALSE, $commit = TRUE) {
        $model = \Model\ModelManage::findModel($_POST['id']);
        parent::action($jump, $commit);
        //更新菜单
        $this->db('menu')->where('menu_name = :old_name')->update(array('menu_name' => $this->p('title'), 'noset' => array('old_name' => $model['model_title'])));

        $this->success('更新模型成功', $this->url(GROUP . '-Model-index'));
    }
}
