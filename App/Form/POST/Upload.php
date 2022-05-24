<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */
namespace App\Form\POST;

class Upload extends \Core\Controller\Controller {

    /**
     * 百度编辑器上传控件
     * @description 本上传方法直接基于百度原有的上传库。PESCMS在此之上进行二次安全转换（主要在图片处理上和上传目录）。
     */
    public function ueditor() {
        //上传大文件，可能需要较大的内存，默认设定为1G
        ini_set ('memory_limit', '1024M');
        echo (new \Expand\UEupload\UEController())->action();
    }

}