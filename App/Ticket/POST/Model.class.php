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
 * 模型管理
 */
class Model extends Content {

    /**
     * 添加模型
     */
    public function action($jump = FALSE, $commit = FALSE) {
        parent::action($jump, $commit);

        $modelId = $this->db()->getLastInsert;
        $modelName = $this->p('name');

        /**
         * 插入模型菜单
         */
        $addMenuResult = \Model\Menu::insertMenu(['menu_name' => $this->p('title'), 'menu_pid' => '9', 'menu_link' => GROUP . "-".ucfirst($modelName)."-index"]);
        if ($addMenuResult === false) {
            $this->db()->rollBack();
            $this->error('插入菜单失败');
        }

        /**
         * 插入初始化的字段
         */
        \Model\ModelManage::setInitField($modelId);

        $this->db()->commit();

        $initResult = \Model\ModelManage::initModelTable(strtolower($modelName));

        $this->success('添加模型成功', $this->url(GROUP . '-Model-index'));
    }

}
