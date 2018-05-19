<?php
/**
 * PESCMS for PHP 5.6+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */

namespace App\Form\GET;

class Category extends \Core\Controller\Controller{

	public function index(){
		$topCategory = \Model\Content::listContent([
			'table' => 'category',
			'condition' => 'category_parent = 0 AND category_status = 1',
			'order' => 'category_listsort ASC, category_id DESC'
		]);

		$this->assign('topCategory', $topCategory);
		$this->layout();
	}

}