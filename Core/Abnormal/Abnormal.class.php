<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @version 2.5
 */

namespace Core\Abnormal;

/**
 * PES异常机制
 * @author LuoBoss
 * @version 1.0
 */
class Abnormal extends \Exception {
    

    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * ajax请求的异常信息提示
     */
    public function getTraceAsAjax() {
        $type = explode(',', $_SERVER['HTTP_ACCEPT']);
        $status['status'] = 0;
        $status['info'] = $this->message;
        switch ($type[0]) {
            case 'application/json':
                exit(json_encode($status));
                break;
            case 'text/javascript':
                // javascript 或 JSONP 格式  需要扩展
                exit();
                break;
            case 'text/html':
                exit($status);
                break;
            case 'application/xml':
                //  XML 格式  需要扩展
                exit();
                break;
        }
    }

}
