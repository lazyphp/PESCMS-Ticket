<?php
/**
 * Copyright (c) 2024 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Slice\Form;

/**
 * 输出主题设置
 */
class ThemeSetting extends \Core\Slice\Slice {
    public function before() {
        $indexSetting = \Model\Theme::getThemeIndexSetting();
        $this->assign('indexSetting', $indexSetting);
    }

    public function after() {
        // TODO: Implement after() method.
    }

}