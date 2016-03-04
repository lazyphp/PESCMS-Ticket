<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model;

/**
 * 菜单模型
 */
class Menu extends \Core\Model\Model {

    private static $menuTitle = '';

    /**
     * 生成后台菜单
     */
    public static function menu($groupId = '') {
        $condition = "";
        if (!empty($groupId) && $_SESSION['ticket']['user_id'] > '1') {
            $group = \Model\Content::findContent('user_group', $groupId, 'user_group_id');
            $condition .= "m.menu_id in ({$group['user_group_menu']})";
        }


        $result = self::db('menu AS m')->field("m.*, IF(parent.top_id IS NULL, m.menu_id, parent.top_id) AS top_id, IF(parent.top_listsort IS NULL, '0', parent.top_listsort) AS top_listsort, IF(parent.top_name IS NULL, m.menu_name, top_name) AS top_name, menu_icon")->join("(SELECT `menu_id` AS top_id, `menu_name` AS top_name, `menu_pid` AS top_pid, `menu_listsort` AS top_listsort FROM `" . self::$modelPrefix . "menu` where menu_pid = 0) AS parent ON parent.top_id = m.menu_pid")->where($condition)->order('top_listsort ASC, m.menu_listsort ASC, m.menu_id DESC')->select();

        foreach ($result as $key => $value) {
            if ($value['menu_pid'] == 0) {
                $menu[$value['top_name']]['menu_id'] = $value['top_id'];
                $menu[$value['top_name']]['menu_name'] = $value['top_name'];
                $menu[$value['top_name']]['menu_link'] = $value['menu_link'];
                $menu[$value['top_name']]['menu_icon'] = $value['menu_icon'];
                $menu[$value['top_name']]['menu_listsort'] = $value['menu_listsort'];
                $menu[$value['top_name']]['menu_type'] = $value['menu_type'];
            }
        }
        foreach ($result as $key => $value) {
            if (!empty($menu[$value['top_name']]) && $value['menu_pid'] != 0) {
                $menu[$value['top_name']]['menu_child'][] = $value;
            }
        }
        return $menu;
    }

    /**
     * 根据菜单获取标题
     */
    public static function getTitleWithMenu() {
        if(empty(self::$menuTitle[GROUP . '-' . MODULE . "-" . ACTION])){
            self::$menuTitle[GROUP . '-' . MODULE . "-" . ACTION] = $result = self::db('menu')->where('menu_link = :menu_link')->find(array('menu_link' => GROUP . '-' . MODULE . "-" . ACTION));
        }
        return self::$menuTitle[GROUP . '-' . MODULE . "-" . ACTION];
    }

    /**
     * 顶级菜单
     */
    public static function topMenu() {
        return self::db('menu')->where('menu_pid = 0')->order('menu_listsort ASC, menu_id DESC')->select();
    }


    /**
     * 执行菜单入库
     * @return type 返回插入结果
     */
    public static function insertMenu(array $array) {
        $param = array_merge(['menu_icon' => 'am-icon-file', 'menu_pid' => '9'], $array);
        return self::db('menu')->insert($param);
    }

}
