<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<?php include THEME_PATH . "/Content/Content_index_tool.php"; ?>

<?php if (empty($list)): ?>
    <div class="am-alert am-alert-secondary am-margin-top am-margin-bottom am-text-center" data-am-alert>
        <p>本页面没有数据 :-(</p>
    </div>
<?php else: ?>
    <form class="am-form" action="<?= $label->url(GROUP . '-' . MODULE . '-listsort'); ?>" method="POST">
        <input type="hidden" name="method" value="PUT"/>
        <table class="am-table am-table-bordered am-table-striped am-table-hover am-text-sm">
            <tr>
                <th class="table-sort">排序</th>
                <th class="table-set">ID</th>
                <?php foreach ($field as $value) : ?>
                    <?php if ($value['field_name'] == 'status'): ?>
                        <?php $class = 'table-set'; ?>
                    <?php else: ?>
                        <?php $class = 'table-title'; ?>
                    <?php endif; ?>
                    <th class="<?= $class ?>"><?= $value['field_display_name']; ?></th>
                <?php endforeach; ?>
                <th class="table-set">操作</th>
            </tr>
            <?php foreach ($list as $key => $value) : ?>
                <tr>
                    <td class="am-text-middle">
                        <input type="text" class="am-input-sm" name="id[<?= $value["{$fieldPrefix}id"]; ?>]"
                               value="<?= $value["{$fieldPrefix}listsort"]; ?>">
                    </td>
                    <td class="am-text-middle"><?= $value["{$fieldPrefix}id"]; ?></td>
                    <?php foreach ($field as $fv) : ?>
                        <td class="am-text-middle">
                            <?php if ($fv['field_type'] == 'date'): ?>
                                <?= date('Y-m-d H:i', $value[$fieldPrefix . $fv['field_name']]); ?>
                            <?php elseif (in_array($fv['field_type'], array('radio', 'checkbox', 'select'))): ?>
                                <?php if ($fv['field_name'] == 'type'): ?>
                                    <?= array_search($value[$fieldPrefix . $fv['field_name']], $formType); ?>
                                <?php elseif ($fv['field_name'] == 'verify'): ?>
                                    <?= array_search($value[$fieldPrefix . $fv['field_name']], $checkType); ?>
                                <?php else: ?>
                                    <?= $label->getFieldOptionToMatch($fv['field_id'], $value[$fieldPrefix . $fv['field_name']]); ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?= $value[$fieldPrefix . $fv['field_name']]; ?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>


                    <td class="am-text-middle">
                        <?php
                        //设置按钮地址
                        $param = ['id' => $value["{$fieldPrefix}id"], 'number' => $_GET['number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])];

                        $editUrl = $label->url(GROUP . '-' . MODULE . '-action', $param);

                        $param['method'] = 'DELETE';
                        $deleteUrl = $label->url(GROUP . '-' . MODULE . '-action', $param);
                        ?>
                        <?php $operate = empty($operate) ? '/Content/Content_index_operate.php' : $operate; ?>
                        <?php include THEME_PATH . $operate; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <ul class="am-pagination am-pagination-right am-text-sm">
            <?= $page; ?>
        </ul>
        <?php if ($listsort): ?>
            <div class="am-margin">
                <button type="submit" class="am-btn am-btn-primary am-btn-xs">排序</button>
            </div>
        <?php endif; ?>
    </form>
<?php endif; ?>

<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
