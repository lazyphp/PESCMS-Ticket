<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */

require 'Core.php';

class SendNotice extends Core {
    
    public function index() {
        $noticeWay = \Model\Content::findContent('option', 'notice_way', 'option_name')['value'];
        if (in_array($noticeWay, ['2', '3'])) {
            \Model\Extra::actionNoticeSend();
        }
    }

}

(new SendNotice())->index();