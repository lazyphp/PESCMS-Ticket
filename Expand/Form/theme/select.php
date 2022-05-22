<select class="input-leng3 am-radius" name="<?= $field['field_name'] ?>" <?= $field['field_required'] == '1' ? 'required' : '' ?> >
    
    <?php $tmpArray = json_decode(htmlspecialchars_decode($field['field_option']), true); ?>
    <?php if(is_array($tmpArray)): ?>
        <?php foreach ($tmpArray as $key => $value) : ?>
            <option value="<?= $value ?>" <?= isset($field['value']) && $field['value'] == $value ? 'selected="selected"' : (!isset($field['value']) && $field['field_default'] == $value ? 'selected="selected"' : '') ?>><?= $key ?></option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>