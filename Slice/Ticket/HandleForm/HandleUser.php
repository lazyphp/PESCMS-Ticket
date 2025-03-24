<?php
/**
 * Copyright (c) 2022 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Slice\Ticket\HandleForm;

/**
 * 处理后台 用户添加/编辑提交过来的密码表单
 * @package Slice\Ticket
 */
class HandleUser extends \Core\Slice\Slice {

    public function before() {

        if (METHOD == 'GET' && empty($_GET['id'])) {
            $job_number = \Model\User::generateJobNumber();
            $this->assign('job_number', $job_number);
        }

        if (!in_array(METHOD, ['POST', 'PUT'])) {
            return true;
        }

        if (METHOD == 'POST') {
            $this->isP('password', '请填写密码');
        }

        if (METHOD == 'PUT') {
            $account = \Model\Content::findContent(['0' => 'user', '1' => true], $_POST['id'], 'user_id', 'user_account')->emptyTips('客服账户不存在')['user_account'];

            if ($account !== $this->p('account') && empty($_POST['password'])) {
                $this->error('若要修改客服账户请输入新密码，否则客服账户变更将无法登录。');
            }


        }

        if (empty($_POST['password'])) {
            $_POST['password'] = \Model\Content::findContent('user', $_POST['id'] ?? '', 'user_id', 'user_password')['user_password'] ?? '';
        } else {
            $account = $this->p('account');
            $_POST['password'] = (string)\Core\Func\CoreFunc::generatePwd($account . $this->p('password'));
        }


    }

    public function after() {
    }


}