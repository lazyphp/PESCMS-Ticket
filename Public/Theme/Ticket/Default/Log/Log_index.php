<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<?php if (empty($path)): ?>
    <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center">
        <p class="am-margin-0">暂时没有错误日志生成 :-(</p>
    </div>
<?php else: ?>

    <ul class="am-list admin-sidebar-list" id="collapase-nav-1">

        <?php foreach ($path as $date => $item): ?>
            <li class="am-panel">
                <a data-am-collapse="{parent: '#collapase-nav-1', target: '#<?= $date ?>'}">
                    <i class="am-icon-folder"></i> <?= $date ?>
                    <i class="am-icon-angle-right am-fr am-margin-right"></i>
                </a>
                <?php if (!empty($item)): ?>

                    <ul class="am-list am-collapse admin-sidebar-sub" id="<?= $date ?>">
                        <?php foreach ($item as $logName => $log): ?>
                            <li>
                                <a href="<?= $label->url(GROUP . '-Log-view', ['file' => $log, 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="am-margin-left-xl am-link-muted"><i class="am-icon-file"></i> <?= $logName ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

            </li>
        <?php endforeach; ?>

    </ul>
<?php endif; ?>


<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
