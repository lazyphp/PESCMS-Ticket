<?php
/**
 *
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\API\GET;


class Ticket extends \Core\Controller\Controller {

    /**
     * 获取个人工单列表
     */
    public function index(){

        $check = \Model\API\Member::auth();

        $condition = '';
        $param = ['member_id' => $check['member_id']];

        //状态
        if(is_numeric($_GET['status']) && $_GET['status'] >= 0  ){
            $condition .= ' AND ticket_status = :ticket_status  ';
            $param['ticket_status'] = $this->g('status');
        }

        $sql = "SELECT %s FROM {$this->prefix}ticket AS t
                LEFT JOIN {$this->prefix}ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id
                WHERE t.member_id = :member_id {$condition}
                ORDER BY t.ticket_submit_time DESC
                ";
        $result = \Model\Content::quickListContent([
            'count' => sprintf($sql, 'count(*)'),
            'normal' => sprintf($sql, 't.ticket_number, t.ticket_title, t.ticket_submit_time, t.ticket_status, tm.ticket_model_name, tm.ticket_model_cid'),
            'param' => $param,
            'page' => 15
        ]);

        $this->success([
            'msg' => '获取工单列表完成',
            'data' => [
                'list' => $result['list'],
                'ticketStatus' => \Core\Func\CoreFunc::$param['ticketStatus']
            ]
        ]);


    }

    /**
     * 获取工单详细
     */
    public function detail(){
        $check = \Model\API\Member::auth();

        $siteUrl  = \Core\Func\CoreFunc::$param['system']['domain'];

        $result = \Model\Ticket::view(100);

        if( ($result['ticket']['ticket_model_login'] == 1 && empty($check['member_id']))  ||  empty($result)   ){
            $this->error('此工单不存在。');
        }

        if($result['ticket']['member_id'] != '-1' && $result['ticket']['member_id'] != $check['member_id'] ){
            $this->error('无法查看本工单');
        }


        /**
         * 重组数据
         */
        foreach ($result['ticket'] as $key => $item){

            $newKey = str_replace(['ticket_', 'ticket_model_'], '', $key);

            //限制接口字段调用
            if(!in_array($newKey, ['id', 'number', 'title', 'model_id', 'status', 'submit_time', 'user_id', 'member_id', 'contact', 'contact_account', 'close', 'model_number', 'model_name', 'model_status', 'model_cid', 'model_explain', 'model_postscript', 'category_name'])){
                continue;
            }

            if($newKey == 'submit_time'){
                $item = date('Y-m-d H:i', $item);
            }
            
            $ticket[$newKey] = $item;
        }


        foreach ($result['form'] as $key => $item){
            if(in_array($item['ticket_form_type'], ['file', 'img', 'thumb'])){
                $item['ticket_value'] = '[文件已上传，查看原件请访问PC或者移动版。]';
            }

            $form[] = [
                'name' => $item['ticket_form_description'],
                'value' => $item['ticket_value'],
                'type'  => $item['ticket_form_type'],
            ];
        }

        foreach ($result['chat']['list'] as $key => $item){

            $content = htmlspecialchars_decode($item['ticket_chat_content']);
            
            preg_match_all('/< *img[^>]*src *= *[\"\']?([^\"\']*)/i', $content, $matches);

            //富文本图片补充完整的请求链接
            if(!empty($matches['1'])){
                foreach ($matches['1'] as $value){
                    $newImgScr[] = $siteUrl.$value;
                }
                $content = str_replace($matches['1'], $newImgScr, $content);
                $content = str_replace('<img src=', '<img width="100%;" src=', $content);
            }

            $chat[] = [
                'id' => $item['user_id'],
                'name' => $item['user_name'],
                'content' => $content,
                'time' => date('Y-m-d H:i', $item['ticket_chat_time']),
            ];
        }


        $this->success([
            'msg' => '读取工单信息完成',
            'data' => [
                'ticket' => $ticket,
                'form' => $form,
                'chat' => $chat,
                'ticketStatus' => \Core\Func\CoreFunc::$param['ticketStatus']
            ]
        ]);
    }

}