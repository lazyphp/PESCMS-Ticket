<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<?php include THEME_PATH . "/Content/Content_index_tool.php"; ?>

<form class="am-form ajax-submit" action="<?= $label->url( GROUP . '-' . MODULE . '-listsort' ); ?>" method="POST">
	<input type="hidden" name="method" value="PUT"/>
	<table class="am-table am-table-bordered am-table-striped am-table-hover">
		<tr>
			<th class="table-sort">排序</th>
			<th class="table-id">ID</th>
			<th class="table-title">名称</th>
			<th class="table-set">操作</th>
		</tr>
		<?php foreach($list as $key => $value): ?>
			<tr>
				<td>
                    <input type="text" name="id[<?= $value['category_id']; ?>]"
                           value="<?= $value['category_listsort']; ?>">
                </td>
				<td><?= $value['category_id'] ?></td>
				<td><?= $value['space'].$value['guide'].$value['category_name'] ?></td>
				<td>
                    <a class="am-text-secondary" href="<?= $label->url(GROUP . '-' . MODULE . '-action', ['id' => $value["category_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                    <i class="am-margin-left-xs am-margin-right-xs">|</i>
                    <a class="am-text-danger ajax-click ajax-dialog"  msg="确定删除吗？将无法恢复的！" href="<?= $label->url(GROUP . '-' . MODULE . '-action', ['id' => $value["category_id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>"><span class="am-icon-trash-o"></span> 删除</a>
                </td>
			</tr>
		<?php endforeach; ?>
	</table>
    <div class="am-margin-top">
        <button type="submit" class="am-btn am-btn-primary am-btn-xs">排序</button>
    </div>
</form>

<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
