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


namespace Slice\Form;

/**
 * 跨域提交的切片
 * Class CrossDomain
 * @package Slice\Form
 */
class CrossDomain extends \Core\Slice\Slice {

    public function before() {
        $crossDomainOption = \Model\Content::findContent('option', 'crossdomain', 'option_name')['value'];
        //为空则表示不进行跨域请求
        if(empty($crossDomainOption)){
            return false;
        }

        //设置跨域相关的
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Methods:POST,GET');
        header('Access-Control-Allow-Credentials:true');
        //下面两个设置是声明程序返回的为json
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $_SERVER['HTTP_ACCEPT'] = 'application/json';
        header('HTTP_ACCEPT:application/json');

        $crossDomain = json_decode($crossDomainOption, true);


        if(!in_array(str_replace(['http://', 'https://'], '', $_SERVER['HTTP_ORIGIN']), $crossDomain)){
            //验证码不参与跨域验证
            if(ACTION != 'verify'){
                $this->error('非法请求!');
                exit;
            }
        }
    }

    public function after() {

    }


}