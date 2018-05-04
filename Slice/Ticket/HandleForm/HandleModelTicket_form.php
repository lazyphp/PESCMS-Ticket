<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */


namespace Slice\Ticket\HandleForm;

/**
 * 处理工单表单管理 添加/编辑 提交的表单内容
 * @package Slice\Ticket
 */
class HandleModelTicket_form extends \Core\Slice\Slice {

    public function before() {
        if (in_array(METHOD, ['POST', 'PUT'])) {
            $ticketModel = \Model\TicketModel::numberFind($_POST['number']);
            if (empty($ticketModel)) {
                $this->error('不存在的工单模型');
            }

            $_POST['model_id'] = (string)$ticketModel['ticket_model_id'];
            $_POST['option'] = (string)\Model\Field::splitOption($this->p('option'));
        }
    }

    public function after() {
    }


}