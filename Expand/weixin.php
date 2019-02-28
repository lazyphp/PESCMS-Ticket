<?php

namespace Expand;

/**
 * 微信接口
 */
class weixin {

    public $access_token = '';
    private $appID, $appsecret;

    public function __construct() {
        $weixin_api = json_decode(\Core\Func\CoreFunc::$param['system']['weixin_api'], true);
        if(empty($weixin_api)){
            die('未配置微信接口信息');
        }
        $this->appID = $weixin_api['appID'];
        $this->appsecret = $weixin_api['appsecret'];

        $FileCache = new FileCache();
        $FileCache->setTime = 7200;
        $result = $FileCache->loadCache('access_token');
        if(empty($result)){
            $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}");
            if(empty($result)){
                die('获取微信access_token失败');
            }
            $FileCache->creatCache('access_token', $result);
        }
        $this->access_token = json_decode($result, true)['access_token'];
        if(empty($this->access_token)){
            die('解析微信access_token失败');
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

}