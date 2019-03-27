<?php

namespace Expand;

/**
 * 短信接口
 */
class sms {

    private $APIID, $APIKEY;

    public function __construct() {
        $sms_api = json_decode(\Core\Func\CoreFunc::$param['system']['sms'], true);
        if(empty($sms_api)){
            die('未配置短信接口');
        }

        $this->APIID = $sms_api['APIID'];
        $this->APIKEY = $sms_api['APIKEY'];
    }

    public function send($param){
        $post_data = "account={$this->APIID}&password={$this->APIKEY}&mobile=".$param['send_account']."&content=".rawurlencode($param['send_title']);
        $result=  $this->xml_to_array((new \Expand\cURL())->init('http://106.ihuyi.cn/webservice/sms.php?method=Submit', $post_data));

        if($result['SubmitResult']['code'] == 2){
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->delete([
                'send_id' => $param['send_id']
            ]);
        }else{
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->update([
                'noset' => [
                    'send_id' => $param['send_id']
                ],
                'send_result' => $result['SubmitResult']['code']
            ]);
        }

        return $result;
    }

    //将 xml数据转换为数组格式。
    private function xml_to_array($xml){
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = $this-> xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

}