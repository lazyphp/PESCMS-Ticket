<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model;

/**
 * 额外的模型
 * 主要存放一些冷门，定位不准确，傻傻的方法
 */
class Extra extends \Core\Model\Model {

    const EMAIL = 1;
    const URL = 2;
    const NUMBER = 3;
    const ALPHANUMERIC = 4;
    const PHONE = 5;

    /**
     * 生成唯一的ID
     */
    public static function getOnlyNumber() {
        $randStr = range('A', 'Z');
        shuffle($randStr);
        $microtime = explode(" ", microtime());
        $number = round($microtime['0'] * $microtime['1'] * rand(1, 100));

        $No = "";
        for ($i = 0; $i < rand(1, 10); $i++) {
            $No .= $randStr[$i];
        }
        return $No . $number;
    }


    /**
     * 验证输入的内容类型
     * @param $value 输入的内容
     * @param $type 验证的类型
     * @return bool 符合则返回true，反之false
     */
    public static function checkInputValueType($value, $type) {
        switch ($type) {
            case 1:
                return filter_var($value, FILTER_VALIDATE_EMAIL);
            case 2:
                $preg = "/^1[3456789]\d{9}$/";
                if (!preg_match($preg, $value)) {
                    return false;
                }

                break;
            case 3:
                if (!is_numeric($value)) {
                    return false;
                }
                break;
            case 4:
                if(!preg_match("/^[a-z\d]$/i",$value)){
                    return false;
                }
                break;
            case 5:
                return filter_var($value, FILTER_VALIDATE_URL);
        }
        return true;
    }

    /**
     * 快速插入通知
     * @param string $title 标题 | 可以为空
     * @param $content 发送的内容
     * @param $type 通知类型
     * @return mixed
     */
    public static function insertSend($account, $title = '', $content, $type){
        $param = [
            'send_account' => $account,
            'send_title' => $title,
            'send_time' => '0',
            'send_type' => $type
        ];


        if(is_array($content)){
            $param['send_content'] =  $content['mail'];
            //为了兼容短信
            if($type == 2){
                $param['send_title'] = $content['sms'];
                $param['send_content'] = $content['sms'];
            }
        }else{
            $param['send_content'] = $content;
        }

        return self::db('send')->insert($param);
    }

    /**
     * 执行通知发送
     */
    public static function actionNoticeSend(){
        foreach (\Model\Content::listContent(['table' => 'send']) as $value) {
            //@todo 目前仅有邮件发送，日后再慢慢完善其他通知方式
            switch ($value['send_type']) {
                case '1':
                    (new \Expand\Notice\Mail())->send($value);
                    break;
                case '4':
                    (new \Expand\weixinWork())->send_notice($value);
                    break;
            }
        }
    }

}
