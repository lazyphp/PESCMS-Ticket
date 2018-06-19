<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<div class="am-g am-margin-bottom-xs am-g-collapse">
    <div class="am-u-sm-12 am-u-md-6 am-padding-top-xs">
        <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
                <?php ?>
                <?php $addUrl = empty($addUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $addUrl ?>
                <a href="<?= $addUrl ?>" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</a>
                <a href="<?= $label->url(GROUP . '-' . MODULE . '-import', array('back_url' => base64_encode($_SERVER['REQUEST_URI']))) ?>" class="am-btn am-btn-success"><span class="am-icon-cloud-download"></span> 导入模型</a>
            </div>
        </div>
    </div>


    <div class="am-u-sm-12 am-u-md-3">
        <form>
            <div class="am-input-group am-input-group-sm">
                <input type="hidden" name="g" value="<?= GROUP; ?>"/>
                <input type="hidden" name="m" value="<?= MODULE ?>"/>
                <input type="hidden" name="a" value="<?= ACTION ?>"/>
                <input type="text" name="keyword" value="<?= $_GET['keyword'] ?>" class="am-form-field">
                <span class="am-input-group-btn">
                        <input class="am-btn am-btn-default" type="submit" value="搜索"/>
                    </span>
            </div>
        </form>
    </div>
</div>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />

<?php include THEME_PATH . "/Content/Content_index_list.php"; ?>

<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
