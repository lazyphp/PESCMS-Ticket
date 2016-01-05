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

class Index extends \App\Form\Common{

    public function index(){
        $openindex = \Model\Content::findContent('option', 'openindex', 'option_name');
        if($openindex['value'] == '0'){
            header('http/1.1 404');
            exit;
        }
        $this->layout();
    }

    public function verify(){
        $verify = new \Expand\Verify();
        $verify->createVerify('7');
    }

    public function getSession(){
        echo json_encode(session_id());
        exit;
    }

}