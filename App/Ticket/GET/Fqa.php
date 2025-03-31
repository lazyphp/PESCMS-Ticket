<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace App\Ticket\GET;

class Fqa extends Content {

    public function index($display = true) {
        $ticketModel = \Model\TicketModel::getTicketModelList();
        $this->assign('ticketModel', $ticketModel);

        if (!empty($_GET['ticket_model_id'])) {
            $this->condition .= ' AND fqa_ticket_model_id = :ticket_model_id ';
            $this->param['ticket_model_id'] = $this->g('ticket_model_id');
        }
        parent::index($display);
    }

    /**
     * 导入文档
     * @return void
     */
    public function doc() {

        $ticket_model_id = $this->isG('ticket_model_id', '请提交工单模型ID');

        $ticketModel = \Model\TicketModel::getTicketModelList();


        $docApi = \Model\Option::getOptionValue('doc', true);
        if (empty($docApi['authorization'])) {
            $this->error('请先配置文档系统API信息');
        }

        $doc = [];

        while (true) {
            $page = 1;
            $res = (new \Expand\cURL())->init("{$docApi['url']}/?m=Doc&a=index&page={$page}", null, [
                CURLOPT_HTTPHEADER => [
                    "Authorization: {$docApi['authorization']}",
                    'Accept: application/json',
                ],
            ]);
            $page++;

            $res = json_decode($res, true);
            if (empty($res['status']) || $res['status'] != 200) {
                break;
            }


            $doc = $doc + array_column($res['data']['list'], 'doc_title', 'doc_id');


            if ($page > $res['data']['pageObj']['totalPages']) {
                break;
            }
        }

        $this->assign('title', "工单模型 「{$ticketModel[$ticket_model_id]['ticket_model_name']}」 —— 导入文档系统");
        $this->assign('doc', $doc);
        $this->layout();

    }

    /**
     * 获取文档目录
     * @return void
     */
    public function getDocPath() {
        $docApi = \Model\Option::getOptionValue('doc', true);
        if (empty($docApi['authorization'])) {
            $this->error('请先配置文档系统API信息');
        }
        $docID = $this->isR('id', '请选择要查看的文档');
        $res = (new \Expand\cURL())->init("{$docApi['url']}/?m=Doc&a=path&id={$docID}", null, [
            CURLOPT_HTTPHEADER => [
                "Authorization: {$docApi['authorization']}",
                'Accept: application/json',
            ],
        ]);
        $res = json_decode($res, true);
        if (empty($res['status']) || $res['status'] != 200) {
            $this->error('获取文档目录失败');
        }
        ob_start();
        $this->recursionDocPath($res['data']);
        $html = ob_get_contents();
        ob_clean();

        $this->success([
            'msg'  => '获取文档目录成功',
            'data' => $html,
        ]);
    }

    /**
     * 递归获取文档目录
     * @param $docPath
     * @return void
     */
    protected function recursionDocPath($docPath) {
        $this->assign('path', $docPath);
        $this->display('fqa_doc_path');
    }

}