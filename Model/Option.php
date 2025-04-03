<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

class Option extends \Core\Model\Model {

    /**
     * 获取配置项
     * @param $optionName
     * @param $isJson
     * @return mixed
     */
    public static function getOptionValue($optionName, $isJson = false) {
        $content = \Model\Content::findContent('option', $optionName, 'option_name');
        if ($isJson) {
            return json_decode($content['value'], true);
        } else {
            return $content['value'];
        }

    }

    /**
     * 获取客服工单回复的预设信息
     * @return mixed
     */
    public static function getCSReplyText() {

        $content = \Model\Option::getOptionValue('cs_text', true);

        $jobNumber = self::session()->get('ticket')['user_job_number'];

        $replacements = [
            '{job_number}' => $jobNumber,
        ];

        foreach ($content as $key => &$item) {
            $item['content'] = strtr($item['content'], $replacements);
        }

        return $content;
    }

    /**
     * 获取后台登录参数
     * @return mixed|string
     */
    public static function getNoticeLoginParam() {
        $loginParam = explode('|', \Core\Func\CoreFunc::$param['system']['notice_login']);

        $serviceLoginTimeout = \Model\Option::getOptionValue('service_login_timeout');

        if ($loginParam[0] < time() - $serviceLoginTimeout * 3600) {
            static $newLoginParam;
            if (empty($newLoginParam)) {
                $newLoginParam = \Model\Extra::getOnlyNumber();
            }
            self::db('option')->where('option_name = :option_name')->update([
                'noset' => [
                    'option_name' => 'notice_login',
                ],
                'value' => time() . "|{$newLoginParam}",
            ]);
            return $newLoginParam;
        } else {
            return $loginParam['1'];
        }
    }

}