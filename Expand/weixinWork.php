<?php

namespace Expand;

/**
 * 企业微信接口
 */
class weixinWork {

    public $access_token = '';
    private $corpid, $AgentId, $Secret;

    public function __construct() {
        $weixinWork_api = json_decode(\Core\Func\CoreFunc::$param['system']['weixinWork_api'], true);
        if(empty($weixinWork_api)){
            die('未配置企业微信接口信息');
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
                die('获取企业微信access_token失败');
            }
            $FileCache->creatCache('weixinWork_access_token', $result);
        }
        $this->access_token = json_decode($result, true)['access_token'];
        if(empty($this->access_token)){
            die('解析企业微信access_token失败');
        }
    }

    public function user(){
        $a = (new cURL())->init("https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token={$this->access_token}&id=ID");
        echo '<pre>';
        print_r($a);
        echo '</pre>';
        echo '<br/>';
        exit;

    }

}