<div class="am-g">
    <!--    logo-->
    <div class="am-text-center index-logo am-margin-bottom">
        <img src="<?= $system['siteLogo'] ?>" width="180"/>
    </div>

    <div class="am-u-sm-12 am-u-sm-centered am-u-lg-8 index-search">
        <form action="<?= $label->url('View-ticket') ?>" method="GET" data-am-validator>
            <input type="hidden" name="m" value="View"/>
            <input type="hidden" name="a" value="ticket">

            <input type="text" name="number" class="am-form-field " required placeholder="<?= $label->xss($indexSetting['search_placeholder']) ?>">

            <button class="am-btn am-btn-default pes-search-button am-radius" type="submit">
                <i class="am-icon-search"></i>
                搜索
            </button>
        </form>
    </div>

    <?php if (!empty($indexSetting['hot_key'])): ?>
        <div class="am-u-sm-12 am-u-sm-centered am-u-lg-8 ">
            <div class="hot-search ">
                <span class="am-margin-top-xs">热门搜索：</span>
                <?php foreach(explode(';', $indexSetting['hot_key']) as $key => $value): ?>
                <?php if(strlen($value) == 0){ continue; }?>
                <div class="am-margin-right am-margin-top-xs"><a href="<?= $label->url('Form-Fqa-list', ['keyword' => $label->xss($value)]) ?>"><?= $value ?></a></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>


    <?php require_once __DIR__ . '/Index_fqa.php' ?>

</div>