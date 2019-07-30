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
            case 'encrypt':
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
            case 'category':
                $category = \Model\Category::recursion(true);
                require 'theme/category.php';
                break;
            case 'ticket':
                $ticketModel = \Model\TicketModel::getTicketModelList();
                require 'theme/ticket.php';
                break;
            case $field['field_type']:
                require "theme/{$field['field_type']}.php";
                break;
        }
    }

}
