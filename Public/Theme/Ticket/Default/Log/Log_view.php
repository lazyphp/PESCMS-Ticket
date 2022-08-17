<div class=" am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <?php if (!empty($_GET['back_url'])): ?>
                        <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                                    class="am-icon-reply"></i>返回</a>
                    <?php endif; ?>
                    <strong class="am-text-primary am-text-lg"><a href="<?= $label->url(GROUP . '-' . MODULE . '-' . ACTION); ?>"><?= $title; ?></a>
                    </strong>
                </div>
            </div>

            <?php if (empty($log)): ?>
                <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center">
                    <p class="am-margin-0">本日志文件好像打不开</p>
                </div>
            <?php else: ?>
                <pre><code><?= $log ?></code></pre>
            <?php endif; ?>


        </div>
    </div>
</div>