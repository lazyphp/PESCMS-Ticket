<?php

namespace App\Ticket\GET;

/**
 * 公用内容删除方法
 */
class Content extends \App\Ticket\Common {

    protected $model, $table, $fieldPrefix, $field = [], $modelThemePrefixPath;

    public function __init() {
        parent::__init();

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
    public function index() {
        $condition = "";
        $param = array();

        //排序条件
        $orderBy = "{$this->fieldPrefix}id DESC";
        foreach ($this->field as $key => $value) {
            if (!empty($_GET['keyword'])) {
                $keyword = $this->g('keyword');
                if (empty($condition)) {
                    $condition .= " {$this->fieldPrefix}{$value['field_name']} LIKE :{$value['field_name']} ";
                } else {
                    $condition .= " OR {$this->fieldPrefix}{$value['field_name']} LIKE :{$value['field_name']} ";
                }
                $param[$value['field_name']] = "%{$keyword}%";
            }
            //判断是否存在排序字段
            if ($value['field_name'] == 'listsort') {
                $orderBy = "{$this->fieldPrefix}listsort ASC, {$orderBy}";
                $this->assign('listsort', true);
                unset($this->field[$key]);
            }
        }

        $pageNameSpace = "\\Expand\\Page";
        $page = new $pageNameSpace();
        $total = count($this->db($this->table)->where($condition)->select($param));
        $count = $page->total($total);
        $page->handle();
        $list = $this->db($this->table)->where($condition)->order($orderBy)->limit("{$page->firstRow}, {$page->listRows}")->select($param);
        $show = $page->show();
        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->assign('title', $this->model['model_title']);
        $this->assign('field', $this->field);

        $this->assign('operate', is_file("{$this->modelThemePrefixPath}_index_operate.php") ? '/'.MODULE.'/'.MODULE."_index_operate.php" : '');


        $this->layout(is_file("{$this->modelThemePrefixPath}_index.php") ? MODULE . "_index" : 'Content_index');
    }

    /**
     * 添加/编辑内容
     */
    public function action() {

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

        $this->layout(is_file("{$this->modelThemePrefixPath}_action.php") ? MODULE . "_action" : 'Content_action');
    }

}
