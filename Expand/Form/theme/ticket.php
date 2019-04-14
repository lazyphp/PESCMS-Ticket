<select class="input-leng3 am-radius" name="<?= $field['field_name'] ?>" <?= $field['field_required'] == '1' ? 'required' : '' ?>>
    <option value="">请选择工单</option>
    <?php foreach($ticketModel as $key => $value): ?>
        <option value="<?= $value['ticket_model_id'] ?>" <?= $field['value'] == $value['ticket_model_id'] ? 'selected="selected"' :'' ?> ><?= "{$value['category_name']} - {$value['ticket_model_name']}" ?></option>
    <?php endforeach; ?>
</select>