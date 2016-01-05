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
        $crossDomainOption = \Model\Content::findContent('option', 'crossdomain', 'option_name');

        //设置跨域相关的
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST,GET');
        header('Access-Control-Allow-Credentials:true');
        //下面两个设置是声明程序返回的为json
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        header('HTTP_ACCEPT:application/json');

        $crossDomain = json_decode($crossDomainOption['value'], true);

        if( !empty($crossDomainOption['value'] ) && !in_array(str_replace(['http://', 'https://'], '', $_SERVER['HTTP_ORIGIN']), $crossDomain)){
            //@todo 验证码不参与跨域验证 = =. 好像会有点问题
            if(ACTION != 'verify'){
                $this->error('非法请求!');
                exit;
            }
        }

        //强制覆盖SESSION
        if (!empty($_REQUEST['PHPSESSIONID'])) {
            //先清空访问产生的session_start()方法；
            session_destroy();
            //重新复写一次SESSION
            session_id($_REQUEST['PHPSESSIONID']);
            session_start();
        }

    }

    public function after() {

    }


}