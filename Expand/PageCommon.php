<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Expand;

/**
 * 分页类公共模块
 *
 */
class PageCommon {

    /**
     * 生成分页URL
     * @param $page 当前的分页页码
     * @return string 返回URL
     */
    protected function urlLinkStr($page) {
        unset($_GET['s'], $_GET['page'], $_GET[substr($_SERVER['REQUEST_URI'], 1)]);
        //获取路由模式
        $urlModel = \Core\Func\CoreFunc::loadConfig('URLMODEL');

        $url = \Core\Func\CoreFunc::url(GROUP . '-' . MODULE . '-' . ACTION, $_GET, true);

        if (\Core\Func\CoreFunc::$useRoute === true) {
            $suffix = '';
            if ($urlModel['SUFFIX'] == '1') {
                $suffix = '.html';
            }
            return "{$url}/page/{$page}{$suffix}";
        } else {
            return "{$url}&page={$page}";

        }

    }

}
