<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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

            if(!empty($_POST['wxapp_key'])){
                $data = [];
                foreach ($_POST['wxapp_key'] as $key => $value){
                    $data[$value]['value'] = $_POST['wxapp_content'][$key];
                    $data[$value]['color'] = $_POST['wxapp_color'][$key];
                }

                $_POST['wxapp_template'] = json_encode($data);

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