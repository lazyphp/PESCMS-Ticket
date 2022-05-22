<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

require 'Core.php';

class SendNotice extends Core {
    
    public function index() {
        $noticeWay = \Model\Content::findContent('option', 'notice_way', 'option_name')['value'];
        if (in_array($noticeWay, ['2', '3'])) {
            \Model\Extra::actionNoticeSend();
        }

        (new \Expand\cURL())->init(\Core\Func\CoreFunc::$param['system']['domain'].'/?m=Index&a=behavior');

    }

}

(new SendNotice())->index();