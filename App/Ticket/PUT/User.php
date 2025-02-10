<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace App\Ticket\PUT;

class User extends Content {

    public function action($jump = TRUE, $commit = TRUE) {
        if($_POST['id'] == 1 && $this->session()->get('ticket')['user_id'] != 1){
            $this->error('天呐，您竟然敢修改超级管理账户！');
        }
        parent::action($jump, $commit);
    }

    /**
     * 个人设置
     */
    public function setting() {
        $this->checkToken();
        $userID = $this->session()->get('ticket')['user_id'];
        foreach (['账号' => 'account', '邮箱' => 'mail', '企业微信' => 'weixinWork'] as $key => $item) {
            if ($item == 'weixinWork') {
                $data["user_{$item}"] = $this->p($item);
                if (!empty($data["user_{$item}"])) {
                    $this->checkUnique($key, $item, $userID, $data);
                } else {
                    $data["user_{$item}"] = NULL;
                }
            } else {
                $data["user_{$item}"] = $this->isP($item, "{$key}没有填写");
                $this->checkUnique($key, $item, $userID, $data);
            }
        }

        if(strcmp($data['user_account'], $this->session()->get('ticket')['user_account']) != 0 && ( empty($_POST['password']) || empty($_POST['repassword']) ) ){
            $this->error('修改登录账号需要填写新密码');
        }

        if (!empty($_POST['password']) && !empty($_POST['repassword'])) {

            $password = \Model\Extra::verifyPassword();
            $data['user_password'] = \Core\Func\CoreFunc::generatePwd($data['user_account'] . $password);

        }

        $data['user_name'] = $this->isP('name', '请提交名称');
        $data['user_vacation'] = $this->isP('vacation', '请提交您的状态');
        $data['user_browser_msg'] = $this->p('browser_msg');
        $data['user_browser_msg_time'] = $this->p('browser_msg_time');
        $data['user_suspension_button'] = $this->p('suspension_button');
        $data['user_ticket_status'] = $this->p('user_ticket_status');
        $data['user_cs_panel'] = (int) $this->p('user_cs_panel');
        $data['user_open_search'] = (int) $this->p('user_open_search');
        $data['noset']['user_id'] = $userID;
        $this->db('user')->where('user_id = :user_id')->update($data);

        $newInfo = array_merge($this->session()->get('ticket'), $data);

        $this->session()->set('ticket', $newInfo);

        $this->success('个人信息已更新');

    }

    /**
     * 验证唯一信息
     * @param $key
     * @param $item
     * @param $userID
     * @param $data
     */
    private function checkUnique($key, $item, $userID, $data) {
        $check = $this->db('user')->where("user_{$item} = :{$item} AND user_id != :user_id")->find([
            $item => $data["user_{$item}"],
            'user_id' => $userID
        ]);
        if (!empty($check)) {
            $this->error("{$key}{$data["user_{$item}"]}已经存在");
        }
    }
}