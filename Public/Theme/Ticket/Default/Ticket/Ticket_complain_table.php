<table class="am-table  am-table-striped am-table-hover am-text-sm ticket-list-table">
    <?php foreach ($list as $key => $value): ?>
        <tr>
            <td class="">
                <div class="admin-task-meta">
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
                <div class="admin-task-bd">
                    <a href="<?= $label->url(GROUP . '-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>">
                        <?= $value['ticket_title'] ?>
                    </a>
                </div>
            </td>
            <td class="am-show-lg-only am-text-bottom am-text-right">
                                <span>
                                        耗时: <?= empty($value['ticket_run_time']) ? '未处理' : $label->timing($value['ticket_run_time']); ?>
                                    </span>
                <i class="am-margin-left-xs am-margin-right-xs">|</i>
                <span>
                                        责任人: <?= $value['user_id'] > 0 ? $value['user_name'] : '<span class="am-text-danger">暂无</span>'; ?>
                                </span>
                <i class="am-margin-left-xs am-margin-right-xs">|</i>

                <span>评分: <?= $value['ticket_score'] ?></span>
                <i class="am-margin-left-xs am-margin-right-xs">|</i>

                <span>
                                        是否解决: <?= $value['ticket_fix'] == 1 ? '是' : '<span class="am-text-danger">否</span>' ?>
                                </span>
                <i class="am-margin-left-xs am-margin-right-xs">|</i>

                <a href="<?= $label->url('Ticket-Ticket-complainDetail', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"
                   class="am-text-primary">查看</a>
            </td>
        </tr>

    <?php endforeach; ?>
</table>