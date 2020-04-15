<?php

namespace Expand\SMS;

/**
 * 阿里云短信接口
 * @author 王浩铭
 * 本源码基于 https://www.whmblog.cn/php/102.html 提供的代码进行整合而成。
 */
class aliyunSMS implements SMSInterface {

    public $error;
    private $accessKeyId = '';
    private $accessKeySecret = '';
    private $signName = '';

    public function __construct($config) {
        if (empty($config['aliyun_accessKeyId']) || empty($config['aliyun_accessSecret'])) {
            $this->error = '未配置阿里云短信接口信息';
            return $this->error;
        }
        // 配置参数
        $this->accessKeyId = $config['aliyun_accessKeyId'];
        $this->accessKeySecret = $config['aliyun_accessSecret'];
        $this->signName = $config['aliyun_SignName'];

    }

    private function percentEncode($string) {
        $string = urlencode($string);
        $string = preg_replace('/\+/', '%20', $string);
        $string = preg_replace('/\*/', '%2A', $string);
        $string = preg_replace('/%7E/', '~', $string);
        return $string;

    }

    /**
     * 签名
     * @param $parameters
     * @param $accessKeySecret
     * @return string
     */
    private function computeSignature($parameters, $accessKeySecret) {

        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQueryString .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }
        $stringToSign = 'GET&%2F&' . $this->percentencode(substr($canonicalizedQueryString, 1));
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, $accessKeySecret . '&', true));
        return $signature;

    }

    /**
     * @desc 发送短信
     * @param $mobile 手机验证
     * @param $code 随机生成的验证码
     */
    public function send($param) {

        $params = array (
            'SignName' => $this->signName,
            'Format' => 'JSON',
            'Version' => '2017-05-25',
            'AccessKeyId' => $this->accessKeyId,
            'SignatureVersion' => '1.0',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => uniqid(),
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'Action' => 'SendSms',
            'PhoneNumbers' => $param['send_account'],
        );
        $params = array_merge($params, json_decode($param['send_content'], true));

        $params['Signature'] = $this->computeSignature($params, $this->accessKeySecret);

        $url = 'http://dysmsapi.aliyuncs.com/?' . http_build_query($params);

        $result = json_decode((new \Expand\cURL())->init($url), true);

        if ($result['Message'] == 'OK') {
            $sendStatus = [
                'msg' => '短信发送成功。',
                'status' => 2,
                'second' => 0,
            ];
        } else {
            $sendStatus = [
                'msg' => "短信发送失败！{$result['Message']}",
                'status' => 1,
                'second' => 600,
            ];
        }
        $sendStatus['id'] = $param['send_id'];
        $sendStatus['sequence'] = $param['send_sequence'];

        \Model\Extra::updateSendStatus($sendStatus);

        return $sendStatus['msg'];

    }

}