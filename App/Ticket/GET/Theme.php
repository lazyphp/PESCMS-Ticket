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


    public function shop(){
        $this->assign('title', '主题商店');
        $this->assign('installed', json_encode(array_column($this->getThemeList(), 'name')));
        $this->layout();
    }

    public function install(){

        $plugin = $this->isP('name', '请提交您要安装的主题');
        $enName = $this->isP('enname', '请提交主题的名称');

        (new \Expand\Install('2', THEME.'/Form/'))->downloadPlugin($plugin);

        $this->success('主题安装完毕', $this->url('Ticket-Theme-index'));

    }


}