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

    /**
     * 添加通知客服的待发送消息
     * @param array $user
     * @param array $content
     */
    public static function addCSNotice(array $user, array $content){
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
            \Model\Extra::insertSend($account, $content['title'], $content['content'], $type);
        }
    }

}