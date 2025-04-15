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
        foreach ($res as $item) {
            $list[$item['ticket_model_cid']][] = $item;
        }

        ksort($list);

        $field = [];

        $i = 0;
        $k = 0;
        foreach ($this->field as $item) {
            if (in_array($item['field_id'], ['186', '153'])) {
                continue;
            } elseif (in_array($item['field_id'], ['240', '211'])) {
                $field['main'][$item['field_id']] = $item;
            } else {
                $field['other'][$i][] = $item;
                $k++;
                if ($k % 3 == 0) {
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
        if (!empty($_GET['copy'])) {
            $this->assign('title', "复制 - {$this->model['model_title']}");
            $this->assign('method', 'POST');
        }

        $tag = [
            'cid'               => '工单基础属性',
            'name'              => '工单基础属性',
            'custom_no'         => '工单基础属性',
            'login'             => '工单基础属性',
            'verify'            => '工单基础属性',
            'title_description' => '工单基础属性',
            'fqa_tips'          => '工单基础属性',
            'recovery_day'      => '工单基础属性',
            'img'               => '工单基础属性',
            'is_appointment'    => '工单基础属性',

            'auto'              => '工单自动化',
            'auto_logic'        => '工单自动化',
            'time_out'          => '工单自动化',
            'time_out_sequence' => '工单自动化',
            'open_close'        => '工单自动化',
            'close_type'        => '工单自动化',
            'close_time'        => '工单自动化',

            'group_id'     => '工单内部设置',
            'default_send' => '工单内部设置',
            'exclusive'    => '工单内部设置',
            'organize_id'  => '工单内部设置',

            'explain'         => '工单页内设置',
            'postscript'      => '工单页内设置',
            'contact'         => '工单页内设置',
            'contact_default' => '工单页内设置',
        ];
        $field = [];
        foreach ($this->field as $item) {
            if (isset($tag[$item['field_name']])) {
                $field[$tag[$item['field_name']]][$item['field_id']] = $item;
            } else {
                $field['其他设置'][$item['field_id']] = $item;
            }
        }


        $this->assign('field', $field);
        $this->layout();
    }

}