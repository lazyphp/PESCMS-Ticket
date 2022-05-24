<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Ticket\GET;

class Login extends \Core\Controller\Controller{

    public function index(){
        $this->display();
    }

    /**
     * 企业微信登录入口
     */
    public function agree(){
        $weixinWork = new \Expand\weixinWork();
        $this->assign('login', $weixinWork->agree(\Core\Func\CoreFunc::$param['system']['domain'].$this->url('Ticket-Login-weixinWork')));
        $this->display();
    }

    /**
     * 企业微信执行登录
     * @todo 废弃
     */
    public function weixinWork() {
        if (empty($_GET['code'])) {
            $this->error('获取参数失败');
        }
        $weixinWork = new \Expand\weixinWork();
        $weixinWork->user($_GET['code']);
    }

    public function logout(){
        $this->session()->destroy();
        $this->jump($this->url('Ticket-Login-index'));
    }

}