<?php
namespace App\Ticket\GET;

/**
 * 工单模型
 */
class Ticket_model extends Content {

    public function action($display = false) {
        parent::action($display);
        if(!empty($_GET['copy'])){
            $this->assign('title', "复制 - {$this->model['model_title']}");
            $this->assign('method', 'POST');
        }
        $this->layout();
    }

}