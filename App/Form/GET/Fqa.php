<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Form\GET;

class Fqa extends \Core\Controller\Controller {

    public function __call($name, $arguments) {
        if ($name == 'list') {
            $this->getList();
        } else {
            $this->_404();
        }

    }

    /**
     * FQA列表输出
     */
    public function index() {
        $number = $this->isG('number', '请提交工单number');
        $ticket = \Model\TicketModel::numberFind($number);
        $list = \Model\Content::listContent([
            'table'     => 'fqa',
            'field'     => 'fqa_id, fqa_url, fqa_title',
            'condition' => 'fqa_ticket_model_id = :model_id AND fqa_status = 1',
            'order'     => 'fqa_listsort ASC, fqa_id DESC',
            'param'     => [
                'model_id' => $ticket['ticket_model_id'],
            ],
        ]);
        if (empty($list) || ($ticket['ticket_model_login'] == 1 && empty($this->session()->getId('member')))) {
            $this->error('没有FQA');
        } else {
            $this->success(['msg' => '获取FQA成功', 'data' => $list]);
        }


    }

    public function getList() {


        if (!empty($_GET['keyword'])) {
            \Model\Fqa::$condition .= ' AND (f.fqa_title LIKE :fqa_title OR f.fqa_content LIKE :fqa_content)';
            \Model\Fqa::$param['fqa_title'] = \Model\Fqa::$param['fqa_content'] = '%' . $this->g('keyword') . '%';
        }


        $result = \Model\Fqa::getList();

        if (!empty($result) && empty($_GET['keyword'])) {
            foreach ($result as $value) {
                $list[$value['ticket_model_cid']][$value['fqa_ticket_model_id']]['ticket_model_name'] = $value['ticket_model_name'];
                $list[$value['ticket_model_cid']][$value['fqa_ticket_model_id']]['list'][] = $value;
            }
        } elseif (!empty($result)) {
            $list = $result;
        }

        $this->assign('title', '常见问题');
        $this->assign('list', $list ?? []);
        $this->assign('category', \Model\Category::getAllCategoryCidPrimaryKey());
        $this->layout('Fqa_list');
    }

    /**
     * 查看工单详情
     */
    public function view() {
        $id = $this->isG('id', '请提交您要查看的问题');
        $content = \Model\Content::findContent('fqa', $id, 'fqa_id');
        if (empty($content)) {
            $this->_404();
        }
        $this->assign($content);

        $ticket = \Model\TicketModel::getTicketModelList($content['fqa_ticket_model_id']);
        if ($ticket['ticket_model_login'] == 1 && empty($this->session()->get('member'))) {
            $this->jump($this->url('Login-index', ['back_url' => base64_encode($_SERVER['REQUEST_URI'])]));
        }

        $this->assign('ticketModel', $ticket);

        $this->assign('title', $content['fqa_title']);

        $this->layout();
    }

}