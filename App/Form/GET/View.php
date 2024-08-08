<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Form\GET;

class View extends \Core\Controller\Controller {


    /**
     * 查看工单的进度
     */
    public function ticket() {
        $content = $this->getTicketInfo();

        \Model\Ticket::loginCheck($content['ticket']);

        //查询工单是否有新回复。
        if (!empty($_GET['replyRefresh'])) {
            echo $content['chat']['pageObj']->totalRow;
            exit;
        } elseif (!empty($_GET['getChat'])) {
            $this->assign('chat', $content['chat']['list']);
            ob_start();
            $this->display('View_chat');
            $html = ob_get_contents();
            ob_clean();
            $this->success([
                'msg'  => '获取对话内容成功',
                'data' => [
                    'html'       => $html,
                    'pageTotal'  => $content['chat']['pageObj']->totalRow,
                    'totalPages' => $content['chat']['pageObj']->totalPages,
                ],
            ]);
        } else {

            \Model\Ticket::readStatus($content['ticket']['ticket_id'], 0);
            $this->assign('title', '查看工单');
            $this->assign($content['ticket']);
            $this->assign('form', $content['form']);
            $this->assign('member', $content['member']);
            $this->assign('chat', $content['chat']['list']);
            $this->assign('page', $content['chat']['page']);
            $this->assign('pageObj', $content['chat']['pageObj']);
            $this->layout();
        }
    }

    /**
     * 打印发票
     */
    public function printer() {
        $content = $this->getTicketInfo(9999);

        if (empty($this->session()->get('ticket'))) {
            \Model\Ticket::loginCheck($content['ticket']);
        }

        $this->assign($content);

        $this->display();

    }

    /**
     * 获取工单的信息
     * @param $page 聊天内容分页输
     * @return array 返回详细信息
     */
    private function getTicketInfo($chatPage = 30) {
        $content = \Model\Ticket::view($chatPage);
        if ($content == false) {
            $this->jump($this->url('Form-Fqa-search', ['keyword' => $this->g('number')]));
        } else {
            return $content;
        }
    }

}