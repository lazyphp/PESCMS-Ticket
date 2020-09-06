<?php
/**
 *
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\API\GET;

use Model\Content;

class Index extends \Core\Controller\Controller {

    public function index(){

        $result = \Model\Category::getCategoryORTicketList();
        if(empty($result)){
            $this->error('获取工单列表失败');
        }else{
            $this->success(['msg' => '获取工单列表完成', 'data' => $result]);
        }
    }

}