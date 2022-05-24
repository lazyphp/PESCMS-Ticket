<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

/**
 * 权限节点
 */
class Node extends \Core\Model\Model {

    /**
     * 节点列表
     */
    public static function nodeList() {

        $result = self::db('node AS n')->field("n.*, IF(parent.top_id IS NULL, n.node_id, parent.top_id) AS top_id, IF(parent.top_listsort IS NULL, '0', parent.top_listsort) AS top_listsort, IF(parent.top_title IS NULL, n.node_name, top_title) AS top_title")->join("(SELECT `node_id` AS top_id, `node_name` AS top_title, `node_parent` AS top_parent, `node_listsort` AS top_listsort FROM `" . self::$modelPrefix . "node` where node_parent = 0) AS parent ON parent.top_id = n.node_parent")->order('top_listsort ASC, node_listsort ASC, n.node_id DESC')->select();

        foreach ($result as $key => $value) {
            if ($value['node_parent'] == 0) {
                $node[$value['node_name']]['node_id'] = $value['top_id'];
                $node[$value['node_name']]['node_name'] = $value['node_name'];
                $node[$value['node_name']]['node_listsort'] = $value['node_listsort'];
            }
        }
        foreach ($result as $key => $value) {
            if (!empty($node[$value['top_title']]) && $value['node_parent'] != 0) {
                $node[$value['top_title']]['node_child'][] = $value;
            }
        }

        return $node;
    }

}
