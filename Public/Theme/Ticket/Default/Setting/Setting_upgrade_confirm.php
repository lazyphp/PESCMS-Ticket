<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">

            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-warning am-text-lg"><i class="am-icon-warning"></i> 本次更新需要二次确认</strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <div>
                <a href="<?= $continueUrl ?>" class="am-btn am-btn-success am-btn-sm"><i class="am-icon-check-square-o"></i> 我已确认更新内容， 且已备份好程序和数据库</a>
                <span class="am-text-middle">← [点击按钮程序将继续执行自动更新]</span>
            </div>
        </div>

        <hr/>

        <?php if (!empty($detail)): ?>
            <div class="am-padding-sm">
                <div class="am-panel am-panel-default">
                    <div class="am-panel-hd"><strong><?= $version ?>更新说明</strong></div>
                    <div class="am-panel-bd">
                        <?= htmlspecialchars_decode($detail) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>


    </div>
</div>