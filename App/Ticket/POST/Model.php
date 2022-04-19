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

        \Model\ModelManage::createNode($modelId, $modelName);

        $this->db()->commit();

        $initResult = \Model\ModelManage::initModelTable(strtolower($modelName));

        $this->success('添加模型成功', $this->url(GROUP . '-Model-index'));
    }

    /**
     * 导入模型
     */
    public function import(){

        $this->error('本功能暂时下架，若需要使用请自行修改代码解除限制。');
        exit;

        $model = json_decode($this->isP('model', '请提交您要导入的模型代码', false), true);
        if(empty($model)){
            $this->error('解析提交的模型代码失败，请检查JSON格式是否异常');
        }

        $this->db()->transaction();
        unset($model['model']['model_id']);
        $modelID = $this->db('model')->insert($model['model']);
        if(empty($modelID)){
            $this->error('创建模型失败');
        }

        if(!empty($model['field'])){
            foreach ($model['field'] as $value){
                unset($value['field_id'], $value['field_model_id']);
                $value['field_model_id'] = $modelID;
                $this->db('field')->insert($value);
            }
        }

        $this->db('menu')->insert([
            'menu_name' => $model['model']['model_title'],
            'menu_pid' => 9,
            'menu_icon' => 'am-icon-file',
            'menu_link' => GROUP."-{$model['model']['model_name']}-index"
        ]);

        $this->db()->commit();

        $this->db()->query($model['table']);

        $this->success('导入模型成功!', $this->url(GROUP . '-Model-index'));


    }

}
