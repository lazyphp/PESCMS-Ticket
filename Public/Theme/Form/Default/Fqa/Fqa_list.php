<div class="am-g">
    <div class="am-u-sm-12 am-u-lg-11 am-u-sm-centered">
        <div class="am-panel am-panel-default fqa-item">
            <div class="am-container fqa-search">
                <h1 class="am-text-center am-text-xxxl"><?= $title ?></h1>
                <form>
                    <input type="hidden" name="g" value="<?= GROUP ?>">
                    <input type="hidden" name="m" value="<?= MODULE ?>">
                    <input type="hidden" name="a" value="<?= ACTION ?>">
                    <div class="am-input-group">
                        <input type="text" class="am-form-field" name="keyword" value="<?= $label->xss($_GET['keyword'] ?? '') ?>">
                        <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default" type="submit"><span class="am-icon-search"></span> </button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="am-panel-bd ">
                <?php if (empty($list)): ?>
                    <p class="am-text-center">暂无常见问题总结</p>
                <?php else: ?>
                    <?php if (!empty($_GET['keyword'])): ?>
                        <?php foreach ($list as $item): ?>
                            <div class="fqa-search-result">
                                <h2>
                                    <a href="<?= $item['fqa_url'] ?>" >
                                        <?= $item['fqa_title'] ?>
                                    </a>
                                </h2>
                                <div class="fqa-search-result-desc">
                                    <a href="<?= $item['fqa_url'] ?>">
                                        <?= $label->strCut(strip_tags(htmlspecialchars_decode($item['fqa_content'])), 500) ?>
                                    </a>
                                </div>
                                <div class="fqa-search-result-tool am-margin-top">
                                    <i class="am-icon-book"></i>
                                    <?= $category[$item['ticket_model_cid']]['category_name'] ?> - <?= $item['ticket_model_name'] ?>
                                    / <i class="am-icon-calendar"></i>
                                    <?= date('Y-m-d H:i', $item['fqa_createtime']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($list as $cid => $ticketModel): ?>
                            <h2 class="am-text-xl">[<?= $category[$cid]['category_name'] ?>]</h2>
                            <?php if (!empty($ticketModel)): ?>
                                <?php foreach ($ticketModel as $item): ?>
                                    <h3 class="am-text-l">
                                        <i class="am-icon-folder-open"></i> <?= $item['ticket_model_name'] ?>
                                        (<?= count($item['list']) ?>)</h3>
                                    <ul class="fqa-ul am-avg-sm-1 am-avg-lg-4">
                                        <?php foreach ($item['list'] as $key => $value): ?>
                                            <li><a href="<?= $value['fqa_url'] ?>"><?= $value['fqa_title'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>