<?php

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