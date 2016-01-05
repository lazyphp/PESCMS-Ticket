<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Ticket\GET;

/**
 * 字段管理
 */
class Field extends Content {

    public function index(){
        $model_id = $this->isG('model_id', '请选择您要查看的模型字段');

        $param = ['field_model_id' => $model_id];
        $condition = 'field_model_id = :field_model_id';
        if(!empty($_GET['keyword'])){
            $param['field_name'] = $param['field_display_name'] = "%{$_GET['keyword']}%";
            $condition .= ' AND ( field_name LIKE :field_name OR field_display_name LIKE :field_display_name )';
        }

        $list = \Model\Content::listContent([
            'table' => 'field',
            'condition' => $condition,
            'order' => 'field_listsort ASC, field_id DESC',
            'param' => $param
        ]);

        $this->assign('addUrl', $this->url(GROUP . '-' . MODULE . '-action', array('model_id' => $model_id ,'back_url' => base64_encode($_SERVER['REQUEST_URI']))));
        $this->assign('list', $list);
        $this->assign('title', $this->model['model_title']);
        $this->assign('field', $this->field);
        $this->assign('operate', is_file("{$this->modelThemePrefixPath}_index_operate.php") ? '/'.MODULE.'/'.MODULE."_index_operate.php" : '');
        $this->assign('listsort', true);

        $this->layout();
    }

}
