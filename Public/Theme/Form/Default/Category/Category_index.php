<?php if(!empty($category)): ?>
	<hr class="am-margin-top-0" />
	<ul class="am-avg-sm-4 am-thumbnails">
		<?php foreach($category as $item ): ?>
			<li >
				<a href="<?= $label->url('Category-index', ['id' => $item['category_id'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="ticket-category">
					<h4 class="am-margin-bottom-xs"><?= $item['category_name'] ?></h4>
					<p class="am-margin-top-0"><?= $item['category_description'] ?></p>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif;?>
<?php if(!empty($ticket)): ?>
	<hr class="am-margin-top-0" />
	<?php if(!empty($category)): ?>
		<h4>可选择工单:</h4>
	<?php endif;?>
	<ul class="am-avg-sm-4 am-thumbnails">
		<?php foreach($ticket as $item ): ?>
			<li >
				<a href="<?= $label->url('Category-ticket', ['id' => $item['ticket_model_cid'], 'number' => $item['ticket_model_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="ticket-category ticket-list">
					<h4 class="am-margin-0"><?= $item['ticket_model_name'] ?></h4>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif;?>