<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */
namespace App\Ticket\DELETE;

/**
 * 删除字段
 */
class Field extends \Core\Controller\Controller {

    public function action() {
        $this->checkToken();
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