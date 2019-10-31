<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<div class="am-g am-margin-bottom-xs am-g-collapse">
    <div class="am-u-sm-12 am-u-md-6 am-padding-top-xs">
        <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
                <a href="<?= $addUrl ?>" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</a>
                <a class="am-btn am-btn-warning" href="<?= $label->url('Ticket-Ticket_model-action', array('id' => $label->xss($_GET['number']))); ?>" target="_blank"><span class="am-icon-edit"></span> 编辑</a>
                <a class="am-btn am-btn-primary" href="<?= $label->url('Category-ticket', array('number' => $label->xss($_GET['number']))); ?>" target="_blank"><span class="am-icon-pencil-square-o"></span> 预览工单</a>

            </div>
        </div>
    </div>
</div>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />

<?php if (empty($list)): ?>
    <div class="am-alert am-alert-secondary am-margin-top am-margin-bottom am-text-center" data-am-alert>
        <p>本页面没有数据 :-(</p>
    </div>
<?php else: ?>
    <form class="am-form ajax-submit" action="<?= $label->url(GROUP . '-' . MODULE . '-listsort'); ?>" method="POST">
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
                        $param = ['id' => $value["{$fieldPrefix}id"], 'number' => $_GET['number'], 'cid' => $_GET['cid'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])];

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
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-lg-6">
                <button type="submit" class="am-btn am-btn-primary am-btn-sm">排序</button>
            </div>
            <div class="am-u-sm-12 am-u-lg-6">
                <ul class="am-pagination am-pagination-right am-text-sm am-margin-0">
                    <?= $page; ?>
                </ul>
            </div>
        </div>

        <div>

        </div>
    </form>
<?php endif; ?>

<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
