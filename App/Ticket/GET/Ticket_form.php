<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */

namespace App\Ticket\GET;

/**
 * 工单表单设置
 * Class Ticket_form
 * @package App\Ticket\GET
 */
class Ticket_form extends Content {

    private $ticket = [], $category = [];

    public function __init() {
        parent::__init();

        //输出工单的表单类型
        $form = json_decode(htmlspecialchars_decode(\Model\Content::findContent('field', '7', 'field_id')['field_option']), true);
        $form['国内地区'] = 'china_regions';
        $form['加密信息'] = 'encrypt';
        unset($form['分类']);
        $this->assign('formType', $form);

        //验证类型
        $checkType = ['不验证' => 'noVerify', '电子邮箱' => 'email', '网址' => 'url', '国内手机号码' => 'phone', '数字' => 'number', '英文' => 'english', '英文数字' => 'alphanumeric'];
        $this->assign('checkType', $checkType);

        $this->ticket = \Model\TicketModel::numberFind($_GET['number']);

        $this->category = \Model\Content::findContent('category', $_GET['cid'], 'category_id');

    }

    /**
     * 自定义工单表单列表
     */
    public function index($display = false) {

        $this->assign('addUrl', $this->url(GROUP . '-' . MODULE . '-action', array('number' => $_GET['number'], 'cid' => $_GET['cid'], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))));

        $sql = "SELECT %s FROM {$this->prefix}ticket_form WHERE ticket_form_model_id = :ticket_model_id ORDER BY ticket_form_listsort ASC, ticket_form_id DESC ";
        $result = \Model\Content::quickListContent([
            'count' => sprintf($sql, 'count(*)'),
            'normal' => sprintf($sql, '*'),
            'param' => ['ticket_model_id' => $this->ticket['ticket_model_id']]
            ]);

        $this->assign('list', $result['list']);
        $this->assign('page', $result['page']);
        $this->assign('title', "[{$this->category['category_name']}] - {$this->ticket['ticket_model_name']} - {$this->model['model_title']}");

        $this->assign('field', $this->field);

        $this->layout();
    }

    /**
     * 添加/编辑自定义工单表单
     */
    public function action($display = true) {

        //查找符合联动绑定的表单
        $param = [ 'ticket_model_id' => $this->ticket['ticket_model_id'] ];
        $condition = '';
        if(!empty($_GET['id'])){
            $param['ticket_form_id'] = $_GET['id'];
            $condition .= " AND ticket_form_id != :ticket_form_id";
        }

        $bindResult = $this->db('ticket_form')->where(" ticket_form_model_id = :ticket_model_id AND  ticket_form_type in ('radio', 'select') {$condition}")->select($param);

        //列出绑定值
        $bind = [ '正常' => '0' ];
        $bindValue = [];
        if (!empty($bindResult)) {
            foreach ($bindResult as $value) {
                $bind[$value['ticket_form_description']] = $value['ticket_form_id'];
                if(!empty($value['ticket_form_option'])){
                    $option = json_decode(htmlspecialchars_decode($value['ticket_form_option']), true);
                    if(is_array($option)){
                        $bindValue[$value['ticket_form_id']] = $option;
                    }
                }
            }
        }
        $this->assign('bind', $bind);
        $this->assign('bindValue', $bindValue);

        parent::action(false);

        $actionType = empty($_GET['id']) ? '新增' : '编辑';

        $this->assign('title', "{$actionType} - [{$this->category['category_name']}] - {$this->ticket['ticket_model_name']} - {$this->model['model_title']}");
        $this->layout();
    }

    /**
     * 验证工单表单字段名称是否重复
     */
    public function checkFieldName(){
        $field = $this->isG('field', '请提交要验证的字段');
        if(empty($this->ticket)){
            $this->error('工单模型不存在');
        }

        $check = $this->db('ticket_form')->where('ticket_form_model_id = :ticket_form_model_id AND ticket_form_name = :ticket_form_name ')->find([
            'ticket_form_model_id' => $this->ticket['ticket_model_id'],
            'ticket_form_name' => $field
        ]);

        if(!empty($check)){
            $this->error("字段{$field}已存在, 请换一个");
        }

        $this->success("字段{$field}可用");

    }

}