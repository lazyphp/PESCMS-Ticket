<?php
namespace Slice\Form;

/**
 * 验证登录状态
 * @package Slice\Api
 */
class Login extends \Core\Slice\Slice{


    public function before() {
        $member = $this->session()->get('member');

        //5小时为过期时间
        if($this->session()->get('login_expire') + 3600 * 5  < time()){
            $expire = true;
        }else{
            $expire = false;
        }

        if(MODULE == 'Login' && !empty($member)){
            $this->jump($this->url('Member-index'));
        }elseif ( MODULE != 'Login' && ( empty($member)  || (!empty($member) && $expire) ) ){
            $this->session()->delete('member');
            $this->error('请登录帐号后再访问', $this->url('Login-index', ['back_url' => base64_encode($_SERVER['REQUEST_URI'])]), -1);
        }else{
            $this->session()->set('login_expire', time());
        }
    }

    public function after() {
    }


}