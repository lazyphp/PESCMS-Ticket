<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
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