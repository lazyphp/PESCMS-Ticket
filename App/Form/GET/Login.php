<?php
namespace App\Form\GET;

class Login extends \Core\Controller\Controller {

    /**
     * 登录帐号
     */
    public function index(){
        $this->assign('title', '登录帐号');
        $this->layout('', 'Login_layout');
    }

    /**
     * 注册帐号
     */
    public function signup(){
        $this->assign('title', '注册帐号');
        $this->layout('', 'Login_layout');
    }

    /**
     * 查找密码
     */
    public function findpw(){
        $this->assign('title', '找回密码');
        $this->layout('', 'Login_layout');
    }

    /**
     * 重置密码
     */
    public function resetpw(){
        $mark = $this->isG('mark', '请提交正确的MARK');
        $checkMark = $this->db('findpassword')->where('findpassword_createtime >= :time AND findpassword_mark = :findpassword_mark ')->find([
            'time' => time() - 86400,
            'findpassword_mark' => $mark
        ]);
        if (empty($checkMark)) {
            $this->error('MARK不存在', '/');
        }

        $this->assign('title', '重置密码');
        $this->layout('Login_layout');
    }

    /**
     * 退出登录
     */
    public function logout(){
        $this->session()->destroy();
        $this->jump($this->url('Login-index'));
    }

}