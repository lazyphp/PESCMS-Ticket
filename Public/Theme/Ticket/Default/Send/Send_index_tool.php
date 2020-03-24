<div class="am-g am-margin-bottom-xs am-g-collapse">
    <div class="am-u-sm-12 am-u-md-6 am-padding-top-xs">
        <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
                <?php ?>
                <?php $addUrl = empty($addUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $addUrl ?>
                <a href="<?= $addUrl ?>" class="am-btn am-btn-default am-radius"><span class="am-icon-plus"></span> 新增</a>
                <a href="<?= $label->url(GROUP . '-' . MODULE . '-truncate', ['method' => 'DELETE']) ?>" class="am-btn am-btn-warning am-radius ajax-click ajax-dialog" msg="确定要清空发送列表吗？"><span class="am-icon-folder-open-o"></span> 清空发送列表</a>
            </div>
        </div>
    </div>


    <div class="am-u-sm-12 am-u-md-3">
        <form>
            <div class="am-input-group am-input-group-sm">
                <input type="hidden" name="g" value="<?= GROUP; ?>"/>
                <input type="hidden" name="m" value="<?= MODULE ?>"/>
                <input type="hidden" name="a" value="<?= ACTION ?>"/>
                <input type="text" name="keyword" placeholder="查找内容" value="<?= $label->xss($_GET['keyword']) ?>" class="am-form-field am-radius">
                <span class="am-input-group-btn">
                        <input class="am-btn am-btn-default am-radius" type="submit" value="搜索"/>
                    </span>
            </div>
        </form>
    </div>
</div>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />