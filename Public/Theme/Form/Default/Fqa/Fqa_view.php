<div class="am-g">
    <div class="am-u-sm-12 am-u-lg-11 am-u-sm-centered">
        <div class="am-panel am-panel-default">
            <div class="am-panel-bd ">
                <article class="am-article">
                    <div class="am-article-hd am-margin-bottom">
                        <h1 class="am-article-title"><?= $fqa_title; ?></h1>
                        <div class="am-article-meta am-padding-0">
                            <ol class="am-breadcrumb am-breadcrumb-slash am-inline">
                                <li><a href="/">首页</a></li>
                                <li><a href="<?= $label->url('Form-Fqa-list') ?>">常见问题</a></li>
                                <li class="am-active"><?= "{$ticketModel['category_name']} - {$ticketModel['ticket_model_name']}" ?></li>
                            </ol>
                            <time class="date" datetime="<?= date('Y-m-d H:i', $fqa_createtime); ?>"
                                  title="<?= date('Y年m月d日 H:i', $fqa_createtime); ?>">
                                <?= date('Y年m月d日 H:i', $fqa_createtime); ?></time>
                        </div>
                    </div>

                    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

                    <div class="am-article-bd">
                        <?= htmlspecialchars_decode($fqa_content); ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>