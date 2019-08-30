<?php

namespace App\Ticket\GET;

/**
 * 公用内容列表
 */
class Content extends \Core\Controller\Controller {

    protected $model, $table, $fieldPrefix, $field = [], $modelThemePrefixPath, $condition = '1 = 1', $param = [], $page, $sortBy;

    public function __init() {
        parent::__init();
        $pageNameSpace = "\\Expand\\Page";
        $this->page = new $pageNameSpace();
        //表名
        $this->table = strtolower(MODULE);

        //表前缀
        $this->fieldPrefix = $this->table . "_";
        $this->assign('fieldPrefix', $this->fieldPrefix);

        //验证模型是否存在
        $this->model = \Model\ModelManage::findModel($this->table, 'model_name');
        if (empty($this->model)) {
            $this->error('不存在的模型');
        }

        $this->modelThemePrefixPath = THEME_PATH.'/'.MODULE.'/'.MODULE;


        //获取模型的字段列表
        $fieldShowType = ACTION == 'index' ? 'field_list' : 'field_form';
        $this->field = \Model\Field::fieldList($this->model['model_id'], ['field_status' => '1', $fieldShowType => '1']);
    }

    /**
     * 内容列表
     */
    public function index($display = true) {

        //排序条件
        $orderBy = "{$this->fieldPrefix}id DESC";
        foreach ($this->field as $key => $value) {
            if (!empty($_GET['keyword'])) {
                $keyword = $this->g('keyword');
                $conditionArray[] = " {$this->fieldPrefix}{$value['field_name']} LIKE :{$value['field_name']} ";
                $this->param[$value['field_name']] = "%{$keyword}%";
            }
            //判断是否存在排序字段
            if ($value['field_name'] == 'listsort') {
                $orderBy = "{$this->fieldPrefix}listsort ASC, {$orderBy}";
                $this->assign('listsort', true);
                unset($this->field[$key]);
            }
        }

        if (!empty($conditionArray)) {
            $this->condition .= ' AND ('.implode(' OR ', $conditionArray).')';
        }

        //若定义了自定义排序，则覆写默认的排序方式
        if(!empty($this->sortBy)){
            $orderBy = $this->sortBy;
        }


        $total = count($this->db($this->table)->where($this->condition)->select($this->param));
        $this->page->listRows = $this->model['model_page'];
        $count = $this->page->total($total);
        $this->page->handle();
        $list = $this->db($this->table)->where($this->condition)->order($orderBy)->limit("{$this->page->firstRow}, {$this->page->listRows}")->select($this->param);
        $show = $this->page->show();
        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->assign('title', $this->model['model_title']);
        $this->assign('field', $this->field);

        //加载列表自定义的工具栏
        $this->assign('tool_column', is_file("{$this->modelThemePrefixPath}_index_tool.php") ? "{$this->modelThemePrefixPath}_index_tool.php" : THEME_PATH . "/Content/Content_index_tool.php");

        //加载列表操作按钮
        $this->assign('operate', is_file("{$this->modelThemePrefixPath}_index_operate.php") ? '/' . MODULE . '/' . MODULE . "_index_operate.php" : '');


        if ($display === true) {
            $this->layout(is_file("{$this->modelThemePrefixPath}_index.php") ? MODULE . "_index" : 'Content_index');
        }
    }

    /**
     * 添加/编辑内容
     */
    public function action($display = true) {

        $id = $this->g('id');
        if (empty($id)) {
            $this->assign('method', 'POST');
            $this->assign('title', "添加 - {$this->model['model_title']}");
        } else {
            $content = \Model\Content::findContent($this->table, $id, "{$this->fieldPrefix}id");
            if (empty($content)) {
                $this->error('不存在的内容');
            }
            $this->assign($content);
            $this->assign('method', 'PUT');
            $this->assign('id', $id);
            $this->assign('title', "编辑 - {$this->model['model_title']}");

            foreach ($this->field as $key => $value) {
                $this->field[$key] = $value;
                $this->field[$key]['field_option'] = $value['field_option'];
                $this->field[$key]['value'] = $content["{$this->fieldPrefix}{$value['field_name']}"];
            }
        }

        $this->assign('field', $this->field);
        $this->assign('form', new \Expand\Form\Form());

        if ($display === true) {
            $this->layout(is_file("{$this->modelThemePrefixPath}_action.php") ? MODULE . "_action" : 'Content_action');
        }
    }

}
