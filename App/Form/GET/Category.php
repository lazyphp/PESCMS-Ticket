<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */

namespace App\Form\GET;

class Category extends \Core\Controller\Controller{

    private $domain = '';

    /**
     * 工单分类
     */
	public function index(){

		$id = $this->g('id');
		$param['category_parent'] = empty($id) ? 0 : $id;

		$category = \Model\Content::listContent([
			'table' => 'category',
			'condition' => 'category_parent = :category_parent AND category_status = 1',
			'order' => 'category_listsort ASC, category_id DESC',
			'param' => $param
		]);

		if(!empty($id)){
			$ticketList = \Model\Content::listContent([
				'table' => 'ticket_model',
				'condition' => 'ticket_model_cid = :id AND ticket_model_status = 1',
				'order' => 'ticket_model_listsort ASC, ticket_model_id DESC',
				'param' => [
					'id' => $id
				]
			]);
			$this->assign('ticket', $ticketList);
		}
        $this->assign('title', '提交工单');
		$this->assign('category', $category);

        $this->displayTicket();


	}

    /**
     * 显示提交工单列表
     * @description 当GET参数new_index存在时且是后台已登陆，则对工单列表进行一次模板HTML缓存记录。
     */
	private function displayTicket(){
        //首页工单模板缓存文件生成
        if(!empty($_GET['new_index']) && !empty($this->session()->get('ticket')) ){
            ob_start();
            $this->layout('Category_index', 'Category_layout');
            $indexHtml = ob_get_contents();
            ob_clean();
            $fopen = fopen(THEME_PATH.'/Index/Index_ticket.php', 'w');
            fwrite($fopen, $indexHtml);
            fclose($fopen);

            $url = empty($_GET['back_url']) ? $this->url('Ticket-Setting-action') : base64_decode($_GET['url']);

            $this->success('首页工单样式已更新', $url);
        }elseif(!empty($_GET['new_index']) && empty($this->session()->get('ticket')) ){
            $this->_404();
        }else{
            $this->layout('Category_index', 'Category_layout');
        }
    }

    /**
     * 创建工单
     */
	public function ticket(){
        $number = $this->isG('number', '请提交您要生成的工单');
        $result = \Model\TicketForm::getFormWithNumber($number);

        \Model\Ticket::organizeCheck(current($result));


        if(empty($result)){
            $this->_404(false, '此工单目前还没内容!');
        }


        $field = [];
        $ticketInfo = [];
        foreach ($result as $key => $value) {
            $ticketInfo = [
                'title' => $value['ticket_model_name'],
                'number' => $value['ticket_model_number'],
                'login' => $value['ticket_model_login'],
                'verify' => $value['ticket_model_verify'],
                'cid' => $value['ticket_model_cid'],
                'contact' => $value['ticket_model_contact'],
                'contact_default' => $value['ticket_model_contact_default'],
                'postscript' => $value['ticket_model_postscript'],
                'exclusive' => $value['ticket_model_exclusive'],
                'organize_id' => $value['ticket_model_organize_id'],
            ];
            $field[$value['ticket_form_id']] = [
                'field_name' => $value['ticket_form_name'],
                'field_display_name' => $value['ticket_form_description'],
                'field_type' => $value['ticket_form_type'],
                'field_option' => htmlspecialchars_decode($value['ticket_form_option']),
                'field_required' => $value['ticket_form_required'],
                'field_explain' => $value['ticket_form_explain'],
                'field_status' => $value['ticket_form_status'],
                'field_bind' => $value['ticket_form_bind'],
                'field_bind_value' => $value['ticket_form_bind_value'],
                'field_postscript' => $value['ticket_form_postscript'],
            ];
        }

        //检查是否开启登录验证
        if($ticketInfo['login'] == 1 && empty($this->session()->get('member'))){
            $this->jump($this->url('Login-index', ['back_url' => base64_encode($_SERVER['REQUEST_URI'])]));
        }

        $ticketInfo['category'] = \Model\Content::findContent('category', $ticketInfo['cid'], 'category_id');
        $this->assign('title', $ticketInfo['title']);
        $this->assign('ticketInfo', $ticketInfo);
        $this->assign('field', $field);

        //@todo 现阶段只有三种联系方式，因此暂时用代码写死的形式展示
        $this->assign('contact', [
            '1' => [
                'title' => '电子邮件',
                'key' => 'member_email'
            ],
            '2' => [
                'title' => '手机号码',
                'key' => 'member_phone'
            ],
            '3' => [
                'title' => '微信',
                'key' => 'member_weixin'
            ],
        ]);

        $this->assign('member', $this->session()->get('member'));

        $this->domain = \Model\Content::findContent('option', 'domain', 'option_name')['value'];
        $this->assign('domain', $this->domain);
        if(ACTION == 'ticket'){
            $this->layout('Category_ticket', 'Category_layout');
        }
	}

    /**
     * 创建JS
     */
	public function createJS(){
	    if(empty($this->session()->get('ticket'))){
	        $this->_404();
        }
	    $this->ticket();
        ob_start();
	    $this->display('Category_ticket');
        $javascript = "var formString = '" . addslashes(preg_replace("/\\n||\\r||\\n\\r/m ", '', ob_get_contents())) . "'\n";
        ob_clean();
        $javascript .= str_replace('{domain}', $this->domain, file_get_contents(THEME_PATH . '/Category/create_js.js'));

        header("Content-type: text/html; charset=utf-8");
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename=PESCMS_Ticket.js');
        echo $javascript;

    }

}