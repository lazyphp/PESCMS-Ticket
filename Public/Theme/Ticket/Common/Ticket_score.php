<?php if($ticket_status == 3): ?>
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <h3 class="am-margin-0">待您评价</h3>
        </div>
        <ul class="am-list am-list-static am-text-sm">
            <li>
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12">
                        <form action="<?= $label->url('Form-Submit-score'); ?>" class="am-form ajax-submit" method="POST" data-am-validator>
                            <?= $label->token() ?>
                            <input type="hidden" name="number" value="<?= $ticket_number; ?>"/>
                            <input type="hidden" name="back_url" value="<?= base64_encode($_SERVER['REQUEST_URI']); ?>"/>

                            <div class="am-form-group">
                                <label class="am-form-label am-margin-bottom-0 am-vertical-align-middle am-text-sm">整体评价 : </label>
                                <div class="am-inline-block am-padding-left-sm">
                                    <div class="raty"></div>
                                </div>

                            </div>

                            <div class="am-form-group">
                                <label class="am-form-label am-margin-bottom-0">问题是否解决 : </label>
                                <label class="form-radio-label am-radio-inline">
                                    <input type="radio" name="fix" value="1" <?= $ticket_fix == 1 ? 'checked="checked"' :'' ?> required>
                                    已解决
                                </label>
                                <label class="form-radio-label am-radio-inline">
                                    <input type="radio" name="fix" value="0" <?= $ticket_fix == 0 && $ticket_score_time > 0 ? 'checked="checked"' :'' ?> required>
                                    未解决
                                </label>
                            </div>

                            <div class="am-form-group pt-reply-content">
                                <label for="">我要反馈: </label>
                                <textarea name="comment" rows="5" <?= $ticket_score_time > 0 ? 'disabled="disabled"' : '' ?>><?= (new \voku\helper\AntiXSS())->xss_clean($ticket_comment) ?></textarea>
                            </div>

                            <?php if($ticket_score_time == 0): ?>
                                <button type="submit" id="btn-submit" class="am-btn am-btn-primary am-btn-xs" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...', resetText: '再次提交'}">
                                    提交
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/jquery.raty.js"></script>
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/jquery.raty.css">
    <script>
        $(function(){
            $('.raty').raty({
                <?php if($ticket_score_time >0): ?>
                readOnly: true,
                score: <?= $ticket_score ?>,
                <?php endif; ?>
                half: true,
                hints:['差', '较差', '一般', '良好', '满意'],
                path: '<?= DOCUMENT_ROOT; ?>/Theme/assets/i/'
            });
        })
    </script>
<?php endif; ?>