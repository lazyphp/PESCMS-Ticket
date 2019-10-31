<?php
namespace App\Form\PUT;

class Member extends \Core\Controller\Controller {
    
    /**
     * 更新个人信息
     */
    public function update(){
        $param['noset']['member_id'] = $this->session()->get('member')['member_id'];
        $param['member_phone'] = $this->isP('phone', '请提交手机号码');
        $param['member_name'] = $this->isP('name', '请提交用户昵称');
        if(\Model\Extra::checkInputValueType($param['member_phone'], 2) === false){
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
            $member = \Model\Content::findContent('member', $param['noset']['member_id'], 'member_id');
            unset($member['member_password']);
            $this->session()->set('member', $member);
            $url = $this->url('Member-update');
        }

        $this->success('更新个人信息完成', $url);

    }

    /**
     * 更新当前登录帐号的邮箱地址
     */
    public function changeEmail(){
        $email = $this->isP('email', '请填写新邮箱地址！');

        $member = $this->session()->get('member');
        if($member['member_email'] === $email){
            $this->error('您填写的邮箱地址并没有变化。');
        }

        $checkRepeat = \Model\Content::findContent('member', $email, 'member_email', 'member_id');
        if(!empty($checkRepeat)){
            $this->error("邮箱地址已注册，请更换别的邮箱地址");
        }

        $this->db('member')->where('member_id = :member_id')->update([
            'noset' => [
                'member_id' => $member['member_id']
            ],
            'member_email' => $email
        ]);

        $this->session()->destroy();
        $this->success('邮箱更改成功！您需要重新登录', $this->url('Login-index'));

    }

}