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
 * 后台验证权限
 * @package Slice\Ticket
 */
class Auth extends \Core\Slice\Slice{

    public function before() {
        $auth = \Model\Auth::check();
        if($auth !== true){
            $this->error($auth);
        }
    }

    public function after() {
    }


}