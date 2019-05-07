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

        $this->authorize();
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

    public function authorize(){
        $file = PES_CORE.'Core/LICENSE.pes';
        if(is_file($file)){
            $type = json_decode(file_get_contents($file), true);
            if(!empty($type['authorize_type'])){
                $this->assign('license', 1);
                $authorize_type = $type['authorize_type'] == 5 ? 0 : 1;
            }else{
                $authorize_type = 0;
            }
        }else{
            $authorize_type = 0;
        }
        $this->assign('authorize_type', $authorize_type);
    }


}