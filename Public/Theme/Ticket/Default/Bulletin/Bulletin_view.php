<div class="admin-content am-padding-xs am-padding-top-0 am-padding-bottom-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <?php if (!empty($_GET['back_url'])): ?>
                        <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                                class="am-icon-reply"></i>返回</a>
                    <?php endif; ?>
                    <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
            <article class="am-article">

                <div class="am-article-hd">
                    <p class="am-article-meta"><?= date('Y-m-d', $bulletin_createtime) ?></p>
                </div>

                <div class="am-article-bd">
                   <?= htmlspecialchars_decode($bulletin_description) ?>
                </div>
            </article>
        </div>
    </div>
</div>
