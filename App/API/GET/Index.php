<?php
/**
 *
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\API\GET;

use Model\Content;

class Index extends \Core\Controller\Controller {

    public function index(){

        $result = \Model\Category::getCategoryORTicketList();
        if(empty($result)){
            $this->error('获取工单列表失败');
        }else{
            $this->success(['msg' => '获取工单列表完成', 'data' => $result]);
        }
    }

    /**
     * 获取对应工单的信息
     */
    public function ticketForm(){

        $check = \Model\API\Member::auth();

        $number = $this->isG('number', '请提交您要生成的工单');
        $result = \Model\TicketForm::getFormWithNumber($number);


        //@todo 指定客户组可见工单
        \Model\Ticket::organizeCheck(current($result), $check['member_organize_id']);


        if(empty($result)){
            $this->error('此工单目前还没内容');
        }

        if($result['0']['ticket_model_login'] == 1 && empty($check['member_id'])){
            $this->error('当前需要登录账号才可以提交本工单');
        }


        $field = [];
        $ticketInfo = [];
        $sortField = [];
        foreach ($result as $key => $value) {
            $ticketInfo = [
                'title' => $value['ticket_model_name'],
                'number' => $value['ticket_model_number'],
                'login' => $value['ticket_model_login'],
                'ticket_model_login' => $value['ticket_model_login'],
                'verify' => $value['ticket_model_verify'],
                'cid' => $value['ticket_model_cid'],
                'contact' => explode(',', $value['ticket_model_contact']),
                'contact_default' => (string) $value['ticket_model_contact_default'],
                'postscript' => $value['ticket_model_postscript'],
                'exclusive' => $value['ticket_model_exclusive'],
                'organize_id' => $value['ticket_model_organize_id'],
                'title_description' => !empty($value['ticket_model_title_description']) ? explode('|', $value['ticket_model_title_description']) : ['工单标题', '简单扼要描述本次工单遇到的问题'] ,
            ];
            $field[$value['ticket_form_id']] = [
                'id' => $value['ticket_form_id'],
                'field_name' => $value['ticket_form_name'],
                'field_display_name' => $value['ticket_form_description'],
                'field_type' => $value['ticket_form_type'],
                'field_option_str' => htmlspecialchars_decode($value['ticket_form_option']),
                'field_option' => json_decode(htmlspecialchars_decode($value['ticket_form_option']), true),
                'field_option_key' => array_keys(json_decode(htmlspecialchars_decode($value['ticket_form_option']), true)),
                'field_required' => $value['ticket_form_required'],
                'field_explain' => $value['ticket_form_explain'],
                'field_status' => $value['ticket_form_status'],
                'field_bind' => $value['ticket_form_bind'],
                'field_bind_value' => $value['ticket_form_bind_value'],
                'field_postscript' => strip_tags(htmlspecialchars_decode($value['ticket_form_postscript'])),
                
            ];
            $sortField['sort'][$value['ticket_form_id']] = $value['ticket_form_listsort'];
            $sortField['id'][$value['ticket_form_id']] = $value['ticket_form_id'];
        }

        //保持设置的排序顺序
        array_multisort($sortField['sort'], SORT_ASC, $sortField['id'], SORT_DESC, $field);

        $ticketInfo['category'] = \Model\Content::findContent('category', $ticketInfo['cid'], 'category_id');

        $this->success([
            'msg' => '获取工单成功',
            'data' => [
                'ticket' => $ticketInfo,
                'field' => $field,
                'phone' => $check['member_phone'],
                'email' => $check['member_email']
            ]
        ]);

        
    }

    /**
     * 获取微信小程序订阅消息模板ID
     */
    public function getTemplateID(){
        $list = $this->db('mail_template')->field('mail_template_wxapp_template_id, mail_template_type')->select();
        $template = [];
        if(!empty($list)){
            foreach ($list as $item){
                $template[$item['mail_template_type']] = $item['mail_template_wxapp_template_id'];
            }
        }

        $this->success(['msg' =>'获取订阅信息完成', 'data' => $template]);
    }

}