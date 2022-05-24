<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace App\Ticket\GET;

class Fqa extends Content {

    public function index($display = true) {
        $ticketModel = \Model\TicketModel::getTicketModelList();
        $this->assign('ticketModel', $ticketModel);

        if(!empty($_GET['ticket_model_id'])){
            $this->condition .= ' AND fqa_ticket_model_id = :ticket_model_id ';
            $this->param['ticket_model_id'] = $this->g('ticket_model_id');
        }
        parent::index($display);
    }

}