<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */

namespace App\Ticket\DELETE;

/**
 * 公用内容删除方法
 */
class Content extends \App\Ticket\Common {

    /**
     * 魔术方法，执行删除
     * @param type $name
     * @param type $arguments
     */
    public function __call($name, $arguments) {
        $this->delete();
    }

    /**
     * 执行删除动作
     */
    public function delete() {
        $id = $this->isG('id', '请选择要删除的数据!');
        $result = \Model\ModelManage::deleteFromModelId(MODULE, $id);
        if (empty($result)) {
            $this->error('删除失败');
        } else {
            $this->success('删除成功');
        }
    }

}
