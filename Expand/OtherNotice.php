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
 * 其他通知方式实现
 * Class OtherNotice
 * @package Expand
 */
class OtherNotice {

    /**
     * 是否删除工单消息通知发送动作
     * @var bool 默认是删除
     */
    public $removeTicketNoticeAction = true;

    public function __construct() {
        //如果你编写自己的通知方式，请务必将此值设置为false，否则你的消息通知行为将无法写入send表。
       //$this->removeTicketNoticeAction = false;
    }

    /**
     * 如果您需要增加其他联系方式，请在此处进行扩展
     */
    public function send($param){
        if (1 == 1) {
            $sendStatus = [
                'msg' => '新增联系方式发送完成。',
                'status' => 2,
                'second' => 0,
            ];
        }else{
            $sendStatus = [
                'msg' => '新增联系方式发送失败!',
                'status' => 1,
                'second' => 600,
            ];
        }

        $sendStatus['id'] = $param['send_id'];
        $sendStatus['sequence'] = $param['send_sequence'];
        $sendStatus['full'] = '';

        \Model\Extra::updateSendStatus($sendStatus);

        return $sendStatus;
    }

    /**
     * 匹配通知模板的标题
     * 请参考\Model\MailTemplate::matchTitle方法
     */
    public function matchTitle($param){

    }

    /**
     * 匹配通知模板的内容
     * 请参考\Model\MailTemplate::matchContent方法
     */
    public function matchContent($param){

    }

}