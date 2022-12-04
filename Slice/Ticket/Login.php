<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace Slice\Ticket;

/**
 * 登录验证切片
 * Class Login
 * @package Slice\Ticket
 */
class Login extends \Core\Slice\Slice{

    public function before() {
        
        //埋入登录切片插件事件
        (new \Core\Plugin\Plugin())->event('loginSlice', NULL);

        if(!empty($_GET['_notice_login'])){
            $notice_login = $this->g('_notice_login');
            if(strcmp($notice_login, \Model\Option::getNoticeLoginParam()) === 0){
                $this->session()->set('backstage', '1');
            }
        }

        if(empty($this->session()->get('backstage'))){
            $this->jump('/');
        }

        //已登录引导回首页
        if(MODULE == 'Login' && ACTION == 'index' && !empty($this->session()->get('ticket')['user_id']) ){
            $this->jump($this->url('Ticket-Ticket-index'));
        }

        if(MODULE != 'Login' && empty($this->session()->get('ticket')['user_id'])){
            $this->jump($this->url('Ticket-Login-index', ['back_url' => base64_encode($_SERVER['REQUEST_URI'])]));
        }
    }

    public function after() {
    }


}