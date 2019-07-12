<?php

/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (https://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
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
        $phpVersion = explode('.', phpversion());
        $version = "{$phpVersion['0']}.{$phpVersion['1']}";
        $check['php_version'] =  $version >= 5.6 ? true : false;

        $check['pdo'] = in_array('pdo_mysql', get_loaded_extensions()) ? true : false;

        $check['gd'] = function_exists('gd_info') ? true : false;

        $check['curl'] = function_exists('curl_version') ? true : false;

        $this->assign($check);
    }

}
