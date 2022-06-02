<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

/**
 * 内容模型
 */
class Content extends \Core\Model\Model {

    private static $table, $fieldPrefix, $model;

    /**
     * @var 保持内容结果
     */
    private static $contentResult = null;

    /**
     * 查找指定内容（动态条件）
     * @param type $param 设置参数，字符串形式则为表名 | array 数组情况下，key 0 的为表名, key 1的为连贯操作
     * @param type $value 内容值
     * @param type $field 查找的字段
     * @return type
     */
    public static function findContent($param, $value, $field, $showField = '*') {
        if (is_array($param)) {
            $table = $param['0'];
        } else {
            $table = $param;
        }

        $result = self::db($table)->field($showField)->where("{$field} = :$field")->find([$field => $value]);
        self::$contentResult = empty($result) ? null : $result;

        return $param['1'] === true ? new static() : self::$contentResult;
    }

    /**
     * 空白内容提示信息
     * @param $message
     * @param string $jumpUrl
     * @param string $waitSecond
     * @return 保持内容结果|void
     */
    public static function emptyTips($message, $jumpUrl = 'javascript:history.go(-1)', $waitSecond = '3') {
        return self::$contentResult ?? self::error($message, $jumpUrl, $waitSecond);
    }

    /**
     * 列出内容（动态条件）
     * @param type $table 内容表名
     * @param array $param 绑定参数
     * @param type $where 查找条件
     * @param type $order 排序
     * @param type $limit 限制输出
     * @return type
     */
    public static function listContent($param) {
        if (empty($param['table'])) {
            self::error('Unkonw Table!');
        }
        $value = array_merge(['field' => '*', 'db' => '', 'prefix' => '', 'join' => '', 'condition' => '', 'order' => '', 'group' => '', 'limit' => '', 'lock' => '', 'param' => []], $param);
        return self::db($value['table'], $value['db'], $value['prefix'])->field($value['field'])->join($value['join'])->where($value['condition'])->order($value['order'])->group($value['group'])->limit($value['limit'])->lock($value['lock'])->select($value['param']);
    }

    /**
     * 添加内容
     */
    public static function addContent($modelName = MODULE) {
        $data = self::baseFrom($modelName);
        $addResult = self::db(self::$table)->insert($data);
        if (empty($addResult)) {
            self::error('添加内容失败');
        }
        self::setUrl($addResult);

        return $addResult;
    }

    /**
     * 更新内容
     */
    public static function updateContent($modelName = MODULE) {

        $data = self::baseFrom($modelName);

        $condition = self::$fieldPrefix . 'id';
        $updateResult = self::db(self::$table)->where("{$condition} = :{$condition}")->update($data);
        if ($updateResult === false) {
            return self::error('更新内容失败');
        }

        self::setUrl($data['noset'][$condition]);

        return true;
    }

    /**
     * 基础表单
     */
    public static function baseFrom($modelName) {
        self::$table = strtolower($modelName);
        self::$fieldPrefix = self::$table . "_";
        self::$model = \Model\ModelManage::findModel(self::$table, 'model_name');
        $field = \Model\Field::fieldList(self::$model['model_id'], 'AND field_status = 1');

        if (self::p('method') == 'PUT') {
            $data['noset'][self::$fieldPrefix . 'id'] = self::isP('id', '丢失模型ID');
            if (!self::findContent(self::$table, $data['noset'][self::$fieldPrefix . 'id'], self::$fieldPrefix . 'id')) {
                self::error('不存在的模型');
            }
        }

        foreach ($field as $value) {

            /**
             * 判断提交的字段是否为数组
             */
            if (is_array($_POST[$value['field_name']])) {
                $_POST[$value['field_name']] = (string)implode(',', $_POST[$value['field_name']]);
            }

            /**
             * 时间转换为时间戳
             * @todo 此地方可能存在一个问题，值为空时，需要填写的为0还是最新的时间？
             */
            if ($value['field_type'] == 'date') {
                $_POST[$value['field_name']] = empty($_POST[$value['field_name']]) ? 0 : (string)strtotime($_POST[$value['field_name']]);
            }

            if (!in_array(METHOD, explode(',', $value['field_action']))) {
                continue;
            }

            if ($value['field_required'] == '1') {
                if (!($data[self::$fieldPrefix . $value['field_name']] = self::p($value['field_name'])) && !is_numeric($data[self::$fieldPrefix . $value['field_name']])) {
                    self::error($value['field_display_name'] . '为必填选项');
                }
            } else {
                $field_name = self::p($value['field_name']);
                if (!empty($field_name)) {
                    $data[self::$fieldPrefix . $value['field_name']] = $field_name;
                } elseif (empty($field_name) && !is_numeric($field_name) && !empty($value['field_default'])) {
                    $data[self::$fieldPrefix . $value['field_name']] = $value['field_default'];
                } elseif (empty($field_name) && $value['field_is_null'] == 1) {
                    $data[self::$fieldPrefix . $value['field_name']] = NULL;
                } else {
                    $data[self::$fieldPrefix . $value['field_name']] = $field_name;
                }
            }

            self::checkOnly($value, $data[self::$fieldPrefix . $value['field_name']]);
        }

        return $data;
    }

