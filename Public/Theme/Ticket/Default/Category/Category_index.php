<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<div class="am-g am-margin-bottom-xs am-g-collapse">
    <div class="am-u-sm-12 am-u-md-6 am-padding-top-xs">
        <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
                <?php ?>
                <?php $addUrl = empty($addUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $addUrl ?>
                <a href="<?= $addUrl ?>" class="am-btn am-btn-default am-radius"><span class="am-icon-plus"></span> 新增</a>

                <?php if($system['indexStyle'] == 1): ?>
                    <a href="<?= $label->url('Form-Category-index', ['new_index' => 1, 'method' => 'GET', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="am-btn am-btn-secondary am-radius ajax-click" style="margin-left: .2rem" data-am-popover="{content: '您开启了首页工单样式，点击我进行更新', trigger: 'hover focus'}">
                        <span class="am-icon-refresh"></span> 更新首页工单样式
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>


    <div class="am-u-sm-12 am-u-md-3">
        <form>
            <div class="am-input-group am-input-group-sm">
                <input type="hidden" name="g" value="<?= GROUP; ?>"/>
                <input type="hidden" name="m" value="<?= MODULE ?>"/>
                <input type="hidden" name="a" value="<?= ACTION ?>"/>
                <input type="text" name="keyword" value="<?= $label->xss($_GET['keyword']) ?>" class="am-form-field am-radius">
                <span class="am-input-group-btn">
                        <input class="am-btn am-btn-default am-radius" type="submit" value="搜索"/>
                    </span>
            </div>
        </form>
    </div>
</div>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />

<form class="am-form ajax-submit" action="<?= $label->url( GROUP . '-' . MODULE . '-listsort' ); ?>" method="POST">
	<input type="hidden" name="method" value="PUT"/>
	<table class="am-table am-table-bordered am-table-striped am-table-hover">
        <?php if(empty($list)): ?>
        <tr>
            <td class="am-text-center">您还没创建分类噢。</td>
        </tr>
        <?php else: ?>
		<tr>
			<th class="table-sort">排序</th>
			<th class="table-id">ID</th>
			<th class="table-title">名称</th>
			<th class="table-title">状态</th>
			<th class="table-set">操作</th>
		</tr>
		<?php foreach($list as $key => $value): ?>
			<tr>
				<td class="am-text-middle">
                    <input type="text" name="id[<?= $value['category_id']; ?>]"
                           value="<?= $value['category_listsort']; ?>">
                </td>
				<td class="am-text-middle"><?= $value['category_id'] ?></td>
				<td class="am-text-middle"><?= $value['space'].$value['guide'].$value['category_name'] ?></td>
                <td class="am-text-middle">
                    <?= $label->getFieldOptionToMatch(187, $value['category_status']); ?>
                </td>
				<td class="am-text-middle">
                    <a class="am-text-secondary" href="<?= $label->url(GROUP . '-' . MODULE . '-action', ['id' => $value["category_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>

                    <i class="am-margin-left-xs am-margin-right-xs">|</i>
                    <a class="am-text-warning" href="<?= $label->url('Category-index', ['id' => $value["{$fieldPrefix}id"]]) ?>" target="_blank" ><span class="am-icon-external-link"></span> 预览</a>

                    <i class="am-margin-left-xs am-margin-right-xs">|</i>
                    <a class="am-text-danger ajax-click ajax-dialog"  msg="确定删除吗？将无法恢复的！" href="<?= $label->url(GROUP . '-' . MODULE . '-action', ['id' => $value["category_id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>"><span class="am-icon-trash-o"></span> 删除</a>
                </td>
			</tr>
		<?php endforeach; ?>
        <?php endif; ?>
	</table>
    <div class="am-margin-top">
        <button type="submit" class="am-btn am-btn-primary am-btn-xs">排序</button>
    </div>
</form>

<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
