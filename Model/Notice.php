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

        $content = \Model\MailTemplate::matchContent($param['ticket_number'], $param['template_type']);

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

        $dictionary = \Model\MailTemplate::ticketDictionary($param['ticket_number']);

        $csTemplateList = \Model\Content::listContent(['table' => 'cssend_template']);
        foreach ($csTemplateList as $item){
            $csTemplate[$item['cssend_template_type']] = $item;
        }

        if(empty( $csTemplate[abs($param['template_type'])] )){
            return false;
        }

        $title = str_replace($dictionary['search'], $dictionary['replace'], $csTemplate[abs($param['template_type'])]['cssend_template_title']);

        //@todo 工单转交通知 待验证模板是否正常
        $content = str_replace($dictionary['search'], $dictionary['replace'], $csTemplate[abs($param['template_type'])]['cssend_template_content']);

        //发送方式是邮件，则加载邮件模板
        if($param['send_type'] == 1){
            $content = \Model\MailTemplate::mergeMailTemplate($content);
        }

        //生成数据完毕，删除动作
        if(\Model\Extra::insertSend($param['send_account'], $title, $content, $param['send_type'])){
            self::db('ticket_notice_action')->where('action_id = :action_id')->delete([
                'action_id' => $param['action_id']
            ]);
        }
    }

}