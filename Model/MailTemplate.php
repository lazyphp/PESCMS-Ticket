<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */
namespace Model;


class MailTemplate extends \Core\Model\Model {

    /**
     * 模板类型
     * 新工单|1
     * 受理工单|2
     * 回复工单|3
     * 转交客服|4
     * 工单完成|5
     * 工单关闭|6
     * @var array
     */
    private static $templateType = [];

    private static $ticket = [];

    private static $system = [];

    /**
     * 依据模板类型，获取模板
     * @param $type
     * @return mixed
     */
    public static function getTemplate($type) {
        if (empty(self::$templateType[$type])) {
            self::$templateType[$type] = \Model\Content::findContent('mail_template', $type, 'mail_template_type');
        }
        return self::$templateType[$type];
    }

    /**
     * 快速生成查看工单的链接
     * @param $number 工单号
     * @param $contactType 发送类型特殊标记
     * @return string
     */
    public static function getViewLink($number, $contactType = '') {
        self::setSystemParam();

        $urlParam = [
            'number' => $number
        ];

        //微信通知带上微信标记,用于指向用户自动登录
        if($contactType == 3){
            $urlParam['loginType'] = 'weixin';
        }

        $link = self::$system['domain'] . self::url('Form-View-ticket', $urlParam);
        return '<a href="' . $link . '">' . $link . '</a>';
    }

    /**
     * 快速生成客服查看工单的链接
     * @param $number 工单号
     * @return string
     */
    public static function getCSViewLink($number) {
        self::setSystemParam();

        $param = ['number' => $number];

        $param['_notice_login'] = \Model\Option::getNoticeLoginParam();

        $link = self::$system['domain'] . self::url('Ticket-Ticket-handle', $param);

        return '<a href="' . $link . '">' . $link . '</a>';
    }

    /**
     * 匹配邮件模板标题
     * @param $number 单号
     * @param $type 模板类型
     * @return mixed
     */
    public static function matchTitle($number, $type) {
        $template = self::getTemplate($type);

        $dictionary = self::ticketDictionary($number);

        $title = str_replace($dictionary['search'], $dictionary['replace'], $template['mail_template_title']);

        $data = [
            '1' => $title,
            '2' => $title,
            '3' => $template['mail_template_weixin_template_id'],
            '6' => $template['mail_template_wxapp_template_id'],
        ];
        return $data;
    }

    /**
     * 匹配邮件模板内容
     * @param array $param 参数
     * @param $type 模板类型
     * @return mixed
     */
    public static function matchContent($number, $type) {
        self::setSystemParam();

        static $SMS;
        if(empty($SMS)){
            $SMS = json_decode(self::$system['sms'], true);
        }

        $template = self::getTemplate($type);

        $dictionary = self::ticketDictionary($number);

        foreach ([
                    '1' => 'mail_template_content',
                    '2' => 'mail_template_sms',
                    '3' => 'mail_template_weixin_template',
                    '6' => 'mail_template_wxapp_template',
                 ] as $key => $item){

            if($key == 1){
                $template[$item] = self::mergeMailTemplate($template[$item]);
            }

            //短信和微信需要将超链接的HTML代码移除
            if(in_array($key, [2, 3, 6])){
                $param['view'] = strip_tags(self::getViewLink($number, $key));
            }

            //阿里云短信需要特殊组装数据
            if($key == 2 && $SMS['COMPANY'] == 1){
                $newFormat = [
                    'TemplateCode' => $SMS['aliyun_TemplateCode'][$type],
                    'TemplateParam' => htmlspecialchars_decode($template[$item])
                ];
                $template[$item] = json_encode($newFormat);
            }

            //微信通知需要先将内容格式化，补充通知的超链接。
            if(in_array($key, ['3', '6'])){
                $newFormat = [
                    'data' => json_decode(htmlspecialchars_decode($template[$item]), true),
                    'link' => strip_tags($param['view']),
                    'ticket_number' => $number,
                ];
                $template[$item] = json_encode($newFormat);
            }

            $content[$key] = str_replace($dictionary['search'], $dictionary['replace'], $template[$item]);
        }

        return $content;
    }

    /**
     * 工单模板字典
     * @param $number
     * @return array
     */
    public static function ticketDictionary($number){
        if(empty(self::$ticket)){
            self::$ticket = \Model\Ticket::getTicketBaseInfo($number);
        }
        
        $ticket = self::$ticket;

        //处理工单提交用户
        if($ticket['member_id'] > 0){
            $ticket['member_name'] = \Model\Member::getMemberWithID($ticket['member_id'])['member_name'];
        }else{
            $ticket['member_name'] = '匿名用户';
        }

        if($ticket['old_user_id'] > 0){
            $ticket['old_user_id'] = \Model\Content::findContent('user', $ticket['old_user_id'], 'user_id', 'user_name')['user_name'];
        }


        //前台跳转链接
        $ticket['ticket_link'] = self::getViewLink($number , self::$ticket['ticket_contact']);

        //后台跳转链接
        $ticket['handle_link'] = \Model\MailTemplate::getCSViewLink($number);

        $ticket['time_out'] = (1 + $ticket['ticket_time_out_sequence']) * $ticket['ticket_model_time_out'];

        //转换工单时间字段
        foreach (['ticket_submit_time', 'ticket_refer_time', 'ticket_complete_time', 'ticket_score_time'] as $field){
            $ticket[$field] = empty($ticket[$field]) ? 0 : date('Y-m-d H:i', $ticket[$field]);
        }

        $ticketField = array_keys($ticket);
        foreach ($ticketField as $name){
            $search[] = '{'.$name.'}';
            $replace[] = $ticket[$name];
        }

        return [
            'search' => $search,
            'replace' => $replace
        ];

    }

    /**
     * 合并邮件模板
     * @param $content
     * @return mixed
     */
    public static function mergeMailTemplate($content){
        self::setSystemParam();

        $host = self::$system['domain'];
        $siteLogo = self::$system['siteLogo'];
        $siteTitle = self::$system['siteTitle'];
        $authorize_type = \Core\Func\CoreFunc::$param['authorize_type'];


        $emailTemplate = file_get_contents(PES_CORE.'Expand/Notice/mailTemplate.html');

        $search = [
            '{host}',
            '{logo}',
            '{siteTitle}',
            '{content}',
            '{display}',
            '{date}'
        ];

        $replace = [
            $host,
            $host.$siteLogo,
            $siteTitle,
            htmlspecialchars_decode($content),
            $authorize_type == 1 ? 'none' : 'block',
            date('Y')
        ];

        return str_replace($search, $replace, $emailTemplate);

    }

    /**
     * 设置全局的system变量
     */
    private static function setSystemParam(){
        if(empty(self::$system)){
            self::$system = \Core\Func\CoreFunc::$param['system'];
        }
    }

}