<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
    <input type="hidden" name="method" value="<?= $method ?? '' ?>"/>
    <input type="hidden" name="copy" value="<?= $label->xss($_GET['copy'] ?? '') ?>">
    <input type="hidden" name="id" value="<?= $ticket_model_number ?? '' ?>"/>
    <input type="hidden" name="back_url" value="<?= $label->xss($_GET['back_url'] ?? '') ?>"/>
<?= $label->token(); ?>

    <div class="am-margin-bottom-sm" id="accordion">
        <?php foreach ($field as $tagName => $item) : ?>

            <div class="am-panel am-panel-warning am-margin-bottom">
                <div class="am-panel-hd">
                    <h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#<?= substr(md5($tagName), 0, 5) ?>'}">
                        <?= $tagName ?>
                    </h4>
                </div>


                <div id="<?= substr(md5($tagName), 0, 5) ?>" class="am-panel-collapse am-collapse">
                    <div class="am-panel-bd">
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
                </div>


            </div>


        <?php endforeach; ?>
    </div>

    <script>
        $(function () {

            let searchParams = new URLSearchParams(window.location.href);
            let urlID = searchParams.get('id');

            if(urlID == null){
                $('.am-panel-title').each(function (){
                    let option = $(this).data('am-collapse');
                    let target = AMUI.utils.parseOptions(option).target;
                    $(target).collapse('open')
                })
            }


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