<?php
/**
 *
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Ticket\GET;

class Theme extends \Core\Controller\Controller {

    /**
     * 模板列表
     */
    public function index(){
        $this->assign('title', '模板列表');
        $this->assign('currentTheme', \Core\Func\CoreFunc::getThemeName('Form'));
        $this->assign('list', $this->getThemeList());
        $this->layout();
    }

    /**
     * 获取模板列表
     * @return array
     */
    private function getThemeList(){
        $themePatch = THEME.'/Form/';

        $themeList = [];

        $handler = opendir($themePatch);
        while (($patchName = readdir($handler)) !== false) {
            if ($patchName != "." && $patchName != ".." && is_dir($themePatch.$patchName) ) {

                $themeInfo = $themePatch.$patchName.'/info.ini';

                if(is_file($themeInfo) === false){
                    continue;
                }

                $info = parse_ini_file($themeInfo, true);


                $themeList[$patchName] = $info['Theme'];

            }
        }
        closedir($handler);

        return $themeList;
    }

}