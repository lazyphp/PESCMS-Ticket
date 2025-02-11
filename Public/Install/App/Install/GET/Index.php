<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Install\GET;

class Index extends \App\Install\Common {

    /**
     * 欢迎界面
     */
    public function index() {
        $this->assign('program', 'PESCMS Ticket');
        $this->assign('title', '欢迎使用PESCMS Ticket客服工单系统');
        $this->checkRunning();
        $this->layout();
    }

    /**
     * 验证程序运行情况
     */
    private function checkRunning() {
        $check['php_version'] = version_compare(PHP_VERSION, '7.0.0', '>=');

        $check['pdo'] = extension_loaded('pdo_mysql');

        $check['gd'] = function_exists('gd_info');

        $check['curl'] = function_exists('curl_version');

        $check['fileinfo'] = extension_loaded('fileinfo');

        $check['public'] = stripos($_SERVER['SCRIPT_NAME'], 'Public/') !== false || stripos($_SERVER['REQUEST_URI'], 'Public/') !== false || stripos($_SERVER['DOCUMENT_URI'], 'Public/') !== false ? true : false;

        $this->assign($check);
    }

}
