<?php

namespace Model;

class Category extends \Core\Model\Model {

    /**
     * 递归获取分类
     * @param string $cid 分类ID
     * @param bool $isSelect 是否选项表单
     * @param int $parent 父类ID
     * @param string $space 空格
     * @return array|string
     */
    public static function recursion($cid, $cidParent = '', $isSelect = false, $parent = 0, $space = '') {
        $list = \Model\Content::listContent([
            'table' => 'category',
            'condition' => 'category_parent = :category_parent AND category_status = 1',
            'order' => 'category_listsort ASC, category_id DESC',
            'param' => [
                'category_parent' => $parent
            ]
        ]);
        $category = $isSelect === false ? [] : '';
        if (!empty($list)) {
            foreach ($list as $value) {
                if ($isSelect === false) {
                    $category[$value['category_id']] = $value;
                    $category[$value['category_id']]['child'] = self::recursion($cid, $cidParent, $isSelect, $value['category_id'],  $space);
                } else {
                    if (!empty($space)) {
                        $guide = '└─';
                    }
                    $selected = $cidParent == $value['category_id'] ? 'selected="selected"' : '';
                    $disabled = $cid == $value['category_id'] ? 'disabled="disabled"' : '';
                    
                    $category .= '<option value="' . $value['category_id'] . '" '.$selected.' '.$disabled.'>' . $space . $guide . $value['category_name'] . '</option>';
                    $category .= self::recursion($cid, $cidParent, $isSelect, $value['category_id'], $space . '&nbsp;&nbsp;');
                }

            }
        }

        return $category;
    }

}