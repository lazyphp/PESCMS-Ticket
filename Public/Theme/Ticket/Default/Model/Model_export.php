<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <a href="<?= empty($_GET['back_url']) ?  $label->url(GROUP.'-'.MODULE.'-index') : base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                                class="am-icon-reply"></i>返回</a>
                    <strong class="am-text-primary am-text-lg">导出 <?= $model['model_name'] ?> 模型</strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <div class="am-g am-g-collapse">
                <div class="am-u-sm-12 am-u-sm-centered">
                    <div class="am-form-group">
                        <label class="am-block">复制如下代码</label>
                        <pre class="am-pre-scrollable"><?= htmlspecialchars(json_encode($export)) ?></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




