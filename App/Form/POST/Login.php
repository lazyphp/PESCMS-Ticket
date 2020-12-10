<?php

namespace App\Form\POST;

class Login extends \Core\Controller\Controller {

    public function __init() {
        parent::__init();
        $this->checkToken();
        if( !in_array(ACTION, ['weixin', 'index'])  ||
            (ACTION == 'index' &&  json_decode(\Core\Func\CoreFunc::$param['system']['login_verify'])[0] == 1)
        ){
            $this->checkVerify();
        }

    }

    /**
     * 登录账号
     */
    public function index() {

        $system = \Core\Func\CoreFunc::$param['system'];

        switch ($system['member_login']){
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


        if($member['member_status'] == 0){
            $statusMsg = $system['member_review'] == 2 ? '请先打开邮箱完成账号激活。' : '当前账号处于待审核/被禁用，请联系网站管理员解决。';
            $this->error($statusMsg);
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
     * 注册账号
     */
    public function signup() {
        $review = \Core\Func\CoreFunc::$param['system']['member_review'];
        $registerForm = json_decode(\Core\Func\CoreFunc::$param['system']['register_form'], true);

        $param = [
            'member_status' => $review == 1 ? 1 : 0,
            'member_createtime' => time(),
        ];

        $param['member_account'] = $this->isP('account', '请填写登录账号');
        $param['member_name'] = $this->isP('name', '请填写名字');
        $param['member_email'] = $this->isP('email', '请填写邮箱地址');
        $param['member_phone'] = $this->isP('phone', '请填写手机号码');
        $param['member_organize_id'] = 1;

        if(!empty($_POST['weixin'])){
            $param['member_weixin'] = $this->p('weixin');
        }

        $password = \Model\Extra::verifyPassword();

        if (\Model\Extra::checkInputValueType($param['member_email'], 1) == false) {
            $this->error('请输入正确的邮箱地址');
        }
        if (\Model\Extra::checkInputValueType($param['member_phone'], 2) == false) {
            $this->error('请输入正确的手机号码');
        }

        foreach ([
            'email' => '该邮箱地址已存在',
            'account' => '该账号已存在',
            'phone' => '该手机号码已存在'
                 ] as $field => $msg){
            $this->checkRepeatInfo($field, $param, $msg);
        }

        $param['member_password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');

        $memberID = $this->db('member')->insert($param);

        $this->sendSignUpEmail($memberID, $param, $review);

        $this->success('注册成功', $this->url('Login-index', ['signup_complete' => $review]));
    }

    /**
     * 检查库中重复的账号、邮箱和手机号码
     * @param $type 检查字段
     * @param $param 提交的参数
     * @param $msg 提示信息
     */
    private function checkRepeatInfo($type, $param, $msg){
        $checkRepeat = $this->db('member')->where("member_{$type} = :member_{$type}")->find([
            "member_{$type}" => $param["member_{$type}"]
        ]);

        if(!empty($checkRepeat)){
            $this->error($msg);
        }
    }

    /**
     * 发送欢迎或者激活账号的邮件
     * @param $memberID 收到通知的账号
     * @param $param 注册时提交的参数
     * @param $review 系统的注册审核设置
     */
    private function sendSignUpEmail($memberID, $param, $review){

        switch ($review){
            //关闭审核状态，发送欢迎注册邮件
            case '1':
                $title = '欢迎来到'.\Core\Func\CoreFunc::$param['system']['siteTitle'];
                $emailContent = \Model\MailTemplate::mergeMailTemplate("<p>您好！</p><p>{$title}，您可以使用此账号登录系统。尔后，您可以提交和管理工单。</p>");
                \Model\Extra::insertSend($param['member_email'], $title, $emailContent, '1');
                break;
            //开启邮件激活验证
            case '2':
                $activationCode = \Model\Extra::getOnlyNumber();
                $this->db('member_activation')->insert([
                    'member_id' => $memberID,
                    'activation_code' => $activationCode,
                    'activation_time' => time()
                ]);

                $url = \Core\Func\CoreFunc::$param['system']['domain'].$this->url('Login-activation', ['code' => $activationCode]);

                $title = '欢迎来到'.\Core\Func\CoreFunc::$param['system']['siteTitle'].'！您需要进行邮件激活。';
                $emailContent = \Model\MailTemplate::mergeMailTemplate("<p>您好！</p><p>{$title}</p><p><a href='{$url}' style='color: #bb0200;font-weight: bold;text-decoration: underline;'>请点击这里立即完成激活</a></p><p>如果上述文字点击无效，请将以下网址复制到浏览器地址栏打开（该链接使用一次或24小时后失效）：<br/>{$url}</p>");
                \Model\Extra::insertSend($param['member_email'], $title, $emailContent, '1');
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
            'time' => time() - 86400
        ]);

        //创建标记
        $this->db('findpassword')->insert([
            'member_id' => $checkmember['member_id'],
            'findpassword_mark' => $mark,
            'findpassword_createtime' => time()
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
            'time' => time() - 86400,
            'findpassword_mark' => $mark
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
            'id' => $checkMark['findpassword_id']
        ]);

        $this->success('密码修改成功!', $loginUrl);
    }


    /**
     * 微信登录
     */
    public function weixin(){
        $param['member_weixin'] = $this->isP('openid', '获取openid失败');
        $param['member_name'] = $this->isP('name', '获取用户名失败');

        //邮件地址没有填写，则直接随机创建账号
        if(empty($_POST['email'])){
            $randomAccount = \Model\Extra::getOnlyNumber();
            $param['member_email'] = "{$randomAccount}@default.wx";
            $param['member_account'] = "wx_{$randomAccount}";
            $param['member_password'] = md5(\Model\Extra::getOnlyNumber());//随机写入一些字符，随机账号无法使用
            $param['member_status'] = \Core\Func\CoreFunc::$param['system']['member_review'] == 2 ? 0 : \Core\Func\CoreFunc::$param['system']['member_review'];
            $param['member_organize_id'] = 1 ; //默认客户分组为 1
            $param['member_createtime'] = time();
            $memberID = $this->db('member')->insert($param);

            $member = $param;
            $member['member_id'] = $memberID;
        }else{
            $data['member_email'] = $this->isP('email', '请填写邮箱地址');
            $password = $this->isP('password', '请填密码');
            $data['member_password'] = \Core\Func\CoreFunc::generatePwd($password, 'USER_KEY');

            $member = $this->db('member')->where('member_email = :member_email AND member_password = :member_password AND member_status = 1 AND member_weixin IS NULL ')->find($data);
            if (empty($member)) {
                $this->error('账号绑定失败!账号可能不存在、待审核/被禁用、密码错误或已绑定!');
            }

            $this->db('member')->where('member_id = :member_id')->update([
                'noset' => [
                    'member_id' => $member['member_id']
                ],
                'member_weixin' => $param['member_weixin']
            ]);
        }

        $this->session()->set('member', $member);
        $this->session()->set('login_expire', time());
        $this->success('登录成功', $this->url('Member-index'), -1);

    }

}