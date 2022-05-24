<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Ticket\POST;

class Login extends \Core\Controller\Controller{

    public function index(){
        $this->checkToken();

        if(json_decode(\Core\Func\CoreFunc::$param['system']['login_verify'])[1] == 2){
            $this->checkVerify();
        }
        
        $data['user_account'] = $data['user_mail'] = $this->isP('account', '请提交账号信息');
        $login = $this->db('user')->where('(user_account = :user_account OR user_mail = :user_mail) AND user_status = 1 ')->find($data);
        if(empty($login)){
            $this->error('账号或者密码错误，也可能您的账号被禁止登录!');
        }

        $data['user_password'] = \Core\Func\CoreFunc::generatePwd($login['user_account'].$this->isP('passwd', '请提交密码'));

        if($login['user_password'] !== $data['user_password']){
            $this->error('账号或者密码错误，也可能您的账号被禁止登录鸟!');
        }

        $this->session()->set('ticket', $login);

        //若返回上一页为空，那么跳转到用户自定义的首页
        if(empty($_POST['back_url'])){
            $url = $this->url('Ticket-Index-index');
        }else{
            $url = base64_decode($_POST['back_url']);
        }

        $this->success('登录成功!', $url, -1);
    }

}