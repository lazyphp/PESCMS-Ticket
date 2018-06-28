<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">

            <div class="am-cf">
                <div class="am-fl am-cf">
                    <a href="<?= $label->url(GROUP.'-Setting-action') ?>" class="am-margin-right-xs am-text-danger"><i class="am-icon-reply"></i>返回系统设置</a>
                    <strong class="am-text-primary am-text-lg">更新执行结果</strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <div class="am-alert am-alert-secondary" data-am-alert>
                <?php foreach ($info as $value): ?>
                    <p><?= $value ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>