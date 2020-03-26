<?php if(ACTION != 'createJS'): ?>
<hr class="am-margin-top-0" />
<?php endif;?>
<h3>新工单 > <?= $ticketInfo['category']['category_name'] ?> > <?= $ticketInfo['title'] ?></h3>
<form action="<?= $label->url('Submit-ticket') ?>" method="POST" class="am-form ajax-submit am-form-horizontal" data-am-validator>
    <input type="hidden" name="number" value="<?= $ticketInfo['number'] ?>">
    <?= $label->token() ?>

    <?php if(!empty($ticketInfo['postscript'])): ?>
    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-alert am-alert-postscript">
                <?= htmlspecialchars_decode($ticketInfo['postscript']) ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">联系方式<i class="am-text-danger">*</i></label>
                
                <?php foreach($contact as $contactID => $contactValue): ?>
                    <?php
                        if($contactID == 3 && empty($member['member_weixin']) ){
                            continue;
                        }

                        if(!in_array($contactID, explode(',', $ticketInfo['contact']))){
                            continue;
                        }

                    ?>
                    <label class="form-radio-label am-radio-inline">
                        <input class="form-radio" type="radio" name="contact" value="<?= $contactID ?>" required="required" <?= $ticketInfo['contact_default'] == $contactID ? 'checked="checked"' : '' ?> data="<?= !empty($member) ? $member[$contactValue['key']] : '' ?>" />
                        <span><?= $contactValue['title'] ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">联系信息<span class="contact_label"></span><i class="am-text-danger">*</i></label>
                <input class="form-text-input input-leng3 am-radius" name="contact_account" placeholder="请填写您的联系信息,方便我们与您联系" type="text" value="" required="">
            </div>
        </div>
    </div>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">工单标题<i class="am-text-danger">*</i></label>
                <input class="form-text-input input-leng3 am-radius" name="title" placeholder="简单扼要描述本次工单遇到的问题" type="text" value="" required="">
            </div>
        </div>
    </div>

    <?php foreach ($field as $key => $value): ?>
        <div id="<?= $value['field_name'] ?>_band" class="am-g am-g-collapse <?= $value['field_bind'] != '0' ? 'am-hide' : '' ?>">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block"><?= $value['field_display_name'] ?><?= $value['field_required'] == '1' ? '<i class="am-text-danger">*</i>' : '' ?></label>
                    <?= (new \Expand\Form\Form())->formList($value); ?>
                    <?php if (!empty($value['field_explain']) || !empty($value['field_postscript']) ): ?>
                        <div class="am-alert am-alert-secondary am-text-xs" data-am-alert>
                            <?= !empty($value['field_explain']) ? '<i class="am-icon-lightbulb-o"></i> '.htmlspecialchars_decode($value['field_explain']) : '' ?>
                            <?= !empty($value['field_postscript']) ? htmlspecialchars_decode($value['field_postscript']) : '' ?>
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
                    <input type="text" name="verify" class="am-inline am-input-sm am-radius" maxlength="<?= $system['verifyLength'] ?>" style="width: 15%" required/>
                    <span class="display-verify">
                        <a href="javascript:;">点击显示验证码</a>
                    </span>
                    <img class="refresh-verify am-hide" src="" class="am-inline"/>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if($ticketInfo['exclusive'] == 1): ?>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">

                <div class="am-form-group am-form-warning">
                    <label class="am-block">受理客服工号</label>
                    <input type="text" class="form-text-input input-leng3 am-radius am-form-warning am-form-field" name="job_number">
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="am-g am-g-collapse am-margin-bottom">
        <div class="am-u-sm-6">
            <button type="submit" class="am-btn am-btn-secondary am-btn-xs am-radius" >提交</button>
        </div>
        <div class="am-u-sm-6 am-text-right">
            <?php if($authorize_type == 0): ?>
            <span>——本工单系统由<a href="https://www.pescms.com" target="_blank">PESCMS Ticket</a>强力驱动</span>
            <?php endif; ?>
        </div>
    </div>
</form>
<script>
    $(function(){
        var contact = function(){
            var dom = $('input[name=contact]:checked');
            var checkContact = dom.val();
            var label = dom.parent().text().trim()

            $('.contact_label').html(' ('+label+')')

            if(checkContact == '3'){
                $('input[name=contact_account]').parent().hide()
            }else{
                $('input[name=contact_account]').parent().show();
            }
            $('input[name=contact_account]').val(dom.attr('data'))
        }

        contact();


        $('input[name=contact]').click(function(){
            contact();
        })
    })
</script>