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

namespace App\Ticket\GET;

class Setting extends \App\Ticket\Common{


    public function action(){
        $option = [];
        foreach(\Model\Content::listContent(['table' => 'option']) as $key => $value){
            if(is_array(json_decode($value['value'], true)) || $value['option_name'] == 'crossdomain' ){
                $option[$value['option_name']] = json_decode($value['value'], true);
            }else{
                $option[$value['option_name']] = $value;
            }
        }
        $this->assign($option);
        $this->assign('title', '系统设置');
        $this->layout();
    }

}