<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace Slice\Ticket;

/**
 * 管理员限制
 * @package Slice\Ticket
 */
class AdminLimit extends \Core\Slice\Slice{

    public function before() {
        if($this->session()->get('ticket')['user_id'] != 1){
            $this->error('您没有权限进行本次操作.');
        }
    }

    public function after() {

    }


}