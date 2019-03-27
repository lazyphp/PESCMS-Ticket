<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
<script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/spectrum.js"></script>
<link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/spectrum.css"/>
<script>
    $(function(){
        var weixin_str = $('.weixin-input-content').html().trim();
        if(weixin_str == ''){
            weixin_str = $('.weixin-input-example').html();
        }
        $('textarea[name=weixin_template]').after(weixin_str);
        $('textarea[name=weixin_template]').remove()

        $('body').on('click', '.plus-weixin', function(){
            $(this).parent().after($('.weixin-input-example').html());

        })

        $('body').on('click', '.minus-weixin', function(){
            $(this).parent().remove();
        })

        $(".weixin_color").spectrum({
            preferredFormat: "hex",
            showInput: true
        });

    })
</script>

<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>

<div class="weixin-input-example am-hide">
    <div class="am-form-inline am-margin-bottom-xs">
        <div class="am-form-group">
            <input type="text" name="weixin_key[]" class="am-form-field" placeholder="模板key名称" value="">
        </div>
        <div class="am-form-group">
            <input type="text" name="weixin_content[]" class="am-form-field" placeholder="对应内容" value="">
        </div>
        <div class="am-form-group">
            <input type="text" class="weixin_color" name="weixin_color[]" placeholder="文字颜色" value="#000000">
        </div>
        <a href="javascript:;" class="am-btn am-btn-default plus-weixin"><i class="am-icon-plus"></i></a>
        <a href="javascript:;" class="am-btn am-btn-default minus-weixin"><i class="am-icon-minus"></i></a>
    </div>
</div>

<div class="weixin-input-content am-hide">
    <?php if(!empty($mail_template_weixin_template)): ?>
        <?php foreach(json_decode(htmlspecialchars_decode($mail_template_weixin_template), true) as $key => $value): ?>
        <div class="am-form-inline am-margin-bottom-xs">
            <div class="am-form-group">
                <input type="text" name="weixin_key[]" class="am-form-field" placeholder="模板key名称" value="<?= $key ?>">
            </div>
            <div class="am-form-group">
                <input type="text" name="weixin_content[]" class="am-form-field" placeholder="对应内容" value="<?= $value['value'] ?>">
            </div>
            <div class="am-form-group">
                <input type="text" class="weixin_color" name="weixin_color[]" placeholder="文字颜色" value="<?= $value['color'] ?>">
            </div>
            <a href="javascript:;" class="am-btn am-btn-default plus-weixin"><i class="am-icon-plus"></i></a>
            <a href="javascript:;" class="am-btn am-btn-default minus-weixin"><i class="am-icon-minus"></i></a>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
