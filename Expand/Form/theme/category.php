<select class="input-leng3" name="<?= $field['field_name'] ?>" <?= $field['field_required'] == '1' ? 'required' : '' ?>>
    <option value="">请选择分类</option>
    <?= $tree ?>
</select>