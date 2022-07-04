<?php

namespace Expand;

/**
 * 钉钉企业接口
 */
class dingtalk {

    public $access_token = '';
    public $AgentId, $AppKey, $AppSecret, $error;

    public function __construct(){
        $initResult = $this->__init();

        //将错误信息生成日志
        if (!empty($this->error)) {
            (new \Expand\Log())->creatLog('dingtalk_log', date('Y-m-d H:i:s')." {$this->error}\n");
        }
        return $initResult;
    }

    public function __init() {
        $dingtalkSetting = json_decode(\Core\Func\CoreFunc::$param['system']['dingtalk'], true);
        if(empty($dingtalkSetting['AppKey']) || empty($dingtalkSetting['AppSecret'])){
            $this->error = '未配置钉钉企业接口信息';
            return $this->error;
        }

        //应用AgentId
        $this->AgentId = $dingtalkSetting['AgentId'];
        //应用AppKey
        $this->AppKey = $dingtalkSetting['AppKey'];
        //应用AppSecret
        $this->AppSecret = $dingtalkSetting['AppSecret'];

        $FileCache = new FileCache();
        $FileCache->setTime = 7200;
        $result = $FileCache->loadCache('dingtalk_access_token');
        if(empty($result)){
            $result = (new cURL())->init("https://oapi.dingtalk.com/gettoken?appkey={$this->AppKey}&appsecret={$this->AppSecret}");

            if(empty($result)){
                $this->error = '获取钉钉企业access_token失败';
                $FileCache->clearCache('dingtalk_access_token');
                return $this->error;
            }

            $checkJSON = json_decode($result, true);
            if(empty($checkJSON['access_token'])){
                $this->error = "受网络波动原因，本次请求出错，请再次尝试，若多次出现请联系网站管理员处理。".($checkJSON['errmsg'] ?? $result);
                $FileCache->clearCache('dingtalk_access_token');
                return $this->error;
            }

            $FileCache->creatCache('dingtalk_access_token', $result);
        }
        $this->access_token = json_decode($result, true)['access_token'];
        if(empty($this->access_token)){
            $this->error = '解析钉钉企业access_token失败';
            $FileCache->clearCache('dingtalk_access_token');
            return $this->error;
        }
    }

    /**
     * 通知对应的微信号
     * @param $param 发送内容
     */
    public function send_notice($param) {
        if(!empty($this->error)){
            \Model\Extra::stopSend($param['send_id'], $this->error);
            return $this->error;
        }
        $result = json_decode($this->notice($param['send_account'], htmlspecialchars_decode($param['send_content'])), true);



        //发送成功，删除消息
        if($result['errcode'] == '0' && !empty($result['task_id']) ){
            $sendStatus = [
                'msg' => '钉钉企业通知发送成功。',
                'status' => 2,
                'second' => 0,
            ];
        }else{
            $sendStatus = [
                'msg' => "钉钉企业通知发送失败！{$result['errmsg']}",
                'status' => 1,
                'second' => 600,
            ];
        }
        $sendStatus['id'] = $param['send_id'];
        $sendStatus['sequence'] = $param['send_sequence'];
        $sendStatus['full'] = $result;

        \Model\Extra::updateSendStatus($sendStatus);

        return $sendStatus;

    }

    /**
     * 发送钉钉企业应用消息通知
     * @param $account 接收消息账号
     * @param $content 发送的内容
     * @return mixed
     */
    public function notice($account, $content){
        return (new cURL())->init("https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2?access_token={$this->access_token}", [
            'agent_id'=> $this->AgentId,
            'userid_list' => $account,
            'msg' => json_encode([
                'msgtype' => 'text',
                'text' => [
                    'content' => strip_tags($content),
                ]
            ])
        ]);
    }

    /**
     * 测试微信access_token返回内容
     */
    public function debug_access_token(){
        $result = (new cURL())->init("https://oapi.dingtalk.com/gettoken?appkey={$this->AppKey}&appsecret={$this->AppSecret}");
        echo '<pre>';
        echo "钉钉企业返回的原始数据：<br/>{$result}";
        echo '<br/>';
        echo '<br/>';
        echo 'PESCMS解析钉钉企业返回数据结构:<br/>';
        print_r(json_decode($result));
        echo '<p>本次测试数据不会生产缓存，请在后台点击右上角[清理缓存]，再打开钉钉企业客户端进行真实环境测试</p>';
        echo '</pre>';
        echo '<br/>';
        exit;

    }

}