<select class="input-leng3" name="<?= $field['field_name'] ?>" <?= $field['field_required'] == '1' ? 'required' : '' ?>>
    <option value="">请选择分类</option>
    <?php foreach($category as $key => $value): ?>
        <option value="<?= $value['category_id'] ?>" <?= $field['value'] == $value['category_id'] ? 'selected="selected"' :'' ?> ><?= $value['space'].$value['guide'].$value['category_name'] ?></option>
    <?php endforeach; ?>
</select>