<?php

/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (https://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Install;

class Common extends \Core\Controller\Controller {

    protected $version;

    public function __init() {
        if (is_file(APP_PATH . 'install.txt')) {
            $this->error('不能再次执行安装程序！');
        }

        if(is_file(APP_PATH.'version')){
            $this->version = file(APP_PATH.'version')[0];
        }else{
            $this->version = 'Unknown Version';
        }

        $this->assign('version', $this->version);

    }

}