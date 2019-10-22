<div class="am-form-inline">
    <?php
        if(empty($field['value'])){
            $option = ['' => ''];
        }else{
            $option = json_decode(htmlspecialchars_decode($field['value']), true);
        }
    ?>
    <?php foreach($option as $ok => $ov): ?>
        <div class="pes-option-line am-margin-bottom-xs">
            <div class="am-form-group">显示名称:</div>

            <div class="am-form-group">
                <input class="form-text-input  am-radius" type="text" name="<?= $field['field_name'] ?>_display[]" placeholder="请填写选项显示的名称" <?= $field['field_required'] == '1' ? 'required' : '' ?> value="<?= $ok ?>">
            </div>

            <div class="am-form-group">值:</div>
            <div class="am-form-group">
                <input class="form-text-input  am-radius" type="text" name="<?= $field['field_name'] ?>_value[]" placeholder="请填写选项的值" <?= $field['field_required'] == '1' ? 'required' : '' ?> value="<?= $ov ?>">
            </div>

            <div class="am-form-group">
                <a href="javascript:;" class="option-plus-square"><i class="am-icon-sm am-icon-plus-square"></i></a>
                <a href="javascript:;" class="option-minus-square"><i class="am-icon-sm am-icon-minus-square"></i></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>