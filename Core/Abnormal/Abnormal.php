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
        \Core\Func\CoreFunc::isAjax(['msg' => $this->message], 0);
    }

}
