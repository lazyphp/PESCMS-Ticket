<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">

            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg">更新执行结果</strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <div class="pes-alert pes-alert-info">
                <?php if (!empty($info)): ?>
                    <?php foreach ($info as $value): ?>
                        <p><?= $value ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>更新成功</p>
                    <p>注：更新程序不会设置用户组的显示菜单和权限，请自行到用户组列表更新缺少的菜单和权限。</p>
                <?php endif; ?>

            </div>
        </div>

        <hr/>


        <?php if (!empty($detail)): ?>
            <div class="am-padding-sm">
                <?php foreach ($detail as $key => $item): ?>
                    <div class="am-panel am-panel-default">
                        <div class="am-panel-hd"><strong><?= $key ?>更新说明</strong></div>
                        <div class="am-panel-bd">
                            <?= htmlspecialchars_decode($item['content']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


    </div>
</div>