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

		$id = $this->g('id');
		$param['category_parent'] = empty($id) ? 0 : $id;

		$category = \Model\Content::listContent([
			'table' => 'category',
			'condition' => 'category_parent = :category_parent AND category_status = 1',
			'order' => 'category_listsort ASC, category_id DESC',
			'param' => $param
		]);

		if(!empty($id)){
			$ticketList = \Model\Content::listContent([
				'table' => 'ticket_model',
				'condition' => 'ticket_model_cid = :id AND ticket_model_status = 1',
				'order' => 'ticket_model_listsort ASC, ticket_model_id DESC',
				'param' => [
					'id' => $id
				]
			]);
			$this->assign('ticket', $ticketList);
		}

		$this->assign('category', $category);
		$this->layout('Category_index', 'Category_layout');
	}

	public function ticket(){
		$this->layout('Category_ticket', 'Category_layout');
	}

}