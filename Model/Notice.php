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

    public static function addTicketNoticeAction($number, $account, $sendType, $templateType){
        return self::db('ticket_notice_action')->insert([
            'ticket_number' => $number,
            'send_account' => $account,
            'send_type' => $sendType,
            'template_type' => $templateType,
        ]);
    }

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

//            $linkStr = "详情: ".\Model\MailTemplate::getCSViewLink($number);
//            \Model\Extra::insertSend($account, $content['title'], $content['content'].$linkStr, $type);
        }
    }

}