<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Ticket\GET;

class Node extends Content{

    public function index($display = false) {
        $this->assign('title', $this->model['model_title']);
        $this->assign('node', \Model\Node::nodeList());
        $this->layout();
    }


}