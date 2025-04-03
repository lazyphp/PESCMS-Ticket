<?php
/**
 * Copyright (c) 2022 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Ticket\GET;

class HelpDocument extends \Core\Controller\Controller {

    /**
     * 查找帮助文档
     * @return void
     */
    public function find() {

        //准确搜索文档
        $result = \Model\Content::findContent('help_document', $this->isG('help_controller', '请提交要查找文档控制器'), 'help_document_controller');


        if (empty($result)) {
            //范围搜索文档
            $result = \Model\Content::findContent('help_document', $this->isG('match', '请提交要查找文档控制器'), 'help_document_controller');
            if (empty($result)) {
                $this->error('当前没有帮助文档');
            }

        }

        $this->success(['data' => $result]);

    }

    /**
     * 读取示例
     * @return void
     */
    public function example() {
        ob_start();
        $this->display('HelpDocument_ticket_model_table');
        $html = ob_get_contents();
        ob_end_clean();
        $this->success(['msg' => 'ok', 'data' => $html]);
    }

}