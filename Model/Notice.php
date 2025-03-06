<?php

/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model;

/**
 * 消息模型
 */
class Notice extends \Core\Model\Model {

    /**
     * 执行通知发送
     */
    public static function sendNotice() {

        //删除7天发送失败和成功的记录
        self::db('send')->where('send_time < :time AND send_status > 0')->delete([
            'time' => time() - 86400 * 7,
        ]);

        //获取未发送或者重发少于5次的通知
        $list = \Model\Content::listContent([
            'table'     => 'send',
            'condition' => "send_time <= :time AND send_status < 2 AND send_sequence < 5 ",
            'lock'      => 'FOR UPDATE',
            'param'     => [
                'time' => time(),
            ],
        ]);

        foreach ($list as $value) {
            switch ($value['send_type']) {
                case '1':
                    $result = (new \Expand\Notice\Mail())->send($value);
                    break;
                case '2':
                    $result = (new \Expand\SMS\SMSMain())->send($value);
                    break;
                case '3':
                    $result = (new \Expand\weixin())->sendTemplate($value);
                    break;
                case '4':
                    $result = (new \Expand\weixinWork())->send_notice($value);
                    break;
                case '5':
                    $result = (new \Expand\dingtalk())->send_notice($value);
                    break;
                case '6':
                    $result = (new \Expand\wxapp())->send($value);
                    break;
                default:
                    //给予一个其他通知的扩展入口
                    $result = (new \Expand\OtherNotice())->send($value);
            }

            if (DEBUG == true) {
                echo "<p>{$value['send_type']}T: {$result['msg']}, 详细JSON格式: " . json_encode($result, JSON_UNESCAPED_UNICODE) . "</p>";
            }

        }
    }

    /**
     * 因配置等信息，直接终止发送
     * @param $sendID
     * @param $msg
     */
    public static function stopSend($sendID, $msg) {
        \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->update([
            'noset'         => [
                'send_id' => $sendID,
            ],
            'send_result'   => $msg,
            'send_status'   => 1,
            'send_sequence' => 5,
        ]);
    }

    /**
     * 生成工作消息通知发送动作
     * @param $number 工单单号
     * @param $account 接收通知的账号
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
     * @param array $user 客服账号信息
     * @param $templateType 模版类型
     */
    public static function addCSNotice($number, array $user, $templateType){
        $cs_notice_type = json_decode(\Core\Func\CoreFunc::$param['system']['cs_notice_type'], true);

        foreach ($cs_notice_type as $type){
            switch ($type){
                case 1:
                    $account = $user['user_mail'];
                    break;
                case 4:
                    $account = $user['user_weixinWork'];
                    break;
                case 5:
                    $account = $user['user_dingtalk'];
                    break;
            }

            if(empty($account)){
                continue;
            }

            self::addTicketNoticeAction($number, $account, $type, $templateType);
        }

        //生成站内消息
        \Model\CSnotice::addCSNotice($number, $user['user_id'], $templateType);

    }

    /**
     * 插入客户消息通知
     * @param array $param 动作参数
     */
    public static function insertMemberNoticeSendTemplate(array $param){

        if($param['send_type'] >= 1 && $param['send_type'] <= 6){
            $title = \Model\MailTemplate::matchTitle($param['ticket_number'], $param['template_type']);

            $content = \Model\MailTemplate::matchContent($param['ticket_number'], $param['template_type']);
        }else{
            $otherNotice = new \Expand\OtherNotice();
            $title = $otherNotice->matchTitle($param);
            $content = $otherNotice->matchTitle($param);
            if($otherNotice->removeTicketNoticeAction == true){
                goto removeAction;
            }
        }

        if(\Model\Extra::insertSend($param['send_account'], $title[$param['send_type']], $content[$param['send_type']], $param['send_type'])){
            removeAction:
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