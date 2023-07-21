<?php

namespace App\Form\GET;

class Login extends \Core\Controller\Controller {

    /**
     * 登录账号
     */
    public function index() {

        $qrcode = \Model\Extra::getOnlyNumber() . (new \Godruoyi\Snowflake\Snowflake)->id();
        $this->session()->set('qrcode', $qrcode);
        $this->assign('qrcode', $qrcode);
        $this->assign('title', '登录账号');
        $this->layout('', 'Login_layout');
    }

    /**
     * 注册账号
     */
    public function signup() {

        $this->assign(\Model\Member::getModelField());
        $this->assign('form', new \Expand\Form\Form());
        
        $this->assign('title', '注册账号');
        $this->layout('', 'Login_layout');
    }

    /**
     * 查找密码
     */
    public function findpw() {
        $this->assign('title', '找回密码');
        $this->layout('', 'Login_layout');
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
        if (empty($checkMark)) {
            $this->error('MARK不存在', '/');
        }

        $this->assign('title', '重置密码');
        $this->layout('', 'Login_layout');
    }

    /**
     * 激活账号
     */
    public function activation() {

        $code = $this->isG('code', '请提交正确的激活码');
        $checkCode = $this->db('member_activation')->where('activation_time >= :time AND activation_code = :code ')->find([
            'time' => time() - 86400,
            'code' => $code,
        ]);

        if (empty($checkCode)) {
            $this->error('激活码不存在', '/');
        }

        $this->db('member')->where('member_id = :member_id')->update([
            'noset'         => [
                'member_id' => $checkCode['member_id'],
            ],
            'member_status' => 1,
        ]);

        $this->db('member_activation')->where('activation_code = :code')->delete([
            'code' => $code,
        ]);

        $this->success('您的账号已经成功激活！', $this->url('Login-index'));

    }

    /**
     * 退出登录
     */
    public function logout() {
        $this->session()->destroy();
        $this->jump($this->url('Login-index'));
    }

    /**
     * 微信公众号登录入口
     */
    public function weixinAgree() {
        $weixin = new \Expand\weixin();
        if (!empty($weixin->error)) {
            $this->error($weixin->error);
        }

        $param = [];

        if (!empty($_GET['qrcode'])) {
            $param['qrcode'] = $this->g('qrcode');
        }

        $this->weixinLoginUrl($weixin, $param, !empty($_GET['qrcode']) ? 'Login-weixinScanLogin' : '');
        $this->display();
    }

    /**
     * 执行微信登录
     */
    public function weixin() {
        $weixin = new \Expand\weixin();

        if (!empty($_GET['code'])) {
            $openid = $weixin->user_access_token($_GET['code']);
            if ($openid === false) {
                $this->error('获取微信用户信息失败，请重试', $this->url('Login-index'));
            }
        } elseif (!empty($_GET['qrcode'])) {

            $qrcodeResult = $this->db('qrcode')->where('qrcode_key = :qrcode_key AND qrcode_status = 0')->find([
                'qrcode_key' => $this->g('qrcode'),
            ]);
            if (empty($qrcodeResult)) {
                $this->error('没有登录信息或您已登录，请重新用微信扫一扫登录系统', $this->url('Login-index'));
            }


            if ($qrcodeResult['qrcode_createtime'] <= time() - 600) {
                $this->error('登录信息已超时，请重新用微信扫一扫登录系统', $this->url('Login-index'));
            }

            $this->db('qrcode')->where('qrcode_id = :qrcode_id')->update([
                'noset' => [
                    'qrcode_id' => $qrcodeResult['qrcode_id']
                ],
                'qrcode_status' => 1
            ]);

            $openid = $qrcodeResult['qrcode_value'];
        } else {
            $this->error('系统无法获取您的登录信息，将重定向回登录页', $this->url('Login-index'));
        }


        $user = $weixin->getUser($openid);

        //检查是否已绑定账号，已存在则直接执行登录
        $member = \Model\Content::findContent('member', $user['openid'], 'member_weixin');
        if (!empty($member)) {
            if ($member['member_status'] == 0) {
                $this->error('当前账号处于待审核/被禁用，请联系网站管理员解决。');
            }

            $this->session()->set('member', $member);
            $this->session()->set('login_expire', time());

            $url = !empty($_GET['back_url']) ? base64_decode(trim($_GET['back_url'])) : $this->url('Member-index');

            $this->success('登录成功', $url, -1);
        }

        $this->assign('user', $user);
        $this->weixinLoginUrl($weixin);
        $this->assign('title', '注册账号');
        $this->layout('', 'Login_layout');
    }

