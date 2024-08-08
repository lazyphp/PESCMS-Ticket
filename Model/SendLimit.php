<?php

/**
 * Copyright (c) 2024 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model;

/**
 * 消息发送限制模型
 */
class SendLimit extends \Core\Model\Model {

    /**
     * 系统参数
     * @var mixed
     */
    protected static $system;

    /**
     * IP地址
     * @var
     */
    protected static $ip;

    /**
     * 记录限制的session信息
     * @var
     */
    public static $limitSession;

    /**
     * 已发送次数
     * @var int
     */
    public static $sendCount = 0;

    /**
     * 初始化
     * @return void
     */
    public static function init() {
        self::$system = \Core\Func\CoreFunc::$param['system'];

        self::$ip = self::$system['enable_proxy'] == 1 ? $_SERVER[self::$system['REMOTE_ADDR'] ?? 'REMOTE_ADDR'] : $_SERVER['REMOTE_ADDR'];

        self::$limitSession = self::session()->get('send_limit');

        self::getSendCountFormIp();

    }

    /**
     * 获取对应IP的发送次数
     * @return void
     */
    public static function getSendCountFormIp() {
        $limit = self::db('send_limit')->field('count(*) AS total')->where('send_limit_ip = :send_limit_ip AND send_limit_time > :send_limit_time')->find([
            'send_limit_ip'   => self::$ip,
            'send_limit_time' => time() - 3600,
        ]);
        if (!empty($limit)) {
            self::$sendCount = $limit['total'];
        }
    }

    /**
     * 从账号和请求类型获取发送间隔
     * @param $account
     * @param $type
     * @param $msg
     * @return void
     */
    public static function getLimitFromAccountAndType($account, $type, $msg = '请勿频繁发起请求') {
        $result = self::db('send_limit')
            ->where('send_limit_account = :send_limit_account AND send_limit_type = :send_limit_type AND send_limit_time > :send_limit_time')
            ->find([
                'send_limit_account' => $account,
                'send_limit_type'    => $type,
                'send_limit_time'    => time() - self::$system['resend_time'],
            ]);
        if (!empty($result)) {
            self::error($msg);
        }
    }

    /**
     * 校验验证码
     * @return void
     */
    public static function verifyCode() {
        //大于等于三次需要校验验证码
        if (self::$limitSession['count'] >= 3 || self::$sendCount >= 3) {
            self::checkVerify();
        }
    }

    /**
     * 从session中获取1小时发送限制
     * @return void
     */
    public static function getLimitFromSession($msg = '请勿频繁发起请求') {
        //1小时内不能重复发送
        if (self::$limitSession['count'] >= self::$system['send_limit_count'] && self::$limitSession['time'] > time() - 3600) {
            self::error($msg);
        } elseif (self::$limitSession['count'] >= self::$system['send_limit_count']) {
            //重置
            self::$limitSession = [
                'count' => 0,
                'time'  => time(),
            ];
            self::session()->set('send_limit', self::$limitSession);
        }
    }

    /**
     * 从IP获取1小时发送限制
     * @return mixed
     */
    public static function getLimitFromIP($msg = '请勿频繁发起请求') {
        if (self::$sendCount >= self::$system['send_limit_count']) {
            self::error($msg);
        }
    }

    /**
     * 添加发送限制记录
     * @param $account
     * @param $type
     * @return void
     */
    public static function addRecord($account, $type) {
        if (empty(self::$limitSession)) {
            self::$limitSession = [
                'count' => 1,
                'time'  => time(),
            ];
        } else {
            self::$limitSession['count']++;
        }
        self::session()->set('send_limit', self::$limitSession);

        self::db('send_limit')->insert([
            'send_limit_account' => $account,
            'send_limit_ip'      => self::$ip,
            'send_limit_type'    => $type,
            'send_limit_time'    => time(),
        ]);
    }

}