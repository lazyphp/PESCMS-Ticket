<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
<script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/spectrum.js"></script>
<link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/spectrum.css"/>


<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>

<script>
    $(function () {
        $('textarea[name=sms]').parents('.am-g.am-g-collapse').before('<hr data-am-widget="divider" style="border-top: 1px dashed #ff7f34;"  />')
        $('input[name=weixin_template_id]').parents('.am-g.am-g-collapse').before('<hr data-am-widget="divider" style="border-top: 1px dashed #ff7f34;" " />')
        $('input[name=wxapp_template_id]').parents('.am-g.am-g-collapse').before('<hr data-am-widget="divider" style="border-top: 1px dashed #ff7f34;"  />')
    })
</script>


<?php foreach (['weixin' => $mail_template_weixin_template, 'wxapp' => $mail_template_wxapp_template ] as $name => $content): ?>

    <script>
        $(function () {
            var <?= $name ?>_str = $('.<?= $name ?>-input-content').html().trim();
            if (<?= $name ?>_str == '') {
                <?= $name ?>_str = $('.<?= $name ?>-input-example').html();
            }
            $('textarea[name=<?= $name ?>_template]').after(<?= $name ?>_str);
            $('textarea[name=<?= $name ?>_template]').remove()

            $('body').on('click', '.plus-<?= $name ?>', function () {
                $(this).parent().after($('.<?= $name ?>-input-example').html());

            })

            $('body').on('click', '.minus-<?= $name ?>', function () {
                $(this).parent().remove();
            })

            $(".<?= $name ?>_color").spectrum({
                preferredFormat: "hex",
                showInput: true
            });

        })
    </script>

    <div class="<?= $name ?>-input-example am-hide">
        <div class="am-form-inline am-margin-bottom-xs">
            <div class="am-form-group">
                <input type="text" name="<?= $name ?>_key[]" class="am-form-field" placeholder="模板key名称" value="">
            </div>
            <div class="am-form-group">
                <input type="text" name="<?= $name ?>_content[]" class="am-form-field" placeholder="对应内容" value="">
            </div>
            <div class="am-form-group">
                <input type="text" class="<?= $name ?>_color" name="<?= $name ?>_color[]" placeholder="文字颜色" value="#000000">
            </div>
            <a href="javascript:;" class="am-btn am-btn-default plus-<?= $name ?>"><i class="am-icon-plus"></i></a>
            <a href="javascript:;" class="am-btn am-btn-default minus-<?= $name ?>"><i class="am-icon-minus"></i></a>
        </div>
    </div>

    <div class="<?= $name ?>-input-content am-hide">
        <?php if(!empty($content)): ?>
            <?php foreach(json_decode(htmlspecialchars_decode($content), true) as $key => $value): ?>
                <div class="am-form-inline am-margin-bottom-xs">
                    <div class="am-form-group">
                        <input type="text" name="<?= $name ?>_key[]" class="am-form-field" placeholder="模板key名称" value="<?= $key ?>">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="<?= $name ?>_content[]" class="am-form-field" placeholder="对应内容" value="<?= $value['value'] ?>">
                    </div>
                    <div class="am-form-group">
                        <input type="text" class="<?= $name ?>_color" name="<?= $name ?>_color[]" placeholder="文字颜色" value="<?= $value['color'] ?>">
                    </div>
                    <a href="javascript:;" class="am-btn am-btn-default plus-<?= $name ?>"><i class="am-icon-plus"></i></a>
                    <a href="javascript:;" class="am-btn am-btn-default minus-<?= $name ?>"><i class="am-icon-minus"></i></a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>



<?php endforeach; ?>

