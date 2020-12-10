<div class="admin-content am-padding-xs am-padding-top-0 am-padding-bottom-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
            <?php if (empty($list)): ?>
                <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center">
                    <p class="am-margin-0">暂无公告</p>
                </div>

            <?php else: ?>
                <ul class="am-list">
                    <?php foreach ($list as $key => $value): ?>
                        <li>
                            <a href="<?= $label->url('Ticket-Bulletin-view', ['id' => $value['bulletin_id'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>"><?= $value['bulletin_title'] ?>
                                <small> <?= date('Y-m-d', $value['bulletin_createtime']) ?></small>
                            </a>
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
