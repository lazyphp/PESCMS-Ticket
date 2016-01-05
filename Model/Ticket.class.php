<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */

namespace Model;

class Ticket extends \Core\Model\Model {


    /**
     * 插入用户提交过来的工单内容
     */
    public static function insert() {
        $number = self::isP('number', '请提交您要生成的工单');
        $field = \Model\TicketForm::getFormWithNumber($number);

        $firstContent = current($field);
        if ($firstContent['ticket_status'] == '0') {
            self::error('已关闭该工单的提交');
        }

        $param['ticket_title'] = self::isP('title', '请填写简明扼要的问题描述，以便客户能够快速反馈问题');
        //@todo 联系方式此处需要联动查询，匹配用户选择的联系方式是否存在
        $param['ticket_contact'] = self::isP('contact', '请选择联系方式');
        $param['ticket_contact_account'] = self::isP('contact_account', '请填写您的联系信息');
        if (\Model\Extra::checkInputValueType($param['ticket_contact_account'], $param['ticket_contact']) === false) {
            self::error('您填写联系方式的信息格式不正确。');
        }

        $param['ticket_number'] = \Model\Extra::getOnlyNumber();
        $param['ticket_model_id'] = $firstContent['ticket_model_id'];
        $param['ticket_submit_time'] = time();

        if ($firstContent['ticket_model_verify'] == '1') {
            $verify = self::isP('verify', '请填写验证码');
            if (md5($verify) != $_SESSION['verify']) {
                self::error('验证码错误');
            }
        }


        self::db()->transaction();

        $creatTicket = self::db('ticket')->insert($param);
        if ($creatTicket === false) {
            self::db()->rollback();
            self::error('创建工单失败');
        }

        self::insertContent($creatTicket, $field);

        \Model\Extra::insertSend(
            $param['ticket_contact_account'],
            \Model\MailTemplate::matchTitle($param['ticket_number'], '1'),
            \Model\MailTemplate::matchContent([
                'number' => $param['ticket_number'],
                'view' => \Model\MailTemplate::getViewLink($param['ticket_number'])
            ], '1'),
            $param['ticket_contact']
        );


        self::db()->commit();
        $domain = \Model\Content::findContent('option', 'domain', 'option_name');
        self::success($domain['value'] . self::url('Form-View-ticket', ['number' => $param['ticket_number']]));


    }

    /**
     * 记录提交的工单表单内容
     * @param $ticketID 创建的工单ID
     * @param $field 对应工单的字段
     */
    private static function insertContent($ticketID, $field) {
        $formID = [];
        array_walk($field, function ($value) use (&$formID) {
            $formID[$value['ticket_form_id']] = $value['ticket_form_name'];
        });

        foreach ($field as $key => $value) {
            $form = self::p($value['ticket_form_name']);
            if (is_array($form)) {
                $form = implode(',', $form);
            }

            if ($value['ticket_form_required'] == '1' || $value['ticket_form_bind'] > 0) {
                $msg = empty($value['ticket_form_msg']) ? "{$value['ticket_form_description']}为必填项" : $value['ticket_form_msg'];

                if (empty($form) && !is_numeric($form) && !is_string($form) && $value['ticket_form_bind'] == 0) {
                    self::error($msg);
                } elseif ($value['ticket_form_bind'] > 0 && in_array($_POST[$formID[$value['ticket_form_bind']]], explode(',', $value['ticket_form_bind_value'])) && $value['ticket_form_required'] == '1' && empty($form) && !is_numeric($form) && !is_string($form)) {
                    self::error($msg);
                }
            }

            //@todo 这里还差一个工单表单类型验证功能

            $result = self::db('ticket_content')->insert(['ticket_id' => $ticketID, 'ticket_form_id' => $value['ticket_form_id'], 'ticket_form_content' => $form]);
            if ($result === false) {
                self::db()->rollback();
                self::error('记录工单内容出错');
            }

        }

    }

