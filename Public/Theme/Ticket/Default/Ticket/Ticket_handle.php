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

                                    <?php if($label->checkAuth('TicketPOSTTicketclose') === true): ?>
                                    <div class="am-form-group">
                                        <label class="am-form-label am-margin-bottom-0">工单状态 : </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="4">
                                            标记完成
                                        </label>
                                    </div>
                                    <?php endif; ?>

                                    <div class="am-form-inline am-margin-bottom">
                                        <div class="am-form-group am-hide am-block assign-user">
                                            <label for="">转派给 : </label>
                                        </div>
                                        <div class="am-form-group am-hide assign-user">
                                            <select class="ticket-group" size="5">
                                                <option value="">请选择组</option>
                                                <?php foreach ($groupList as $value): ?>
                                                    <option value="<?= $value['user_group_id']; ?>"><?= $value['user_group_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="am-form-group am-hide assign-user">
                                        <select name="uid" size="5">
                                            <option value="" disabled>等待获取用户信息</option>
                                        </select>
                                        </div>
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
                                        <input type="checkbox" name="notice" value="1" <?= $ticket_model_default_send == 1 ? 'checked="checked"' : '' ?>>
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
    
    <?php if(ACTION == 'complainDetail' && $ticket_score_time > 0 ): ?>
        <?php require THEME . '/Ticket/Common/Ticket_score.php'; ?>
    <?php endif; ?>

</div>

<div class="am-hide">
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

        /**
         * 选择对应的组，进行获取对应的用户列表
         */
        $('.ticket-group').on('click', function(){
            var group = $(this).val();
            if(group == ''){
                return false;
            }
            $('select[name=uid]').html('<option disabled>正在获取客服信息中...</option>');

            $.post('<?= $label->url('Ticket-Ticket-getAssignUser', ['method' => 'GET']) ?>', {group:group}, function(result){
                if(result.status == 200){
                    var option = '';
                    for(var key in result.data){
                        option += '<option value="'+result.data[key]['user_id']+'" '+result.data[key]['disabled']+' >'+result.data[key]['user_name']+'</option>'
                    }
                    $('select[name=uid]').html(option);
                }else{
                    var d = dialog({
                        title: '系统提示',
                        id:'tisp',
                        content: result.msg
                    })
                    d.showModal();
                    setTimeout(function(){
                        d.close();
                    }, 1800)
                }
            }, 'JSON')

        })

        /**
         * 工单备注登记
         */
        $('.ticket-remark-input').on('blur', function(){
            var remark = $(this).val();
            if(remark == '' || remark == $(this).attr('old')){
                return false;
            }
            var number = '<?= $ticket_number ?>';
            $.ajaxsubmit({url : '<?= $label->url('Ticket-Ticket-remark') ?>', data : {number:number, remark:remark}}, function(){

            })
        })

    })
</script>
