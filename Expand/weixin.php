<?php

namespace Expand;

/**
 * 微信接口
 */
class weixin {

    public $access_token = '', $error;
    private $appID, $appsecret;

    public function __construct() {
        $weixin_api = json_decode(\Core\Func\CoreFunc::$param['system']['weixin_api'], true);
        if(empty($weixin_api['appID']) || empty($weixin_api['appsecret']) ){
            $this->error = '未配置微信接口信息';
            return $this->error;
        }
        $this->appID = $weixin_api['appID'];
        $this->appsecret = $weixin_api['appsecret'];

        $FileCache = new FileCache();
        $FileCache->setTime = 7200;
        $result = $FileCache->loadCache('access_token');
        if(empty($result)){
            $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}");
            if(empty($result)){
                $this->error = '获取微信access_token失败';
                return $this->error;
            }
            $FileCache->creatCache('access_token', $result);
        }
        $this->access_token = json_decode($result, true)['access_token'];
        if(empty($this->access_token)){
            $this->error = '解析微信access_token失败';
            return $this->error;
        }
    }

    /**
     * 跳转用户同意授权页面
     * @param string $scope 应用授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且， 即使在未关注的情况下，只要用户授权，也能获取其信息 ）
     */
    public function agree($redirect_uri, $scope = 'snsapi_base'){
        $url = urlencode($redirect_uri);

        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appID}&redirect_uri={$url}&response_type=code&scope={$scope}&state=STATE#wechat_redirect";
    }

    /**
     * 获取用户的access_token
     * @param $code
     */
    public function user_access_token($code){
        $result = (new cURL())->init("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appID}&secret={$this->appsecret}&code={$code}&grant_type=authorization_code");
        $access_token = json_decode($result, true);
        if(empty($access_token['openid']) ){
            die('获取openid失败');
        }

        return $access_token['openid'];
    }

    /**
     * 获取用户基本信息
     * @param $openid
     * @return mixed
     */
    public function getUser($openid){
        $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$this->access_token}&openid={$openid}&lang=zh_CN");
        return json_decode($result, true);
    }

    /**
     * 获取模版消息列表
     * @return mixed 返回json解析过的模板列表
     */
    public function getTemplateList(){
        //TM00017 订单状态
        $result =(new cURL())->init("https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={$this->access_token}");
        return json_decode($result, true);
    }

    /**
     * 添加模板
     * @param $id 模板库中模板的编号，有“TM**”和“OPENTMTM**”等形式
     * @return mixed
     */
    public function addTemplate($id){
        return (new cURL())->init("https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token={$this->access_token}", json_encode(['template_id_short' => $id]));
    }

    /**
     * 删除模板
     * @param $id 公众帐号下模板消息ID
     * @return mixed
     */
    public function deleteTemplate($id){
        return (new cURL())->init("https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token={$this->access_token}", json_encode(['template_id' => $id]));
    }

    /**
     * 发送模板消息
     */
    public function sendTemplate($param){
        if(!empty($this->error)){
            \Model\Extra::errorSendResult($param['send_id'], $this->error);
            return $this->error;
        }


        $content = json_decode($param['send_content'], true);

        $data = [
            'touser' => $param['send_account'],
            'template_id' => $param['send_title'],
            'url' => $content['link'],
            'data' => $content['data']
        ];

        $result = json_decode((new cURL())->init("https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->access_token}", json_encode($data)), true);

        if($result['errcode'] == 0){
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->delete([
                'send_id' => $param['send_id']
            ]);
        }else{
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->update([
                'noset' => [
                    'send_id' => $param['send_id']
                ],
                'send_result' => $result['errcode']
            ]);
        }

        return json_encode($result);
    }

    /**
     * 测试微信access_token返回内容
     */
    public function debug_access_token(){
        $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}");
        echo '<pre>';
        echo "微信返回的原始数据：<br/>{$result}";
        echo '<br/>';
        echo '<br/>';
        echo 'PESCMS解析微信返回数据结构:<br/>';
        print_r(json_decode($result));
        echo '</pre>';
        echo '<br/>';
        exit;

    }

}