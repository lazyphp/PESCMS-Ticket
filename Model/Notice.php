<?php

/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model;

/**
 * 消息模型
 */
class Notice extends \Core\Model\Model {

    public static function addNotice(){

    }

    /**
     * 生成工作消息通知发送动作
     * @param $number 工单单号
     * @param $account 接收通知的帐号
     * @param $sendType 发送方式
     * @param $templateType 发送模版类型 | 负数则表示为 客服用的消息
     * @return mixed
     */
    public static function addTicketNoticeAction($number, $account, $sendType, $templateType){
        return self::db('ticket_notice_action')->insert([
            'ticket_number' => $number,
            'send_account' => $account,
            'send_type' => $sendType,
            'template_type' => $templateType,
        ]);
    }

    /**
     * 添加客服消息通知
     * @param $number 工单单号
     * @param array $user 客服帐号信息
     * @param $templateType 模版类型
     */
    public static function addCSNotice($number, array $user, $templateType){
        $cs_notice_type = json_decode(\Core\Func\CoreFunc::$param['system']['cs_notice_type'], true);
        foreach ($cs_notice_type as $type){
            if($type == 4 && empty($user['user_weixinWork']) ){
                continue;
            }
            switch ($type){
                case 1:
                    $account = $user['user_mail'];
                    break;
                case 4:
                    $account = $user['user_weixinWork'];
                    break;
            }

            self::addTicketNoticeAction($number, $account, $type, $templateType);
        }
    }

    /**
     * 插入客户消息通知
     * @param array $param 动作参数
     */
    public static function insertMemberNoticeSendTemplate(array $param){
        $title = \Model\MailTemplate::matchTitle($param['ticket_number'], $param['template_type']);
        $content = \Model\MailTemplate::matchContent([
            'number' => $param['ticket_number'],
            'view' => \Model\MailTemplate::getViewLink($param['ticket_number'])
        ], $param['template_type']);

        if(\Model\Extra::insertSend($param['send_account'], $title[$param['send_type']], $content[$param['send_type']], $param['send_type'])){
            self::db('ticket_notice_action')->where('action_id = :action_id')->delete([
                'action_id' => $param['action_id']
            ]);
        }
    }

    /**
     * 插入客服消息通知
     * @param array $param 动作参数
     */
    public static function insertCSNoticeSendTemplate(array $param){
        if(empty($ticket[$param['ticket_number']])){
            $ticket[$param['ticket_number']] = \Model\Ticket::getTicketBaseInfo($param['ticket_number']);
        }

        switch (abs($param['template_type'])){
            case '1':
                $title = '新工单提醒';
                $content = "工单《{$ticket[$param['ticket_number']]['ticket_model_name']}》有新工单: {$param['ticket_number']},请及时处理!";
                break;
            case '2':
                break;
            case '3':
                $title = '客户回复工单提醒';
                $content = "工单《{$ticket[$param['ticket_number']]['ticket_title']}》有新回复! 单号:{$ticket['ticket_number']},请跟进!";
                break;
            case '4':
                $title = '工单转交通知';
                $content = self::session()->get('ticket')['user_name']."将工单《{$ticket[$param['ticket_number']]['ticket_title']}》指派给了您，单号：{$param['ticket_number']}，请您协助他/她尽快解决该工单问题。";
                break;
            case '5':
                break;
            case '6':
                break;
            case '504':
                $title = '工单超时提醒';
                $timeOut = (1 + $ticket[$param['ticket_number']]['ticket_time_out_sequence']) * $ticket[$param['ticket_number']]['ticket_model_time_out'] ;
                $content = "工单单号：{$param['ticket_number']}，《{$ticket[$param['ticket_number']]['ticket_title']}》已在{$timeOut}分钟内无人受理，请您收到本消息后，尽快处理客户提交的问题。";
                break;
        }

        //工单处理的超链接
        $linkStr = "详情: ".\Model\MailTemplate::getCSViewLink($param['ticket_number']);

        //发送方式是邮件，则加载邮件模板
        if($param['send_type'] == 1){
            $content = \Model\MailTemplate::mergeMailTemplate($content.$linkStr);
        }else{
            $content = $content.$linkStr;
        }

        //生成数据完毕，删除动作
        if(\Model\Extra::insertSend($param['send_account'], $title, $content, $param['send_type'])){
            self::db('ticket_notice_action')->where('action_id = :action_id')->delete([
                'action_id' => $param['action_id']
            ]);
        }
    }

}