<?php
namespace App\Ticket\GET;

/**
 * 工单模型
 */
class Ticket_model extends Content {

    public function index($display = true) {
        switch ($_GET['sortby']){
            case '1':
                $this->sortBy = 'ticket_model_cid ASC, ticket_model_listsort ASC, ticket_model_id DESC';
                break;
        }
        parent::index($display);
    }

    public function action($display = false) {
        parent::action($display);
        if(!empty($_GET['copy'])){
            $this->assign('title', "复制 - {$this->model['model_title']}");
            $this->assign('method', 'POST');
        }
        $this->layout();
    }

}