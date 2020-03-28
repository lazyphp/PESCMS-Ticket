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

    public function call(){
        $template = $this->isP('template', '请提交您要切换的主题模板');
        if(!is_dir(THEME."/Form/{$template}")){
            $this->error('无法找到切换的主题模板，请再次提交');
        }

        $privateKey = md5('Form' . self::$config['PRIVATE_KEY']);
        $markUsingFile = THEME . "/Form/{$privateKey}";

        $f = fopen($markUsingFile, 'w');
        fwrite($f, $template);
        fclose($f);

        $this->success('切换主题模板成功！');

    }

}