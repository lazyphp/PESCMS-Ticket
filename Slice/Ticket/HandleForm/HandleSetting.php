<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace Slice\Ticket\HandleForm;

/**
 * 处理后台 用户添加/编辑提交过来的密码表单
 * @package Slice\Ticket
 */
class HandleSetting extends \Core\Slice\Slice {

    public function before() {
        $license = PES_CORE.'/Core/LICENSE.pes';
        if(is_file($license)){
            $authorize = json_decode(file_get_contents($license), true);
        }

        if((empty($authorize['authorize_type']) || $authorize['authorize_type'] == 5) && METHOD == 'PUT' ){
            $_POST['siteKeywords'] = base64_decode('UEVTQ01TLFBFU0NNUyBUaWNrZXQs5byA5rqQ55qE5bel5Y2V57O757ufLOW3peWNleezu+e7nyzlt6XljZXlrqLmnI3ns7vnu58s5a6i5pyN5bel5Y2V57O757ufLEdQTOW3peWNlSxHUEzlrqLmnI3ns7vnu58sR1BM5bel5Y2V5a6i5pyN57O757uf');
            $_POST['siteDescription'] = base64_decode('UEVTQ01TIFRpY2tldOaYr+S4gOasvuS7pUdQTHYy5Y2P6K6u5Y+R5biD55qE5byA5rqQ5bel5Y2V5a6i5pyN57O757uf');
        }

        $check = strcmp(trim($_SERVER['HTTP_HOST']), trim($authorize['authorize_domain'] ?? ''));

        if($check !== 0){
            is_file($license) ? unlink($license) : '';
        }
        if(( $check !== 0 || empty($authorize['authorize_domain']) ) && METHOD == 'PUT'){
            $_POST['siteTitle'] = 'PESCMS Ticket';
            $_POST['siteLogo'] = DOCUMENT_ROOT.'/Theme/assets/i/logo.png';
            $_POST['siteContact'] = '';
            $_POST['pescmsIntroduce'] = file_get_contents(dirname(__FILE__).'/introduce.php');
        }


    }

    public function after() {
    }


}