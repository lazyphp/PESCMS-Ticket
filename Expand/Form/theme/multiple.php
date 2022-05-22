<?php
$itemValue = explode(',', $field['value'] ?? '');
$itemDefault = explode(',', $field['field_default']);
?>

<select class="input-leng3 am-radius" name="<?= $field['field_name'] ?>[]" <?= $field['field_required'] == '1' ? 'required' : '' ?> multiple="multiple" >
    <?php foreach (json_decode(htmlspecialchars_decode($field['field_option']), true) as $key => $item) : ?>
        <option value="<?= $item ?>"
            <?= in_array($item, $itemValue) ? 'selected="selected"' : (empty($field['value']) && in_array($item, $itemDefault) ? 'selected="selected"' : '') ?>
        ><?= $key ?></option>
    <?php endforeach; ?>
</select>