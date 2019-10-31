<div class="am-g">
    <div class="am-u-sm-12 am-u-sm-centered">
        <?php require THEME . '/Ticket/Common/Ticket_view_package.php'; ?>
        <?php if ($ticket_status < 3 && $ticket_close == '0'): ?>
        <div class="am-panel am-panel-default">
            <div class="am-panel-bd">
                <h3 class="am-margin-0">补充内容</h3>
            </div>
            <ul class="am-list am-list-static am-text-sm">
                <li>
                    <div class="am-g am-g-collapse">
                        <div class="am-u-lg-8">
                            <form action="<?= $label->url('Form-Submit-reply'); ?>" class="am-form ajax-submit" method="POST" data-am-validator>
                                <?= $label->token() ?>
                                <input type="hidden" name="number" value="<?= $ticket_number; ?>"/>
                                <input type="hidden" name="back_url" value="<?= base64_encode($_SERVER['REQUEST_URI']); ?>"/>

                                <div class="am-form-group pt-reply-content">
                                    <label for="">回复内容</label>
                                    <script type="text/plain" id="content" style="height:250px;"></script>
                                    <script>
                                    var ue = UE.getEditor('content', {
                                        textarea: 'content'
                                    });
                                    </script>
                                </div>
                                <?php if($ticket_model_verify == 1): ?>
                                <div class="am-form-group pt-reply-content">
                                    <label for="">验证码: </label>
                                    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify" height="25"/>
                                    <input type="text" name="verify" maxlength="<?= $system['verifyLength'] ?>" required/>
                                </div>
                                <?php endif; ?>
                                
                                <button type="submit" id="btn-submit" class="am-btn am-btn-primary am-btn-xs"
                                        data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...', resetText: '再次提交'}">
                                    提交
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <?php endif; ?>

        <?php require THEME . '/Ticket/Common/Ticket_score.php'; ?>

    </div>
</div>