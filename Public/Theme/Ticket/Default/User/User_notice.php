<div class="admin-content am-padding-xs am-padding-top-0 am-padding-bottom-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">

            <ul class="am-nav am-nav-tabs">
                <li class="<?= empty($_GET['type']) ? 'am-active' : '' ?>"><a
                            href="<?= $label->url('Ticket-User-notice') ?>">所有消息</a></li>
                <?php foreach ($type as $name => $value): ?>
                    <li class="<?= $_GET['type'] == $value ? 'am-active' : '' ?>"><a
                                href="<?= $label->url('Ticket-User-notice', ['type' => $label->xss($value)]) ?>"><?= $name ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if (empty($list)): ?>
                <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center">
                    <p class="am-margin-0">暂无未读的消息</p>
                </div>

            <?php else: ?>
                <div>
                    <?php foreach ($list as $key => $value): ?>
                        <div class="am-block am-margin-top">

                            <?=
                                sprintf('在 %s 有 <span class="am-badge am-badge-%s am-radius">%s</span> ：<a href="%s">《%s》</a>。请您尽快处理。',
                                date('m-d H:i', $value['csnotice_time']),
                                $value['csnotice_type'],
                                $typeName[$value['csnotice_type']],
                                $label->url('Ticket-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]),
                                $value['ticket_title'])
                            ?>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<script>
    $(function () {
        $(['1', '3', '4', '504']).each(function (key, value) {
            var className = '';
            switch (value) {
                case '1':
                    className = 'am-badge-warning'
                    break;
                case '3':
                    className = 'am-badge-primary'
                    break;
                case '4':
                    className = 'am-badge-success'
                    break;
                case '504':
                    className = 'am-badge-danger'
                    break;
            }

            $('.am-badge-'+value).addClass(className);

        })
    })
</script>