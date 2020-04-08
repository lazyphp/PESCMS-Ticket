<?php

namespace Expand;

/**
 * 企业微信接口
 */
class weixinWork {

    public $access_token = '';
    private $corpid, $AgentId, $Secret, $error;

    public function __construct() {
        $weixinWork_api = json_decode(\Core\Func\CoreFunc::$param['system']['weixinWork_api'], true);
        if(empty($weixinWork_api['corpid']) || empty($weixinWork_api['AgentId'])){
            $this->error = '未配置企业微信接口信息';
            return $this->error;
        }
        //企业ID
        $this->corpid = $weixinWork_api['corpid'];
        //应用序号
        $this->AgentId = $weixinWork_api['AgentId'];
        //应用Secret
        $this->Secret = $weixinWork_api['Secret'];

        $FileCache = new FileCache();
        $FileCache->setTime = 7200;
        $result = $FileCache->loadCache('weixinWork_access_token');
        if(empty($result)){
            $result = (new cURL())->init("https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$this->corpid}&corpsecret=$this->Secret");

            if(empty($result)){
                $this->error = '获取企业微信access_token失败';
                return $this->error;
            }
            $FileCache->creatCache('weixinWork_access_token', $result);
        }
        $this->access_token = json_decode($result, true)['access_token'];
        if(empty($this->access_token)){
            $this->error = '解析企业微信access_token失败';
            return $this->error;
        }
    }

    /**
     * 通知对应的微信号
     * @param $param 发送内容
     */
    public function send_notice($param) {
        if(!empty($this->error)){
            \Model\Extra::errorSendResult($param['send_id'], $this->error);
            return $this->error;
        }
        $result = json_decode($this->notice($param['send_account'], $param['send_content']), true);

        //发送成功，删除消息
        if($result['errmsg'] == 'ok' && empty($result['invaliduser']) ){
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->delete([
                'send_id' => $param['send_id']
            ]);
        }else{
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->update([
                'noset' => [
                    'send_id' => $param['send_id']
                ],
                'send_result' => $result['errmsg']
            ]);
        }

        return json_encode($result);

    }

    /**
     * 发送企业微信应用消息通知
     * @param $account 接收消息帐号
     * @param $content 发送的内容
     * @return mixed
     */
    public function notice($account, $content){
        return (new cURL())->init("https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token={$this->access_token}", json_encode([
            "touser" => $account,
            "msgtype" => "text",
            "agentid" => $this->AgentId,
            "text" => [
                "content" => strip_tags(htmlspecialchars_decode($content), '<a><br>')
            ]
        ]));
    }

    /**
     * 测试微信access_token返回内容
     */
    public function debug_access_token(){
        $result = (new cURL())->init("https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$this->corpid}&corpsecret=$this->Secret");
        echo '<pre>';
        echo "企业微信返回的原始数据：<br/>{$result}";
        echo '<br/>';
        echo '<br/>';
        echo 'PESCMS解析企业微信返回数据结构:<br/>';
        print_r(json_decode($result));
        echo '</pre>';
        echo '<br/>';
        exit;

    }

    /**
     * 企业微信用户登录授权页面
     * @deprecated 废弃
     */
    public function agree($redirect_uri, $scope = 'snsapi_base'){
        $url = urlencode($redirect_uri);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->corpid}&redirect_uri={$url}&response_type=code&scope=SCOPE&agentid={$this->AgentId}&state=STATE#wechat_redirect";
    }

}