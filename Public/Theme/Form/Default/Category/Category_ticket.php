<hr class="am-margin-top-0" />
<h3>新工单 > <?= $ticketInfo['title'] ?></h3>
<form action="<?=$domain?><?= $label->url('Submit-ticket') ?>" method="POST" class="am-form ajax-submit am-form-horizontal" data-am-validator>
    <input type="hidden" name="number" value="<?= $ticketInfo['number'] ?>">
    <input type="hidden" name="PHPSESSIONID" value="">
    <?= $label->token() ?>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">联系方式<i class="am-text-danger">*</i></label>
                <label class="form-radio-label am-radio-inline">
                    <input class="form-radio" type="radio" name="contact" value="1" required="required"  checked="checked" />
                    <span>邮件</span>
                </label>
            </div>
        </div>
    </div>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">联系信息<i class="am-text-danger">*</i></label>
                <input class="form-text-input input-leng3 am-field-valid" name="contact_account" placeholder="请填写您的联系信息,方便我们与您联系" type="text" value="" required="">
            </div>
        </div>
    </div>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">工单标题<i class="am-text-danger">*</i></label>
                <input class="form-text-input input-leng3 am-field-valid" name="title" placeholder="简单扼要描述本次工单遇到的问题" type="text" value="" required="">
            </div>
        </div>
    </div>

    <?php foreach ($field as $key => $value): ?>
        <div id="<?= $value['field_name'] ?>_band" class="am-g am-g-collapse <?= $value['field_bind'] != '0' ? 'am-hide' : '' ?>">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block"><?= $value['field_display_name'] ?><?= $value['field_required'] == '1' ? '<i class="am-text-danger">*</i>' : '' ?></label>
                    <?= (new \Expand\Form\Form())->formList($value); ?>
                    <?php if (!empty($value['field_explain'])): ?>
                        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                            <i class="am-icon-lightbulb-o"></i> <?= $value['field_explain'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if ($value['field_bind'] != '0'): ?>
            <script>
                $(function () {
                    var formName_<?=$value['field_name']?> = $("input[name=<?=$value['field_name']?>], select[name=<?= $value['field_name'] ?>]");
                    formName_<?=$value['field_name']?>.removeAttr("required", "required");
                    $('input[name=<?=$field[$value['field_bind']]['field_name']?>], select[name=<?=$field[$value['field_bind']]['field_name']?>]').on("change", function () {
                        var bindForm = $("#<?=$value['field_name']?>_band");
                        var bindValue = '<?=$value['field_bind_value']?>'.split(',');
                        if ($.inArray($(this).val(), bindValue) != '-1') {
                            bindForm.removeClass('am-hide');
                            <?php if($value['field_required'] == '1'): ?>
                            formName_<?=$value['field_name']?>.attr("required", "required");
                            <?php endif;?>
                        } else {
                            bindForm.addClass('am-hide');
                            <?php if($value['field_required'] == '1'): ?>
                            formName_<?=$value['field_name']?>.removeAttr("required", "required");
                            <?php endif;?>
                        }
                    })
                })
            </script>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($ticketInfo['verify'] == '1'): ?>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">验证码<i class="am-text-danger">*</i></label>
                    <input type="text" name="verify" class="am-inline am-input-sm" style="width: 15%" required/>
                    <span class="display-verify">
                        <a href="javascript:;">点击显示验证码</a>
                    </span>
                    <img class="refresh-verify am-hide" src="" class="am-inline"/>
                </div>
            </div>
        </div>
        <script>
            var TICKETSESSIONID;
            function getSession() {
                $.getJSON('<?=$domain?>/?m=Index&a=getSession', function (data) {
                    TICKETSESSIONID = data;
                    $(".display-verify").remove();
                    $(".refresh-verify").removeClass("am-hide").attr("src", "<?=$domain?>/?m=Index&a=verify&PHPSESSIONID=" + TICKETSESSIONID + "&" + Date.parse(new Date()) + Math.random());
                    $('input[name=PHPSESSIONID]').val(TICKETSESSIONID)
                })
            }

            $(function () {
                getSession();
                $(".display-verify").on("click", function () {
                    if ($(this).hasClass("am-active")) {
                        if (typeof TICKETSESSIONID != 'undefined' && TICKETSESSIONID != '') {
                            $(this).remove();
                            $(".refresh-verify").removeClass("am-hide").attr("src", "<?=$domain?>/?m=Index&a=verify&PHPSESSIONID=" + TICKETSESSIONID + "&" + Date.parse(new Date()) + Math.random());
                        }
                    } else {
                        getSession();
                        $(this).addClass("am-active");
                    }

                });

                $(".refresh-verify").on("click", function () {
                    $(this).attr("src", "<?=$domain?>/?m=Index&a=verify&PHPSESSIONID=" + TICKETSESSIONID + "&" + Date.parse(new Date()) + Math.random());
                })

            })
        </script>
    <?php endif; ?>
    <div class="am-g am-g-collapse am-margin-bottom">
        <div class="am-u-sm-6">
            <button type="submit" class="am-btn am-btn-primary am-btn-xs" >提交</button>
        </div>
        <div class="am-u-sm-6 am-text-right">
            <span>——本工单系统由<a href="https://www.pescms.com" target="_blank">PESCMS Ticket</a>强力驱动</span>
        </div>
    </div>
</form>