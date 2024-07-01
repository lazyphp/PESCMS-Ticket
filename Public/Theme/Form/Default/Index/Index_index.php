<div class="am-g">
    <!--    logo-->
    <div class="am-text-center index-logo am-margin-bottom">
        <img src="<?= $system['siteLogo'] ?>" width="180"/>
    </div>

    <div class="am-u-sm-12 am-u-sm-centered am-u-lg-6 index-search">
        <form action="<?= $label->url('View-ticket') ?>" method="GET" data-am-validator>
            <input type="hidden" name="m" value="View"/>
            <input type="hidden" name="a" value="ticket">

            <input type="text" name="number" class="am-form-field " required placeholder="提交单号或者搜索问题解决方案">


            <?php if ($system['interior_ticket'] == 1): ?>
                <a href="<?= $label->url('Category-index') ?>" class="am-btn am-btn-primary am-radius pes-submit-ticket"><i class="am-icon-yelp"></i>
                    提交工单</a>
            <?php endif; ?>

            <button class="am-btn am-btn-default pes-search-button am-radius" type="submit"><i class="am-icon-search"></i>
                搜索
            </button>


        </form>
    </div>
</div>