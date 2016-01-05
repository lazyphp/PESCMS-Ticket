<?php
/**
 * 本模板为智能表单添加/编辑模式下的表单模板
 * 定制开发中，若没有特殊的需求，请加载本模板。
 */
?>
<?php foreach ($field as $key => $value) : ?>
    <?php if ($value['field_form']): ?>
        <li>
            <div class="am-g">
                <label for="" class="am-u-sm-2 am-form-label"><?= $value['field_display_name'] ?></label>

                <div class="am-u-sm-9">
                    <?= $form->formList($value); ?>
                    <?php if (!empty($value['field_explain'])): ?>
                        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                            <i class="am-icon-lightbulb-o"></i> <?= $value['field_explain'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="am-u-sm-1">
                    <?= $value['field_required'] == '1' ? '<span class="am-badge am-round am-badge-danger">必填</span>' : '' ?>
                </div>
            </div>
        </li>
    <?php endif; ?>
<?php endforeach; ?>