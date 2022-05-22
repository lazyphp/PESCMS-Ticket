<?php
namespace App\Ticket\GET;

/**
 * 工单模型
 */
class Ticket_model extends Content {

    public function index($display = true) {
        $this->model['model_page'] = 9999;
        parent::index(false);

        $res = \Core\Func\CoreFunc::$param['list'];
        unset(\Core\Func\CoreFunc::$param['list']);
        $list = [];
        foreach ($res as $item){
            $list[$item['ticket_model_cid']][] = $item;
        }

        ksort($list);

        $field = [];

        $i = 0;
        $k = 0;
        foreach ($this->field as $item){
            if(in_array($item['field_id'], ['186', '153'])){
                continue;
            }elseif(in_array($item['field_id'], ['240', '211'])){
                $field['main'][$item['field_id']] = $item;
            }else{
                $field['other'][$i][] = $item;
                $k++;
                if($k%3 == 0){
                    $i++;
                }
            }

        }

        $this->assign('field', $field);
        $this->assign('list', $list);

        $this->layout();

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