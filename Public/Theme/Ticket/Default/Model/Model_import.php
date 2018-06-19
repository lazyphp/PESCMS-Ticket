<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
<div class="am-cf">
    <div class="am-fl am-cf">
        <a href="<?= empty($_GET['back_url']) ?  $label->url(GROUP.'-'.MODULE.'-index') : base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                    class="am-icon-reply"></i>返回</a>
        <strong class="am-text-primary am-text-lg">导入模型</strong>
    </div>
</div>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
<form class="am-form am-form-horizontal ajax-submit" action="" method="post" data-am-validator>
    <input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?>"/>
    <?= $label->token() ?>
    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">粘贴代码</label>
                <textarea name="model" rows="15" ></textarea>
            </div>
        </div>
    </div>
    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <button type="submit" class="am-btn am-btn-primary am-btn-xs" >导入</button>
        </div>
    </div>
</form>
<script>
    $(function () {
        $('#btn-submit').click(function () {
            var $btn = $(this)
            $btn.button('loading');
            setTimeout(function () {
                $btn.button('reset');
            }, 5000);
        });
    })
</script>
        </div>
    </div>
</div>