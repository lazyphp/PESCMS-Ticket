<?php

namespace App\Ticket\POST;

/**
 * 公用内容插入
 */
class Content extends \App\Ticket\Common {


    /**
     * 添加内容
     * @param type $jump 是否跳转.当继承本类时,若不跳转,提交false
     * @param type $commit 是否提交事务.默认提交.若想继承者继续在本事务中操作,请提交false
     */
    public function action($jump = TRUE, $commit = TRUE) {
        $this->db()->transaction();
        $addResult = \Model\Content::addContent();
        if ($addResult === false) {
            $this->db()->rollBack();
            $this->error($addResult['mes']);
        }

        if (!empty($_POST['back_url'])) {
            $url = base64_decode($_POST['back_url']);
        } else {
            $url = $this->url(GROUP . '-' . MODULE . '-index');
        }

        if ($commit === TRUE) {
            $this->db()->commit();
        }

        if ($jump === TRUE) {
            $this->success('添加内容成功', $url);
        }
    }

}
