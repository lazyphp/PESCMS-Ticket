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

    public static function csText(){
        $content = \Model\Content::findContent('option', 'cs_text', 'option_name');

        return json_decode($content['value'], true);
    }

    /**
     * 获取后台登录参数
     * @return mixed|string
     */
    public static function getNoticeLoginParam(){
        $loginParam = explode('|', \Core\Func\CoreFunc::$param['system']['notice_login']);

        if($loginParam[0] < time() - 86400){
            static $newLoginParam;
            if(empty($newLoginParam)){
                $newLoginParam = \Model\Extra::getOnlyNumber();
            }
            self::db('option')->where('option_name = :option_name')->update([
                'noset' => [
                    'option_name' => 'notice_login'
                ],
                'value' => time() . "|{$newLoginParam}"
            ]);
            return $newLoginParam;
        }else{
            return $loginParam['1'];
        }
    }

}