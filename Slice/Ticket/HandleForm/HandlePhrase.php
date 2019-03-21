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