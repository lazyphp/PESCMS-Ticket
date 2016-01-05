<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Expand\Form;

/**
 * 智能表单生成扩展
 */
class Form {

    /**
     * 生成对应的HTML表单内容
     * @param type $field 提交过来的字段
     */
    public function formList($field) {
        switch ($field['field_type']) {
            case 'text':
                require 'theme/text.php';
                break;
            case 'textarea':
                require 'theme/textarea.php';
                break;
            case 'editor':
                /**
                 * 将属于必填项的表单名称写入数组
                 * 在模板的底部进行一个JS的校验.
                 */
                static $checkEditor, $checkEditorName;
                if ($field['field_required'] == '1') {
                    /* 表单名称 */
                    $checkEditor[] = $field['field_name'];
                    /* 显示名称 */
                    $checkEditorName[] = $field['field_display_name'];
                }
                require 'theme/editor.php';
                break;
            case 'date':
                require 'theme/date.php';
                break;
            case 'radio':
                require 'theme/radio.php';
                break;
            case 'checkbox':
                require 'theme/checkbox.php';
                break;
            case 'thumb':
                require 'theme/thumb.php';
                break;
            case 'category':
                \Model\Category::$where = 'm.model_name = "' . MODULE . '"';
                $tree = \Model\Category::getSelectCate($field['value'] ? array($field['value']) : array(), true);
                require 'theme/category.php';
                break;
            case 'select':
                require 'theme/select.php';
                break;
            case 'file':
                require 'theme/file.php';
                break;
            case 'img':
                require 'theme/img.php';
                break;
        }
    }

}
