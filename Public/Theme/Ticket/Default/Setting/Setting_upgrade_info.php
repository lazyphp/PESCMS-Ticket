<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">

            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg">更新执行结果</strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <div class="am-alert am-alert-secondary" data-am-alert>
                <?php if(!empty($info)): ?>
                    <?php foreach ($info as $value): ?>
                        <p><?= $value ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p>更新成功</p>
                <p>注：更新程序不会设置用户组的显示菜单和权限，请自行到用户组列表更新缺少的菜单和权限。</p>
            </div>
        </div>
    </div>
</div>