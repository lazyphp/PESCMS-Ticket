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

        $result = self::getSubmitTicketBase();
        $field = $result['field'];
        $firstContent = $result['firstContent'];
        $param = $result['param'];

        self::loginCheck($firstContent);

        self::organizeCheck($firstContent, self::session()->get('member')['member_organize_id']);

        $param['member_id'] = empty(self::session()->get('member')) ? '-1' : self::session()->get('member')['member_id'];

        \Model\Extra::limitSubmit('submitTicket', '1', '10');

        if ($firstContent['ticket_model_verify'] == '1') {
            self::checkVerify();
        }

        $param = array_merge($param, self::csInfoParam($firstContent));

        self::createTicket($param, $field, $firstContent);

        return $param;
    }

    /**
     * 获取提交工单基础信息
     * @return mixed
     */
    public static function getSubmitTicketBase() {
        $number = self::isP('number', '请提交您要生成的工单');
        $field = \Model\TicketForm::getFormWithNumber($number);

        $firstContent = current($field);

        if ($firstContent['ticket_status'] == '0') {
            self::error('该工单已禁止提交');
        }

        $param['ticket_title'] = self::isP('title', '请填写简明扼要的问题描述，以便客户能够快速反馈问题');
        //@todo 联系方式此处需要联动查询，匹配用户选择的联系方式是否存在
        $param['ticket_contact'] = self::isP('contact', '请选择联系方式');
        $param['ticket_contact_account'] = self::isP('contact_account', '请填写您的联系信息');

        //微信和小程序选项不验证格式
        if (\Model\Extra::checkInputValueType($param['ticket_contact_account'], $param['ticket_contact']) === false && in_array($param['ticket_contact'], ['1', '2'])) {
            self::error('您填写联系方式的信息格式不正确。');
        }

        //工单长度限定为15
        $param['ticket_number'] = str_pad(substr(\Model\Extra::getOnlyNumber(), 0, 15), 15, 0, STR_PAD_RIGHT);

        $param['ticket_model_id'] = $firstContent['ticket_model_id'];
        $param['ticket_submit_time'] = time();

        return [
            'field'        => $field,
            'firstContent' => $firstContent,
            'param'        => $param,
        ];
    }

    /**
     * 自动分单和专属客服的参数
     * @param $firstContent
     * @return mixed
     */
    public static function csInfoParam($firstContent) {

        $csUserInfo = self::autoAssign($firstContent['ticket_model_auto'], $firstContent);

        $exclusiveCS = self::exclusiveCSTicket($firstContent['ticket_model_exclusive']);
        if (!empty($exclusiveCS)) {
            $csUserInfo = $exclusiveCS;
        }

        $param = [];

        if (!empty($csUserInfo)) {
            $param['user_id'] = $csUserInfo['user_id'];
            $param['user_name'] = $csUserInfo['user_name'];
            $param['ticket_exclusive'] = empty($csUserInfo['exclusive']) ? 0 : 1;
        }
        return $param;
    }

    /**
     * 执行创建工单
     * @param $param
     * @param $field
     * @param $firstContent
     */
    public static function createTicket($param, $field, $firstContent) {
        self::db()->transaction();

        $createTicket = self::db('ticket')->insert($param);
        if ($createTicket === false) {
            self::db()->rollback();
            self::error('创建工单失败');
        }

        self::insertContent($createTicket, $field);
        self::newTicketNotice($firstContent, $param);

        self::db()->commit();
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

                if (empty($form) && !is_numeric($form) && $value['ticket_form_bind'] == 0) {
                    self::error($msg);
                } elseif ($value['ticket_form_bind'] > 0 && in_array($_POST[$formID[$value['ticket_form_bind']]], explode(',', $value['ticket_form_bind_value'])) && $value['ticket_form_required'] == '1' && empty($form) && !is_numeric($form)) {
                    self::error($msg);
                }
            }

            //加密
            if ($value['ticket_form_type'] == 'encrypt' && !empty($form)) {
                $form = (new \Expand\OpenSSL(\Core\Func\CoreFunc::loadConfig('USER_KEY', true)))->encrypt($form);
            }

            if(!empty($form)){
                switch ($value['ticket_form_verify']) {
                    case 'noVerify':
                        break;
                    default:
                        if (\Model\Extra::checkInputValueType($form, $value['ticket_form_verify']) == false) {
                            self::error("表单'{$value['ticket_form_description']}'只能提交" . array_flip(\Model\Extra::$checkType)[$value['ticket_form_verify']]);
                        }
                }
            }

            //特定字段需要校验提交的内容和设置是否一致。
            if(isset($form) && in_array($value['ticket_form_type'], ['radio', 'checkbox', 'select', 'multiple']) ){
                $optionName = \Model\Field::getFieldOptionToMatch($form, $value['ticket_form_option']);
                if($optionName === NULL){
                    self::error("您提交的'<b>{$value['ticket_form_description']}</b>'选项值存在异常，请提交正确的值，或者刷新页面再提交。");
                }

            }else{
				$optionName  = '';
			}

            $result = self::db('ticket_content')->insert([
                'ticket_id'           => $ticketID,
                'ticket_form_id'      => $value['ticket_form_id'],
                'ticket_form_content' => $form,
                'ticket_form_option_name' => $optionName,
            ]);
            if ($result === false) {
                self::db()->rollback();
                self::error('记录工单内容出错');
            }

        }

    }

    /**
     * 新工单消息
     * @param $ticket 工单基础信息
     * @param $param 内容参数
     */
    private static function newTicketNotice($ticket, $param) {

        //将工单单号发给发起者
        \Model\Notice::addTicketNoticeAction($param['ticket_number'], $param['ticket_contact_account'], $param['ticket_contact'], 1);

        //新工单后台客服通知
        if (($param['ticket_exclusive'] == 1 || $ticket['ticket_model_auto'] == 1) && !empty($param['user_id'])) {
            $user = \Model\Content::findContent('user', $param['user_id'], 'user_id');
            \Model\Notice::addCSNotice($param['ticket_number'], $user, -1);

        } elseif (!empty($ticket['ticket_model_group_id'])) {
            //移除手尾,
            $ticket['ticket_model_group_id'] = trim($ticket['ticket_model_group_id'], ',');

            $userList = self::db('user')->where("user_group_id IN ({$ticket['ticket_model_group_id']})")->select();
            if (!empty($userList)) {
                foreach ($userList as $user) {
                    \Model\Notice::addCSNotice($param['ticket_number'], $user, -1);
                }
            }
        }
    }

    /**
     * 自动分单功能
     * @param bool $isOpen
     * @param $ticket
     * @return bool
     */
    private static function autoAssign($isOpen = false, $ticket) {
        if ($isOpen !== 1) {
            return false;
        }

        $ticket['ticket_model_group_id'] = trim($ticket['ticket_model_group_id'], ',');

        switch ($ticket['ticket_model_auto_logic']) {
            case '1':
                $userList = self::db('user')->where("user_group_id IN ({$ticket['ticket_model_group_id']}) AND user_status = 1 AND user_vacation = 0 ")->select();
                if (empty($userList)) {
                    return false;
                }

                $userSort = [];
                foreach ($userList as $item) {
                    $user[$item['user_id']] = $item;
                    $user[$item['user_id']]['total'] = 0;
                    $userSort[$item['user_id']] = 0;
                }

                $ticket = self::db('user AS u')->field('u.user_id, COUNT(t.user_id) as total')->join(self::$modelPrefix . 'ticket AS t ON t.user_id = u.user_id')->where("user_group_id IN ({$ticket['ticket_model_group_id']}) AND t.ticket_close = 0 AND t.ticket_submit_time >= :ticket_submit_time ")->group('t.user_id')->select([
                    'ticket_submit_time' => time() - 86400 * 30,
                ]);
                $avgSubTotal = 0;
                $avgTotal = count($user);

                array_walk($ticket, function ($value) use (&$user, &$avgSubTotal, &$userSort) {
                    $user[$value['user_id']]['total'] = $value['total'];
                    $avgSubTotal += $value['total'];
                    $userSort[$value['user_id']] = $value['total'];
                });
                array_multisort($userSort, SORT_ASC, $user);

                $avg = round($avgSubTotal / $avgTotal, 2);

                foreach ($user as $item) {
                    $item['total'] = $item['total'] > $avg ? $avg + 2 : $avg + 1;
                    if ($item['total'] > $avg) {
                        return $item;
                    } elseif ($item['total'] + 1 > $avg) {
                        return $item;
                    }
                }

                //分配失败，则返回false，产生全局工单通知
                return false;
                break;
            case '0':
            default:
                $user = self::db('user')->where("user_group_id IN ({$ticket['ticket_model_group_id']}) AND user_status = 1 AND user_vacation = 0 ")->order('RAND()')->find();
                if (!empty($user)) {
                    return $user;
                }
                break;
        }
        return false;
    }

    /**
     * 检测是否填写正确的客服工号
     * @return bool|type
     */
    private static function exclusiveCSTicket($isOpen = false) {
        if ($isOpen !== 1) {
            return false;
        }

        $jobNumber = self::p('job_number');
        if (empty($jobNumber)) {
            return false;
        }

        $user = \Model\Content::findContent('user', $jobNumber, 'user_job_number', 'user_id, user_name, user_job_number, user_mail, user_weixinWork, user_dingtalk');
        if (empty($user)) {
            return false;
        } else {
            //标记专属客服
            $user['exclusive'] = 1;
            return $user;
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

            switch ($value['ticket_form_type']) {
                case 'radio':
                case 'checkbox':
                case 'select':
                case 'checkbox':
                    //获取相应工单字段的选项值
                    $form[$value['ticket_form_id']]['ticket_form_option'] = json_decode(htmlspecialchars_decode($value['ticket_form_option']), true);
                    //复选项要做特殊处理
                    if ($value['ticket_form_type'] == 'checkbox') {
                        $ticketValue = [];
                        foreach (explode(',', $value['ticket_form_content']) as $item) {
                            $ticketValue[] = array_search($item, $form[$value['ticket_form_id']]['ticket_form_option']);
                        }
                        $form[$value['ticket_form_id']]['ticket_value'] = implode(' , ', $ticketValue);
                    } else {
                        $form[$value['ticket_form_id']]['ticket_value'] = array_search($value['ticket_form_content'], $form[$value['ticket_form_id']]['ticket_form_option']);
                    }


                    break;
                case 'thumb':
                    $suffix = pathinfo($value['ticket_form_content']);
                    $small = "{$value['ticket_form_content']}_50x50.{$suffix['extension']}";

                    $form[$value['ticket_form_id']]['ticket_value'] = empty($value['ticket_form_content']) ? '' : '<a href="' . $value['ticket_form_content'] . '" data-fancybox="gallery"><img src="' . $small . '" alt="' . $value['ticket_form_content'] . '" class="am-img-thumbnail" width="50" height="50" /></a>';
                    break;
                case 'img':
                    $splitImg = explode(',', $value['ticket_form_content']);
                    $imgStr = '<ul class="am-avg-sm am-thumbnails">';
                    if (!empty($value['ticket_form_content'])) {
                        foreach ($splitImg as $item) {
                            $suffix = pathinfo($item);
                            $small = "{$item}_50x50.{$suffix['extension']}";
                            $imgStr .= '<li>
<a href="' . $item . '" data-fancybox="gallery" ><img src="' . $small . '" alt="' . imgs . '" class="am-img-thumbnail" width="50" height="50" /></a>
</li>';
                        }
                    }
                    $imgStr .= '</ul>';
                    $form[$value['ticket_form_id']]['ticket_value'] = $imgStr;
                    break;
                case 'file':
                    //@todo 待优化,下载应该基于header方法

                    $downloadFile = (new \Expand\UBB())->url($value['ticket_form_content']);
                    if ($downloadFile == false) {
                        $splitImg = explode(',', $value['ticket_form_content']);
                        $imgStr = '<ul class="am-avg-sm am-thumbnails">';
                        if (!empty($value['ticket_form_content'])) {
                            foreach ($splitImg as $key => $item) {
                                $imgStr .= '<li><a href="' . $item . '">下载附件' . ($key + 1) . '</a></li>';
                            }
                        }
                        $imgStr .= '</ul>';
                        $form[$value['ticket_form_id']]['ticket_value'] = $imgStr;
                    } else {
                        $imgStr = '<ul class="am-avg-sm am-thumbnails">';
                        foreach ($downloadFile as $item) {
                            $imgStr .= "<li>{$item}</li>";
                        }
                        $imgStr .= '</ul>';
                        $form[$value['ticket_form_id']]['ticket_value'] = $imgStr;
                    }
                    break;
                case 'encrypt':
                    $form[$value['ticket_form_id']]['ticket_value'] = !empty(self::session()->get('ticket')['user_id']) ? (new \Expand\OpenSSL(\Core\Func\CoreFunc::loadConfig('USER_KEY', true)))->decrypt($value['ticket_form_content']) : '<i class="am-text-warning">您提交了加密信息,此部分只有客服可知.</i>';
                    break;
                default:
                    $form[$value['ticket_form_id']]['ticket_value'] = (new \voku\helper\AntiXSS())->xss_clean(htmlspecialchars_decode($value['ticket_form_content']));
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
     * @param $page 聊天内容的分页数
     * @return array 返回处理好得通用数组
     */
    public static function view($chatPage = '30') {
        $number = self::isG('number', '请选择您要查看的工单');
        $ticket = self::getTicketBaseInfo($number);
        if (empty($ticket)) {
            return false;
        }

        foreach (json_decode(\Model\Content::findContent('option', 'ticket_contact', 'option_name')['value'], true) as $item){
            if($item['key'] == $ticket['ticket_contact']){
                $ticket['ticket_contact_name'] = $item['title'];
                break;
            }
        }

        $form = self::getTicketContent($ticket['ticket_id']);
        $chat = self::getTicketChat($ticket['ticket_id'], $chatPage);

        $member = $ticket['member_id'] == '-1' ? '' : \Model\Content::findContent('member', $ticket['member_id'], 'member_id');
        if(!empty($member)){
            unset($member['member_password']);
        }

        return [
            'ticket' => $ticket,
            'form' => $form,
            'chat' => $chat,
            'member' => $member,
            'global_contact' => array_flip(\Model\Field::findField('240', true)->deFieldOptionToArray()),
        ];

    }

    /**
     * 获取工单的基础信息
     * @param $number
     * @return mixed
     */
    public static function getTicketBaseInfo($number) {
        return self::db('ticket AS t')
            ->field('t.*, tm.*, c.category_name')
            ->join(self::$modelPrefix . 'ticket_model AS tm ON tm.ticket_model_id = t.ticket_model_id')
            ->join(self::$modelPrefix . 'category AS c ON c.category_id = tm.ticket_model_cid')
            ->where('ticket_number = :ticket_number')
            ->find([
                'ticket_number' => $number,
            ]);
    }

    /**
     * 获取客服与用户的反馈信息
     * @param $id 工单ID
     * @return 返回查询得到的内容
     */
    public static function getTicketChat($id, $chatPage) {
        $sql = "SELECT %s FROM " . self::$modelPrefix . "ticket_chat WHERE ticket_id = :ticket_id ORDER BY ticket_chat_id ASC";

        return \Model\Content::quickListContent([
            'count'  => sprintf($sql, 'count(*)'),
            'normal' => sprintf($sql, '*'),
            'param'  => ['ticket_id' => $id],
            'page'   => $chatPage,
        ]);
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
        if (!empty(self::session()->get('ticket')) && empty($custom)) {
            $param['user_id'] = self::session()->get('ticket')['user_id'];
            $param['user_name'] = self::session()->get('ticket')['user_name'];
        }

        return self::db('ticket_chat')->insert($param);

    }

    /**
     * 设置工单负责人
     * @param $id 工单ID
     * @param $userID 用户的ID
     * @param $userName 用户名称
     * @param $oldID 记录转派前负责人的ID
     * @description 此处需要手动填写用户的ID和名称是由于，除了当前的客户外，还会有一个转指派的。这时候他就需要手动声明用户信息了。
     */
    public static function setUser($id, $userID, $userName, $oldID = NULL) {
        $param = ['user_id' => $userID, 'user_name' => $userName, 'noset' => ['ticket_id' => $id]];

        if(!empty($oldID)){
            $param['old_user_id'] = $oldID;
        }

        return self::inTicketIdWithUpdate($param);
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
        if($referTime > 0 ){
            $runTime = (time() - $referTime) + $runTime;
        }
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


    /**
     * 验证工单是否开启了客户分组可见
     * @param $ticket
     * @param $member_organize_id 客户组
     */
    public static function organizeCheck($ticket, $member_organize_id) {
        if (!empty($ticket['ticket_model_organize_id']) && !in_array($member_organize_id, explode(',', $ticket['ticket_model_organize_id']))) {
            self::error('您无法在当前页面提交新工单，请联系网站管理员。', self::url('Category-index'), '-1');
        }
    }

    /**
     * 工单登录验证
     * @param $ticket 工单信息
     * @param string $back_url 返回的地址
     */
    public static function loginCheck($ticket, $back_url = '') {

        if (empty($back_url)) {
            $back_url = base64_encode($_SERVER['REQUEST_URI']);
        }

        //判断工单模型是否设置登录验证.
        if ($ticket['ticket_model_login'] == 1 && empty(self::session()->get('member'))) {

            switch ($_GET['loginType']) {
                case 'weixin':
                    $url = self::url('Login-weixinAgree', ['back_url' => $back_url]);
                    break;
                default:
                    $url = self::url('Login-index', ['back_url' => $back_url]);
            }

            self::success('需要登录账号', $url, -1);
        }

        /**
         * 提交工单的请求不进行跳转。
         */
        if ((MODULE == 'Submit' && ACTION == 'ticket') || (MODULE == 'Category' && ACTION == 'ticket')) {
            return true;
        }

        //非匿名工单判断用户所属，非此用户所属则跳转至我的工单
        if ($ticket['member_id'] != '-1' && $ticket['member_id'] != self::session()->get('member')['member_id']) {
            self::success('获取工单成功，系统将指引您返回工单列表', self::url('Member-index'), -1);
        }
    }

}