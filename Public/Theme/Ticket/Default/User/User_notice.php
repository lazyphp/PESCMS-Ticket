<div class="admin-content am-padding-xs am-padding-top-0 am-padding-bottom-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">

            <ul class="am-nav am-nav-tabs">
                <li class="<?= empty($_GET['type']) ? 'am-active' : '' ?>"><a href="<?= $label->url('Ticket-User-notice') ?>">所有消息</a></li>
                <?php foreach($type as $name => $value): ?>
                    <li class="<?= $_GET['type'] == $value ? 'am-active' : '' ?>"><a href="<?= $label->url('Ticket-User-notice', ['type' => $label->xss($value)]) ?>"><?= $name ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php if (empty($list)): ?>
                <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center">
                    <p class="am-margin-0">暂无公告</p>
                </div>

            <?php else: ?>
                <ul class="am-list">
                    <?php foreach ($list as $key => $value): ?>
                        <li class="am-padding-top-xs am-padding-bottom-xs">
                            <?= $typeName[$value['csnotice_type']] ?> : <a href="<?= $label->url('Ticket-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>">《<?= $value['ticket_title'] ?>》</a> <?= date('Y-m-d', $value['csnotice_time']) ?>
                        </li>
                    <?php endforeach; ?>

                </ul>

                <ul class="am-pagination am-pagination-right am-text-sm am-margin-0">
                    <?= $page; ?>
                </ul>
            <?php endif; ?>

        </div>
    </div>
</div>