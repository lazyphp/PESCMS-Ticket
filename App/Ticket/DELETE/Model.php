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
 * 删除模型
 */
class Model extends \Core\Controller\Controller {

    /**
     * 删除模型
     */
    public function action() {
        $this->checkToken();
        $modelId = $this->isG('id', '请选择要删除的数据!');

        $model = \Model\ModelManage::findModel($modelId);
        if (empty($model)) {
            $this->error('模型不存在');
        }

        $this->db()->transaction();

        $deleteModelResult = \Model\ModelManage::deleteModel($modelId);
        if (empty($deleteModelResult)) {
            $this->db()->rollBack();
            $this->error('删除模型失败');
        }

        $deleteModelField = \Model\Field::deleteModelField($modelId);
        if (empty($deleteModelField)) {
            $this->db()->rollBack();
            $this->error('移除模型字段记录失败');
        }

        $this->db('menu')->where('menu_name = :name')->delete(['name' => $model['model_title']]);

        $this->db()->commit();

        $alterTableResult = \Model\ModelManage::alterTable(strtolower($model['model_name']));
        if (empty($alterTableResult)) {

            $log = new \Expand\Log();
            $failLog = "Alter Model Table Field: {$this->prefix}{$model['model_name']}" . date("Y-m-d H:i:s");
            $log->creatLog('modelError', $failLog);

            $this->error('删除数据库表失败，具体信息请查阅程序日志');
        }

        $this->success('删除成功');
    }

}
