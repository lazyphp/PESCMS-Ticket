<?php if ($indexSetting['fqa'] == 1 && !empty($fqa) ): ?>
    <div class="am-u-sm-12 am-u-sm-centered am-u-lg-8 am-u-lg-centered pes-index-fqa">
        <h2 class="fqa-title am-text-center">常见问题</h2>
        <ul class="am-avg-sm-2 am-avg-lg-4 am-thumbnails">
            <?php foreach ($fqa as $name => $item): ?>
                <li>
                    <div class="am-panel am-panel-default">
                        <div class="am-panel-bd">
                            <h2><?= $name ?></h2>
                            <div class="subcard">
                                <?php if (!empty($item['list'])): ?>
                                    <?php foreach ($item['list'] as $key => $value): ?>
                                        <div><a href="<?= $value['fqa_url'] ?>" target="_blank"><?= $value['fqa_title'] ?></a></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>