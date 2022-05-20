<?php
$itemValue = explode(',', $field['value'] ?? null);
$itemDefault = explode(',', $field['field_default']);
?>
<?php if (is_array(json_decode(htmlspecialchars_decode($field['field_option']), true))): ?>
    <?php foreach (json_decode(htmlspecialchars_decode($field['field_option']), true) as $key => $item) : ?>
        <label class="form-checkbox-label am-checkbox-inline">
            <input class="form-checkbox" type="checkbox" name="<?= $field['field_name'] ?>[]"
                   value="<?= $item ?>" <?= $field['field_required'] == '1' ? 'required' : '' ?>  <?= in_array($item, $itemValue) ? 'checked="checked"' : (!isset($field['value']) && in_array($item, $itemDefault) ? 'checked="checked"' : '') ?> />
        <span>
            <?= $key ?>
        </span>
        </label>
    <?php endforeach; ?>
<?php endif; ?>
