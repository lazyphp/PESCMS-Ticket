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
 * 字段模型
 */
class Field extends \Core\Model\Model {

    public static $model;

    private static $findFieldResult;

    /**
     * 列出对应的模型的字段
     * @param $modelId 模型ID
     * @param $condition 筛选提交
     * @param array $param 占位符数组
     * @return mixed
     */
    public static function fieldList($modelId, $condition, array $param = []) {
        $where = "field_model_id = :model_id ";
        $data = array_merge(['model_id' => $modelId], $param);
        $where.= $condition;

        return self::db('field')->where($where)->order('field_listsort ASC, field_id DESC')->select($data);
    }


    /**
     * 快速查找字段
     * @param $fieldId 字段ID
     * @param bool $link 是否连贯操作. 有 deFieldOptionToArray
     * @return static
     */
    public static function findField($fieldId, $link = false) {
        self::$findFieldResult =  self::db('field')->where('field_id = :field_id')->find(array('field_id' => $fieldId));
        return $link == true ? new static() : self::$findFieldResult ;
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
        $isNull = $_POST['is_null'] == 0 ? 'NOT NULL' : 'NULL';
        return self::db()->alter("ALTER TABLE `" . self::$modelPrefix . "{$model}` ADD `{$model}_{$fieldName}`  {$fieldType['TYPE']} {$isNull} {$fieldType['DEFAULT']};");
    }

    /**
     * 返回创建字段的类型
     */
    private static function returnFieldType($type) {

        switch ($type) {
            case 'text':
            case 'checkbox':
            case 'thumb':
            case 'theme':
            case 'author':
            case 'multiple':
                return ['TYPE' => ' VARCHAR( 255 ) ', 'DEFAULT' => " DEFAULT '' "];
            case 'color':
                return ['TYPE' => ' VARCHAR( 8 ) ', 'DEFAULT' => " DEFAULT '' "];
            case 'icon':
                return ['TYPE' => ' VARCHAR( 32 ) ', 'DEFAULT' => " DEFAULT '' "];
            case 'textarea':
            case 'editor':
            case 'img':
            case 'file':
                return ['TYPE' => ' TEXT ', 'DEFAULT' => ""];

            case 'category':
            case 'select':
            case 'radio':
            default:
                return ['TYPE' => ' INT(11) ', 'DEFAULT' => " DEFAULT '0' "];
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
        $_POST['option'] = (string)$option;
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
        foreach ($splitNewline as $item) {
            $splitOption = explode("|", $item);
            $option[$splitOption[0]] = str_replace("\r", "", $splitOption[1]);
        }

        if (!is_array($option)) {
            return false;
        }
        return json_encode($option);
    }

    /**
     * 新的拆分选项值方法，返回为一个数组
     * @param $optionName 选项表单名称
     * @return json
     */
    public static function newSplitOption($optionName){
        $display = $_POST["{$optionName}_display"];
        $value = $_POST["{$optionName}_value"];

        if(empty($display) || empty($value)){
            return false;
        }

        if(count($display) != count($value)){
            self::error('选项值的显示名称与值长度不一致.');
        }

        $option = [];

        foreach ($display as $key => $item){
            $option[$item] = $value[$key];
        }

        return json_encode($option);
    }

    public static function deFieldOptionToArray(){
        return json_decode(htmlspecialchars_decode(self::$findFieldResult['field_option']), true);
    }

    /**
     * 移除模型字段
     * @param type $modelId 模型 ID
     */
    public static function deleteModelField($modelId) {
        return self::db('field')->where('field_model_id = :model_id')->delete(array('model_id' => $modelId));
    }

    /**
     * 基于选项内容返回对应选项的名称
     * @param $optionValue 选项值
     * @param $optionJSON 选项的JSON设置
     * @return bool|string
     */
    public static function getFieldOptionToMatch($optionValue, $optionJSON){
        $option = json_decode(htmlspecialchars_decode($optionJSON), true);

        $splitValue = explode(',', trim($optionValue, ','));

        $search = [];
        foreach ($splitValue as $item){
            if(empty($item) && !is_numeric($item) ){
                continue;
            }
            $tmp = array_search($item, $option);
            $search[] = $tmp;
            if(empty($tmp)){
                return NULL;
            }
        }

        return implode(', ', $search);
    }

}
