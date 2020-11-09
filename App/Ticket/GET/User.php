<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2016 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


namespace App\Ticket\GET;

class User extends Content {

    /**
     * 个人设置
     */
    public function setting(){
        $info = \Model\Content::findContent('user', $this->session()->get('ticket')['user_id'], 'user_id');
        $this->assign($info);
        $this->assign('title', '个人信息');
        $this->layout();
    }

    /**
     * 个人的站内消息
     */
    public function notice(){

        //删除7天已读消息
        self::db('csnotice')->where('csnotice_read = 1 AND csnotice_read_time < :time')->delete([
            'time' => time() - 86400 * 7
        ]);

        $condition = 'cn.user_id = :user_id';

        $param = [
            'user_id' => $this->session()->get('ticket')['user_id'],
        ];

        if(!empty($_GET['type'])){
            $condition .= " AND cn.csnotice_type = :csnotice_type ";
            $param['csnotice_type'] = (int) $this->g('type') * -1;
        }

        //未读更新已读
        $this->db('csnotice cn')->where($condition.' AND cn.csnotice_read = 0  ')->update(array_merge(['csnotice_read' => 1, 'csnotice_read_time' => time()], [
            'noset' => $param,
        ]));

        //默认100条记录
        $list = $this->db('csnotice AS cn')->field('cn.*, ABS(cn.csnotice_type) AS csnotice_type, t.ticket_title')->join("{$this->prefix}ticket AS t ON t.ticket_number = cn.ticket_number")->where($condition)->order('csnotice_id DESC')->limit(100)->select($param);

        $option = \Model\Field::findField('255', true)->deFieldOptionToArray();

        $this->assign('type', $option);
        $this->assign('typeName', array_flip($option));
        $this->assign('list', $list);

        $this->layout();
    }
}