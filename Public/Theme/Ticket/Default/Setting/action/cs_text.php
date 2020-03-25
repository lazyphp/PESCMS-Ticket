<div class="am-panel am-panel-default">
    <div class="am-panel-hd">可定义的内容</div>
    <div class="am-panel-bd">
        
        <?php foreach($cs_text as $key => $item): ?>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block"><?= $item['title'] ?></label>
                    <input type="hidden" name="cs_text[<?= $key ?>][title]" value="<?= $item['title'] ?>" >
                    <input name="cs_text[<?= $key ?>][content]" type="text" value="<?= $item['content']; ?>" required >
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>