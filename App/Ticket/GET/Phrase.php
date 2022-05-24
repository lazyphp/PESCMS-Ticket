<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace App\Ticket\GET;

class Phrase extends Content {

    public function index($display = true) {
        $this->condition .= ' AND phrase_user_id = :user_id';
        $this->param['user_id'] = $this->session()->get('ticket')['user_id'];
        parent::index($display);
    }

}