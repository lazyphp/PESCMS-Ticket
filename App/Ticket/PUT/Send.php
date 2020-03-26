<?php
namespace App\Ticket\PUT;

class Send extends Content {

    /**
     * 刷新发送列表中的执行结果
     */
    public function refresh(){
        $id = $this->isG('id', '请提交要重新发送的ID');
        $this->db('send')->where('send_id = :send_id')->update([
            'noset' => [
                'send_id' => $id
            ],
            'send_result' => ''
        ]);
        if(!empty($_GET['back_url'])){
            $url = base64_decode($this->g('back_url'));
        }else{
            $url = $this->url('Ticket-Send-index');
        }

        $this->success('已重置发送任务，请等待系统执行发送', $url);

    }

}