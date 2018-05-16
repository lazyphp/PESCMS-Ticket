<?php
/**
 * 本模板为智能表单添加/编辑模式下的表单模板
 * 定制开发中，若没有特殊的需求，请加载本模板。
 */
?>
<?php foreach ($field as $key => $value) : ?>
    <?php if ($value['field_form']): ?>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block"><?= $value['field_display_name'] ?><?= $value['field_required'] == '1' ? '<i class="am-text-danger">*</i>' : '' ?></label>
                    <?= $form->formList($value); ?>
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