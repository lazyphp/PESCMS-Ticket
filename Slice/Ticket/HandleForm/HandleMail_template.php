<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */


namespace Slice\Ticket\HandleForm;

/**
 * 处理发送模板
 * @package Slice\Ticket
 */
class HandleMail_template extends \Core\Slice\Slice {

    public function before() {

        if(in_array(METHOD, ['POST', 'PUT'])){

            if(!empty($_POST['weixin_key'])){
                $data = [];
                foreach ($_POST['weixin_key'] as $key => $value){
                    $data[$value]['value'] = $_POST['weixin_content'][$key];
                    $data[$value]['color'] = $_POST['weixin_color'][$key];
                }

                $_POST['weixin_template'] = json_encode($data);

            }


            /*
            'data' => [
                'first' => [
                    'value' => '工单登记通知',
                ],
                'OrderSn' => [
                    'value' => '123456',
                ],
                'OrderStatus' => [
                    'value' => '待解决',
                ],
                'remark' => [
                    'value' => '<p>测试备注说明</p>'
                ],
            ]
            */
        }

    }

    public function after() {
    }


}