    /**
     * 微信扫一扫登录
     * @return void
     */
    public function weixinScanLogin() {
        $code = $this->isG('code', '获取微信代码失败');
        $qrcode = $this->isG('qrcode', '获取二维码失败');

        $weixin = new \Expand\weixin();

        $openid = $weixin->user_access_token($code);
        if ($openid === false) {
            $this->error('获取微信用户信息失败请重试', $this->url('Login-index'));
        }

        $this->db('qrcode')->insert([
            'qrcode_key'        => $qrcode,
            'qrcode_value'      => $openid,
            'qrcode_status'     => 0,
            'qrcode_createtime' => time(),
        ]);

        //删除超过一天的记录
        $this->db('qrcode')->where('qrcode_createtime <= :qrcode_createtime')->delete([
            'qrcode_createtime' => time() - 86400,
        ]);

        $this->display();

    }

    /**
     * 微信扫一扫验证
     * @return void
     */
    public function weixinScanVerify() {
        $qrcode = $this->isG('qrcode', '请提交二维码');

        //比较前后台二维码是否一致
        if (strnatcmp($qrcode, $this->session()->get('qrcode')) !== 0) {
            $this->ajaxReturn(['data' => $qrcode, 'msg' => 'QR不一致，系统将刷新'], 201);
        }

        //查询是否有完成登录的QR码
        $verify = $this->db('qrcode')->where('qrcode_key = :qrcode_key AND qrcode_status = 0 AND qrcode_createtime >= :qrcode_createtime ')->find([
            'qrcode_key'        => $qrcode,
            'qrcode_createtime' => time() - 600,
        ]);

        if (empty($verify)) {
            $this->error('未扫描或未完成登录');
        } else {
            $this->success(['data' => $qrcode, 'msg' => '已完成登录'], $this->url('Login-weixin'));
        }
    }

    /**
     * 微信登录URL地址
     * @param $weixin
     * @param array $urlParam
     * @param $url
     * @return void
     */
    private function weixinLoginUrl($weixin, array $urlParam = [], $url = '') {
        //添加go back的地址
        if (!empty($_GET['back_url'])) {
            $urlParam['back_url'] = $this->g('back_url');
        }

        $this->assign('login', $weixin->agree(\Core\Func\CoreFunc::$param['system']['domain'] . $this->url(empty($url) ? 'Login-weixin' : $url, $urlParam)));
    }

    /**
     * 微信获取用户信息测试
     * 本入口只有在获取OpenID失败下才触发。
     * 用户直接访问也只是看到反馈结果。
     * 仅限调试模式开启
     */
    public function wexinGetUSerTest() {
        if (DEBUG !== true) {
            exit;
        }
        $weixin = new \Expand\weixin();
        if (!empty($weixin->error)) {
            $this->error($weixin->error);
        }

        if (empty($_GET['code'])) {
            $url = $weixin->agree(\Core\Func\CoreFunc::$param['system']['domain'] . $this->url('Login-wexinGetUSerTest'));

            $this->jump($url);

        } else {
            $openid = $weixin->user_access_token($_GET['code']);

            $user = $weixin->getUser($openid);

            $log = new \Expand\Log();
            $fileName = 'weixin_log' . md5(\Core\Func\CoreFunc::loadConfig('PRIVATE_KEY') . date("Ymd"));

            $info = date('H:i:s') . "\n";
            $info .= "OPENID: {$openid} \n";
            $info .= "USER INFO: " . json_encode($user) . " \n";
            $info .= "-------\n\n";

            $log->creatLog($fileName, $info);

            echo '获取ID:' . (empty($openid) ? '失败' : '正常') . '<br/>';
            echo '用户信息:' . (empty($user) ? '失败' : '正常') . '<br/>';
            echo '校验信息已完成记录，请联系站点管理员获取解决办法。';
        }
    }

}