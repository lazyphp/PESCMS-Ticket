<?php

namespace Expand;

/**
 * 简单的HTML标记
 */
class UBB{

    private $returnMatch;

    /**
     * UBB constructor.
     * @param bool $returnMatch 是否直接返回转行好的UBB数组，默认返回处理好的HTML断片
     */
    public function __construct($returnMatch = false) {
        $this->returnMatch = $returnMatch;
    }

    /**
     * 处理URL格式
     * @param $string 要处理的字符
     * @return array
     */
    public function url($string){
        $pattern = '/\[url=(.*?)\](.*?)\[\/url\]/i';

        preg_match_all($pattern, $string, $match);

        if(empty($match[0])){
            return false;
        }

        if($this->returnMatch == true){
            return $match;
        }

        $html = [];

        foreach ($match[1] as $key => $value){
            $html []= "<a href='{$value}' target='_blank' >{$match[2][$key]}</a>";
        }

        return $html;
    }

}