<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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