<table class="am-table  am-table-striped am-table-hover am-text-sm ticket-list-table">
    <?php foreach ($list as $key => $value): ?>
        <tr>
            <td class="">
                <div class="admin-task-meta">
                    <?php if ($value['ticket_close'] == 1): ?>
                        <span class="am-badge"><i class="am-icon-lock"></i> 已关闭</span>
                    <?php elseif ($value['ticket_exclusive'] == 1 && $value['user_id'] == self::session()->get('ticket')['user_id']): ?>
                        <span class="am-badge gold-badge">专属工单</span>
                    <?php endif; ?>
                    <?php if ( ($value['ticket_top'] == 1 && ACTION == 'myTicket')  || ($value['ticket_top_list'] == 1 && ACTION != 'myTicket')): ?>
                        <span class="am-badge"><i class="am-icon-thumb-tack"></i> 置顶</span>
                    <?php endif; ?>
                    
                    <span class="am-badge" style="background-color: <?= $ticketStatus[$value['ticket_status']]['color']; ?>"><?= $value['ticket_status'] == 3 ? '<i class="am-icon-check"></i> ' : '' ?><?= $ticketStatus[$value['ticket_status']]['name']; ?></span>
                    [<?= $category[$value['ticket_model_cid']]['category_name'] ?> - <?= $value['ticket_model_name'] ?>]
                    <?= $value['ticket_number'] ?>
                    <i class="am-margin-left-xs am-margin-right-xs">|</i>
                    <?php if ($value['member_id'] == -1): ?>
                        匿名用户
                    <?php else: ?>
                        <a href="<?= $label->url('Ticket-Ticket-' . ACTION, ['member' => $value['member_id']]) ?>"><?= $member[$value['member_id']]['member_name'] ?></a>
                    <?php endif; ?>

                    <span>
                                        发布于: <?= date('Y-m-d H:i', $value['ticket_submit_time']); ?>
                                    </span>
                </div>
                <div class="admin-task-bd <?= $label->ticketTimeOutTag($value) ?>">
                    <a href="<?= $label->url(GROUP . '-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>">
                        <span class="am-text-primary"><?= $value['ticket_read'] == '0' ? '[未读]' : ''; ?></span>
                        <?= $value['ticket_title'] ?>
                    </a>
                </div>
                <?php if (!empty($value['ticket_remark'])): ?>
                    <div class="am-text-gray am-show-sm-only am-text-xs">
                        <i>(备注: <?= $label->strCut($value['ticket_remark'], '44', '') ?>)</i>
                    </div>
                <?php endif; ?>
            </td>
            <td class="am-show-lg-only am-text-right am-text-bottom ">
                <?php if (!empty($value['ticket_remark'])): ?>
                    <div class="am-text-warning">
                        备注: <?= $label->strCut($value['ticket_remark'], '44', '') ?>
                    </div>
                <?php endif; ?>
                <?php require __DIR__.'/Ticket_index_operate.php'?>
            </td>
        </tr>

    <?php endforeach; ?>
</table>