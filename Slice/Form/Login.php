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
     * 检测系统是否关闭注册
     */
    private function option(){
        $system = \Core\Func\CoreFunc::$param['system'];

        if($system['open_register'] == 0 && MODULE == 'Login' && in_array(ACTION , ['signup', '']) ){
            $this->_404();
        }

    }

    public function after() {
    }


}