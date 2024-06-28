<?php
/**
 *
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Ticket\PUT;

class Theme extends \Core\Controller\Controller {

    public function call() {
        $template = $this->isP('template', '请提交您要切换的主题模板');
        if (!is_dir(THEME . "/Form/{$template}")) {
            $this->error('无法找到切换的主题模板，请再次提交');
        }

        $privateKey = md5('Form' . self::$config['PRIVATE_KEY']);
        $markUsingFile = THEME . "/Form/{$privateKey}";

        $f = fopen($markUsingFile, 'w');
        fwrite($f, $template);
        fclose($f);

        $this->success('切换主题模板成功！');

    }

    /**
     * 更新主题首页布局设置
     * @return void
     */
    public function setting() {
        $check = \Model\Theme::checkIndexSetting();
        $data = [
            'index_type' => $this->p('index_type'),
            'hot_key'    => $this->p('hot_key'),
            'index_cid'  => (int)$this->p('index_cid'),
            'fqa'        => (int)$this->p('fqa'),
        ];


        $f = fopen($check['settingFile'], 'w');
        fwrite($f, json_encode($data, JSON_UNESCAPED_UNICODE));
        fclose($f);

        if (!empty($_POST['back_url'])) {
            $url = base64_decode($_POST['back_url']);
        } else {
            $url = $this->url(GROUP . 'Theme-index');
        }

        $this->success('更新主题首页布局设置成功！', $url);

    }


}