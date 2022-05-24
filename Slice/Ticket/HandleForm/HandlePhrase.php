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
 * 处理回复短语
 * @package Slice\Ticket
 */
class HandlePhrase extends \Core\Slice\Slice {

    public function before() {

        $userID = $this->session()->get('ticket')['user_id'];

        if(in_array(METHOD, ['POST', 'PUT'])){
            $_POST['user_id'] = $userID;
        }

        if(METHOD == 'DELETE'){
            $result = \Model\Content::findContent('phrase', intval($_GET['id']), 'phrase_id');
            if($result['phrase_user_id'] != $userID ){
                $this->error('没有找到要删除的回复短语');
            }
        }

    }

    public function after() {
    }


}