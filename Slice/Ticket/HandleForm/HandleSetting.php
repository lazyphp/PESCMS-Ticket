<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */


namespace Slice\Ticket\HandleForm;

/**
 * 处理后台 用户添加/编辑提交过来的密码表单
 * @package Slice\Ticket
 */
class HandleSetting extends \Core\Slice\Slice {

    public function before() {
        $license = PES_CORE.'/Core/LICENSE.pes';
        if(is_file($license)){
            $authorize = json_decode(file_get_contents($license), true);
        }

        $check = strcmp(trim($_SERVER['HTTP_HOST']), trim($authorize['authorize_domain']));

        if($check !== 0){
            is_file($license) ? unlink($license) : '';
        }
        if(( $check !== 0 || empty($authorize['authorize_domain']) ) && METHOD == 'PUT'){
            $_POST['siteTitle'] = 'PESCMS Ticket';
            $_POST['siteLogo'] = '/Theme/assets/i/logo.png';
            $_POST['siteContact'] = '';
            $_POST['pescmsIntroduce'] = file_get_contents(dirname(__FILE__).'/introduce.php');
        }


    }

    public function after() {
    }


}