<?php

namespace App\Ticket\GET;

class Category extends Content {

    public function index($display = true){
        $this->assign('list', \Model\Category::recursion());
		$this->layout();
    }

    public function action($display = false) {
        parent::action($display);

        $this->assign('select', \Model\Category::recursion(true));
        $this->layout();
    }

}