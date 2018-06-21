<?php
namespace Slice\Form;

/**
 * 验证登录状态
 * @package Slice\Api
 */
class Login extends \Core\Slice\Slice{


    public function before() {
        $this->option();

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
            $this->success('请登录帐号后再访问', $this->url('Login-index', ['back_url' => base64_encode($_SERVER['REQUEST_URI'])]), -1);
        }else{
            $this->session()->set('login_expire', time());
        }
    }

    /**
     * 检测系统设置
     */
    private function option(){
        $open_register = \Model\Content::findContent('option', 'open_register', 'option_name');

        if($open_register['value'] == 0 && MODULE == 'Login'){
            $this->_404();
        }

    }

    public function after() {
    }


}