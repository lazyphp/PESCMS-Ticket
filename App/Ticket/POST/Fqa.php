<?php

namespace App\Ticket\POST;

class Fqa extends Content {

    public function doc() {

        $modelID = $this->isP('id', '请提交工单模型ID');

        if (empty($_POST['docID'])) {
            $this->error('请选择文档');
        }

        $antiXss = new \voku\helper\AntiXSS();
        $docApi = \Model\Option::getOptionValue('doc', true);

        $this->db('fqa')->where('fqa_ticket_model_id = :fqa_ticket_model_id AND fqa_is_doc = 1')->delete([
            'fqa_ticket_model_id' => $modelID,
        ]);

        foreach ($_POST['docID'] as $key => $docID) {
            $docID = intval($docID);
            if (empty($docID)) {
                continue;
            }

            $title = $antiXss->xss_clean(trim($_POST['title'][$key]));
            $adMark = $antiXss->xss_clean(trim($_POST['aidlist'][$key]));

            //检查已经是否存在相同的FQA
            $checkFQA = $this->db('fqa')->where('fqa_ticket_model_id = :fqa_ticket_model_id AND fqa_title = :fqa_title')->find([
                'fqa_ticket_model_id' => $modelID,
                'fqa_title'           => $title,
            ]);
            if (!empty($checkFQA)) {
                continue;
            }

            $this->db('fqa')->insert([
                'fqa_ticket_model_id' => $modelID,
                'fqa_title'           => $title,
                'fqa_type'            => 1,
                'fqa_link'            => rtrim($docApi['url'], '/') . "/?m=Article&a=index&id={$docID}&aid={$adMark}",
                'fqa_is_doc'          => 1,
                'fqa_status'          => 1,
                'fqa_createtime'      => time(),
            ]);

        }

        $this->success('导入成功');

    }
}