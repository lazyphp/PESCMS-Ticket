<script type="text/plain" id="<?= $field['field_name']; ?>" style="height:250px;"><?= htmlspecialchars_decode($field['value'] ?? ($field['field_default'] ?? '')) ?></script>
<script>
    var ue = UE.getEditor('<?= $field['field_name']; ?>', {
        textarea: '<?= $field['field_name']; ?>'
    });
</script>