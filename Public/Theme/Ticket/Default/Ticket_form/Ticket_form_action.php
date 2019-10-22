<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<input type="hidden" name="method" value="<?= $method ?>"/>
<input type="hidden" name="id" value="<?= $id ?>"/>
<input type="hidden" name="number" value="<?= $_GET['number'] ?>"/>
<input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?>"/>

<?php foreach ($field as $key => $value) : ?>
    <?php if ($value['field_form']): ?>
		<div class="am-g am-g-collapse">
			<div class="am-u-sm-12 am-u-sm-centered">
				<div class="am-form-group">
					<label class="am-block"><?= $value['field_display_name'] ?><?= $value['field_required'] == '1' ? '<i class="am-text-danger">*</i>' : '' ?></label>

					<?php if ($value['field_name'] == 'type'): ?>
						<?php $value['field_option'] = json_encode($formType); ?>
					<?php elseif ($value['field_name'] == 'verify'): ?>
						<?php $value['field_option'] = json_encode($checkType); ?>
					<?php elseif ($value['field_name'] == 'bind'): ?>
						<?php $value['field_option'] = json_encode($bind); ?>
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
			</div>
		</div>
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

        $('input[name=name]').on('blur', function(){
            $('.tips-alert').remove();
            var dom = $(this)
            var field = $(this).val();
            if(field == ''){
                return false;
            }
            $.getJSON(PESCMS_PATH + '/?g=Ticket&m=Ticket_form&a=checkFieldName&number=<?= $label->xss($_GET['number']) ?>&field='+field, function(data){
                if(data.status == 200){
                    dom.removeClass('am-field-error');
                }else{
                    dom.addClass('am-field-error').removeClass('am-field-valid')
                    dom.after('<div class="tips-alert am-alert am-alert-danger" style="">'+data.msg+'</div>')
                }

            })
        })
    })
</script>
