<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model;

/**
 * 字段模型
 */
class Field extends \Core\Model\Model {

    public static $model;

    /**
     * 列出对应的模型的字段
     * @param type $modelId 模型ID
     * @param array $condition 筛选条件| 字段名称 => 匹配值
     * @return type
     */
    public static function fieldList($modelId, array $condition = array()) {
        $where = "field_model_id = :model_id ";
        $data = array('model_id' => $modelId);
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                $where .= " AND {$key} = :{$key}";
                $data[$key] = $value;
            }
        }
        return self::db('field')->where($where)->order('field_listsort asc, field_id asc')->select($data);
    }

    /**
     * 查找字段
     */
    public static function findField($fieldId) {
        return self::db('field')->where('field_id = :field_id')->find(array('field_id' => $fieldId));
    }

    /**
     * 查找对应模型表的字段
     */
    public static function findTableField($tableName, $fieldName) {
        $tableName = strtolower($tableName);
        $fieldList = self::db()->getAll("show columns from `" . self::$modelPrefix . "{$tableName}`");
        if (!empty($fieldList)) {
            foreach ($fieldList as $value) {
                if ($value['Field'] == "{$tableName}_{$fieldName}") {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 移除字段表的字段
     */
    public static function removeField($fieldId) {
        return self::db('field')->where('field_id = :field_id')->delete(array('field_id' => $fieldId));
    }

    /**
     * 执行移除表字段的动作
     * @param type $model 模型名称
     * @param type $fieldName 待移除的字段名称
     * @return type 返回执行结果
     */
    public static function alertTableField($model, $fieldName) {
        $model = strtolower($model);
        $prefix = self::$modelPrefix;
        return self::db()->alter("ALTER TABLE `{$prefix}{$model}` DROP `{$model}_$fieldName`;");
    }

    /**
     * 插入字段
     */
    public static function addField($fieldID) {

        $fieldType = self::returnFieldType($_POST['type']);
        $alterTableResult = self::addTableField(self::$model['model_name'], self::p('name'), $fieldType);

        if ($alterTableResult === FALSE) {
            self::removeField($fieldID);
            self::error('添加字段失败');
        }
    }

    /**
     * 执行插入字段
     */
    public static function addTableField($model, $fieldName, $fieldType) {
        $model = strtolower($model);
        return self::db()->alter("ALTER TABLE `" . self::$modelPrefix . "{$model}` ADD `{$model}_{$fieldName}`  {$fieldType} NOT NULL ;");
    }

    /**
     * 返回创建字段的类型
     */
    private static function returnFieldType($type) {

        switch ($type) {
            case 'text':
            case 'checkbox':
            case 'thumb':
                return ' VARCHAR( 255 ) ';

            case 'textarea':
            case 'editor':
            case 'img':
            case 'file':
                return ' TEXT ';

            case 'category':
            case 'select':
            case 'radio':
            default:
                return ' INT(11) ';
        }
    }

    /**
     * 基础表单
     */
    public static function baseForm() {

        if (!self::$model = \Model\ModelManage::findModel(self::isP('model_id', '丢失模型ID'))) {
            self::error('不存在的模型');
        }

        $option = self::splitOption(self::p('option'));

        if ($option === false) {
            self::error('拆分字段选项出错');
        }
        $_POST['option'] = (string) $option;
    }

    /**
     * 拆分选项值，返回为一个数组
     * @param $fieldOption 提交过来的选项值， 以：名称|值 提交的字符串
     * @return json
     */
    public static function splitOption($fieldOption) {
        if (!empty($fieldOption)) {
            $splitNewline = explode("\n", $fieldOption);
        } else {
            return '';
        }
        foreach ($splitNewline as $value) {
            $splitOption[] = explode("|", $value);
            foreach ($splitOption as $key => $value) {
                $option[$value[0]] = str_replace("\r", "", $value[1]);
            }
        }
        if (!is_array($option)) {
            return false;
        }
        return json_encode($option);
    }

    /**
     * 移除模型字段
     * @param type $modelId 模型 ID
     */
    public static function deleteModelField($modelId) {
        return self::db('field')->where('field_model_id = :model_id')->delete(array('model_id' => $modelId));
    }

}
