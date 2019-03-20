<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2016 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


namespace App\Ticket\PUT;

class User extends Content {

    /**
     * 个人设置
     */
    public function setting() {
        $userID = $this->session()->get('ticket')['user_id'];
        foreach (['帐号' => 'account', '邮箱' => 'mail', '企业微信' => 'weixinWork'] as $key => $item) {
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
            $this->error('修改登录帐号需要填写新密码');
        }

        if (!empty($_POST['password']) && !empty($_POST['repassword'])) {
            if (strcmp(trim($_POST['password']), trim($_POST['repassword'])) != 0) {
                $this->error('两次输入的密码不一致');
            }
            $data['user_password'] = \Core\Func\CoreFunc::generatePwd($data['user_account'] . $this->p('password'));

        }

        $data['user_name'] = $this->isP('name', '请提交名称');
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