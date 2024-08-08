<?php

namespace App\Form\POST;


class Login extends \Core\Controller\Controller {

    public function __init() {
        parent::__init();
        $this->checkToken();
        if (!in_array(ACTION, ['weixin', 'index', 'reActivate', 'sendSMSCode', 'phone']) ||
            (ACTION == 'index' && json_decode(\Core\Func\CoreFunc::$param['system']['login_verify'])[0] == 1)
        ) {
            $this->checkVerify();
        }

    }

    /**
     * 登录账号
     */
    public function index() {

        $system = \Core\Func\CoreFunc::$param['system'];

        switch ($system['member_login']) {
            case '1':
                $condition = 'member_account = :member_account';
                $param['member_account'] = $this->isP('account', '请填写您的账号');
                break;
            case '2':
                $condition = 'member_phone = :member_phone';
                $param['member_phone'] = $this->isP('phone', '请填写手机号码');
                break;
            default:
                $condition = 'member_email = :member_email';
                $param['member_email'] = $this->isP('email', '请填写邮箱地址');

        }

        $password = $this->isP('password', '请填密码');

        $param['member_password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');

        $member = $this->db('member')->where("{$condition} AND member_password = :member_password")->find($param);
        if (empty($member)) {
            $this->error('账号不存在或者密码错误');
        }


        if ($member['member_status'] == 0) {
            $statusMsg = $system['member_review'] == 2 ? '请先打开邮箱完成账号激活。' : '当前账号处于待审核/被禁用，请联系网站管理员解决。';
            if ($system['member_review'] == 2) {
                $this->session()->set('toBeActivated', $member['member_email']);
            }
            $this->success($statusMsg, $this->url('Login-activate'));
        }

        unset($member['member_password']);
        $this->setLogin($member);
    }

    /**
     * 注册账号
     */
    public function signup() {
        $review = \Core\Func\CoreFunc::$param['system']['member_review'];

        $_POST['status'] = $review == 1 ? 1 : 0;
        $_POST['createtime'] = date('Y-m-d H:i:s');
        $_POST['organize_id'] = 1;
        $_POST['requisition'] = \Model\Member::getRequisitionStatus();

        $field = \Model\Member::getModelField()['field'];


        if (empty($field['account'])) {
            $_POST['account'] = \Model\Extra::getOnlyNumber() . time();
        }

        if (empty($field['email'])) {
            $_POST['email'] = \Model\Extra::getOnlyNumber() . time() . '@default.com';
        }


        $email = $this->p('email');
        if (!empty($email) && \Model\Extra::checkInputValueType($email, 1) == false) {
            $this->error('请输入正确的邮箱地址');
        }

        $phone = $this->p('phone');
        if (!empty($phone) && \Model\Extra::checkInputValueType($phone, 2) == false) {
            $this->error('请输入正确的手机号码');
        }


        if (!empty($_POST['weixin'])) {
            $_POST['weixin'] = $this->p('weixin');
        }


        $password = \Model\Extra::verifyPassword();
        $_POST['password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');


        $memberID = \Model\Content::addContent('Member');

        $this->sendSignUpEmail($memberID, $email, $review);

        $this->success('注册成功', $this->url('Login-index', ['signup_complete' => $review]));
    }

