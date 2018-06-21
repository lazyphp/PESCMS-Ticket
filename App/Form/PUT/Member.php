<?php
namespace App\Form\PUT;

class Member extends \Core\Controller\Controller {
    
    /**
     * 更新个人信息
     */
    public function update(){
        $param['noset']['member_id'] = $this->session()->get('member')['member_id'];
        $param['member_phone'] = $this->isP('phone', '请提交手机号码');
        if(\Model\Extra::checkInputValueType($param['member_phone'], 5) === false){
            $this->error('请填写正确的手机号码');
        }

        $updatepasswd = false;

        if(!empty($_POST['password']) && !empty($_POST['repassword'])){
            if(!empty($_POST['oldpassword'])){
                $checkpwd = $this->db('member')->where('member_id = :member_id AND member_password = :member_password')->find([
                    'member_id' => $param['noset']['member_id'],
                    'member_password' => \Core\Func\CoreFunc::generatePwd($_POST['oldpassword'], 'USER_KEY')
                ]);
                if(empty($checkpwd)){
                    $this->error('旧密码错误，请重新输入');
                }
            }

            $updatepasswd = true;
            $password = $this->p('password');
            $repassword = $this->p('repassword');
            if (strcmp($password, $repassword) != 0) {
                $this->error('两次输入的密码不一致');
            }
            $param['member_password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');
        }

        $this->db('member')->where('member_id = :member_id')->update($param);

        if($updatepasswd == true){
            $this->session()->destroy();
            $url = $this->url('Login-index');
        }else{
            $url = '';
        }

        $this->success('更新个人信息完成', $url);

    }

}