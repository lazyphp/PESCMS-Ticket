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

namespace App\Ticket\PUT;

class Setting extends \App\Ticket\Common {

    public function action() {
        $data['domain'] = $this->isP('domain', '请提交网站域名');
        $data['openindex'] = $this->p('openindex');
        $data['notice_way'] = $this->p('notice_way');
        $data['crossdomain'] = !empty($_POST['crossdomain']) ? json_encode(explode("\n", str_replace("\r", "", $this->p('crossdomain')))) : '';

        if(count($_POST['customstatus']) != '4' && count($_POST['customcolor']) != '4'){
            $this->error('请提交工单状态');
        }

        $customstatus = [];
        foreach($_POST['customstatus'] as $key => $value){
            $customstatus[$key]['color'] = $_POST['customcolor'][$key];
            $customstatus[$key]['name'] = $value;
        }

        $data['customstatus'] = json_encode($customstatus);
        $data['mail'] = json_encode($this->p('mail'));

        foreach($data as $key => $value){
            $this->db('option')->where('option_name = :option_name')->update([
                'value' => $value,
                'noset' => ['option_name'  => $key]
            ]);
        }

        $this->success('保存设置成功!', $this->url('Ticket-Setting-action'));


    }

}