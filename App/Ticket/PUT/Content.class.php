<?php

namespace App\Ticket\PUT;

/**
 * 公用内容更新
 */
class Content extends \App\Ticket\Common {

    /**
     * 更新内容
     * @param type $jump 是否跳转.当继承本类时,若不跳转,提交false
     * @param type $commit 是否提交事务.默认提交.若想继承者继续在本事务中操作,请提交false
     */
    public function action($jump = TRUE, $commit = TRUE) {

        $this->db()->transaction();
        $updateResult = \Model\Content::updateContent();

        if (!empty($_POST['back_url'])) {
            $url = base64_decode($_POST['back_url']);
        } else {
            $url = $this->url(GROUP . '-' . MODULE . '-index');
        }

        if ($commit === TRUE) {
            $this->db()->commit();
        }

        if ($jump === TRUE) {
            $this->success('更新内容成功', $url);
        }
    }

    /**
     * 内容排序
     */
    public function listsort() {
        foreach ($_POST['id'] as $key => $value) {
            \Model\ModelManage::updateSortFromModel(MODULE, $key, $value);
        }

        if (!empty($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $url = "";
        }
        $this->success('内容排序成功', $url);
    }

}
