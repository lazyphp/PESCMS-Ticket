<?php

namespace Expand;

/**
 * 微信接口
 */
class weixin {

    public $access_token = '', $error;
    public $appID, $appsecret;
    private $errorNum = 0;

    public function __construct() {
        $initResult = $this->__init();

        //将错误信息生成日志
        if (!empty($this->error)) {
            (new \Expand\Log())->creatLog('weixin_log', date('Y-m-d H:i:s')." {$this->error}\n");
        }
        return $initResult;
    }

    /**
     * 微信接口初始化
     * @return string|void
     */
    public function __init() {
        $weixin_api = json_decode(\Core\Func\CoreFunc::$param['system']['weixin_api'], true);
        if (empty($weixin_api['appID']) || empty($weixin_api['appsecret'])) {
            $this->error = '未配置微信接口信息';
            return $this->error;
        }
        $this->appID = $weixin_api['appID'];
        $this->appsecret = $weixin_api['appsecret'];

        $this->createAccessTokenCache();

    }

    /**
     * 创建微信的接口token
     * @param $reload 是否重载缓存 | 默认不重载
     * @return string|void
     */
    private function createAccessTokenCache($reload = false){
        $FileCache = new FileCache();
        $FileCache->setTime = 6500;

        if($reload == true){
            $FileCache->clearCache('weixin_access_token');
        }

        $result = $FileCache->loadCache('weixin_access_token');
        if (empty($result)) {
            createApiCache:
            $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}");
            if (empty($result)) {
                $this->error = '获取微信access_token失败';
                $FileCache->clearCache('weixin_access_token');
                return $this->error;
            }

            $checkJSON = json_decode($result, true);
            if(empty($checkJSON['access_token'])){
                $this->error = "受网络波动原因，本次请求出错，请再次尝试，若多次出现请联系网站管理员处理。".($checkJSON['errcode'] ?? $result);
                $FileCache->clearCache('weixin_access_token');
                return $this->error;
            }

            $FileCache->creatCache('weixin_access_token', $result);
        }


        $this->access_token = json_decode($result, true)['access_token'];
        if (empty($this->access_token)) {
            $this->error = '解析微信access_token失败';
            if ($this->errorNum > 5) {
                $FileCache->clearCache('weixin_access_token');
                return $this->error;
            } else {
                $this->errorNum++;
                goto createApiCache;
            }

        }
    }

    /**
     * 跳转用户同意授权页面
     * @param string $redirect_uri 重定向地址
     * @param string $state 返回参数
     * @param string $scope 应用授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且， 即使在未关注的情况下，只要用户授权，也能获取其信息 ）
     */
    public function agree($redirect_uri, $state = 'STATE', $scope = 'snsapi_userinfo') {
        $url = urlencode($redirect_uri);

        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appID}&redirect_uri={$url}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    /**
     * 获取用户的access_token
     * @param $code
     */
    public function user_access_token($code) {
        $result = (new cURL())->init("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appID}&secret={$this->appsecret}&code={$code}&grant_type=authorization_code");
        $access_token = json_decode($result, true);

        if (empty($access_token['openid'])) {
            return false;
        }

        return $access_token['openid'];
    }

    /**
     * 获取用户基本信息
     * @param $openid
     * @return mixed
     */
    public function getUser($openid) {

        static $tryAgainToGetUserInfo = 0;

        tryAgainToGetUserInfo:

        $result = json_decode((new cURL())->init("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$this->access_token}&openid={$openid}&lang=zh_CN"), true);

        if(!empty($result['errcode'])){
            (new \Expand\Log())->creatLog('weixin_log', date('Y-m-d H:i:s')." 读取用户信息失败,接口返回错误信息: errcode: {$result['errcode']} errmsg: {$result['errmsg']}\n");

            //token失效，强制刷新
            if($result['errcode'] == '40001'){
                $this->createAccessTokenCache(true);
                if($tryAgainToGetUserInfo == 0){
                    goto tryAgainToGetUserInfo;
                    $tryAgainToGetUserInfo = 1;
                }

            }
        }

        return $result;
    }

    /**
     * 获取模版消息列表
     * @return mixed 返回json解析过的模板列表
     */
    public function getTemplateList() {
        //TM00017 订单状态
        $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={$this->access_token}");
        return json_decode($result, true);
    }

    /**
     * 添加模板
     * @param $id 模板库中模板的编号，有“TM**”和“OPENTMTM**”等形式
     * @return mixed
     */
    public function addTemplate($id) {
        return (new cURL())->init("https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token={$this->access_token}", json_encode(['template_id_short' => $id]));
    }

    /**
     * 删除模板
     * @param $id 公众账号下模板消息ID
     * @return mixed
     */
    public function deleteTemplate($id) {
        return (new cURL())->init("https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token={$this->access_token}", json_encode(['template_id' => $id]));
    }

    /**
     * 发送模板消息
     */
    public function sendTemplate($param) {
        if (!empty($this->error)) {
            \Model\Extra::stopSend($param['send_id'], $this->error);
            return [
                'msg'    => $this->error,
                'status' => 1,
                'second' => 600,
            ];
        }


        $content = json_decode($param['send_content'], true);

        $data = [
            'touser'      => $param['send_account'],
            'template_id' => $param['send_title'],
            'url'         => $content['link'],
            'data'        => $content['data'],
        ];

        $result = json_decode((new cURL())->init("https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->access_token}", json_encode($data)), true);

        if ($result['errcode'] == 0) {
            $sendStatus = [
                'msg'    => '模板消息发送成功。',
                'status' => 2,
                'second' => 0,
            ];
        } else {
            $sendStatus = [
                'msg'    => "模板消息发送失败！{$result['errcode']}",
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
     * 测试微信access_token返回内容
     */
    public function debug_access_token() {
        $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}");
        echo '<pre>';
        echo "微信返回的原始数据：<br/>{$result}";
        echo '<br/>';
        echo '<br/>';
        echo 'PESCMS解析微信返回数据结构:<br/>';
        print_r(json_decode($result));
        echo '<p>本次测试数据不会生产缓存，请在后台点击右上角[清理缓存]，再打开微信客户端进行真实环境测试</p>';
        echo '</pre>';
        echo '<br/>';

        exit;

    }

}