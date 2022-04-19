<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

/**
 * 模型(Model)模型
 */
class ModelManage extends \Core\Model\Model {

    /**
     * 查找模型(动态条件)
     * @param type $value 查询值
     * @param type $condition 查询条件
     */
    public static function findModel($value, $condition = 'model_id') {
        return self::db('model')->where("{$condition} = :$condition")->find([$condition => $value]);
    }

    /**
     * 依据模型 + 字段：模型_id 进行删除内容动作
     * @param type $model 模型名称
     * @param type $id 待删除的ID
     * @return type 返回执行结果
     */
    public static function deleteFromModelId($model, $id) {
        $model = strtolower($model);
        return self::db($model)->where("{$model}_id = :{$model}_id")->delete(["{$model}_id" => $id]);
    }

    /**
     * 依据模型 + 字段:模型_id 进行排序动作
     * @param type $model 模型名称
     * @param type $id 待排序的ID
     * @param type $sortValue 排序的值
     */
    public static function updateSortFromModel($model, $id, $sortValue) {
        $model = strtolower($model);
        return self::db($model)->where("{$model}_id = :{$model}_id")->update(["{$model}_listsort" => $sortValue, 'noset' => ["{$model}_id" => $id]]);
    }

    /**
     * 设置预设的模型字段
     */
    public static function setInitField($modelId) {
        $setStatus = self::db('field')->insert([
            'field_model_id'     => $modelId,
            'field_name'         => 'status',
            'field_display_name' => '状态',
            'field_type'         => 'radio',
            'field_option'       => '{"\u7981\u7528":"0","\u542f\u7528":"1"}',
            'field_default'      => '1',
            'field_required'     => '1',
            'field_listsort'     => '100',
            'field_list'         => 1,
            'field_form'         => 1,
            'field_status'       => '1',
            'field_action'       => 'POST,PUT',
        ]);
        if ($setStatus === false) {
            self::error('设置预设字段失败');
        }

        $setListsort = self::db('field')->insert([
            'field_model_id'     => $modelId,
            'field_name'         => 'listsort',
            'field_display_name' => '排序',
            'field_type'         => 'text',
            'field_option'       => '',
            'field_listsort'     => '98',
            'field_list'         => 1,
            'field_form'         => 1,
            'field_status'       => '1',
            'field_action'       => 'POST,PUT',
        ]);
        if ($setListsort === false) {
            self::error('设置预设字段失败');
        }

        $setCreatetime = self::db('field')->insert([
            'field_model_id'     => $modelId,
            'field_name'         => 'createtime',
            'field_display_name' => '创建时间',
            'field_type'         => 'date',
            'field_option'       => '',
            'field_listsort'     => '99',
            'field_list'         => 1,
            'field_form'         => 1,
            'field_status'       => '1',
            'field_action'       => 'POST,PUT',
        ]);
        if ($setCreatetime === false) {
            self::error('设置预设字段失败');
        }
    }

    /**
     * 初始化模型表
     * 基础字段：模型_id,模型_listsort,模型_lang,模型_url,模型_status,模型_createtime
     */
    public static function initModelTable($model) {
        $model = strtolower($model);
        $table = self::$modelPrefix . $model;

        //前台模型才会创建url字段
        $url = $_POST['attr'] == 1 ? "`{$model}_url` VARCHAR( 255 ) NOT NULL DEFAULT ''," : '';

        $initResult = self::db()->alter("CREATE TABLE IF NOT EXISTS `{$table}` (`{$model}_id` int(11) NOT NULL AUTO_INCREMENT, `{$model}_listsort` int(11) NOT NULL DEFAULT '0',`{$model}_status` tinyint(4) NOT NULL DEFAULT '0', {$url} `{$model}_createtime` int(11) NOT NULL DEFAULT '0', PRIMARY KEY (`{$model}_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        if ($initResult == false) {
            $log = new \Expand\Log();
            $failLog = "Create Model Table : {$table}" . date("Y-m-d H:i:s");
            $log->creatLog('modelError', $failLog);
            self::error("创建{$table}表失败");
        }
    }

    /**
     * 创建模型的基础权限节点
     * @param $modelId
     */
    public static function createNode($modelId, $model) {
        //后台模型才创建权限节点
        if ($_POST['attr'] != 2) {
            return true;
        }

        $title = self::p('title');

        $nodeID = self::db('node')->insert([
            'node_name'        => $title,
            'node_parent'      => '0',
            'node_msg'         => '',
            'node_method_type' => 'GET',
            'node_value'       => ucfirst($model),
            'node_listsort'    => $modelId * 100,
        ]);

        //列表页节点
        self::db('node')->insert([
            'node_name'        => $title . '列表',
            'node_parent'      => $nodeID,
            'node_msg'         => '',
            'node_method_type' => 'GET',
            'node_value'       => 'index',
            'node_check_value' => GROUP . 'GET' . ucfirst($model) . 'action',
            'node_controller'  => $nodeID,
        ]);

        //CURD节点
        $i = 1;
        foreach (['GET' => '新增/编辑', 'POST' => '请求新增', 'PUT' => '请求更新', 'DELETE' => '请求删除'] as $method => $name) {
            self::db('node')->insert([
                'node_name'        => $name . $title,
                'node_parent'      => $nodeID,
                'node_method_type' => $method,
                'node_value'       => 'action',
                'node_check_value' => GROUP . $method . ucfirst($model) . 'action',
                'node_controller'  => $nodeID,
                'node_listsort'    => $i++,
            ]);
        }

    }

    /**
     * 删除模型
     */
    public static function deleteModel($modelId) {
        return self::db('model')->where('model_id = :model_id')->delete(['model_id' => $modelId]);
    }

    /**
     * 删除模型表
     * @param type $tableName 表名
     */
    public static function alterTable($tableName) {
        $prefix = self::$modelPrefix;
        return self::db()->alter("DROP TABLE {$prefix}{$tableName}");
    }

}
