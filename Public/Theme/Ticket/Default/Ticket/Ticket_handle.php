<div class="am-padding-xs am-padding-top-0">
    <?php require THEME . '/Ticket/Common/Ticket_view_package.php'; ?>

    <?php if ($ticket_status < 3 && $ticket_close == '0' && ($user_id == $this->session()->get('ticket')['user_id'] || empty($user_id))): ?>
    <form action="<?= $label->url('Ticket-Ticket-reply'); ?>" class="am-form ajax-submit" method="POST" data-am-validator>
        <input type="hidden" name="number" value="<?= $ticket_number; ?>"/>
        <input type="hidden" name="back_url" value="<?= $_GET['back_url']; ?>"/>
        <div class="am-panel am-panel-default">
            <div class="am-panel-bd">
                <h3 class="am-margin-0">处理工单</h3>
            </div>
                <ul class="am-list am-list-static am-text-sm">
                    <li>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-lg-12">

                                <?php if ($ticket_status == '0'): ?>
                                    <div class="am-form-group">
                                        <label class="am-form-label am-margin-bottom-0">受理工单 : </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="0" checked>
                                            假装没看见
                                        </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="1">
                                            开始受理
                                        </label>
                                    </div>
                                <?php elseif (in_array($ticket_status, ['1', '2'])): ?>
                                    <div class="am-form-group">
                                        <label class="am-form-label am-margin-bottom-0">是否需要转派 : </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="2" checked="checked">
                                            否
                                        </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="3">
                                            是
                                        </label>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-form-label am-margin-bottom-0">工单状态 : </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="4">
                                            标记完成
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

                                    <?php if(!empty($phrase)): ?>
                                        <div class="am-form-group phrase_list">
                                            <label for="">我的回复短语</label>
                                            <select id="phrase">
                                                <option value="">请选择</option>
                                                <?php foreach ($phrase as $value): ?>
                                                    <option value="<?= $value['phrase_id']; ?>"><?= $value['phrase_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>

                                    <div class="am-form-group pt-reply-content">
                                        <label for="">回复内容</label>
                                        <script type="text/plain" id="content" style="height:250px;"></script>
                                        <script>
                                        var ue = UE.getEditor('content', {
                                            textarea: 'content'
                                        });
                                        </script>
                                    </div>
                                <?php endif; ?>

                                <div class="am-form-group">
                                    <label class="am-form-label am-margin-bottom-0">是否通知 : </label>
                                    <label class="form-checkbox-label am-checkbox-inline">
                                        <input type="checkbox" name="notice" value="1">
                                        告知客户
                                    </label>
                                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                                        <i class="am-icon-lightbulb-o"></i> 若回复内容非常重要，请勾选告知客户，以便客户知道业务解决情况。
                                    </div>
                                </div>

                                <button type="submit" id="btn-submit" class="am-btn am-btn-primary am-btn-xs" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...', resetText: '再次提交'}">提交
                                </button>

                            </div>
                        </div>
                    </li>
                </ul>
        </div>
    </form>
    <?php endif; ?>
</div>

<div class="phrase_list am-hide">
    <?php if(!empty($phrase)): ?>
        <?php foreach ($phrase as $value): ?>
            <div id="phrase_<?=$value['phrase_id']?>">
                <?= htmlspecialchars_decode($value['phrase_content']) ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function assign(val) {
        if (val == '3') {
            $(".assign-user").removeClass("am-hide");
            $(".phrase_list, .pt-reply-content").addClass("am-hide");
        } else if (val == '4') {
            if (confirm('确定要设置工单为完成吗?') == false) {
                $("input[name=assign]").removeAttr("checked");
                $("input[name=assign]").eq(0).prop("checked", "checked")
            } else {
                $("form").submit();
            }
        } else {
            $(".assign-user").addClass("am-hide");
            $(".phrase_list, .pt-reply-content").removeClass("am-hide");
        }
    }

    $(function () {
        assign($("input[name=assign]:checked").val());
        $("input[name=assign]").change(function () {
            assign($(this).val());
        })

        /**
         * 回复短语
         */
        $('#phrase').change(function(){
            var id = $(this).val()
            if(id == ''){
                return false;
            }
            var content = $('#phrase_'+id).html().trim();
            ue.setContent(content);

        })

    })
</script>
