<?php

/**
 *
 * Copyright (c) 202 PESCMS (https://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model\API;

/**
 * API 用户模型
 */
class Member extends \Core\Model\Model {

    /**
     * 用户鉴权同时获取绑定的用户ID信息
     */
    public static function auth(){
        header("HTTP/1.1 995 Login not found");

        $token = self::isP('token', '缺少登录参数，请重新打开小程序');
        $systeminfo = self::isP('systemInfo', '请提交系统信息', false);

        $result = self::db('certificate AS c')
            ->field('c.*, m.member_id, m.member_name, m.member_avatar, member_wxapp, member_organize_id, member_email, member_phone')
            ->join(self::$modelPrefix."member AS m ON m.member_wxapp = c.certificate_openid")
            ->where('c.certificate_token = :certificate_token')
            ->find([
                'certificate_token' => $token
            ]);

        if(empty($result)){
            self::error('登录信息不存在或者已经超时，请重新登录');
        }elseif(!empty($result) && strcmp($result['certificate_systeminfo'], md5($systeminfo)) != 0 ){
            self::error('设备信息发生变化，登录信息已更改，请重新登录');
        }

        header("HTTP/1.1 200 Status OK");
        return $result;
    }

}