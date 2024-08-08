<?php

namespace Model;

use Model\SendLimit;

/**
 * 发送限制链式操作包装类
 */
class SendLimitWrapper {

    public $sendCount = 0;

    public function __construct() {
        SendLimit::init();

        $this->sendCount =
            (SendLimit::$limitSession['count'] ?? 0) > SendLimit::$sendCount ?
                SendLimit::$limitSession['count'] : SendLimit::$sendCount;
        return $this;
    }

    public function getLimitFromAccountAndType($account, $type, $msg = '请勿频繁发起请求') {
        SendLimit::getLimitFromAccountAndType($account, $type, $msg);
        return $this;
    }

    public function verifyCode() {
        SendLimit::verifyCode();
        return $this;
    }

    public function getLimitFromSession($msg = '请勿频繁发起请求') {
        SendLimit::getLimitFromSession($msg);
        return $this;
    }

    public function getLimitFromIP($msg = '请勿频繁发起请求') {
        SendLimit::getLimitFromIP($msg);
        return $this;
    }

    public function addRecord($account, $type) {
        SendLimit::addRecord($account, $type);
        return $this;
    }
}