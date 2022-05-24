<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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