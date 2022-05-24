<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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
