<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<?php include $tool_column; ?>

<?php if (empty($list)): ?>
    <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center">
        <p class="am-margin-0">本页面没有数据 :-(</p>
    </div>
<?php else: ?>
    <form class="am-form ajax-submit" action="<?= $label->url(GROUP . '-' . MODULE . '-listsort'); ?>" method="POST">
        <input type="hidden" name="method" value="PUT"/>
        <?= $label->token() ?>
        <table class="am-table am-table-bordered am-table-striped am-table-hover am-text-sm">
            <tr>
                <th><input type="checkbox" class="checkbox-all"></th>
                <?php if (isset($listsort)): ?>
                    <th class="table-sort">排序</th>
                <?php endif; ?>
                <th class="table-set">ID</th>
                <?php foreach ($field as $value) : ?>
                    <?php if ($value['field_name'] == 'status'): ?>
                        <?php $class = 'table-set'; ?>
                    <?php else: ?>
                        <?php $class = 'table-title'; ?>
                    <?php endif; ?>
                    <th class="<?= $class ?>"><?= $value['field_display_name']; ?></th>

                    <?php if ($value['field_name'] == 'name'): ?>
                        <th>
                            绑定客户账号
                        </th>
                    <?php endif; ?>

                <?php endforeach; ?>
                <th class="table-set">操作</th>
            </tr>
            <?php foreach ($list as $key => $value) : ?>
                <tr>
                    <td class="am-text-middle">
                        <input type="checkbox" class="checkbox-all-children" name="id[<?= $value["{$fieldPrefix}id"]; ?>]" value="<?= $value["{$fieldPrefix}id"]; ?>">
                    </td>
                    <?php if (isset($listsort)): ?>
                        <td class="am-text-middle">
                            <input type="text" class="am-input-sm" name="id[<?= $value["{$fieldPrefix}id"]; ?>]"
                                   value="<?= $value["{$fieldPrefix}listsort"]; ?>">
                        </td>
                    <?php endif; ?>
                    <td class="am-text-middle"><?= $value["{$fieldPrefix}id"]; ?></td>
                    <?php foreach ($field as $fv) : ?>
                        <td class="am-text-middle">
                            <?= $label->valueTheme($fv, $fieldPrefix, $value); ?>
                        </td>
                        <?php if ($fv['field_name'] == 'name'): ?>
                            <td>
                                <div class="">
                                    <span class="am-margin-right-xs am-badge am-badge-warning am-radius">
                                        <?= $value['user_bind_mid'] == 0 ? '无绑定' : ($memberList[$value['user_bind_mid']]['member_name'] ?? '客户账号不存在') ?>
                                    </span>
                                    |
                                    <?php if ($value['user_bind_mid'] == 0): ?>
                                        <a href="<?= $label->url('Ticket-Member-bind', ['uid' => $value['user_id'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="am-text-success"><i class="am-icon-link"></i> 绑定</a>
                                    <?php else: ?>
                                        <a href="<?= $label->url('Ticket-Member-unbind', ['uid' => $value['user_id'], 'method' => 'PUT', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="am-text-warning ajax-click ajax-dialog" msg="确定要解除绑定吗？"><i class="am-icon-unlink"></i> 解绑</a>
                                    <?php endif; ?>

                                </div>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>


                    <td class="am-text-middle">
                        <?php /* 若要实现自定义的操作按钮，请更改本变量 */ ?>
                        <?php $operate = empty($operate) ? '/Content/Content_index_operate.php' : $operate; ?>
                        <?php include THEME_PATH . $operate; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-lg-6">
                <?php if (isset($listsort) && $label->checkAuth(GROUP . '-PUT-' . MODULE . '-listsort') === true): ?>
                    <button type="submit" class="am-btn am-btn-primary am-btn-xs am-radius">排序</button>
                <?php endif; ?>

                <?php if ($label->checkAuth(GROUP . '-DELETE-' . MODULE . '-action') === true): ?>
                    <button type="button" class="am-btn am-btn-danger am-btn-xs am-radius delete-batch" data="<?= $label->url(GROUP . '-' . MODULE . '-action', ['method' => 'DELETE']) ?>">
                        删除
                    </button>
                <?php endif; ?>
            </div>
            <div class="am-u-sm-12 am-u-lg-6">
                <ul class="am-pagination am-pagination-right am-text-sm am-margin-0">
                    <?= $page ?? ''; ?>
                </ul>
            </div>
        </div>
    </form>
<?php endif; ?>

<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
