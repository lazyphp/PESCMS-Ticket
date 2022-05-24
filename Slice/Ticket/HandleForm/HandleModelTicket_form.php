<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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
            $_POST['option'] = (string)\Model\Field::newSplitOption('option');
        }
    }

    public function after() {
    }


}