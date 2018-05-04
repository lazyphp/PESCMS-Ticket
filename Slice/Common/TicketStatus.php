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


namespace Slice\Common;

/**
 * 全局订单状态
 * Class Login
 * @package Slice\Ticket
 */
class TicketStatus extends \Core\Slice\Slice{

    public function before() {
        $status = json_decode(\Model\Content::findContent('option', 'customstatus', 'option_name')['value'], true);
        $this->assign('ticketStatus', $status);
    }

    public function after() {
    }


}