<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Expand;

/**
 * 模版标签函数
 * 说明：建议本类中的所有方法尽量使用return形式。
 * 统一使用return，可以方便前台代码的调用。
 * 此外，也尽量勿在方法进行终止类操作。
 * 以免对程序的运行产生影响。
 */
class Label {

    /**
     * 此是语法糖，将一些写法近似的方法整合一起，减少重复
     * @param type $name
     * @param type $arguments
     * @return type
     */
    public function __call($name, $arguments) {
        switch (strtolower($name)) {
            case 'findproject':
            case 'finduser':
            case 'findgroup':
            case 'finddepartment':
                return $this->findContent($arguments['0'], $arguments['1'], $arguments['2']);
            default :
                return '不存在此方法';
        }
    }

    /**
     * 查找某一表信息的语法糖
     * @param type $table 查询内容的表名称
     * @param type $field 用于快捷获取内容的组合字段名称
     * @param type $id 需要查找的ID
     * @return type 返回处理好的数组
     */
    public function findContent($table, $field, $id) {
        static $array = array();
        if (empty($array[$table])) {
            $list = \Model\Content::listContent(['table' => $table]);
            foreach ($list as $value) {
                $array[$table][$value[$field]] = $value;
            }
        }
        return $array[$table][$id];
    }

    /**
     * 生成URL链接
     * @param type $controller 链接的控制器
     * @param array $param 参数
     * @param type $filterHtmlSuffix 是否强制过滤HTML后缀 | 由于ajax GET请求中，若不过滤HTML，将会引起404的问题
     * @return type 返回URL
     */
    public function url($controller, $param = array(), $filterHtmlSuffix = false) {
        $url = \Core\Func\CoreFunc::url($controller, $param);
        if ($filterHtmlSuffix == true) {
            if (substr($url, '-5') == '.html') {
                return substr($url, '0', '-5');
            }
        }

        return $url;
    }

    /**
     * 生成令牌
     */
    public function token() {
        list($usec, $sec) = explode(" ", microtime());
        $token = md5(substr($usec, 2) * rand(1, 100));
        $_SESSION['token'] = $token;
        return "<input type=\"hidden\" name=\"token\" value=\"{$token}\" />";
    }

    /**
     * 标准状态输出
     * 0 禁用
     * 1 启用
     */
    public function status($type) {
        switch ($type) {
            case '0':
                return "<font color=\"red\">禁用</font>";
            case '1':
                return "<font color=\"green\">启用</font>";
            default:
                return '未知状态';
        }
    }

    /**
     * 是否搜索
     */
    public function isSearch($type) {
        switch ($type) {
            case '0':
                return "<font color=\"red\">禁止</font>";
            case '1':
                return "<font color=\"green\">允许</font>";
            default:
                return '未知状态';
        }
    }

    /**
     * 是否必填
     */
    public function isQequired($type) {
        switch ($type) {
            case '0':
                return "<font color=\"red\">不</font>";
            case '1':
                return "<font color=\"green\">是</font>";
            default:
                return '未知状态';
        }
    }

    /**
     * 模型属性
     * @param type $attr 属性值
     */
    public function modelAttr($attr) {
        switch ($attr) {
            case '1':
                return "<font color=\"green\">前台</font>";
            case '2':
                return "<font color=\"#E7790E\">后台</font>";
            default:
                return '未知状态';
        }
    }


    /**
     * 返回字段选项值的内容
     * @param type $option
     */
    public function fieldOption($option) {
        if (empty($option) || $option == '{"":null}') {
            return NULL;
        }
        $array = json_decode($option, true);
        $str = "";
        foreach ($array as $key => $value) {
            $str .="{$key}|{$value}\n";
        }
        return trim($str);
    }

    /**
     * 字符串截断
     * @param type $sourcestr 字符串
     * @param type $cutlength 截断的长度
     * @param type $suffix 截断后显示的内容
     * @return string 返回一个截断后的字符串
     */
    function strCut($sourcestr, $cutlength, $suffix = '...') {
        $str_length = strlen($sourcestr);
        if ($str_length <= $cutlength) {
            return $sourcestr;
        }
        $returnstr = '';
        $n = $i = $noc = 0;
        while ($n < $str_length) {
            $t = ord($sourcestr[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $i = 1;
                $n++;
                $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $i = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t <= 239) {
                $i = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $i = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $i = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $i = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n++;
            }
            if ($noc >= $cutlength) {
                break;
            }
        }
        if ($noc > $cutlength) {
            $n -= $i;
        }
        $returnstr = substr($sourcestr, 0, $n);


        if (substr($sourcestr, $n, 6)) {
            $returnstr = $returnstr . $suffix; //超过长度时在尾处加上省略号
        }
        return $returnstr;
    }

    /**
     * 计算现在时间和提交时间的差值
     */
    public function timing($timing) {
        if ($timing < '60') {
            return "{$timing}秒";
        } elseif ($timing >= '60' && $timing < '3600') {
            return round($timing / 60, 0) . "分钟";
        } elseif ($timing >= '3600' && $timing < '86400') {
            return round($timing / 3600, 0) . "小时";
        } elseif ($timing >= '86400' && $timing < '604800') {
            return round($timing / 86400, 0) . "天";
        } elseif ($timing >= '604800' && $timing < '2592000') {
            return round($timing / 604800, 0) . "周";
        } elseif ($timing >= '2592000') {
            return round($timing / 2592000, 0) . "月";
        }
    }

    /**
     * 获取对应的字段，然后进行内容值匹配
     * @param type $fieldId 字段ID
     * @param type $value 进行匹配的值
     */
    public function getFieldOptionToMatch($fieldId, $value) {
        $fieldContent = \Model\Content::findContent('field', $fieldId, 'field_id');
        $option = json_decode(htmlspecialchars_decode($fieldContent['field_option']), true);
        $search = array_search($value, $option);
        if (empty($search)) {
            return '未知值';
        } else {
            return $search;
        }
    }

}
