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
        $param['member_email'] = $this->isP('email', '请填写邮箱地址');
        $password = $this->isP('password', '请填密码');

        $param['member_password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');

        $member = $this->db('member')->where('member_email = :member_email AND member_password = :member_password AND member_status = 1')->find($param);
        if (empty($member)) {
            $this->error('帐号不存在或者密码错误');
        }
        unset($member['member_password']);
        $this->session()->set('member', $member);
        $this->session()->set('login_expire', time());

        if (empty($_POST['back_url'])) {
            $url = $this->url('Member-index');
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
            'member_status' => 1,
            'member_createtime' => time(),
        ];


        $param['member_name'] = $this->isP('name', '请填写名字');
        $param['member_email'] = $this->isP('email', '请填写邮箱地址');
        $param['member_phone'] = $this->isP('phone', '请填写手机号码');
        $password = $this->isP('password', '请填密码');
        $repassword = $this->isP('repassword', '请填写再次确认密码');

        if (\Model\Extra::checkInputValueType($param['member_email'], 1) == false) {
            $this->error('请输入正确的邮箱地址');
        }
        if (\Model\Extra::checkInputValueType($param['member_phone'], 5) == false) {
            $this->error('请输入正确的手机号码');
        }

        $checkEmail = $this->db('member')->where('member_email = :member_email')->find([
            'member_email' => $param['member_email']
        ]);
        if (!empty($checkEmail)) {
            $this->error('该邮箱地址已存在');
        }

        if (strcmp($password, $repassword) != 0) {
            $this->error('两次输入的密码不一致');
        }

        $param['member_password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');

        $this->db('member')->insert($param);

        $this->success('注册成功', $this->url('Member-index'));
    }

    /**
     * 查找密码
     */
    public function findpw() {
        $email = $this->isP('email', '请提交邮箱地址');
        $checkmember = \Model\Content::findContent('member', $email, 'member_email');
        if (empty($checkmember)) {
            $this->error('邮箱地址不存在');
        }

        $mark = \Model\Extra::getOnlyNumber();

        $this->db('findpassword')->where('findpassword_createtime < :time')->delete([
            'time' => time() - 86400
        ]);

        //创建标记
        $this->db('findpassword')->insert([
            'member_id' => $checkmember['member_id'],
            'findpassword_mark' => $mark,
            'findpassword_createtime' => time()
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

        $member = \Model\Content::findContent('member', $checkMark['member_id'], 'member_id');

        $data['noset']['member_id'] = $checkMark['member_id'];

        $data['member_password'] = \Core\Func\CoreFunc::generatePwd($member['member_email'] . $password);

        $this->db('member')->where('member_id = :member_id')->update($data);

        $this->db('findpassword')->where('findpassword_id = :id')->delete([
            'id' => $checkMark['findpassword_id']
        ]);

        $this->success('密码修改成功!', $loginUrl);
    }

}