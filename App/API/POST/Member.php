<?php
/**
 *
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\API\POST;

class Member extends \Core\Controller\Controller {

    /**
     * 执行微信登陆和生成登录鉴权token.
     */
    public function weixinLogin(){

        $code = $this->isP('code', '请提交code信息');
        $systeminfo = $this->isP('systemInfo', '请提交系统信息', false);

        $wxapp = new \Expand\wxapp();

        $result = json_decode((new \Expand\cURL())->init("https://api.weixin.qq.com/sns/jscode2session?appid={$wxapp->appID}&secret={$wxapp->appsecret}&js_code={$code}&grant_type=authorization_code"), true);

        if(!empty($result['errcode'])){
            switch ($result['errcode']){
                case -1:
                case 45011:
                    $this->ajaxReturn(['msg' => '当前系统繁忙，请稍后再试'], 45011);
                    break;
                case 40029:
                    $this->ajaxReturn(['msg' => '程序校验数据失败，请点击按钮再试'], 40029);
                    break;
                default:
                    $this->error('未知错误');
            }
        }

        if(empty($result['session_key'])){
            $this->error('获取用户信息失败，请重新打开小程序');
        }

        $checkCertificate = \Model\Content::findContent('certificate', $result['session_key'], 'certificate_value');

        if(empty($checkCertificate)){

            $openid = $result['openid'];

            //生成一个小程序使用的token
            $token = \Core\Func\CoreFunc::generatePwd($result['session_key'].$result['openid'], 'USER_KEY');

            $this->db('certificate')->insert([
                'certificate_value' => $result['session_key'],
                'certificate_openid' => $openid,
                'certificate_token' => $token,
                'certificate_systeminfo' => md5($systeminfo),
                'certificate_time' => time()
            ]);

            //删除7天前的登录请求数据。
            $this->db('certificate')->where('certificate_time < :certificate_time')->delete([
                'certificate_time' => time() - 86400 * 7
            ]);
        }else{
            $token = $checkCertificate['certificate_token'];
            $openid = $checkCertificate['certificate_openid'];
        }

        $member = \Model\Content::findContent('member', $openid, 'member_wxapp', 'member_id, member_wxapp, member_name, member_avatar');

        if(!empty($member['member_id'])){
            $dataParam = [
                'username' => $member['member_name'],
                'avatar' => $member['member_avatar']
            ];
        }

        $dataParam['token'] = $token;
        $dataParam['signup'] = empty($member['member_id']) ? 0 : 1;

        $this->ajaxReturn([
            'msg' => '登录完成',
            'data' => $dataParam
        ], 200);

    }

    /**
     * 登录鉴权
     */
    public function auth(){
        $check = \Model\API\Member::auth();

        if(!empty($check['member_id'])){
            $dataParam = [
                'username' => $check['member_name'],
                'avatar' => $check['member_avatar']
            ];
        }

        $dataParam['signup'] = empty($check['member_id']) ? 0 : 1;

        $this->success([
            'msg' => '登录校验成功!',
            'data' => $dataParam
        ]);

    }

    public function signup(){

        $data = json_decode($this->isP('data', '请提交用户数据', false), true);

        $check = \Model\API\Member::auth();
        if(!empty($check['member_id'])){
            $this->ajaxReturn([
                'msg' => '您已经注册过账号',
                'data' => [
                    'signup' => 1
                ]
            ], 1);
        }

        //绑定账号
        if(!empty($data['bingAccount'])){

            $member = $this->db('member')->where('member_account = :member_account AND member_password = :member_password AND member_status = 1 AND member_wxapp IS NULL ')->find([
                'member_account' => $data['account'],
                'member_password' => \Core\Func\CoreFunc::generatePwd($data['password'], 'USER_KEY')
            ]);
            if (empty($member)) {
                $this->error('帐号绑定失败!帐号可能不存在、待审核/被禁用、密码错误或已绑定!');
            }

            $this->db('member')->where('member_id = :member_id')->update([
                'noset' => [
                    'member_id' => $member['member_id']
                ],
                'member_wxapp' => $check['certificate_openid']
            ]);

            $this->success([
                'msg' => '账号绑定成功!',
                'data' => [
                    'username' => $member['member_name'],
                    'avatar' => $member['member_avatar']
                ]
            ]);

        }elseif(!empty($data['nickName']) && !empty($data['avatarUrl']) ){
            $randomAccount = \Model\Extra::getOnlyNumber();

            $this->db('member')->insert([
                'member_account' => "wxapp_{$randomAccount}",
                'member_email' => "{$randomAccount}@wxapp.com",
                'member_password' => md5(\Model\Extra::getOnlyNumber()),
                'member_name' => $data['nickName'],
                'member_status' => \Core\Func\CoreFunc::$param['system']['member_review'] == 2 ? 0 : \Core\Func\CoreFunc::$param['system']['member_review'],
                'member_createtime' => time(),
                'member_organize_id' => '1',
                'member_wxapp' => $check['certificate_openid'],
                'member_avatar' => $data['avatarUrl'],
            ]);

            $this->success([
                'msg' => '快速注册完成',
                'data' => [
                    'username' => $data['nickName'],
                    'avatar' => $data['avatarUrl']
                ]
            ]);
        }else{
            $this->error('小程序账号注册出错');
        }
    }

}