<?php foreach (json_decode(htmlspecialchars_decode($field['field_option']), true) as $key => $value) : ?>
    <label class="form-radio-label am-radio-inline">
        <input class="form-radio" type="radio" name="<?= $field['field_name'] ?>" value="<?= $value ?>" <?= $field['field_required'] == '1' ? 'required' : '' ?>  <?= $field['value'] == $value ? 'checked="checked"' : empty($field['value']) && !is_numeric($field['value']) && $field['field_default'] == $value ? 'checked="checked"' : '' ?> />
        <span>
            <?= $key ?>
        </span>
    </label>
<?php endforeach; ?>