    /**
     * 检查唯一属性
     * @param $field 字段信息
     * @param $value 处理过的数据
     */
    private static function checkOnly($field, $value) {
        if ($field['field_only'] == 1 && !empty($value)) {
            $checkField = self::$fieldPrefix . $field['field_name'];
            $primaryKeyID = self::$fieldPrefix . 'id';

            $checkCondition = '1 = 1';
            $param = [
                "{$checkField}" => $value,
            ];

            if (METHOD == 'PUT') {
                $checkCondition .= " AND {$primaryKeyID} != :$primaryKeyID ";
                $param[$primaryKeyID] = self::p('id');
            }

            $checkCondition .= " AND {$checkField} = :$checkField  ";
            $checkOnly = self::db(self::$table)->where($checkCondition)->find($param);
            if (!empty($checkOnly)) {
                self::error("{$field['field_display_name']} 提交的 `{$value}` 已存在，请更改后再提交。");
            }
        }
    }

    /**
     * 列出对应分类
     * @param type $table 表名
     * @param type $cid 分类ID
     */
    public static function listCategoryContent($table, $cid) {
        return self::db($table)->where("{$table}_catid = :cid")->select(['cid' => $cid]);
    }

    /**
     * 设置URL
     * @param type $id 需要更新的ID
     */
    private static function setUrl($id) {
        $existUrl = self::db()->fetch('SHOW columns FROM ' . self::$modelPrefix . self::$table . ' WHERE Field = :field;', ['field' => self::$fieldPrefix . 'url']);
        if (!empty($existUrl)) {
            $url = self::url(MODULE . '-view', ['id' => $id]);
            return self::db(self::$table)->where(self::$fieldPrefix . 'id = :id')->update([self::$fieldPrefix . 'url' => $url, 'noset' => ['id' => $id]]);
        }
    }

    /**
     * 快速构造内容分页
     * @param array $sql 结构内容如下：
     * count => 一个完整的SQL count查询。用户获取本当前内容的总数量 如：SELECT count(*) TABLE WHERE id = :id
     * normal => 结合上面的SQL。这部分是分类的。如： SELECT * TABLE WHERE id = :id
     * param => 预处理参数。如果SQL语句中有占位符，此处也应该调用。如: array('id' => $id)
     * page => '分页输出数量'
     * style => '分页的样式，具体参考\Expand\Page分页类'
     * LANG => '分页的语言设置，同上'
     * 上面说的可能不太好理解。有如下SQL：
     * $sql = SELECT %s FROM user WHERE user_id = :user_id ORDER BY user_id DESC
     * $param = array('user_id' => $uid);
     *
     * 最终可以这样调用本方法：
     * \Model\Content::listContent(array('count' => sprintf($sql, 'count(*)'), 'normal' => sprintf($sql, '*'), 'param' => $param))
     *
     * @return array 结果返回：处理好的 列表二维数组和 一个分类超链接 还有分页的对象
     */
    public static function quickListContent(array $sql = ['count' => '', 'normal' => '', 'param' => []]) {
        $sql = array_merge(['param' => [], 'page' => '10', 'style' => [], 'LANG' => []], $sql);
        $page = new \Expand\Page();
        $page->style = $sql['style'];
        $page->LANG = $sql['LANG'];
        $page->listRows = $sql['page'];
        $count = self::db()->fetch($sql['count'], $sql['param']);
        $total = $count === false ? '0' : current($count);
        $page->total($total);
        $page->handle();
        $list = self::db()->getAll("{$sql['normal']} LIMIT {$page->firstRow}, {$page->listRows}", $sql['param']);
        return ['list' => $list, 'page' => $page->show(), 'pageObj' => $page];
    }

    /**
     * 快速插入方法，适用不能调用db方法的地方使用
     * @param $table 表名
     * @param $data 数据
     */
    public static function insert($table, $data) {
        return self::db($table)->insert($data);
    }

    /**
     * 递归获取表内容
     * @param $table 表名称
     * @param $condition 筛选条件
     * @param $param 筛选值
     * @param $template 加载的模板
     * @param $space 空字符
     */
    public static function recursion($table, $condition, $param, $template, $space, $order) {
        static $label;
        if (empty($label)) {
            $label = new \Expand\Label();
        }
        $result = self::db($table)->where($condition)->order($order)->select($param);
        if (!empty($result)) {
            require $template;
        }
    }

    /**
     * 检查重复
     * @param $table 查询的表
     * @param $field 查询的字段
     * @param $value 匹配的内容
     * @return bool 存在重复返回true 。反之false
     */
    public static function checkRepeat($table, $field, $value){
        $checkRepeat = self::db($table)->where("$field = :$field")->find([
            $field => $value
        ]);

        if(!empty($checkRepeat)){
            return true;
        }else{
            return false;
        }

    }

}
