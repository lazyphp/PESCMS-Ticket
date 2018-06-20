<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */


namespace Slice\Ticket\HandleForm;

/**
 * 处理后台 用户添加/编辑提交过来的密码表单
 * @package Slice\Ticket
 */
class HandleMember extends \Core\Slice\Slice {

    public function before() {
        $this->checkEmail();
        $this->setPassword();
    }

    public function after() {
    }

    /**
     * 验证邮箱地址
     */
    private function checkEmail(){

        if(!in_array(METHOD, ['POST', 'PUT'])){
            return true;
        }

        $condition = ' member_email = :member_email ';
        $param = [];

        $param['member_email'] = $this->isP('email', '请提交邮箱地址');
        if(\Model\Extra::checkInputValueType($param['member_email'], 1) === false){
            $this->error("邮箱地址 '{$param['member_email']}' 不正确");
        }

        if(METHOD == 'PUT'){
            $condition .= ' AND member_id != :member_id ';
            $param['member_id'] = $this->isP('id', '请提交您要编辑的会员ID');
        }

        $check = $this->db('member')->where($condition)->find($param);
        if(!empty($check)){
            $this->error("邮箱地址 '{$param['member_email']}' 已存在");
        }

    }

    /**
     * 设置密码
     */
    private function setPassword(){
        if (METHOD == 'POST') {
            $this->isP('password', '请填写密码');
        }

        if (empty($_POST['password'])) {
            $_POST['password'] = \Model\Content::findContent('member', $_POST['id'], 'member_id')['member_password'];
        } else {
            $_POST['password'] = (string)\Core\Func\CoreFunc::generatePwd($this->p('password'), 'USER_KEY');
        }
    }


}