    /**
     * 发送欢迎或者激活账号的邮件
     * @param $memberID 收到通知的账号
     * @param $email 邮箱地址
     * @param $review 系统的注册审核设置
     */
    private function sendSignUpEmail($memberID, $email, $review) {
        //若没有开启邮箱选项，则不发送通知
        if (empty($email)) {
            return true;
        }

        switch ($review) {
            //关闭审核状态，发送欢迎注册邮件
            case '1':
                $title = '欢迎来到' . \Core\Func\CoreFunc::$param['system']['siteTitle'];
                $emailContent = \Model\MailTemplate::mergeMailTemplate("<p>您好！</p><p>{$title}，您可以使用此账号登录系统。尔后，您可以提交和管理工单。</p>");
                \Model\Extra::insertSend($email, $title, $emailContent, '1');
                break;
            //开启邮件激活验证
            case '2':
                $activationCode = \Model\Extra::getOnlyNumber();
                $this->db('member_activation')->insert([
                    'member_id'       => $memberID,
                    'activation_code' => $activationCode,
                    'activation_time' => time(),
                ]);

                $url = \Core\Func\CoreFunc::$param['system']['domain'] . $this->url('Login-activation', ['code' => $activationCode]);

                $title = '欢迎来到' . \Core\Func\CoreFunc::$param['system']['siteTitle'] . '！您需要进行邮件激活。';
                $emailContent = \Model\MailTemplate::mergeMailTemplate("<p>您好！</p><p>{$title}</p><p><a href='{$url}' style='color: #bb0200;font-weight: bold;text-decoration: underline;'>请点击这里立即完成激活</a></p><p>如果上述文字点击无效，请将以下网址复制到浏览器地址栏打开（该链接使用一次或24小时后失效）：<br/>{$url}</p>");
                \Model\Extra::insertSend($email, $title, $emailContent, '1');
                break;
        }
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
            'time' => time() - 86400,
        ]);

        //创建标记
        $this->db('findpassword')->insert([
            'member_id'               => $checkmember['member_id'],
            'findpassword_mark'       => $mark,
            'findpassword_createtime' => time(),
        ]);

        //创建邮件
        $restPWUrl = \Core\Func\CoreFunc::$param['system']['domain'] . $this->url(GROUP . '-Login-resetpw', ['mark' => $mark]);
        $mailContent = \Model\MailTemplate::mergeMailTemplate("<p>您已提交找回密码的请求，请点击此链接完成操作：<a href=\"{$restPWUrl}\">{$restPWUrl}</a>");

        \Model\Extra::insertSend($checkmember['member_email'], '重置密码请求', $mailContent, 1);

        $this->success('系统已将找回密码的信息发至您的邮箱，请注意查收。', $this->url('Login-index'));
    }

    /**
     * 重置密码
     */
    public function resetpw() {
        $mark = $this->isG('mark', '请提交正确的MARK');
        $checkMark = $this->db('findpassword')->where('findpassword_createtime >= :time AND findpassword_mark = :findpassword_mark ')->find([
            'time'              => time() - 86400,
            'findpassword_mark' => $mark,
        ]);

        $loginUrl = $this->url('Login-index');

        if (empty($checkMark)) {
            $this->error('MARK不正确或者不存在', $loginUrl);
        }

        $password = \Model\Extra::verifyPassword();

        $member = \Model\Content::findContent('member', $checkMark['member_id'], 'member_id');

        $data['noset']['member_id'] = $checkMark['member_id'];

        $data['member_password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');

        $this->db('member')->where('member_id = :member_id')->update($data);

        $this->db('findpassword')->where('findpassword_id = :id')->delete([
            'id' => $checkMark['findpassword_id'],
        ]);

        $this->success('密码修改成功!', $loginUrl);
    }


    /**
     * 微信登录
     */
    public function weixin() {
        $wxID = $this->isP('openid', '获取openid失败');

        //邮件地址没有填写，则直接随机创建账号
        if (empty($_POST['email'])) {
            $member = $this->createRandomMember(null, $wxID);
        } else {
            $data['member_email'] = $this->isP('email', '请填写邮箱地址');
            $password = $this->isP('password', '请填密码');
            $data['member_password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');

            $member = $this->db('member')->where('member_email = :member_email AND member_password = :member_password AND member_status = 1 AND member_weixin IS NULL ')->find($data);
            if (empty($member)) {
                $this->error('账号绑定失败!账号可能不存在、待审核/被禁用、密码错误或已绑定!');
            }

            //对应账号绑定微信ID
            $this->db('member')->where('member_id = :member_id')->update([
                'noset'         => [
                    'member_id' => $member['member_id'],
                ],
                'member_weixin' => $wxID,
            ]);
        }

        $this->setLogin($member);

    }

    /**
     * 重新发送激活账号
     * @return void
     */
    public function reActivate() {

        $email = $this->session()->get('toBeActivated');

        if (empty($email)) {
            $this->jump($this->url('Login-index'));
        }

        $member = \Model\Content::findContent('member', $email, 'member_email', 'member_id, member_email');

        $this->sendSignUpEmail($member['member_id'], $email, 2);

        //限制发送频率
        $wrapper = new \Model\SendLimitWrapper();
        $wrapper->getLimitFromAccountAndType($member['member_email'], 0, '激活邮件已发送，请稍后再试')->getLimitFromSession('激活邮件发送太频繁了，请稍后再试')->getLimitFromIP('激活邮件发送太频繁了，已被限制发送')->addRecord($member['member_email'], 0);


        $this->success('我们已发送激活邮件至您的邮箱，请注意查收！', $this->url('Login-index'));

    }

    /**
     * 发送短信验证码
     * @return void
     */
    public function sendSMSCode() {
        $phone = $this->isP('phone', '请提交您的手机号码');

        if (\Model\Extra::checkInputValueType($phone, 2) == false) {
            $this->error('请提交正确的手机号码');
        }

        $wrapper = new \Model\SendLimitWrapper();

        $wrapper->getLimitFromAccountAndType($phone, 0, '短信已发送，请稍后再试')->verifyCode()->getLimitFromSession('您短信发送太频繁了，请稍后再试')->getLimitFromIP('您短信发送太频繁了，已被限制发送')->addRecord($phone, 0);

        $smsCode = random_int(100000, 999999);

        $template = \Model\MailTemplate::matchContent($smsCode, 0);

        $this->db('sms_code')->insert([
            'sms_code_phone'     => $phone,
            'sms_code'           => $smsCode,
            'sms_code_send_time' => time(),
        ]);

        $param = [
            'send_id'      => -1,
            'send_account' => $phone,
            'send_title'   => "{$phone}的验证码短信",
            'send_content' => $template['2'],
        ];

        $result = (new \Expand\SMS\SMSMain())->send($param);

        \Model\Extra::insertSend($phone, "{$phone}的验证码短信", $template['2'], 2, json_encode($result, JSON_UNESCAPED_UNICODE), $result['status'], 999);


        if ($result['status'] == 2) {
            $this->success(['msg' => '验证码已发送，请注意查收。', 'data' => $wrapper->sendCount]);
        } else {
            $this->error(['msg' => '验证码发送失败，请稍后再试。', 'data' => $wrapper->sendCount]);
        }
    }

    /**
     * 手机验证码登录
     * @return void
     */
    public function phone() {
        $phone = $this->isP('phone', '请填写手机号码');
        $smscode = $this->isP('smscode', '请填写手机验证码');

        if (\Model\Extra::checkInputValueType($phone, 2) == false) {
            $this->error('请提交正确的手机号码');
        }

        $checkCode = $this->db('sms_code')->where('sms_code_phone = :sms_code_phone AND sms_code = :sms_code AND sms_code_used = 0 AND sms_code_send_time > :sms_code_send_time')->find([
            'sms_code_phone'     => $phone,
            'sms_code'           => $smscode,
            'sms_code_send_time' => time() - 600,
        ]);

        if (empty($checkCode)) {
            $this->error('验证码错误或已过期，请重新获取');
        } else {
            $this->db('sms_code')->where('sms_code_id = :sms_code_id')->update([
                'noset'         => [
                    'sms_code_id' => $checkCode['sms_code_id'],
                ],
                'sms_code_used' => 1,
            ]);
        }

        $member = $this->db('member')->where('member_phone = :member_phone')->find(['member_phone' => $phone]);

        if (empty($member)) {
            $member = $this->createRandomMember($phone);
        }

        $this->setLogin($member);
    }

    /**
     * 快速注册 - 创建对应的随机账号
     * @param $phone
     * @param $weixin
     * @return array
     */
    private function createRandomMember($phone = null, $weixin = null) {
        $randomAccount = \Model\Extra::getOnlyNumber();
        $param = [
            'member_phone'       => $phone,
            'member_weixin'      => $weixin,
            'member_email'       => "{$randomAccount}@default." . ($phone ? "phone" : "wx"),
            'member_name'        => ($phone ? "手机用户" : "微信用户") . \Model\Extra::getOnlyNumber(),
            'member_account'     => ($phone ? "phone_" : "wx_") . $randomAccount,
            'member_password'    => md5(\Model\Extra::getOnlyNumber()), // 随机写入一些字符，随机账号无法使用
            'member_status'      => \Core\Func\CoreFunc::$param['system']['member_review'] == 2 ? 0 : \Core\Func\CoreFunc::$param['system']['member_review'],
            'member_organize_id' => 1, // 默认客户分组为 1
            'member_createtime'  => time(),
        ];
        $memberID = $this->db('member')->insert($param);

        $param['member_id'] = $memberID;
        return $param;
    }

    /**
     * 设置登录状态
     * @param $member
     * @return void
     */
    private function setLogin($member, $url = null) {
        $this->session()->set('member', $member);
        $this->session()->set('login_expire', time());

        if (empty($_POST['back_url'])) {
            $link = $this->url('Member-index');
        } else {
            $link = base64_decode($_POST['back_url']);
        }

        $this->success('登录成功', $url ?? $link, -1);
    }

}