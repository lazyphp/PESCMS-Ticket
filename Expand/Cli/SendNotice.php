<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

require 'Core.php';

/**
 * @todo 由于一些历史原因，这个文件现在不能随便改名了，改名将会导致老用户升级后，程序定时任务失效。
 * 只能在这里进行一个扩展，以便支持插件的定时任务。
 * 当然了，以后有更好的解决方案，会在新版本中进行调整。
 */
class SendNotice extends Core {

    /**
     * @return void
     */
    public function notice() {
        $noticeWay = \Model\Content::findContent('option', 'notice_way', 'option_name')['value'];
        if (in_array($noticeWay, ['2', '3'])) {
            \Model\Notice::sendNotice();
        }

        \Model\Behavior::behavior();

    }

    public function pluginCrontab(){

    }

}

$cronTab = new SendNotice();
$cronTab->notice();
$cronTab->pluginCrontab();