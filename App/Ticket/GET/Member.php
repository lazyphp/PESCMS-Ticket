<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2019 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


namespace App\Ticket\GET;

class Member extends Content {

    public function index($display = true) {
        switch ($_GET['sortby']){
            case '1':
                $this->sortBy = 'CONVERT( member_name USING gbk ) ASC';
                break;
            case '2':
                $this->sortBy = 'CONVERT( member_name USING gbk ) DESC';
                break;
        }

        parent::index($display);
    }

}