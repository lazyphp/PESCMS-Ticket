<table class="am-table  am-table-striped am-table-hover am-text-sm">
    <?php foreach ($list as $key => $value): ?>
        <tr>
            <td class="">
                <div class="admin-task-meta">
                    <?php if($value['ticket_close'] == 1): ?>
                        <span class="am-badge">已关闭</span>
                    <?php elseif($value['ticket_exclusive'] == 1 && $value['user_id'] == self::session()->get('ticket')['user_id']  ): ?>
                        <span class="am-badge gold-badge">专属工单</span>
                    <?php endif; ?>
                    <span class="am-badge" style="background-color: <?= $ticketStatus[$value['ticket_status']]['color']; ?>"><?= $ticketStatus[$value['ticket_status']]['name']; ?></span>
                    [<?= $category[$value['ticket_model_cid']]['category_name'] ?> - <?= $value['ticket_model_name'] ?>]
                    <?= $value['ticket_number'] ?>
                    <i class="am-margin-left-xs am-margin-right-xs">|</i>
                    <?php if($value['member_id'] == -1 ): ?>
                        匿名用户
                    <?php else: ?>
                        <a href="<?= $label->url('Ticket-Ticket-'.ACTION, ['member' => $value['member_id']]) ?>"><?= $member[$value['member_id']]['member_name'] ?></a>
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
            </td>
            <td class="am-show-lg-only am-text-right am-text-bottom ">
                <?php if(!empty($value['ticket_remark'])): ?>
                    <div class="am-text-warning">
                        备注: <?= $label->strCut($value['ticket_remark'], '44', '') ?>
                    </div>
                <?php endif; ?>
                <div class="admin-task-bd">
                    <a class="am-link-muted print-ticket" href="<?= $label->url('View-printer', array('number' => $value["ticket_number"])); ?>"><span class="am-icon-print"></span></a>

                    <span>
                                        耗时: <?= empty($value['ticket_run_time']) ? '未处理' : $label->timing($value['ticket_run_time']); ?>
                                    </span>
                    <i class="am-margin-left-xs am-margin-right-xs">|</i>
                    <span>
                                        责任人: <?= $value['user_id'] > 0 ? $value['user_name'] : '<span class="am-text-danger">暂无</span>'; ?>
                                </span>
                    <i class="am-margin-left-xs am-margin-right-xs">|</i>

                    <a href="<?= $label->url('Ticket-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"
                       class="am-text-primary">处理</a>
                    <i class="am-margin-left-xs am-margin-right-xs">|</i>

                    <?php if ($value['ticket_close'] == '0' && $value['ticket_status'] < 3): ?>
                        <a href="<?= $label->url('Ticket-Ticket-close', ['number' => $value['ticket_number'], 'method' => 'POST', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" class="am-text-danger ajax-click ajax-dialog" msg="确定要关闭本工单吗？">关闭工单</a>
                    <?php else: ?>
                        <a href="javascript:;" class="am-text-warning"><?= $value['ticket_status'] == '3' ? '已结束' : '已关闭' ?></a>

                    <?php endif; ?>
                    <?php if($label->checkAuth(GROUP . 'DELETETicketaction') === true): ?>
                        <i class="am-margin-left-xs am-margin-right-xs">|</i>
                        <a class="am-text-danger ajax-click ajax-dialog"  msg="确定删除吗？将无法恢复的！" href="<?= $label->url(GROUP . '-' . MODULE . '-action', array('id' => $value["ticket_id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-trash-o"></span></a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>

    <?php endforeach; ?>
</table>