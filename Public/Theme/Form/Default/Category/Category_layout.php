<?php include THEME_PATH . '/header.php'; ?>
<?php include  THEME_PATH .'/Topbar.php'; ?>
<div id="wrapper" class="am-text-sm">
	<div class="am-g">
		<div class="am-u-sm-12 am-u-sm-centered">
			<div class="am-panel am-panel-default">
				<div class="am-panel-bd">
					<ol class="am-breadcrumb am-text-default am-margin-bottom-0 categort-breadcrumb">
						<li class="am-active">
							<a href="<?= $label->url('Category-index') ?>"><span class="am-badge am-badge-primary am-round am-text-default">1</span> 选择问题类型</a>
						</li>
						<li class="<?= empty($category) ? 'am-active' : '' ?>">
							<a href="<?= empty($_GET['back_url']) ? 'javascript:;' : base64_decode($_GET['back_url']) ?>"><span class="am-badge am-badge-primary am-round am-text-default">2</span> 选择对应工单</a>
						</li>
						<li class="<?= ACTION != 'index' ? 'am-active' : '' ?>" >
							<a href="javascript:;"><span class="am-badge am-badge-primary am-round am-text-default">3</span> 创建工单</a>
						</li>
					</ol>
					<?php include $file; ?>
				</div>
			</div>

            <?php require 'Ticket_fqa.php'?>

		</div>
	</div>
</div>
<?php include THEME_PATH . '/footer.php'; ?>
