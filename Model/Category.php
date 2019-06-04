<?php

namespace Model;

class Category extends \Core\Model\Model {

    /**
     * @var bool 默认分类筛选状态为1
     */
    public static $filterStatus = true;

    /**
     * 获取所有分类且cid作为主键
     * @return 返回cid作为主键的完整分类信息
     */
    public static function getAllCategoryCidPrimaryKey(){
        $categoryList = \Model\Content::listContent(['table' => 'category']);
        if(!empty($categoryList)){
            foreach ($categoryList as $item){
                $category[$item['category_id']] = $item;
            }
        }
        return $category;
    }

    /**
     * 递归获取分类
     * @param string $cid 分类ID
     * @param bool $isSelect 是否选项表单
     * @param int $parent 父类ID
     * @param string $space 空格
     * @return array|string
     */
    public static function recursion($isSelect = false, $parent = 0, $space = '') {

        $condition = self::$filterStatus == true ? ' AND category_status = 1 ' : '';

        $list = \Model\Content::listContent([
            'table' => 'category',
            'condition' => "category_parent = :category_parent {$condition}",
            'order' => 'category_listsort ASC, category_id DESC',
            'param' => [
                'category_parent' => $parent
            ]
        ]);
        $category = [];
        $symbol = $isSelect === false ? '<span class="plus_icon plus_none_icon"></span>' : '&nbsp;&nbsp;';
        $guide = $isSelect === false ? '<span class="plus_icon plus_end_icon"></span>' : '└─';

        if (!empty($list)) {
            foreach ($list as $value) {
                    $category[$value['category_id']] = $value;
                    $category[$value['category_id']]['space'] = $space;
                    $child = self::recursion($isSelect, $value['category_id'],  $space.$symbol);
					if(!empty($child)){
						foreach($child as $item){
							$category[$item['category_id']] = $item;
							$category[$item['category_id']]['guide'] = $guide;
						}
					}
            }
        }

        return $category;
    }

}