<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<input type="hidden" name="method" value="<?= $method ?>"/>
<input type="hidden" name="id" value="<?= $id ?>"/>
<input type="hidden" name="number" value="<?= $_GET['number'] ?>"/>
<input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?>"/>

<?php foreach ($field as $key => $value) : ?>
    <?php if ($value['field_form']): ?>
        <li>
            <div class="am-g">
                <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label"><?= $value['field_display_name'] ?></label>

                <div class="am-u-sm-9">
                    <?php if ($value['field_name'] == 'type'): ?>
                        <?php $value['field_option'] = json_encode($formType); ?>
                    <?php elseif ($value['field_name'] == 'verify'): ?>
                        <?php $value['field_option'] = json_encode($checkType); ?>
                    <?php elseif ($value['field_name'] == 'bind'): ?>
                        <?php $value['field_option'] = json_encode($bind); ?>
                    <?php elseif ($value['field_name'] == 'option' && !empty($value['value'])): ?>
                        <?php
                        $optionStr = '';
                        foreach (json_decode(htmlspecialchars_decode($value['value']), true) as $ok => $ov) {
                            $optionStr .= "{$ok}|{$ov}\n";
                        }
                        $value['value'] = $optionStr;
                        ?>
                    <?php endif; ?>

                    <?php if ($value['field_name'] == 'bind_value'): ?>
                        <span id="bind_value">
                        <?php if (empty($ticket_form_bind)): ?>
                            待选择
                        <?php else: ?>
                            <?php foreach ($bindValue[$ticket_form_bind] as $bk => $bv): ?>
                                <?php $bindValueSelect = in_array($bv, explode(',', $ticket_form_bind_value)) ? 'checked="checked"' : '' ?>
                                <label class="am-checkbox-inline">
                                    <input type="checkbox" value="<?= $bv ?>"
                                           name="bind_value[]" <?= $bindValueSelect ?>> <?= $bk ?>
                                </label>
                            <?php endforeach; ?>
                        </span>
                        <?php endif; ?>

                    <?php else: ?>
                        <?= $form->formList($value); ?>
                    <?php endif; ?>
                    <?php if (!empty($value['field_explain'])): ?>
                        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                            <i class="am-icon-lightbulb-o"></i> <?= $value['field_explain'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div
                    class="am-u-sm-1"><?= $value['field_required'] == '1' ? '<span class="am-badge am-round am-badge-danger">必填</span>' : '' ?></div>
            </div>
        </li>
    <?php endif; ?>
<?php endforeach; ?>

<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>
<script>
    $(function () {

        //联动显示选项表单的选项列表
        var bindValue = eval('(' + '<?= json_encode($bindValue) ?>' + ')');

        //动态设置联动触发值的选项
        $("select[name=bind]").on("change", function () {
            var bindID = $(this).val();
            if (bindValue[bindID]) {
                var appendRaido = '';
                //bind_value
                $.each(bindValue[bindID], function (key, value) {
                    appendRaido += '<label class="am-checkbox-inline"><input type="checkbox" value="' + value + '" name="bind_value[]"> ' + key + '</label>';
                })
                $("#bind_value").html(appendRaido)
            } else {
                $("#bind_value").html('待选择')
            }
        })
    })
</script>
