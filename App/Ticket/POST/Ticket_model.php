<?php
namespace App\Ticket\POST;

/**
 * 工单模型
 */
class Ticket_model extends Content {

    /**
     * 添加工单模型基础信息
     * @param bool $jump
     * @param bool $commit
     */
    public function action($jump = false, $commit = false) {
        parent::action($jump, $commit);
        if($_POST['copy'] == 1){
            $this->copy();
        }

        $this->db()->commit();

        if (!empty($_POST['back_url'])) {
            $url = base64_decode($_POST['back_url']);
        } else {
            $url = $this->url(GROUP . '-' . MODULE . '-index');
        }

        $this->success('添加内容成功', $url);

    }

    /**
     * 执行工单模型复制
     */
    private function copy(){
        $id = $this->db()->getLastInsert;

        $ticket = \Model\Content::findContent('ticket_model', $this->p('id'), 'ticket_model_number');
        if(empty($ticket)){
            $this->db()->rollback();
            $this->error('复制的目标工单模型不存在');
        }

        $form = $this->db('ticket_form')->where('ticket_form_model_id = :ticket_form_model_id')->select([
            'ticket_form_model_id' => $ticket['ticket_model_id']
        ]);
        if(!empty($form)){
            foreach ($form as $key => $value){
                unset($value['ticket_form_id']);
                $value['ticket_form_model_id'] = $id;
                $this->db('ticket_form')->insert($value);
            }
        }
    }

}