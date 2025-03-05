<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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
        self::isP('systemInfo', '请提交系统信息', false);

        $result = self::db('certificate AS c')
            ->field('c.*, m.member_id, m.member_name, m.member_avatar, member_wxapp, member_organize_id, member_email, member_phone')
            ->join(self::$modelPrefix."member AS m ON m.member_wxapp = c.certificate_openid")
            ->where('c.certificate_token = :certificate_token')
            ->find([
                'certificate_token' => $token
            ]);

        if(empty($result)){
            self::error('登录信息不存在或者已经超时，请重新登录');
        }

        header("HTTP/1.1 200 Status OK");
        return $result;
    }

}