<div class="am-g">
	<div class="am-u-sm-12 am-u-sm-centered">
		<div class="am-panel am-panel-default">
			<div class="am-panel-bd">
				<ol class="am-breadcrumb am-text-default am-margin-bottom-0 categort-breadcrumb">
					<li class="am-active">
						<a href="<?= $label->url('Category-index') ?>"><span class="am-badge am-badge-primary am-round am-text-default">1</span> 选择问题类型</a>
					</li>
					<li>
						<a href="#"><span class="am-badge am-badge-primary am-round am-text-default">2</span> 选择对应工单</a>
					</li>
					<li >
						<a href="#"><span class="am-badge am-badge-primary am-round am-text-default">3</span> 创建工单</a>
					</li>
				</ol>
				<hr class="am-margin-top-0" />
				<ul class="am-avg-sm-4 am-thumbnails">
					<?php foreach($topCategory as $item ): ?>
						<li >
							<a href="" class="ticket-category">
								<h4 class="am-margin-bottom-xs"><?= $item['category_name'] ?></h4>
								<p class="am-margin-top-0"><?= $item['category_description'] ?></p>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>