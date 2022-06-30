<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */
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
        $category = [];
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

    public static function getCategoryORTicketList(){

        $id = self::g('id');

        $categoryList = \Model\Content::listContent([
            'table' => 'category',
            'field' => 'category_id, category_name, category_description',
            'condition' => 'category_parent = :category_parent AND category_status = 1',
            'order' => 'category_listsort ASC, category_id DESC',
            'param' => [
                'category_parent' => empty($id) ? 0 : $id
            ]
        ]);
        if(!empty($categoryList)){
            foreach ($categoryList as $key => $value){
                $category[$key] = $value;
                $category[$key]['category_description'] = htmlspecialchars_decode($value['category_description']);
            }
        }

        if(!empty($id)){
            $getTicketModelResult = \Model\Content::listContent([
                'table' => 'ticket_model',
                'field' => 'ticket_model_number, ticket_model_name, ticket_model_explain, ticket_model_organize_id, ticket_model_fqa_tips',
                'condition' => 'ticket_model_cid = :id AND ticket_model_status = 1',
                'order' => 'ticket_model_listsort ASC, ticket_model_id DESC',
                'param' => [
                    'id' => $id
                ]
            ]);
            if(!empty($getTicketModelResult)){
                foreach ($getTicketModelResult as $key => $value){
                    $ticketModelList[$key] = $value;
                    $ticketModelList[$key]['ticket_model_explain'] = htmlspecialchars_decode($value['ticket_model_explain']);
                }
            }
        }

        return [
            'category' => empty($category) ? false : $category,
            'ticket' => empty($ticketModelList) ? false : $ticketModelList,
        ];
    }

}