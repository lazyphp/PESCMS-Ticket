<?php

namespace App\Form\POST;

class Login extends \Core\Controller\Controller {

    public function __init() {
        parent::__init();
        $this->checkToken();
        $this->checkVerify();
    }

    /**
     * 登录帐号
     */
    public function index() {
        $param['user_email'] = $this->isP('email', '请填写邮箱地址');
        $password = $this->isP('password', '请填密码');

        $param['user_password'] = \Core\Func\CoreFunc::generatePwd($param['user_email'] . $password);

        $user = $this->db('user')->where('user_email = :user_email AND user_password = :user_password')->find($param);
        if (empty($user)) {
            $this->error('帐号不存在或者密码错误');
        }
        unset($user['user_password']);
        $this->session()->set('user', $user);
        $this->session()->set('login_expire', time());

        if (empty($_POST['back_url'])) {
            $url = $this->url('User-index');
        } else {
            $url = base64_decode($_POST['back_url']);
        }


        $this->success('登录成功', $url, -1);
    }

    /**
     * 注册帐号
     */
    public function signup() {
        $param = [
            'user_vip' => 1,
            'user_analyze_frequency' => 100,
            'user_vip_expire' => time() + 86400 * 30,
            'user_apikey' => \Model\User::apikey()
        ];


        $param['user_name'] = $this->isP('name', '请填写名字');
        $param['user_email'] = $this->isP('email', '请填写邮箱地址');
        $password = $this->isP('password', '请填密码');
        $repassword = $this->isP('repassword', '请填写再次确认密码');

        if($_POST['agree'] != 1){
            $this->error('您没有同意《基金定投助手用户协议》');
        }

        if (\Model\Extra::checkInputValueType($param['user_email'], 1) == false) {
            $this->error('请输入正确的邮箱地址');
        }

        $checkEmail = $this->db('user')->where('user_email = :user_email')->find([
            'user_email' => $param['user_email']
        ]);
        if (!empty($checkEmail)) {
            $this->error('该邮箱地址已存在');
        }

        if (strcmp($password, $repassword) != 0) {
            $this->error('两次输入的密码不一致');
        }

        $param['user_password'] = \Core\Func\CoreFunc::generatePwd($param['user_email'] . $password);

        $this->db('user')->insert($param);

        \Model\Notice::addNotice('Welcome', $param['user_email'], '欢迎注册基金定投助手', ['{username}' => $param['user_name']]);

        $this->success('注册成功', $this->url('User-index'));
    }

    /**
     * 查找密码
     */
    public function findpw() {
        $email = $this->isP('email', '请提交邮箱地址');
        $checkUser = \Model\Content::findContent('user', $email, 'user_email');
        if (empty($checkUser)) {
            $this->error('邮箱地址不存在');
        }

        $mark = \Model\Extra::getOnlyNumber();

        $this->db('findpassword')->where('findpassword_createtime < :time')->delete([
            'time' => time() - 86400
        ]);

        //创建标记
        $this->db('findpassword')->insert([
            'user_id' => $checkUser['user_id'],
            'findpassword_mark' => $mark,
            'findpassword_createtime' => time()
        ]);

        //创建邮件
        \Model\Notice::addNotice('FindPassword', $checkUser['user_email'], '重置密码请求', [
            '{key}' => $mark
        ]);

        $this->success('系统已将找回密码的信息发至您的邮箱，请注意查收。', $this->url('Login-index'));
    }

    /**
     * 重置密码
     */
    public function resetpw() {
        $mark = $this->isG('mark', '请提交正确的MARK');
        $checkMark = $this->db('findpassword')->where('findpassword_createtime >= :time AND findpassword_mark = :findpassword_mark ')->find([
            'time' => time() - 86400,
            'findpassword_mark' => $mark
        ]);

        $loginUrl = $this->url('Login-index');

        if (empty($checkMark)) {
            $this->error('MARK不正确或者不存在', $loginUrl);
        }

        $password = $this->isP('passwd', '请输入新密码');
        $repasswd = $this->isP('repasswd', '请输入确认新密码');

        if ($password !== $repasswd) {
            $this->error('两次密码不正确');
        }

        $user = \Model\Content::findContent('user', $checkMark['user_id'], 'user_id');

        $data['noset']['user_id'] = $checkMark['user_id'];

        $data['user_password'] = \Core\Func\CoreFunc::generatePwd($user['user_email'] . $password);

        $this->db('user')->where('user_id = :user_id')->update($data);

        $this->db('findpassword')->where('findpassword_id = :id')->delete([
            'id' => $checkMark['findpassword_id']
        ]);

        $this->success('密码修改成功!', $loginUrl);
    }

}