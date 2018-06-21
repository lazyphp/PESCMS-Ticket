<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */


namespace Slice\Common;

/**
 * 赋予全站的选项
 */
class Option extends \Core\Slice\Slice{

    public function before() {
        $list = \Model\Content::listContent([
            'table' => 'option',
            'condition' => "option_range = 'system'"
        ]);
        $system = [];
        foreach($list as $value){
            $system[$value['option_name']] = $value['value'];
        }

        $this->checkInterior($system['interior_ticket']);

        $this->assign('system', $system);
    }

    /**
     * 验证站内工单是否开启
     * @param $interior_ticket
     */
    private function checkInterior($interior_ticket){
        if(GROUP == 'Form' && MODULE == 'Category' && $interior_ticket == 0 ){
            $this->_404();
        }
    }

    public function after() {
        // TODO: Implement after() method.
    }


}