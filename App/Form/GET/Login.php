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
        $this->layout('', 'Login_layout');
    }

    /**
     * 退出登录
     */
    public function logout(){
        $this->session()->destroy();
        $this->jump($this->url('Login-index'));
    }

    /**
     * 微信公众号登录入口
     */
    public function weixinAgree(){
        $weixin = new \Expand\weixin();
        if(!empty($weixin->error)){
            $this->error($weixin->error);
        }

        //添加go back的地址
        if(!empty($_GET['back_url'])){
            $urlParam = [
                'back_url' => $this->g('back_url')
            ];
        }else{
            $urlParam = [];
        }

        $this->assign('login', $weixin->agree(\Core\Func\CoreFunc::$param['system']['domain'].$this->url('Login-weixin', $urlParam)));
        $this->display();
    }

    /**
     * 执行微信登录
     */
    public function weixin(){
        if(empty($_GET['code'])){
            $this->error('获取参数失败');
        }

        $weixin = new \Expand\weixin();

        $openid = $weixin->user_access_token($_GET['code']);

        $user = $weixin->getUser($openid);

        //检查是否已绑定账号，已存在则直接执行登录
        $member = \Model\Content::findContent('member', $user['openid'], 'member_weixin');
        if(!empty($member)){
            if($member['member_status'] == 0){
                $this->error('当前账号处于待审核/被禁用，请联系网站管理员解决。');
            }

            $this->session()->set('member', $member);
            $this->session()->set('login_expire', time());

            $url = !empty($_GET['back_url']) ? base64_decode(trim($_GET['back_url'])) : $this->url('Member-index');

            $this->success('登录成功', $url, -1);
        }

        $this->assign('user', $user);

        $this->assign('title', '注册帐号');
        $this->layout('', 'Login_layout');
    }

}