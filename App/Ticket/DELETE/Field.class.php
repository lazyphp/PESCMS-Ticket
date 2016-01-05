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
 * 删除字段
 */
class Field extends \App\Ticket\Common {

    public function action() {
        $id = $this->isG('id', '请选择要删除的数据!');

        $field = \Model\Field::findField($id);

        if (empty($field)) {
            $this->error('不存在的字段');
        }

        $removeFieldResult = \Model\Field::removeField($id);
        if (empty($removeFieldResult)) {
            $this->error('删除失败');
        }

        $model = \Model\ModelManage::findModel($field['field_model_id']);

        $alertTableFieldResult = \Model\Field::alertTableField($model['model_name'], $field['field_name']);
        if (empty($alertTableFieldResult)) {

            $log = new \Expand\Log();
            $failLog = "Delete Field: " . strtolower($model['model_name']) . "_{$field['field_name']}, Model:{$model['model_name']}  " . date("Y-m-d H:i:s");
            $log->creatLog('fieldError', $failLog);

            $this->error('移除数据库表字段失败，具体信息请查阅程序日志');
        }

        $this->success('删除成功');
    }

}