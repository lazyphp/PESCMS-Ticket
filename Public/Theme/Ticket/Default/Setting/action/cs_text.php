<div class="am-panel am-panel-default">
    <div class="am-panel-hd">工单状态客服自动回复文本内容定义</div>
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

        <div class="pes-alert pes-alert-info am-text-xs ">
            <i class="am-icon-lightbulb-o"></i> 所有回复文本可以填写：{job_number} 自动生成工号
        </div>

    </div>
</div>