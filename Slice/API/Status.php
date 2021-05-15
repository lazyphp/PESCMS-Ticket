<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


namespace Slice\API;

/**
 * API启用状态
 */
class Status extends \Core\Slice\Slice{

    public function before() {
        if(\Core\Func\CoreFunc::$param['system']['openapi'] == 0){
            $this->jump('/');
        }

    }

    public function after() {
    }


}