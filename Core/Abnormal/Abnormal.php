<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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
        \Core\Func\CoreFunc::isAjax(['msg' => $this->message], 0);
    }

}
