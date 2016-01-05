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
 * 切片接口
 * 定义规则，所有切片实现需要继承
 * Interface interfaceSlice
 * @package Slice
 */
interface interfaceSlice
{
    public function before();
    public function after();
}