    /**
     * 获取用户提交的工单表单内容
     * @param $id 工单ID
     * @return 返回查询得到的内容
     */
    public static function getTicketContent($id) {
        $form = [];
        $result = self::db('ticket_content AS tc')->join(self::$modelPrefix . 'ticket_form AS tf ON tf.ticket_form_id = tc.ticket_form_id')->where('tc.ticket_id = :ticket_id')->order('tf.ticket_form_listsort ASC, tf.ticket_form_id DESC')->select(['ticket_id' => $id]);
        if (empty($result)) {
            return $form;
        }
        //组装一下，让他ticket_form_id成为键值
        foreach ($result as $value) {
            $form[$value['ticket_form_id']] = $value;
            $form[$value['ticket_form_id']]['ticket_value'] = $value['ticket_form_content'];
            if (in_array($value['ticket_form_type'], ['radio', 'checkbox', 'select'])) {
                $form[$value['ticket_form_id']]['ticket_form_option'] = json_decode(htmlspecialchars_decode($value['ticket_form_option']), true);
                $form[$value['ticket_form_id']]['ticket_value'] = array_search($value['ticket_form_content'], $form[$value['ticket_form_id']]['ticket_form_option']);
            }

            if ($value['ticket_form_bind'] > 0) {
                $form[$value['ticket_form_id']]['ticket_form_bind_value'] = explode(',', $value['ticket_form_bind_value']);
            }
        }

        return $form;
    }

    /**
     * 查看工单内容
     * 注：前后台公用本方法
     * @return array 返回处理好得通用数组
     */
    public static function view() {
        $number = self::isG('number', '请选择您要查看的工单');
        $ticket = \Model\Content::findContent('ticket', $number, 'ticket_number');
        if (empty($ticket)) {
            header('HTTP/1.1 404');
            self::error('工单不存在');
        }

        $form = self::getTicketContent($ticket['ticket_id']);
        $chat = self::getTicketChat($ticket['ticket_id']);

        return ['ticket' => $ticket, 'form' => $form, 'chat' => $chat];

    }

    /**
     * 获取客服与用户的反馈信息
     * @param $id 工单ID
     * @return 返回查询得到的内容
     */
    public static function getTicketChat($id) {
        $sql = "SELECT %s FROM " . self::$modelPrefix . "ticket_chat WHERE ticket_id = :ticket_id ORDER BY ticket_chat_id ASC";
        return \Model\Content::quickListContent(['count' => sprintf($sql, 'count(*)'), 'normal' => sprintf($sql, '*'), 'param' => ['ticket_id' => $id]]);
    }

    /**
     * 回复工单
     * @param $id 工单ID
     * @param $content 内容
     * @param string $custom 本参数用于识别前台还是后台，默认为空。
     * @return mixed
     */
    public static function addReply($id, $content, $custom = '') {
        $param = ['ticket_id' => $id, 'ticket_chat_content' => $content, 'ticket_chat_time' => time()];
        if (!empty($_SESSION['ticket']) && empty($custom)) {
            $param['user_id'] = $_SESSION['ticket']['user_id'];
            $param['user_name'] = $_SESSION['ticket']['user_name'];
        }

        return self::db('ticket_chat')->insert($param);

    }

    /**
     * 设置工单负责人
     * @param $id 工单ID
     * @param $userID 用户的ID
     * @param $userName 用户名称
     * @description 此处需要手动填写用户的ID和名称是由于，除了当前的客户外，还会有一个转指派的。这时候他就需要手动声明用户信息了。
     */
    public static function setUser($id, $userID, $userName) {
        return self::inTicketIdWithUpdate(['user_id' => $userID, 'user_name' => $userName, 'noset' => ['ticket_id' => $id]]);
    }


    /**
     * 更改任务状态
     * @param $id 工单ID
     * @param $status 要更改的状态
     */
    public static function changeStatus($id, $status) {
        return self::inTicketIdWithUpdate(['ticket_status' => $status, 'noset' => ['ticket_id' => $id]]);
    }

    /**
     * 更新工单耗时参照时间
     * @param $id
     * @return mixed
     */
    public static function updateReferTime($id) {
        return self::inTicketIdWithUpdate(['ticket_refer_time' => time(), 'noset' => ['ticket_id' => $id]]);
    }

    /**
     * 工单运行时间
     * @param $id 工单ID
     * @param $submitTime 工单耗时参照时间
     * @return mixed
     */
    public static function runTime($id, $referTime, $runTime) {
        $runTime = (time() - $referTime) + $runTime;
        return self::inTicketIdWithUpdate(['ticket_run_time' => $runTime, 'noset' => ['ticket_id' => $id]]);
    }

    /**
     * 依据工单ID进行更新
     * @param array $param
     * @return mixed
     */
    public static function inTicketIdWithUpdate(array $param) {
        return self::db('ticket')->where('ticket_id = :ticket_id')->update($param);
    }
}