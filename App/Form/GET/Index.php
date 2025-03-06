<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Form\GET;

use Model\Content;

class Index extends \Core\Controller\Controller {

    private $rowlock = '';

    public function index() {
        if (!empty($_GET)) {
            $this->jump('/');
        }
        $system = \Core\Func\CoreFunc::$param['system'];
        if ($system['openindex'] == '0') {
            $this->_404();
        }
        $template = $system['indexStyle'] == 0 ? '' : 'Index_ticket';

        $indexSetting = \Core\Func\CoreFunc::$param['indexSetting'];

        $this->indexTicketType($indexSetting);
        $this->fqa($indexSetting);

        $this->layout($template);
    }

    /**
     * 首页工单分类/模型类型输出
     * @param $indexSetting
     * @return void
     */
    private function indexTicketType($indexSetting) {
        $listType = [];

        switch ($indexSetting['index_type']) {
            case 1:
                $listType = \Model\Content::listContent([
                    'table'     => 'category',
                    'field'     => 'category_id AS id, category_img AS img, category_name AS name, category_description AS description',
                    'condition' => 'category_parent = 0',
                    'order'     => 'category_listsort ASC, category_id DESC',
                ]);
                break;
            case 2:
                $listType = \Model\Content::listContent([
                    'table'     => 'category AS c',
                    'field'     => 'c.category_id AS id, c.category_img AS img, c.category_name AS name, c.category_description AS description',
                    'join'      => "{$this->prefix}ticket_model AS tm ON tm.ticket_model_cid = c.category_id",
                    'condition' => 'tm.ticket_model_id IS NOT NULL',
                    'group'     => 'c.category_id',
                    'order'     => 'category_listsort ASC, category_id DESC',
                ]);
                break;
            case 3:
                $listType = \Model\Content::listContent([
                    'table'     => 'ticket_model',
                    'field'     => 'ticket_model_name AS name, ticket_model_number AS number, ticket_model_img AS img, ticket_model_cid AS id, ticket_model_explain AS description',
                    'condition' => 'ticket_model_cid = :ticket_model_cid AND ticket_model_status = 1 ',
                    'order'     => 'ticket_model_listsort ASC, ticket_model_id  DESC',
                    'param'     => [
                        'ticket_model_cid' => $indexSetting['index_cid'],
                    ],
                ]);

        }

        $this->assign('listType', $listType);
    }

    /**
     * 首页FQA显示
     * @param $indexSetting
     * @return void
     */
    private function fqa($indexSetting) {
        $fqa = [];
        if ($indexSetting['fqa'] == 1) {
            $fqaList = \Model\Fqa::getList();
            if (!empty($fqaList)) {
                foreach ($fqaList as $value) {
                    $fqa[$value['ticket_model_name']]['img'] = $value['ticket_model_img'];
                    $fqa[$value['ticket_model_name']]['list'][] = $value;
                }
            }
        }


        $this->assign('fqa', $fqa);
    }

    /**
     * 验证码
     */
    public function verify() {
        $verify = new \Expand\Verify();
        if (!empty($_GET['height'])) {
            $verify->height = intval($this->g('height'));
        }
        $verifyLength = \Core\Func\CoreFunc::$param['system']['verifyLength'];
        $verify->createVerify(empty($verifyLength) ? '4' : $verifyLength);
    }

    /**
     * 发送通知
     */
    public function notice() {
        $system = \Core\Func\CoreFunc::$param['system'];
        $this->db()->transaction();
        if (in_array($system['notice_way'], ['1', '3'])) {
            \Model\Notice::sendNotice();
        }

        $this->db()->commit();
    }

    /**
     * 工单系统行为事件
     */
    public function behavior() {
        \Model\Behavior::behavior();
    }

}