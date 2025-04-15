<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<?php include $tool_column; ?>

<div class="am-margin-bottom">
    <i class="am-icon-question-circle"></i>
    常见问题：<a href="https://document.pescms.com/article/3/296557456849371136.html" target="_blank" class="am-text-warning">1.工单404或者工单没有显示</a>
    2.本列表按照工单分类ID大小升序并合并汇总展示
</div>

<?php if (empty($list)): ?>
    <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center nothing-ticketModel">
        <p class="am-margin-0">当前系统还没有创建工单模型，客户无法向您正常反馈问题。</p>

        <p class="am-margin-top-xs am-text-danger">点击查看
            <a href="https://document.pescms.com/article/3/268655938838200320.html" target="_blank">《<i class="am-icon-book"></i>工单模型》</a>教程文档
        </p>
    </div>
<?php else: ?>
    <form class="am-form ajax-submit" action="<?= $label->url(GROUP . '-' . MODULE . '-listsort'); ?>" method="POST">
        <?= $label->token() ?>
        <input type="hidden" name="method" value="PUT"/>


        <?php foreach ($list as $cid => $item): ?>
            <div class="ticket-model-panel">
                <div class="ticket-model-cate">
                    <?= \Model\Content::findContent('category', $cid, 'category_id', 'category_name')['category_name'] ?>
                </div>

                <table class="am-table am-table-striped am-table-bordered ticket_model_table">
                    <?php foreach ($item as $key => $value): ?>
                        <tr>

                            <td class="am-text-middle ticket_model_base">
                                <div>
                                    <strong><?= $value['ticket_model_name'] ?></strong>
                                    <span>#<?= $value['ticket_model_number'] ?></span>
                                    <?php require __DIR__ . '/Ticket_model_index_button.php' ?>
                                </div>
                                <div>
                                    <?= $field['main']['211']['field_display_name'] ?>
                                    : <?= $label->getFieldOptionToMatch(211, $value['ticket_model_group_id']); ?>
                                </div>
                                <div>
                                    <?= $field['main']['240']['field_display_name'] ?>
                                    : <?= $label->getFieldOptionToMatch(240, $value['ticket_model_contact']); ?>
                                </div>
                            </td>
                            <?php foreach ($field['other'] as $item) : ?>
                                <td class="am-text-middle ticket_model_setting am-hide-md-down">
                                    <?php foreach ($item as $fv): ?>
                                        <div>
                                            <span><?= $fv['field_display_name'] ?></span>
                                            <span><?= $label->valueTheme($fv, $fieldPrefix, $value); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                            <?php endforeach; ?>
                            <td class="am-text-middle ticket_model_operate am-hide-md-down">
                                <?php /* 若要实现自定义的操作按钮，请更改本变量 */ ?>
                                <?php $operate = empty($operate) ? '/Content/Content_index_operate.php' : $operate; ?>
                                <?php include THEME_PATH . $operate; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endforeach; ?>

    </form>
<?php endif; ?>
<style>
    .test {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

</style>
<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
<?php include __DIR__ . '/Ticket_model_index_driver.php' ?>

