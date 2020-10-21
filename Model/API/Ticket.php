<?php

/**
 *
 * Copyright (c) 202 PESCMS (https://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model\API;

/**
 * API 用户模型
 */
class Ticket extends \Core\Model\Model {

    public static function insert(){

        $check = \Model\API\Member::auth();

        if($_POST['contact'] == 6){
            $_POST['contact_account'] = $check['member_wxapp'];
        }

        $result = \Model\Ticket::getSubmitTicketBase();
        $field = $result['field'];
        $firstContent = $result['firstContent'];
        $param = $result['param'];

        if($firstContent['ticket_model_login'] == 1 && empty($check['member_id'])){
            self::error('当前需要登录账号才可以提交本工单');
        }


        $param['member_id'] = empty($check['member_id']) ? '-1' : $check['member_id'];

        $param = array_merge($param, \Model\Ticket::csInfoParam($firstContent));

        \Model\Ticket::createTicket($param, $field, $firstContent);

        return $param;

    }

}