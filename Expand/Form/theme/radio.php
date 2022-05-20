<?php if (is_array(json_decode(htmlspecialchars_decode($field['field_option']), true))): ?>
    <?php foreach (json_decode(htmlspecialchars_decode($field['field_option']), true) as $key => $value) : ?>
        <label class="form-radio-label am-radio-inline">
            <input class="form-radio" type="radio" name="<?= $field['field_name'] ?>"
                   value="<?= $value ?>" <?= $field['field_required'] == '1' ? 'required' : '' ?>  <?= isset($field['value']) && $field['value'] == $value ? 'checked="checked"' : (!isset($field['value']) && isset($field['field_default'] ) && $field['field_default'] == $value ? 'checked="checked"' : '') ?> />
        <span>
            <?= $key ?>
        </span>
        </label>
    <?php endforeach; ?>
<?php endif; ?>
