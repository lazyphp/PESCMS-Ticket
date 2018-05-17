<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<?php include THEME_PATH . "/Content/Content_index_tool.php"; ?>

<form class="am-form ajax-submit" action="<?= $label->url( GROUP . '-' . MODULE . '-listsort' ); ?>" method="POST">
	<input type="hidden" name="method" value="PUT"/>
	<table class="am-table am-table-bordered am-table-striped am-table-hover am-text-default">
		<tr>
			<th class="table-sort">排序</th>
			<th class="table-id">ID</th>
			<th class="table-title">名称</th>
			<th class="table-set">操作</th>
		</tr>
		<?php foreach($list as $key => $value): ?>
			<tr>
				<td></td>
				<td><?= $value['category_id'] ?></td>
				<td><?= $value['space'].$value['end_icon'].$value['category_name'] ?></td>
				<td></td>
			</tr>
		<?php endforeach; ?>
	</table>
</form>

<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
