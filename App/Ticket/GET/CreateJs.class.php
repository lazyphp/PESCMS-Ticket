<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */

namespace App\Ticket\GET;


class CreateJs extends \App\Ticket\Common{

    /**
     * 生成JS
     */
    public function action(){
        $number = $this->isG('number', '请提交您要生成的工单');
        $ticket = \Model\TicketForm::getFormWithNumber($number);
        $this->assign('form', json_encode($ticket));
        $domain = \Model\Content::findContent('option', 'domain', 'option_name');
        $this->assign('domain', $domain['value']);
        $this->display('CreateJs_action');

    }

    public function preview(){
        $this->action();
    }

}