<?php
/**
 * Copyright (c) 2020 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


namespace Slice\Ticket\HandleForm;

class HandleBulletin extends \Core\Slice\Slice {

    public function before() {
        if(in_array(METHOD, ['POST', 'PUT'])){
            $_POST['group_id'] = ','.implode(',', $_POST['group_id']).',';
        }
    }

    public function after() {

    }


}