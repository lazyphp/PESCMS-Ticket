<div class="admin-content  am-padding am-padding-top-0">
    <div class="">
        <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i class="am-icon-reply"></i>返回上一页</a>
    </div>
    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
    <?php require THEME . '/Ticket/Common/Ticket_view_package.php'; ?>

    <?php if ($ticket_status < 3 && $ticket_close == '0' && ($user_id == $_SESSION['ticket']['user_id'] || empty($user_id) ) ): ?>
        <ul class="am-list am-list-static am-list-border am-text-sm">
            <li style="background: #F5f6FA;border-left: 4px solid #6d7781;">处理工单</li>
            <li>
                <div class="am-g am-g-collapse">
                    <div class="am-u-lg-8">
                        <form action="<?= $label->url('Ticket-Ticket-reply'); ?>" class="am-form" method="POST" data-am-validator>
                            <input type="hidden" name="number" value="<?= $ticket_number; ?>"/>
                            <input type="hidden" name="back_url" value="<?= $_GET['back_url']; ?>"/>
                            <?php if ($ticket_status == '0'): ?>
                                <div class="am-form-group">
                                    <label class="am-form-label am-margin-bottom-0">受理工单 : </label>
                                    <label class="form-radio-label am-radio-inline">
                                        <input type="radio" name="assign" value="0" checked>
                                        假装没看见
                                    </label>
                                    <label class="form-radio-label am-radio-inline" onclick="submit()">
                                        <input type="radio" name="assign" value="1">
                                        开始受理
                                    </label>
                                </div>
                            <?php elseif (in_array($ticket_status, ['1', '2'])): ?>
                                <div class="am-form-group">
                                    <label class="am-form-label am-margin-bottom-0">是否需要转派 : </label>
                                    <label class="form-radio-label am-radio-inline">
                                        <input type="radio" name="assign" value="2" checked>
                                        否
                                    </label>
                                    <label class="form-radio-label am-radio-inline">
                                        <input type="radio" name="assign" value="3">
                                        是
                                    </label>
                                </div>
                                <div class="am-form-group">
                                    <label class="form-radio-label am-radio-inline">
                                        <input type="radio" name="assign" value="4">
                                        设置工单完成
                                    </label>
                                </div>
                                <div class="am-form-group am-hide assign-user">
                                    <label for="">转派给</label>
                                    <select name="uid">
                                        <option value="">转派给谁呢？</option>
                                        <?php foreach ($user as $value): ?>
                                            <option value="<?= $value['user_id']; ?>"><?= $value['user_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="am-form-group pt-reply-content">
                                    <label for="">回复内容</label>
                                    <textarea name="content" rows="5"></textarea>
                                </div>
                                <button type="submit" id="btn-submit" class="am-btn am-btn-primary am-btn-xs"
                                        data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...', resetText: '再次提交'}">
                                    提交
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    <?php endif; ?>


</div>

<script>
    function assign(val) {
        if (val == '3') {
            $(".assign-user").removeClass("am-hide");
            $(".pt-reply-content").addClass("am-hide");
        }else if(val == '4'){
            if(confirm('确定要设置工单为完成吗?') == false){
                $("input[name=assign]").removeAttr("checked");
            }else{
                $("form").submit();
            }
        } else {
            $(".assign-user").addClass("am-hide");
            $(".pt-reply-content").removeClass("am-hide");
        }
    }
    $(function () {
        assign($("input[name=assign]:checked").val());
        $("input[name=assign]").change(function () {
            assign($(this).val());
        })
    })
</script>
