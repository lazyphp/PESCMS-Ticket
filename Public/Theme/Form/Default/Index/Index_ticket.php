<?php if ($indexSetting['index_type'] != 0): ?>
    <div class="am-u-sm-12 am-u-sm-centered am-u-lg-8 am-u-lg-centered index-ticket-service">
        <h2 class="am-text-center index-ticket-service-title">工单服务</h2>
        <ul class="am-avg-sm-2 am-avg-lg-4 am-thumbnails">
            <?php foreach ($listType as $item): ?>
                <li>
                    <div class="am-panel am-panel-default">
                        <div class="am-panel-bd">
                            <?php $catUrl = $label->url('Form-Category-index', ['id' => $item['id']]); ?>
                            <a href="<?= !empty($item['number']) ? $label->url('Form-Category-ticket', ['id' => $item['id'], 'number' => $item['number'], 'back_url' => base64_encode($catUrl)]) : $catUrl ?>">
                                <?php if ($item['img']): ?>
                                    <img src="<?= $item['img'] ?>" alt="<?= $item['name'] ?>">
                                <?php else: ?>
                                    <i class="am-icon-book am-primary am-icon-sm"></i>
                                <?php endif; ?>
                                <span class="am-text-middle"><?= $item['name'] ?></span>
                            </a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>