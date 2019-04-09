<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */

namespace App\Form\GET;

class Index extends \Core\Controller\Controller {

    public function index() {
        $openindex = \Model\Content::findContent('option', 'openindex', 'option_name');
        if ($openindex['value'] == '0') {
            $this->_404();
        }
        $this->layout();
    }

    /**
     * 验证码
     */
    public function verify() {
        $verify = new \Expand\Verify();
        if(!empty($_GET['height'])){
            $verify->height = intval($this->g('height'));
        }
        $verify->createVerify('7');
    }

    /**
     * 发送通知
     */
    public function notice() {
        $list = \Model\Content::listContent(['table' => 'ticket_notice_action']);
        if (!empty($list)) {
            foreach ($list as $item) {
                //大于0的，则为发送给客户的，反之是给客服
                if ($item['template_type'] > 0) {
                    \Model\Notice::insertMemberNoticeSendTemplate($item);
                } else {
                    \Model\Notice::insertCSNoticeSendTemplate($item);
                }
            }
        }

        $system = \Core\Func\CoreFunc::$param['system'];
        if (in_array($system['notice_way'], ['1', '3'])) {
            \Model\Extra::actionNoticeSend();
        }
    }

    /**
     * 获取session id
     */
    public function getSession() {
        echo json_encode($this->session()->getId());
        exit;
    }

}