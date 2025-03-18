<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
    <input type="hidden" name="method" value="<?= $method ?? '' ?>"/>
    <input type="hidden" name="copy" value="<?= $label->xss($_GET['copy'] ?? '') ?>">
    <input type="hidden" name="id" value="<?= $ticket_model_number ?? '' ?>"/>
    <input type="hidden" name="back_url" value="<?= $label->xss($_GET['back_url'] ?? '') ?>"/>
<?= $label->token(); ?>


    <div class="am-tabs am-margin-bottom" data-am-tabs="{noSwipe: 1}">
        <ul class="am-tabs-nav am-nav am-nav-tabs">
            <?php foreach (array_keys($field) as $k => $name): ?>
                <li class="<?= $k == 0 ? 'am-active' : '' ?>">
                    <a href="#tab_<?= substr(md5($name), 0, 5) ?>"><?= $name ?></a></li>
            <?php endforeach; ?>
            <li class="am-active">
                <button type="submit" class="am-btn am-btn-primary am-btn-xs am-radius"><i class="am-icon-save"></i>
                    保存设置
                </button>
            </li>
        </ul>

        <div class="am-tabs-bd">
            <?php foreach ($field as $tagName => $item): ?>
                <div class="am-tab-panel am-fade <?= $tagName == '工单基础属性' ? 'am-in am-active' : '' ?>" id="tab_<?= substr(md5($tagName), 0, 5) ?>">


                    <?php foreach ($item as $key => $value): ?>
                        <?php if ($value['field_form'] && in_array($method, explode(',', $value['field_action']))): ?>
                            <div class="am-g am-g-collapse">
                                <div class="am-u-sm-12 am-u-sm-centered">
                                    <div class="am-form-group">
                                        <label class="am-block"><?= $value['field_display_name'] ?><?= $value['field_required'] == '1' ? '<i class="am-text-danger">*</i>' : '' ?></label>
                                        <?= $form->formList($value); ?>
                                        <?php if (!empty($value['field_explain'])): ?>
                                            <div class="pes-alert pes-alert-info am-text-xs ">
                                                <i class="am-icon-lightbulb-o"></i> <?= $value['field_explain'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>


                </div>
            <?php endforeach; ?>
        </div>

    </div>


    <script>
        $(function () {

            const form = document.getElementsByClassName('am-form')[0];

            const requiredFields = form.querySelectorAll('[required]')
            // console.dir(requiredFields)

            function isFieldValid(field) {
                if (field.type === 'radio') {
                    const radios = form.querySelectorAll(`[name="${field.name}"]`);
                    return Array.from(radios).some(radio => radio.checked);
                } else if (field.type === 'checkbox') {
                    return field.checked;
                } else if (field.tagName.toLowerCase() === 'select') {
                    return field.value !== '';
                } else {
                    return field.checkValidity();
                }
            }

            $('.am-form').submit(function (){
                if($(this).validator('isFormValid') == false){
                    for (let i = 0; i < requiredFields.length; i++) {
                        if (!isFieldValid(requiredFields[i])) {
                            var index = $(requiredFields[i]).parents('.am-tab-panel').index();
                            $('.am-tabs').tabs('open', index)
                            break;
                        }
                    }
                }
            })


            var closeTicket = function (val) {
                var showCloseType = $('input[name="close_type[]"]').parent().parent()
                var showCloseSetting = $('input[name="close_time"]').parent()

                if (val == "1") {
                    showCloseType.show();
                    showCloseSetting.show();
                } else {
                    showCloseType.hide();
                    showCloseSetting.hide();
                }
            }

            closeTicket($('input[name="open_close"]:checked').val());

            $('input[name="open_close"]').on('click', function () {
                closeTicket($(this).val());
            })
        })
    </script>

<?php if (empty($license)): ?>
    <script>
        $(function () {
            $('input[name=time_out_sequence]').attr('readonly', 'readonly').popover({
                trigger: 'hover',
                content: '需求购买使用授权方解除限制'
            })
        })
    </script>
<?php endif; ?>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>
<?php include __DIR__ . '/Ticket_model_action_driver.php' ?>