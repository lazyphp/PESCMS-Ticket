<?php

namespace Expand\SMS;

/**
 * 短信接口
 */
class SMSMain {

    public function send(array $param) {
        $smsConfig = json_decode(\Core\Func\CoreFunc::$param['system']['sms'], true);

        switch ($smsConfig['COMPANY']){
            case '1':
                $name = 'aliyunSMS';
                break;
            case '2':
                $name = 'ihuyiSMS';
                break;
            default:
                $error = '未知的短信接口设置';
                \Model\Extra::stopSend($param['send_id'], $error);
                return $error;
        }

        $objName= "\\Expand\\SMS\\{$name}";
        $result = (new $objName($smsConfig))->send($param);
        return $result;
    }

}