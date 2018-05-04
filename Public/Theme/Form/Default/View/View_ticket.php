<div class="admin-content  am-padding">
    <?php require THEME . '/Ticket/Common/Ticket_view_package.php'; ?>
    <?php if ($ticket_status < 3 && $ticket_close == '0'): ?>
        <ul class="am-list am-list-static am-list-border am-text-sm">
            <li style="background: #F5f6FA;border-left: 4px solid #6d7781;">回复工单</li>
            <li>
                <div class="am-g am-g-collapse">
                    <div class="am-u-lg-8">
                        <form action="<?= $label->url('Form-Submit-reply'); ?>" class="am-form" method="POST" data-am-validator>
                            <input type="hidden" name="number" value="<?= $ticket_number; ?>"/>

                            <div class="am-form-group pt-reply-content">
                                <label for="">回复内容</label>
                                <textarea name="content" rows="5" required></textarea>
                            </div>
                            <div class="am-form-group pt-reply-content">
                                <label for="">验证码: </label>
                                <img src="/?g=Form&m=Index&a=verify" class="refresh-verify" height="25"/>
                                <input type="text" name="verify" required/>
                            </div>
                            <button type="submit" id="btn-submit" class="am-btn am-btn-primary am-btn-xs"
                                    data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...', resetText: '再次提交'}">
                                提交
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    <?php endif; ?>
</div>
<script>
    $(function () {
        $(".refresh-verify").on("click", function () {
            $(this).attr("src", "/?g=Form&m=Index&a=verify&" + Date.parse(new Date()) + Math.random());
        })
    })
</script>
