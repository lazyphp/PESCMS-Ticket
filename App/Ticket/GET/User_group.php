<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */
namespace App\Ticket\GET;

class User_group extends Content {

    public function action($display = false) {
        parent::action($display);
        if(!empty($_GET['copy'])){
            $this->assign('title', "复制 - {$this->model['model_title']}");
            $this->assign('url', $this->url('Ticket-User_group-copy'));
            $this->assign('method', 'POST');
        }
        $this->layout();
    }

    /**
     * 设置菜单
     */
    public function setMenu() {
        $id = $this->isG('id', '请提交用户组');
        $record = [];
        $recordList = \Model\Content::findContent('user_group', $id, 'user_group_id')['user_group_menu'];
        if(!empty($recordList)){
            $record = explode(',', $recordList);
        }
        $this->assign('record', json_encode($record));
        $this->assign('list', \Core\Func\CoreFunc::$param['menu']);
        $this->assign('prefix', 'menu_');
        $this->display('User_group_setting');
    }

    /**
     * 设置权限
     */
    public function setAuth() {
        $id = $this->isG('id', '请提交用户组');
        $record = [];
        $recordList = \Model\Content::listContent(['table' => 'node_group', 'condition' => 'user_group_id = :user_group_id', 'param' => ['user_group_id' => $id]]);
        if(!empty($recordList)){
            foreach($recordList as $value){
                $record[] = $value['node_id'];
            }
        }

        $this->assign('record', json_encode($record));
        $this->assign('list', \Model\Node::nodeList());
        $this->assign('prefix', 'node_');
        $this->display('User_group_setting');
    }
}