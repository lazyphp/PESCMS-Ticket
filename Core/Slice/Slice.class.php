<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Core\Slice;

/**
 * 切片抽象类
 */
abstract class Slice extends \Core\Controller\Controller {

    abstract public function before();

    abstract public function after();

}