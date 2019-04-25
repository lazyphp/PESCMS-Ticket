<div class="am-g">
    <!--    logo-->
    <div class="am-text-center index-logo am-margin-bottom">
        <img src="<?= $system['siteLogo'] ?>" width="180"/>
    </div>

    <div class="am-u-sm-12 am-u-sm-centered am-u-lg-6 index-search">
        <form action="<?= $label->url('View-ticket') ?>" method="GET" data-am-validator>
            <input type="hidden" name="m" value="View" />
            <input type="hidden" name="a" value="ticket">
            <div class="am-input-group">
                <input type="text" name="number" class="am-form-field " required placeholder="键入工单编号，了解进度">
            <span class="am-input-group-btn">
                <button class="am-btn am-btn-default" type="submit"><i class="am-icon-search"></i> 查询进度</button>
                <?php if($system['interior_ticket'] == 1): ?>
                <a href="<?= $label->url('Category-index') ?>" class="am-btn am-btn-warning"><i class="am-icon-yelp"></i> 提交工单</a>
                <?php endif; ?>
            </span>
            </div>
        </form>
    </div>
</div>