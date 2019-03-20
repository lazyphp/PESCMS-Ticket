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

class Phrase extends Content {

    public function index($display = true) {
        $this->condition .= ' AND phrase_user_id = :user_id';
        $this->param['user_id'] = $this->session()->get('ticket')['user_id'];
        parent::index($display);
    }

}